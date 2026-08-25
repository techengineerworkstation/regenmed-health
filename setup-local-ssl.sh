#!/bin/bash
# RegenMed - Local SSL with Self-Signed Certificate (for development)
# No domain name needed - works with localhost

set -e

GREEN='\033[0;32m'; YELLOW='\033[1;33m'; BLUE='\033[0;34m'; NC='\033[0m'
SUDO="sudo"

echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}  RegenMed - Local SSL Setup${NC}"
echo -e "${GREEN}========================================${NC}"

APP_DIR="$HOME/Apps/RegenMed"
SSL_DIR="${APP_DIR}/.ssl"
PORT=8443

# Create SSL directory
mkdir -p "$SSL_DIR"

echo -e "${BLUE}Generating self-signed certificate...${NC}"

# Generate self-signed cert
openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
    -keyout "${SSL_DIR}/server.key" \
    -out "${SSL_DIR}/server.crt" \
    -subj "/C=US/ST=State/L=City/O=RegenMed/CN=localhost" \
    -addext "subjectAltName=DNS:localhost,IP:127.0.0.1"

chmod 600 "${SSL_DIR}/server.key"
chmod 644 "${SSL_DIR}/server.crt"

echo -e "${GREEN}Certificate generated${NC}"

# Update launch script to use SSL
cat > "${APP_DIR}/launch-ssl.sh" << LAUNCHEOF
#!/bin/bash
# RegenMed - Start with SSL (self-signed)
APP_DIR="$(cd "$(dirname "$0")" && pwd)"
PORT=${PORT:-8443}

echo "Starting RegenMed with HTTPS on port \${PORT}..."
echo "URL: https://localhost:\${PORT}"
echo "Note: Browser will show 'Not Secure' warning (expected for self-signed cert)"
echo "Click 'Advanced' -> 'Proceed' to continue"
echo "Ctrl+C to stop"

cd "\$APP_DIR"
exec php -S 127.0.0.1:\${PORT} -t "\$APP_DIR" \
    -d "openssl.cafile=\${APP_DIR}/.ssl/server.crt" \
    -d "openssl.local_cert=\${APP_DIR}/.ssl/server.crt" \
    -d "openssl.local_pk=\${APP_DIR}/.ssl/server.key"
LAUNCHEOF

chmod +x "${APP_DIR}/launch-ssl.sh"

echo ""
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}  Local SSL Ready!${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""
echo -e "  Start with SSL: ${GREEN}./launch-ssl.sh${NC}"
echo -e "  Access: ${GREEN}https://localhost:8443${NC}"
echo ""
echo -e "  ${YELLOW}Browser warning is normal${NC}"
echo -e "  Click Advanced -> Proceed to localhost"
echo ""
echo -e "${GREEN}========================================${NC}"
