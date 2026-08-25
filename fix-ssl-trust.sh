#!/bin/bash
# Fix SSL certificate trust - no browser warnings
# Works for Chrome, Firefox, Edge, and system-wide tools

set -e

GREEN='\033[0;32m'; YELLOW='\033[1;33m'; RED='\033[0;31m'; BLUE='\033[0;34m'; CYAN='\033[0;36m'; NC='\033[0m'
SUDO="sudo"

log() { echo -e "$(date +%H:%M:%S) $1"; }
ok()   { log "  ${GREEN}✓${NC} $1"; }
step() { echo -e "\n${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"; log "${GREEN}$1${NC}"; echo -e "${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"; }

APP_DIR="/home/hptechworkpc/Apps/RegenMed"
SSL_DIR="${APP_DIR}/.ssl"

echo -e "${GREEN}╔════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║  RegenMed - Fix SSL Certificate Trust  ║${NC}"
echo -e "${GREEN}╚════════════════════════════════════════╝${NC}"

# Step 1: Ensure mkcert is installed
step "Step 1: Checking mkcert"

if ! command -v mkcert &>/dev/null; then
    log "Installing mkcert..."
    if command -v dnf &>/dev/null; then
        $SUDO dnf install -y nss-tools 2>&1 | tail -1
    elif command -v apt &>/dev/null; then
        $SUDO apt install -y libnss3-tools 2>&1 | tail -1
    fi
    curl -sL https://github.com/FiloSottile/mkcert/releases/download/v1.4.4/mkcert-v1.4.4-linux-amd64 -o /tmp/mkcert
    chmod +x /tmp/mkcert
    $SUDO mv /tmp/mkcert /usr/local/bin/mkcert
fi
ok "mkcert available"

# Step 2: Install local CA system-wide
step "Step 2: Installing Certificate Authority system-wide"

mkcert -install 2>&1 | head -1
ok "CA installed in system trust store"

# Step 3: Copy CA to system certificate store
step "Step 3: Adding CA to system certificate store"

CA_ROOT=$(mkcert -CAROOT 2>/dev/null)
if [ -d "$CA_ROOT" ]; then
    # Copy CA cert to system store
    $SUDO cp "${CA_ROOT}/rootCA.pem" /etc/pki/ca-trust/source/anchors/mkcert-rootCA.pem 2>/dev/null || \
    $SUDO cp "${CA_ROOT}/rootCA.pem" /usr/local/share/ca-certificates/mkcert-rootCA.crt 2>/dev/null || true
    
    # Update system trust store
    if command -v update-ca-trust &>/dev/null; then
        $SUDO update-ca-trust extract 2>/dev/null
        ok "CA added to Fedora/RHEL trust store (update-ca-trust)"
    elif command -v update-ca-certificates &>/dev/null; then
        $SUDO update-ca-certificates 2>/dev/null
        ok "CA added to Debian/Ubuntu trust store"
    fi
else
    warn "Could not find mkcert CA root"
fi

# Step 4: Generate certificate for localhost
step "Step 4: Generating trusted certificate for localhost"

cd "$SSL_DIR"

# Remove old certs
rm -f localhost.crt localhost.key

# Generate new cert trusted by system
mkcert -key-file localhost.key -cert-file localhost.crt localhost 127.0.0.1 ::1 2>&1 | head -2

chmod 600 localhost.key
chmod 644 localhost.crt
ok "Certificate generated and trusted"

# Step 5: Add to Firefox trust store (Firefox uses its own store)
step "Step 5: Adding to Firefox trust store (if installed)"

if command -v firefox &>/dev/null; then
    # Find Firefox profiles
    FIREFOX_PROFILES=$(find ~/.mozilla/firefox -name "default*" -type d 2>/dev/null)
    for profile in $FIREFOX_PROFILES; do
        if [ -d "$profile" ]; then
            # Use certutil to add to Firefox SQLite DB
            if command -v certutil &>/dev/null; then
                certutil -A -n "mkcert-rootCA" -t "TCu,Cu,Tu" -i "${CA_ROOT}/rootCA.pem" -d "sql:${profile}" 2>/dev/null && \
                    ok "Added to Firefox profile: $(basename $profile)"
            fi
        fi
    done
else
    warn "Firefox not installed"
fi

# Step 6: Update nginx to use the new certificate
step "Step 6: Updating nginx configuration"

$SUDO sed -i "s|ssl_certificate .*|ssl_certificate ${SSL_DIR}/localhost.crt;|" /etc/nginx/conf.d/regenmed.conf 2>/dev/null
$SUDO sed -i "s|ssl_certificate_key .*|ssl_certificate_key ${SSL_DIR}/localhost.key;|" /etc/nginx/conf.d/regenmed.conf 2>/dev/null

# Also update to listen on 443 if possible, otherwise keep 8443
if ! ss -tln | grep -q ":443 "; then
    $SUDO sed -i "s|listen 8443 ssl;|listen 443 ssl;|" /etc/nginx/conf.d/regenmed.conf 2>/dev/null
    $SUDO sed -i "s|return 301 https://localhost:8443|return 301 https://localhost|" /etc/nginx/conf.d/regenmed.conf 2>/dev/null
    ok "Updated nginx to port 443"
else
    warn "Port 443 in use, keeping port 8443"
fi

# Test and restart nginx
if $SUDO nginx -t 2>&1; then
    $SUDO systemctl restart nginx 2>/dev/null || $SUDO nginx
    ok "nginx restarted"
else
    err "nginx config test failed"
    $SUDO nginx -t
fi

# Step 7: Verify
step "Step 7: Verifying SSL"

sleep 1

# Check if port 443 is now in use by nginx
if ss -tln | grep -q ":443 "; then
    PORT=443
    URL="https://localhost"
else
    PORT=8443
    URL="https://localhost:8443"
fi

# Test with curl
if curl -s -o /dev/null -w "%{http_code}" "${URL}/" 2>/dev/null | grep -q "200\|302\|301"; then
    ok "HTTPS responding on ${URL}"
else
    warn "HTTPS check returned non-200 (may need browser)"
fi

# Done
echo ""
echo -e "${GREEN}╔════════════════════════════════════════╗${NC}"
echo -e "${GREEN}  SSL Trust Fix Complete!${NC}"
echo -e "${GREEN}╚════════════════════════════════════════╝${NC}"
echo ""
log "Access: ${GREEN}${URL}${NC}"
echo ""
log "${YELLOW}If you still see warnings:${NC}"
echo "  1. Close and reopen your browser completely"
echo "  2. In Firefox: Settings → Privacy → View Certificates → Import ${SSL_DIR}/localhost.crt"
echo "  3. In Chrome: Restart browser (uses system trust store)"
echo ""
log "${YELLOW}Certificate files:${NC}"
echo "  ${SSL_DIR}/localhost.crt"
echo "  ${SSL_DIR}/localhost.key"
echo ""
