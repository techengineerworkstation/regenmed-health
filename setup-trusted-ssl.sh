#!/bin/bash
# RegenMed - Trusted SSL for localhost (no browser warnings)
# Uses mkcert to create locally-trusted certificates

set -e

GREEN='\033[0;32m'; YELLOW='\033[1;33m'; RED='\033[0;31m'; BLUE='\033[0;34m'; CYAN='\033[0;36m'; NC='\033[0m'
SUDO="sudo"

log() { echo -e "$(date +%H:%M:%S) $1"; }
ok()   { log "  ${GREEN}✓${NC} $1"; }
warn() { log "  ${YELLOW}⚠${NC} $1"; }
step() { echo -e "\n${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"; log "${GREEN}$1${NC}"; echo -e "${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"; }

echo -e "${GREEN}╔════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║  RegenMed - Trusted Localhost SSL     ║${NC}"
echo -e "${GREEN}╚════════════════════════════════════════╝${NC}"

APP_DIR="/home/hptechworkpc/Apps/RegenMed"
SSL_DIR="${APP_DIR}/.ssl"
PORT=8443

# Step 1: Install mkcert
step "Step 1/5: Installing mkcert (trusted local CA)"

if ! command -v mkcert &>/dev/null; then
    # Install mkcert
    if command -v dnf &>/dev/null; then
        $SUDO dnf install -y nss-tools 2>&1 | tail -1
        curl -sL https://github.com/FiloSottile/mkcert/releases/download/v1.4.4/mkcert-v1.4.4-linux-amd64 -o /tmp/mkcert
        chmod +x /tmp/mkcert
        $SUDO mv /tmp/mkcert /usr/local/bin/mkcert
    elif command -v apt &>/dev/null; then
        $SUDO apt install -y libnss3-tools 2>&1 | tail -1
        curl -sL https://github.com/FiloSottile/mkcert/releases/download/v1.4.4/mkcert-v1.4.4-linux-amd64 -o /tmp/mkcert
        chmod +x /tmp/mkcert
        $SUDO mv /tmp/mkcert /usr/local/bin/mkcert
    fi
    ok "mkcert installed"
else
    ok "mkcert already installed"
fi

# Install local CA
mkcert -install 2>&1 | head -1
ok "Local CA installed in system trust store"

# Step 2: Generate trusted certificate
step "Step 2/5: Generating trusted certificate for localhost"

mkdir -p "$SSL_DIR"
cd "$SSL_DIR"

mkcert -key-file localhost.key -cert-file localhost.crt localhost 127.0.0.1 ::1 2>&1 | head -2

chmod 600 localhost.key
chmod 644 localhost.crt
ok "Trusted certificate generated"

# Step 3: Start PHP server
step "Step 3/5: Starting PHP backend"

pkill -f "php -S 127.0.0.1:8081" 2>/dev/null || true
sleep 1

cd "$APP_DIR"
nohup php -S 127.0.0.1:8081 -t "$APP_DIR" > "${APP_DIR}/storage/logs/server.log" 2>&1 &
PHP_PID=$!

sleep 1
if kill -0 $PHP_PID 2>/dev/null; then
    ok "PHP running on 127.0.0.1:8081 (PID: $PHP_PID)"
else
    err "PHP failed to start"
    cat "${APP_DIR}/storage/logs/server.log" 2>/dev/null
    exit 1
fi

# Verify PHP is responding
if curl -s http://127.0.0.1:8081/ | grep -q "RegenMed\|regenmed\|DOCTYPE"; then
    ok "PHP responding correctly"
else
    warn "PHP may not be responding (check log)"
fi

# Step 4: Install and configure nginx
step "Step 4/5: Installing and configuring nginx"

if ! command -v nginx &>/dev/null; then
    if command -v dnf &>/dev/null; then
        $SUDO dnf install -y nginx 2>&1 | tail -1
    elif command -v apt &>/dev/null; then
        $SUDO apt install -y nginx 2>&1 | tail -1
    fi
fi

# Remove default config that might conflict
$SUDO rm -f /etc/nginx/conf.d/default.conf 2>/dev/null || true
$SUDO rm -f /etc/nginx/sites-enabled/default 2>/dev/null || true

# Create nginx config
$SUDO tee /etc/nginx/conf.d/regenmed.conf > /dev/null << EOF
server {
    listen 80;
    server_name localhost;
    return 301 https://localhost:${PORT}\$request_uri;
}

server {
    listen ${PORT} ssl;
    http2 on;
    server_name localhost;

    ssl_certificate ${SSL_DIR}/localhost.crt;
    ssl_certificate_key ${SSL_DIR}/localhost.key;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-RSA-AES128-GCM-SHA256:ECDHE-ECDSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-GCM-SHA384;
    ssl_prefer_server_ciphers on;
    ssl_session_cache shared:SSL:10m;
    ssl_session_timeout 1d;

    add_header X-Frame-Options "DENY" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;

    access_log /var/log/nginx/regenmed_access.log;
    error_log /var/log/nginx/regenmed_error.log;

    root ${APP_DIR};
    index index.php;

    client_max_body_size 50M;

    location ~ ^/(data|storage|includes|uploads)/ { deny all; return 404; }
    location ~ /\. { deny all; return 404; }

    location / {
        try_files \$uri \$uri/ /index.php?\$is_args\$args;
    }

    location ~ \.php\$ {
        proxy_pass http://127.0.0.1:8081;
        proxy_set_header Host \$host;
        proxy_set_header X-Real-IP \$remote_addr;
        proxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto \$scheme;
        proxy_set_header X-Forwarded-Host \$host;
        proxy_set_header X-Forwarded-Port \$server_port;
        proxy_read_timeout 300;
        proxy_connect_timeout 300;
        proxy_buffering off;
    }

    location ~* \.(css|js|svg|png|jpg|jpeg|gif|ico|woff2?|ttf|eot)\$ {
        expires 30d;
        add_header Cache-Control "public, immutable";
    }
}
EOF

# Test nginx config
if $SUDO nginx -t 2>&1; then
    ok "nginx config valid"
else
    err "nginx config test failed"
    $SUDO nginx -t
    exit 1
fi

$SUDO systemctl enable nginx 2>/dev/null || true
$SUDO systemctl restart nginx 2>/dev/null || $SUDO nginx
ok "nginx started"

# Step 5: Verify everything works
step "Step 5/5: Verifying setup"

sleep 1

# Check PHP
if curl -s -o /dev/null -w "%{http_code}" http://127.0.0.1:8081/ | grep -q "200"; then
    ok "PHP backend: OK"
else
    warn "PHP backend: check log"
fi

# Check nginx HTTPS
if curl -sk -o /dev/null -w "%{http_code}" https://localhost:${PORT}/ | grep -q "200"; then
    ok "nginx HTTPS: OK"
else
    warn "nginx HTTPS: check log"
fi

# Done
echo ""
echo -e "${GREEN}╔════════════════════════════════════════╗${NC}"
echo -e "${GREEN}  Trusted SSL Setup Complete!${NC}"
echo -e "${GREEN}╚════════════════════════════════════════╝${NC}"
echo ""
log "  ${GREEN}https://localhost:${PORT}${NC}"
log "  (No browser warning - certificate is trusted)"
echo ""
log "${YELLOW}Troubleshooting:${NC}"
echo "  PHP log:  tail -f ${APP_DIR}/storage/logs/server.log"
echo "  nginx log: tail -f /var/log/nginx/regenmed_error.log"
echo ""
