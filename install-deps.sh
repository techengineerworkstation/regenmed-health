#!/bin/bash
set -e
GREEN='\033[0;32m'; YELLOW='\033[1;33m'; RED='\033[0;31m'
BLUE='\033[0;34m'; CYAN='\033[0;36m'; BOLD='\033[1m'; NC='\033[0m'
APP_DIR="$(cd "$(dirname "$0")" && pwd)"
LOG_FILE="${APP_DIR}/storage/logs/install-$(date +%Y%m%d-%H%M%S).log"
mkdir -p "${APP_DIR}/storage/logs"
log() { echo -e "[$(date +%H:%M:%S)] $1" | tee -a "$LOG_FILE"; }
step() { echo -e "\n${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"; log "${BOLD}$1${NC}"; echo -e "${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"; }
ok()   { log "  ${GREEN}✓${NC} $1"; }
warn() { log "  ${YELLOW}⚠${NC} $1"; }
err()  { log "  ${RED}✗${NC} $1"; }
info() { log "  ${BLUE}ℹ${NC} $1"; }
echo -e "${GREEN}╔════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║  RegenMed - Complete Automated Setup  ║${NC}"
echo -e "${GREEN}╚════════════════════════════════════════╝${NC}"
log "Log: $LOG_FILE"

# ===== STEP 1: Detect OS =====
step "Step 1/6: Detecting operating system"
DISTRO=""
if [ -f /etc/os-release ]; then
    . /etc/os-release
    DISTRO=$ID
    ok "OS: ${BOLD}${PRETTY_NAME}${NC}"
fi
PKG_MGR=""
if   command -v dnf &>/dev/null; then PKG_MGR="dnf"; ok "Package manager: dnf"
elif command -v yum &>/dev/null; then PKG_MGR="yum"; ok "Package manager: yum"
elif command -v apt  &>/dev/null; then PKG_MGR="apt";  ok "Package manager: apt"
elif command -v pacman &>/dev/null; then PKG_MGR="pacman"; ok "Package manager: pacman"
elif command -v zypper &>/dev/null; then PKG_MGR="zypper"; ok "Package manager: zypper"
else err "No supported package manager"; exit 1; fi
SUDO=""
if [ "$EUID" -ne 0 ]; then
    if command -v sudo &>/dev/null; then SUDO="sudo"; ok "Using sudo"
    else err "Root access required"; exit 1; fi
else ok "Running as root"; fi

# ===== STEP 2: Install PHP + Extensions =====
step "Step 2/6: Installing PHP and all required extensions"
info "Updating package cache and installing packages..."
case $PKG_MGR in
  dnf)
    $SUDO $PKG_MGR module enable php:8.1 -y 2>/dev/null || $SUDO $PKG_MGR module enable php:8.2 -y 2>/dev/null || $SUDO $PKG_MGR module enable php:8.3 -y 2>/dev/null || true
    info "Installing via dnf..."
    $SUDO $PKG_MGR install -y php php-cli php-common php-pdo php-sqlite3 php-mbstring php-json php-fileinfo php-openssl php-session php-filter php-hash php-sodium php-process php-posix php-zip php-xml php-curl php-intl php-gd php-bcmath php-ctype php-phar which curl wget git sqlite sqlite-tools ImageMagick inkscape 2>&1 | tee -a "$LOG_FILE" || true
    ;;
  yum)
    $SUDO $PKG_MGR install -y epel-release yum-utils 2>/dev/null || true
    $SUDO $PKG_MGR install -y https://rpms.remirepo.net/enterprise/remi-release-8.rpm 2>/dev/null || true
    $SUDO $PKG_MGR module enable php:remi-8.1 -y 2>/dev/null || true
    info "Installing via yum..."
    $SUDO $PKG_MGR install -y php php-cli php-common php-pdo php-mbstring php-json php-fileinfo php-openssl php-session php-posix php-zip php-xml php-curl php-intl php-gd php-bcmath php-ctype which curl wget git sqlite 2>&1 | tee -a "$LOG_FILE" || true
    ;;
  apt)
    export DEBIAN_FRONTEND=noninteractive
    $SUDO apt update -qq 2>&1 | tee -a "$LOG_FILE"
    info "Installing via apt..."
    $SUDO apt install -y -qq php-cli php-common php-pdo php-sqlite3 php-mbstring php-json php-fileinfo php-openssl php-session php-filter php-curl php-zip php-xml php-intl php-gd php-bcmath php-ctype php-iconv php-tokenizer php-xmlreader php-phar curl wget git sqlite3 ca-certificates imagemagick inkscape 2>&1 | tee -a "$LOG_FILE" || true
    ;;
  pacman)
    info "Installing via pacman..."
    $SUDO pacman -S --noconfirm --needed php php-gd php-intl php-sqlite php-curl curl wget git sqlite 2>&1 | tee -a "$LOG_FILE" || true
    ;;
  zypper)
    info "Installing via zypper..."
    $SUDO zypper install -y php8 php8-cli php8-pdo php8-sqlite php8-mbstring php8-json php8-fileinfo php8-openssl php8-session php8-curl php8-zip php8-xml php8-intl php8-gd php8-bcmath php8-ctype curl wget git sqlite3 2>&1 | tee -a "$LOG_FILE" || true
    ;;
esac
if command -v php &>/dev/null; then
    PHP_VERSION=$(php -v | head -n 1 | cut -d " " -f 2)
    ok "PHP ${PHP_VERSION} installed"
else
    err "PHP installation failed"; exit 1
fi

# ===== STEP 3: Verify Extensions =====
step "Step 3/6: Verifying PHP extensions"
MISSING=0
REQUIRED_EXTS=(pdo pdo_sqlite mbstring json fileinfo openssl session filter sodium)
for ext in "${REQUIRED_EXTS[@]}"; do
    if php -m 2>/dev/null | grep -qi "^${ext}$"; then ok "$ext"
    else err "$ext - MISSING"; MISSING=$((MISSING+1)); fi
done
[ $MISSING -gt 0 ] && { err "$MISSING extensions missing"; exit 1; }
ok "All ${#REQUIRED_EXTS[@]} extensions verified"

# ===== STEP 4: Directories + Permissions =====
step "Step 4/6: Creating directories and setting permissions"
for dir in data storage logs uploads; do
    mkdir -p "${APP_DIR}/${dir}"
    $SUDO chmod 750 "${APP_DIR}/${dir}"
    ok "Directory created: ${dir}/ (chmod 750)"
done
$SUDO chmod +x "${APP_DIR}/install-deps.sh" "${APP_DIR}/launch.sh" 2>/dev/null || true
ok "Scripts made executable"
if command -v chown &>/dev/null && [ -n "$SUDO" ]; then
    WEB_USER=$(ps aux 2>/dev/null | grep -E '[a]pache|[h]ttpd|[n]ginx' | head -1 | awk '{print $1}')
    [ -n "$WEB_USER" ] && { $SUDO chown -R "$WEB_USER":"$WEB_USER" "${APP_DIR}/data" "${APP_DIR}/storage" "${APP_DIR}/uploads" 2>/dev/null || true; ok "Ownership set to $WEB_USER"; }
fi

# ===== STEP 5: Initialize Database =====
step "Step 5/6: Initializing SQLite database"
if php -r "require '${APP_DIR}/includes/seed.php'; seedDatabase();" 2>&1 | tee -a "$LOG_FILE"; then
    ok "Database initialized successfully"
else
    warn "Database may already exist"
fi
[ -f "${APP_DIR}/data/regenmed.db" ] && { DB_SIZE=$(du -h "${APP_DIR}/data/regenmed.db" | cut -f1); ok "Database: data/regenmed.db (${DB_SIZE})"; }

# ===== STEP 6: Firewall / SELinux =====
step "Step 6/6: Configuring system security"
if command -v firewall-cmd &>/dev/null && $SUDO firewall-cmd --state 2>/dev/null | grep -q running; then
    $SUDO firewall-cmd --permanent --add-port=8081/tcp 2>/dev/null && $SUDO firewall-cmd --reload 2>/dev/null
    ok "Firewall: port 8081 opened"
fi
if command -v getenforce &>/dev/null && [ "$(getenforce 2>/dev/null)" = "Enforcing" ]; then
    $SUDO setsebool -P httpd_can_network_connect 1 2>/dev/null || true
    ok "SELinux: configured"
fi

# ===== DONE =====
echo ""
echo -e "${GREEN}╔════════════════════════════════════════╗${NC}"
echo -e "${GREEN}  Setup Complete! Everything ready.${NC}"
echo -e "${GREEN}╚════════════════════════════════════════╝${NC}"
echo ""
log "${BOLD}Quick Start:${NC}"
echo -e "  ${YELLOW}cd ~/Apps/RegenMed${NC}"
echo -e "  ${YELLOW}./launch.sh${NC}"
echo ""
log "${BOLD}Default Login:${NC}"
echo -e "  Username: ${GREEN}admin${NC}"
echo -e "  Password: ${GREEN}admin123${NC}"
echo ""
log "Full log: $LOG_FILE"
echo ""
