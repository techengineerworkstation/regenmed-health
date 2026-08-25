#!/bin/bash
# RegenMed - Complete Server Setup Script
# Run with: sudo bash setup-server.sh
set -e

APP_DIR="/home/hptechworkpc/Apps/RegenMed"
APP_USER="hptechworkpc"
DB_NAME="regenmed"
DB_USER="regenmed"
DB_PASS="regenmed_secure_2024"

GREEN='\033[0;32m'; YELLOW='\033[1;33m'; RED='\033[0;31m'; BOLD='\033[1m'; NC='\033[0m'
ok()   { echo -e "  ${GREEN}✓${NC} $1"; }
warn() { echo -e "  ${YELLOW}⚠${NC} $1"; }
err()  { echo -e "  ${RED}✗${NC} $1"; }
step() { echo -e "\n${BOLD}━━━ $1 ━━━${NC}"; }

echo -e "${GREEN}╔══════════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║  RegenMed Server Setup (nginx + php-fpm)    ║${NC}"
echo -e "${GREEN}╚══════════════════════════════════════════════╝${NC}"

# ── Step 1: Create directories ──
step "Step 1/8: Creating required directories"
mkdir -p "${APP_DIR}/logs" "${APP_DIR}/data/sessions" "${APP_DIR}/uploads"
chown -R "${APP_USER}:${APP_USER}" "${APP_DIR}/logs" "${APP_DIR}/data" "${APP_DIR}/uploads"
ok "Directories ready"

# ── Step 2: MySQL database and user ──
step "Step 2/8: Setting up MariaDB database"
if systemctl list-unit-files | grep -q mysqld.service; then
    systemctl enable --now mysqld
    DB_SERVICE="mysqld"
elif systemctl list-unit-files | grep -q mariadb.service; then
    systemctl enable --now mariadb
    DB_SERVICE="mariadb"
else
    warn "No MySQL/MariaDB service found - ensure it is installed"
    DB_SERVICE=""
fi
sleep 2

# Try to connect as root (passwordless on fresh install)
if mysql -u root -e "SELECT 1" &>/dev/null; then
    mysql -u root -e "CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
    mysql -u root -e "CREATE USER IF NOT EXISTS '${DB_USER}'@'127.0.0.1' IDENTIFIED BY '${DB_PASS}';"
    mysql -u root -e "CREATE USER IF NOT EXISTS '${DB_USER}'@'localhost' IDENTIFIED BY '${DB_PASS}';"
    mysql -u root -e "GRANT ALL PRIVILEGES ON \`${DB_NAME}\`.* TO '${DB_USER}'@'127.0.0.1';"
    mysql -u root -e "GRANT ALL PRIVILEGES ON \`${DB_NAME}\`.* TO '${DB_USER}'@'localhost';"
    mysql -u root -e "FLUSH PRIVILEGES;"
    ok "MySQL database '${DB_NAME}' and user '${DB_USER}' configured"
else
    warn "MySQL root requires password. Run manually:"
    echo "  mysql -u root -p -e \"CREATE DATABASE regenmed; CREATE USER regenmed@127.0.0.1 IDENTIFIED BY 'regenmed_secure_2024'; GRANT ALL ON regenmed.* TO regenmed@127.0.0.1; FLUSH PRIVILEGES;\""
fi

# ── Step 3: PHP-FPM pool config ──
step "Step 3/8: Configuring PHP-FPM pool"
# Remove default www pool if it exists and conflicts
rm -f /etc/php-fpm.d/www.conf 2>/dev/null || true
cp "${APP_DIR}/setup/php-fpm-regenmed.conf" /etc/php-fpm.d/regenmed.conf
mkdir -p /run/php-fpm
chown "${APP_USER}:${APP_USER}" /run/php-fpm
ok "PHP-FPM pool configured (regenmed.conf)"

# ── Step 4: Nginx config ──
step "Step 4/8: Configuring Nginx"
# Remove default server block if it conflicts on port 8081
rm -f /etc/nginx/conf.d/default.conf 2>/dev/null || true
cp "${APP_DIR}/setup/nginx-regenmed.conf" /etc/nginx/conf.d/regenmed.conf
# Test nginx config
if nginx -t 2>&1; then
    ok "Nginx configuration valid"
else
    err "Nginx configuration test failed!"
    exit 1
fi

# ── Step 5: Set permissions ──
step "Step 5/8: Setting file permissions"
chown -R "${APP_USER}:${APP_USER}" "${APP_DIR}"
chmod -R 750 "${APP_DIR}/data" "${APP_DIR}/logs" "${APP_DIR}/uploads"
ok "Permissions set"

# ── Step 6: Start services ──
step "Step 6/8: Starting services"
systemctl enable --now php-fpm
ok "php-fpm enabled and started"

systemctl enable --now nginx
ok "nginx enabled and started"

# ── Step 7: Initialize database ──
step "Step 7/8: Initializing MariaDB database"
sleep 2
sudo -u "${APP_USER}" php -r "define('APP_RUNNING', true); require '${APP_DIR}/includes/seed.php'; seedDatabase();" 2>&1 || {
    warn "Database init may need manual run:"
    echo "  cd ${APP_DIR} && php -r \"define('APP_RUNNING', true); require 'includes/seed.php'; seedDatabase();\""
}
ok "Database initialization attempted"

# ── Step 8: Firewall ──
step "Step 8/8: Configuring firewall"
if command -v firewall-cmd &>/dev/null && firewall-cmd --state 2>/dev/null | grep -q running; then
    firewall-cmd --permanent --add-port=8081/tcp 2>/dev/null
    firewall-cmd --reload 2>/dev/null
    ok "Firewall: port 8081 opened"
else
    warn "Firewall not active or not found - port 8081 accessible"
fi

# ── Verify ──
step "Verification"
sleep 2
if ss -tlnp | grep -q ":8081 "; then
    ok "Port 8081 is listening"
else
    warn "Port 8081 not yet listening - services may need a moment"
fi

echo ""
echo -e "${GREEN}╔══════════════════════════════════════════════╗${NC}"
echo -e "${GREEN}  Setup Complete!                             ║${NC}"
echo -e "${GREEN}  URL: http://localhost:8081                   ║${NC}"
echo -e "${GREEN}  Login: admin / admin123                      ║${NC}"
echo -e "${GREEN}╚══════════════════════════════════════════════╝${NC}"
echo ""
echo -e "Service management:"
echo -e "  ${YELLOW}sudo systemctl status nginx${NC}"
echo -e "  ${YELLOW}sudo systemctl status php-fpm${NC}"
echo -e "  ${YELLOW}sudo systemctl status mysqld  # or mariadb${NC}"
echo -e "  ${YELLOW}sudo systemctl restart nginx php-fpm${NC}"
echo ""
