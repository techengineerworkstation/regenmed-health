#!/bin/bash
# RegenMed - Security Hardening Script
# Run with: sudo ./setup-security.sh
set -e

GREEN='\033[0;32m'; YELLOW='\033[1;33m'; RED='\033[0;31m'; NC='\033[0m'

echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}  RegenMed Security Setup${NC}"
echo -e "${GREEN}========================================${NC}"

APP_DIR="/home/hptechworkpc/Apps/RegenMed"

# 1. Install new SSL certificate
echo -e "\n${YELLOW}[1/3] Installing SSL certificate...${NC}"
cp "${APP_DIR}/.ssl/regenmed.crt" /etc/nginx/ssl/regenmed.crt
cp "${APP_DIR}/.ssl/regenmed.key" /etc/nginx/ssl/regenmed.key
chmod 600 /etc/nginx/ssl/regenmed.key
chmod 644 /etc/nginx/ssl/regenmed.crt
echo -e "  ${GREEN}SSL certificate installed (ECDSA P-384, SHA-384)${NC}"

# 2. Install rate limit zone (must be in http context, not server)
echo -e "\n${YELLOW}[2/4] Installing rate limit configuration...${NC}"
cp "${APP_DIR}/ratelimit.conf" /etc/nginx/conf.d/ratelimit.conf
echo -e "  ${GREEN}Rate limit zone installed${NC}"

# 3. Install updated nginx config
echo -e "\n${YELLOW}[3/4] Installing nginx configuration...${NC}"
cp /etc/nginx/conf.d/regenmed.conf /etc/nginx/conf.d/regenmed.conf.bak
cp "${APP_DIR}/nginx-regenmed.conf" /etc/nginx/conf.d/regenmed.conf
echo -e "  ${GREEN}Nginx config updated with:${NC}"
echo -e "    - ECDSA P-384 curves"
echo -e "    - TLS 1.2/1.3 only"
echo -e "    - Strong cipher suite"
echo -e "    - OCSP stapling"
echo -e "    - HSTS preload"
echo -e "    - Rate limiting (60 req/min)"
echo -e "    - Content-Security-Policy"

# 4. Fix directory permissions
echo -e "\n${YELLOW}[4/4] Fixing directory permissions...${NC}"
chmod o+rx /home/hptechworkpc
echo -e "  ${GREEN}/home/hptechworkpc permissions fixed${NC}"

# Test nginx config
echo -e "\n${YELLOW}Testing nginx configuration...${NC}"
if nginx -t 2>&1; then
    echo -e "  ${GREEN}Nginx config valid${NC}"
    echo -e "\n${YELLOW}Restarting services...${NC}"
    systemctl restart php-fpm
    echo -e "  ${GREEN}php-fpm restarted${NC}"
    systemctl reload nginx
    echo -e "  ${GREEN}nginx reloaded${NC}"
else
    echo -e "  ${RED}Nginx config test failed! Restoring backup...${NC}"
    cp /etc/nginx/conf.d/regenmed.conf.bak /etc/nginx/conf.d/regenmed.conf
    rm -f /etc/nginx/conf.d/ratelimit.conf
    systemctl reload nginx
    exit 1
fi

echo -e "\n${GREEN}========================================${NC}"
echo -e "${GREEN}  Security Setup Complete!${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""
echo -e "  Certificate: ${GREEN}ECDSA P-384 + SHA-384${NC}"
echo -e "  TLS: ${GREEN}1.2/1.3 only${NC}"
echo -e "  HSTS: ${GREEN}Enabled (2 years + preload)${NC}"
echo -e "  Rate Limit: ${GREEN}60 req/min${NC}"
echo -e "  CSP: ${GREEN}Enabled${NC}"
echo ""
echo -e "  ${YELLOW}Note: Self-signed cert will show browser warning.${NC}"
echo -e "  ${YELLOW}Click 'Advanced' -> 'Proceed' to continue.${NC}"
echo ""
