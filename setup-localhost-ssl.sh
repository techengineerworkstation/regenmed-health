#!/bin/bash
# RegenMed - Setup Nginx with SSL for localhost (self-signed)
# No domain name needed - works immediately for local development

set -e

GREEN='\033[0;32m'; YELLOW='\033[1;33m'; RED='\033[0;31m'; BLUE='\033[0;34m'; CYAN='\033[0;36m'; NC='\033[0m'
SUDO="sudo"

log() { echo -e "$(date +%H:%M:%S) $1"; }
ok()   { log "  ${GREEN}✓${NC} $1"; }
warn() { log "  ${YELLOW}⚠${NC} $1"; }
step() { echo -e "\n${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"; log "${GREEN}$1${NC}"; echo -e "${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"; }

echo -e "${GREEN}╔════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║  RegenMed - Localhost SSL Setup       ║${NC}"
echo -e "${GREEN}╚════════════════════════════════════════╝${NC}"

APP_DIR="/home/hptechworkpc/Apps/RegenMed"
SSL_DIR="${APP_DIR}/.ssl"
PORT=8443

# Step 1: Install nginx
step "Step 1/4: Installing nginx"

if command -v dnf &>/dev/null; then
    $SUDO dnf install -y nginx openssl 2>&1 | tail -3
elif command -v apt &>/dev/null; then
    $SUDO apt update -qq && $SUDO apt install -y nginx openssl 2>&1 | tail -3
elif command -v yum &>/dev/null; then
    $SUDO yum install -y epel-release 2>/dev/null || true
    $SUDO yum install -y nginx openssl 2>&1 | tail -3
fi
ok "nginx installed"

# Step 2: Start PHP server
step "Step 2/4: Starting PHP backend"

kill $(cat "${APP_DIR}/.server.pid" 2>/dev/null) 2>/dev/null || true
cd "$APP_DIR"
nohup php -S 127.0.0.1:8081 -t "$APP_DIR" > "${APP_DIR}/storage/logs/server.log" 2>&1 &
echo $! > "${APP_DIR}/.server.pid"
ok "PHP running on 127.0.0.1:8081 (PID: $!)"

# Step 3: Generate self-signed certificate
step "Step 3/4: Generating self-signed SSL certificate"

mkdir -p "$SSL_DIR"

openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
    -keyout "${SSL_DIR}/localhost.key" \
    -out "${SSL_DIR}/localhost.crt" \
    -subj "/C=US/ST=Local/L=Localhost/O=RegenMed/CN=localhost" \
    -addext "subjectAltName=DNS:localhost,IP:127.0.0.1,IP:::1" 2>/dev/null

chmod 600 "${SSL_DIR}/localhost.key"
chmod 644 "${SSL_DIR}/localhost.crt"
ok "Certificate generated at ${SSL_DIR}/"

# Step 4: Create nginx config with SSL
step "Step 4/4: Creating nginx SSL configuration"

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
    ssl_ciphers HIGH:!aNULL:!MD5;
    ssl_prefer_server_ciphers on;

    add_header X-Frame-Options "DENY" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;

    access_log /var/log/nginx/regenmed_access.log;
    error_log /var/log/nginx/regenmed_error.log;

    root ${APP_DIR};
    index index.php;

    location ~ ^/(data|storage|includes|uploads)/ { deny all; return 404; }
    location ~ /\. { deny all; return 404; }

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php$ {
        proxy_pass http://127.0.0.1:8081;
        proxy_set_header Host \$host;
        proxy_set_header X-Real-IP \$remote_addr;
        proxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto \$scheme;
        proxy_set_header X-Forwarded-Host \$host;
        proxy_set_header X-Forwarded-Port \$server_port;
        proxy_read_timeout 300;
    }

    location ~* \.(css|js|svg|png|jpg|jpeg|gif|ico|woff2?)$ {
        expires 30d;
        add_header Cache-Control "public, immutable";
    }
}
EOF

# Remove default nginx config if it conflicts
$SUDO rm -f /etc/nginx/conf.d/default.conf 2>/dev/null || true
$SUDO rm -f /etc/nginx/sites-enabled/default 2>/dev/null || true

# Test and start nginx
if $SUDO nginx -t; then
    $SUDO systemctl enable nginx 2>/dev/null || true
    $SUDO systemctl restart nginx || $SUDO nginx
    ok "nginx started with SSL"
else
    err "nginx config test failed"
    $SUDO nginx -t
    exit 1
fi

# Done
echo ""
echo -e "${GREEN}╔════════════════════════════════════════╗${NC}"
echo -e "${GREEN}  Localhost SSL Setup Complete!${NC}"
echo -e "${GREEN}╚════════════════════════════════════════╝${NC}"
echo ""
log "HTTPS URL:  ${GREEN}https://localhost:${PORT}${NC}"
log "HTTP:       http://localhost (redirects to HTTPS)"
log "PHP backend: http://127.0.0.1:8081"
echo ""
log "${YELLOW}Browser will show 'Not Secure' warning${NC}"
log "${YELLOW}Click 'Advanced' -> 'Proceed to localhost'${NC}"
echo ""
log "${YELLOW}Commands:${NC}"
echo "  Stop:    sudo systemctl stop nginx"
echo "  Restart: sudo systemctl restart nginx"
echo "  Logs:    sudo tail -f /var/log/nginx/regenmed_error.log"
echo ""
