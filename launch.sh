#!/bin/bash
# RegenMed Diagnostic Platform - Safe Launch Script
set -e

GREEN='\033[0;32m'; YELLOW='\033[1;33m'; RED='\033[0;31m'
BLUE='\033[0;34m'; CYAN='\033[0;36m'; BOLD='\033[1m'; NC='\033[0m'
APP_DIR="$(cd "$(dirname "$0")" && pwd)"
LOG_FILE="${APP_DIR}/storage/logs/launch-$(date +%Y%m%d-%H%M%S).log"
DEFAULT_PORT=8081
MAX_PORT=8120
PORT=$DEFAULT_PORT

mkdir -p "${APP_DIR}/storage/logs"
log() { echo -e "[$(date +%H:%M:%S)] $1" | tee -a "$LOG_FILE"; }
ok()   { log "  ${GREEN}✓${NC} $1"; }
warn() { log "  ${YELLOW}⚠${NC} $1"; }
err()  { log "  ${RED}✗${NC} $1"; }
info() { log "  ${BLUE}ℹ${NC} $1"; }

echo -e "${GREEN}╔════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║  RegenMed - Starting Server           ║${NC}"
echo -e "${GREEN}╚════════════════════════════════════════╝${NC}"

# Check PHP
log "${BOLD}Checking PHP...${NC}"
if ! command -v php &>/dev/null; then
    err "PHP not found. Run ./install-deps.sh first"; exit 1
fi
PHP_VERSION=$(php -v | head -n 1 | cut -d " " -f 2)
ok "PHP ${PHP_VERSION} found"

# Check extensions
log "${BOLD}Checking extensions...${NC}"
for ext in pdo pdo_sqlite mbstring json fileinfo openssl session filter sodium; do
    php -m 2>/dev/null | grep -qi "^${ext}$" && ok "$ext" || { err "$ext missing"; exit 1; }
done

# Find port
log "${BOLD}Checking port availability...${NC}"
check_port() {
    local port=$1
    if command -v ss &>/dev/null; then ss -tln 2>/dev/null | grep -q ":${port} " && return 0
    elif command -v netstat &>/dev/null; then netstat -tln 2>/dev/null | grep -q ":${port} " && return 0
    elif command -v lsof &>/dev/null; then lsof -i :"${port}" -sTCP:LISTEN &>/dev/null && return 0; fi
    (echo >/dev/tcp/127.0.0.1/${port}) 2>/dev/null && return 0
    return 1
}
while [ $PORT -le $MAX_PORT ]; do
    if check_port $PORT; then
        warn "Port $PORT in use, trying next..."
        PORT=$((PORT+1))
    else
        ok "Port $PORT available"
        break
    fi
done
[ $PORT -gt $MAX_PORT ] && { err "No available ports"; exit 1; }

# Custom port
if [ -n "$1" ]; then
    [[ "$1" =~ ^[0-9]+$ ]] && [ "$1" -ge 1 ] && [ "$1" -le 65535 ] || { err "Invalid port: $1"; exit 1; }
    check_port "$1" && { err "Port $1 in use"; exit 1; }
    PORT=$1
    ok "Using custom port: $PORT"
fi

# Create dirs
log "${BOLD}Preparing directories...${NC}"
mkdir -p "${APP_DIR}/data" "${APP_DIR}/storage/logs" "${APP_DIR}/uploads"
chmod 750 "${APP_DIR}/data" "${APP_DIR}/storage" "${APP_DIR}/uploads"
ok "Directories ready"

# Stop previous
if [ -f "${APP_DIR}/.server.pid" ]; then
    OLD_PID=$(cat "${APP_DIR}/.server.pid")
    if kill -0 "$OLD_PID" 2>/dev/null; then
        warn "Stopping previous instance (PID: $OLD_PID)"
        kill "$OLD_PID" 2>/dev/null; sleep 1
    fi
    rm -f "${APP_DIR}/.server.pid"
fi

# Start server
echo ""
echo -e "${GREEN}╔════════════════════════════════════════╗${NC}"
echo -e "${GREEN}  Server starting on port ${PORT}${NC}"
echo -e "${GREEN}  URL: http://localhost:${PORT}${NC}"
echo -e "${GREEN}  Ctrl+C to stop${NC}"
echo -e "${GREEN}╚════════════════════════════════════════╝${NC}"
echo ""

cd "$APP_DIR"
php -S "127.0.0.1:${PORT}" -t "$APP_DIR" > "$LOG_FILE" 2>&1 &
SERVER_PID=$!
echo $SERVER_PID > "${APP_DIR}/.server.pid"

sleep 1
if kill -0 $SERVER_PID 2>/dev/null; then
    ok "Server running (PID: $SERVER_PID)"
    info "Log: $LOG_FILE"
    trap "echo ''; log 'Stopping server...'; kill $SERVER_PID 2>/dev/null; rm -f '${APP_DIR}/.server.pid'; ok 'Server stopped.'" INT TERM
    wait $SERVER_PID
else
    err "Server failed to start"
    cat "$LOG_FILE" 2>/dev/null
    rm -f "${APP_DIR}/.server.pid"
    exit 1
fi
