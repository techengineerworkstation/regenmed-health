#!/bin/bash
# RegenMed - Install Updated SSL Certificate
# Run with: sudo ./install-ssl-cert.sh
set -e

GREEN='\033[0;32m'; NC='\033[0m'

echo -e "${GREEN}Installing new SSL certificate...${NC}"

cp /home/hptechworkpc/Apps/RegenMed/.ssl/regenmed.crt /etc/nginx/ssl/regenmed.crt
cp /home/hptechworkpc/Apps/RegenMed/.ssl/regenmed.key /etc/nginx/ssl/regenmed.key
chmod 600 /etc/nginx/ssl/regenmed.key
chmod 644 /etc/nginx/ssl/regenmed.crt

echo "Testing nginx configuration..."
nginx -t

echo "Reloading nginx..."
systemctl reload nginx

echo -e "${GREEN}SSL certificate installed successfully!${NC}"
echo "New certificate features:"
echo "  - ECDSA P-384 (stronger than RSA)"
echo "  - SHA-384 signature"
echo "  - SANs: localhost, HPWorkPC, 127.0.0.1, 192.168.1.16"
echo "  - Valid for 10 years"
