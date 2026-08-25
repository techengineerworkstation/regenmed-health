#!/bin/bash
# RegenMed - Setup Nginx Reverse Proxy with SSL (Certbot)

set -e

GREEN='\033[0;32m'; YELLOW='\033[1;33m'; RED='\033[0;31m'; BLUE='\033[0;34m'; CYAN='\033[0;36m'; NC='\033[0m'
SUDO="sudo"

log() { echo -e "$(date +%H:%M:%S) $1"; }
ok()   { log "  ${GREEN}✓${NC} $1"; }
warn() { log "  ${YELLOW}⚠${NC} $1"; }
err()  { log "  ${RED}✗${NC} $1"; }
step() { echo -e "\n${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"; log "${GREEN}$1${NC}"; echo -e "${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"; }

echo -e "${GREEN}╔════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║  RegenMed - Nginx + SSL Setup         ║${NC}"
echo -e "${GREEN}╚════════════════════════════════════════╝${NC}"

APP_DIR="$HOME/Apps/RegenMed"
DOMAIN=""
EMAIL=""

echo ""
echo -e "${YELLOW}Enter your domain (must point to this server):${NC}"
read -p "> " DOMAIN

echo -e "${YELLOW}Enter your email (for SSL certificate):${NC}"
read -p "> " EMAIL

if [ -z "$DOMAIN" ] || [ -z "$EMAIL" ]; then
    err "Domain and email are required"
    exit 1
fi

# Step 1: Install packages
step "Step 1/5: Installing nginx and certbot"

if command -v dnf &>/dev/null; then
    $SUDO dnf install -y nginx certbot python3-certbot-nginx 2>&1 | tail -3
elif command -v apt &>/dev/null; then
    $SUDO apt update -qq && $SUDO apt install -y nginx certbot python3-certbot-nginx 2>&1 | tail -3
elif command -v yum &>/dev/null; then
    $SUDO yum install -y epel-release 2>/dev/null || true
    $SUDO yum install -y nginx certbot python3-certbot-nginx 2>&1 | tail -3
fi
ok "Packages installed"

# Step 2: Start PHP server first
step "Step 2/5: Starting PHP backend server"

kill $(cat "${APP_DIR}/.server.pid" 2>/dev/null) 2>/dev/null || true
cd "$APP_DIR"
nohup php -S 127.0.0.1:8081 -t "$APP_DIR" > "${APP_DIR}/storage/logs/server.log" 2>&1 &
echo $! > "${APP_DIR}.server.pid"
ok "PHP server running on 127.0.0.1:8081 (PID: $!)"

# Step 3: Create initial HTTP-only nginx config for Certbot validation
step "Step 3/5: Creating nginx HTTP config for domain validation"

$SUDO tee /etc/nginx/conf.d/regenmed.conf > /dev/null << EOF
server {
    listen 80;
    server_name ${DOMAIN};

    root ${APP_DIR};
    index index.php;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php$ {
        proxy_pass http://127.0.0.1:8081;
        proxy_set_header Host \$host;
        proxy_set_header X-Real-IP \$remote_addr;
        proxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto \$scheme;
    }
}
EOF

$SUDO nginx -t && $SUDO systemctl restart nginx
ok "Nginx HTTP config active"

# Step 4: Obtain SSL certificate
step "Step 4/5: Obtaining SSL certificate for ${DOMAIN}"
warn "Domain must point to this server's IP for validation"

SERVER_IP=$(curl -s ifconfig.me 2>/dev/null || hostname -I | awk '{print $1}')
info "Server IP: ${SERVER_IP}"
info "Make sure ${DOMAIN} A-record points to ${SERVER_IP}"

echo ""
echo -e "${YELLOW}Press Enter when DNS is configured, or Ctrl+C to abort...${NC}"
read

if $SUDO certbot --nginx -d "${DOMAIN}" --email "${EMAIL}" --agree-tos --non-interactive 2>&1 | tail -5; then
    ok "SSL certificate obtained"
else
    err "Certbot failed. Check DNS points to this server."
    warn "Falling back to HTTP-only mode"
fi

# Step 5: Create full HTTPS config
step "Step 5/5: Creating final HTTPS nginx config"

$SUDO tee /etc/nginx/conf.d/regenmed.conf > /dev/null << EOF
server {
    listen 80;
    server_name ${DOMAIN};
    return 301 https://\$server_name\$request_uri;
}

server {
    listen 443 ssl;
    http2 on;
    server_name ${DOMAIN};

    ssl_certificate /etc/letsencrypt/live/${DOMAIN}/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/${DOMAIN}/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-RSA-AES128-GCM-SHA256:ECDHE-ECDSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-GCM-SHA384;
    ssl_prefer_server_ciphers off;
    ssl_session_cache shared:SSL:10m;
    ssl_session_timeout 1d;

    add_header X-Frame-Options "DENY" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;
    add_header Strict-Transport-Security "max-age=63072000; includeSubDomains" always;

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
    }

    location ~* \.(css|js|svg|png|jpg|jpeg|gif|ico|woff2?)$ {
        expires 30d;
        add_header Cache-Control "public, immutable";
    }
}
EOF

$SUDO nginx -t && $SUDO systemctl restart nginx
ok "HTTPS config active"

# Done
echo ""
echo -e "${GREEN}╔════════════════════════════════════════╗${NC}"
echo -e "${GREEN}  Setup Complete!${NC}"
echo -e "${GREEN}╚════════════════════════════════════════╝${NC}"
echo ""
log "URL: ${GREEN}https://${DOMAIN}${NC}"
log "PHP: ${GREEN}http://127.0.0.1:8081${NC}"
echo ""
log "${YELLOW}Useful commands:${NC}"
echo "  Test renewal:  sudo certbot renew --dry-run"
echo "  View logs:     sudo tail -f /var/log/nginx/regenmed_error.log"
echo "  Restart nginx: sudo systemctl restart nginx"
echo ""
