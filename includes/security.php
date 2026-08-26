<?php
declare(strict_types=1);

/**
 * Regen Med Health Security Layer
 * Comprehensive security hardening for the diagnostic platform
 */

class SecurityManager
{
    private static array $rateLimit = [];
    private const MAX_REQUESTS_PER_MINUTE = 60;
    private const MAX_LOGIN_ATTEMPTS = 5;
    private const LOCKOUT_DURATION = 900;
    private const ALLOWED_TAGS = '<br><p><strong><em><ul><ol><li><h1><h2><h3><h4><h5><h6><span><div><table><thead><tbody><tr><td><th>';
    
    public static function init(): void {
        self::enforceSecurityHeaders();
        self::validateRequestMethod();
        self::checkRateLimit();
        self::sanitizeAllInput();
        self::preventSessionFixation();
    }
    
    private static function enforceSecurityHeaders(): void {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: DENY');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header_remove('X-Powered-By');
        header_remove('Server');
    }
    
    private static function validateRequestMethod(): void {
        $allowedMethods = ['GET', 'POST', 'HEAD'];
        if (!in_array($_SERVER['REQUEST_METHOD'], $allowedMethods, true)) {
            http_response_code(405);
            header('Allow: GET, POST, HEAD');
            exit('Method Not Allowed');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
            if (strpos($contentType, 'application/x-www-form-urlencoded') === false && 
                strpos($contentType, 'multipart/form-data') === false &&
                strpos($contentType, 'application/json') === false) {
                http_response_code(415);
                exit('Unsupported Media Type');
            }
        }
    }
    
    private static function checkRateLimit(): void {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        $key = md5($ip);
        $now = time();
        
        if (!isset(self::$rateLimit[$key])) {
            self::$rateLimit[$key] = ['count' => 0, 'start' => $now];
        }
        
        if ($now - self::$rateLimit[$key]['start'] > 60) {
            self::$rateLimit[$key] = ['count' => 0, 'start' => $now];
        }
        
        self::$rateLimit[$key]['count']++;
        
        if (self::$rateLimit[$key]['count'] > self::MAX_REQUESTS_PER_MINUTE) {
            http_response_code(429);
            header('Retry-After: 60');
            exit('Too Many Requests');
        }
    }
    
    private static function sanitizeAllInput(): void {
        if (!empty($_GET)) {
            $_GET = self::deepSanitize($_GET);
        }
        if (!empty($_POST)) {
            $_POST = self::deepSanitize($_POST);
        }
        if (!empty($_COOKIE)) {
            $_COOKIE = self::deepSanitize($_COOKIE);
        }
    }
    
    private static function deepSanitize($data) {
        if (is_array($data)) {
            return array_map([self::class, 'deepSanitize'], $data);
        }
        if (is_string($data)) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $data = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $data);
            return $data;
        }
        return $data;
    }
    
    private static function preventSessionFixation(): void {
        if (session_status() === PHP_SESSION_ACTIVE) {
            if (!isset($_SESSION['initiated'])) {
                session_regenerate_id(true);
                $_SESSION['initiated'] = true;
                $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
                $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'] ?? '';
            }
            if (isset($_SESSION['ip_address']) && $_SESSION['ip_address'] !== ($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0')) {
                session_destroy();
                session_start();
            }
            if (isset($_SESSION['user_agent']) && $_SESSION['user_agent'] !== ($_SERVER['HTTP_USER_AGENT'] ?? '')) {
                session_destroy();
                session_start();
            }
        }
    }
    
    public static function validateCSRF(string $token): bool {
        if (empty($_SESSION['csrf_token']) || empty($token)) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }
    
    public static function generateCSRF(): string {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    public static function getNonce(): string {
        static $nonce = null;
        if ($nonce === null) {
            $nonce = base64_encode(random_bytes(16));
        }
        return $nonce;
    }
    
    public static function validateFileUpload(array $file): array {
        $errors = [];
        $maxSize = 50 * 1024 * 1024;
        $allowedExtensions = ['dcm', 'nii', 'nii.gz', 'png', 'jpg', 'jpeg', 'zip', 'csv', 'json', 'gz', 'tar'];
        $allowedMimeTypes = ['application/dicom', 'application/octet-stream', 'image/png', 'image/jpeg', 'application/zip', 'text/csv', 'application/json', 'application/gzip', 'application/x-gzip', 'application/x-tar', 'multipart/x-gzip'];
        
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'Upload error code: ' . $file['error'];
            return $errors;
        }
        
        if ($file['size'] > $maxSize) {
            $errors[] = 'File exceeds maximum size of 50MB';
        }
        
        if ($file['size'] === 0) {
            $errors[] = 'Empty file uploaded';
        }
        
        $filename = $file['name'] ?? '';
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if ($extension === 'gz' && strpos($filename, '.nii.gz') !== false) {
            $extension = 'nii.gz';
        }
        
        if (!in_array($extension, $allowedExtensions, true)) {
            $errors[] = 'File type not allowed: ' . $extension;
        }
        
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);
        
        if (!in_array($mimeType, $allowedMimeTypes, true)) {
            $errors[] = 'MIME type not allowed: ' . $mimeType;
        }
        
        if (strpos($mimeType, 'php') !== false || strpos($filename, '.php') !== false) {
            $errors[] = 'PHP files are not allowed';
        }
        
        $content = file_get_contents($file['tmp_name']);
        if (preg_match('/<\?php|<\?=|<\?/i', $content)) {
            $errors[] = 'File contains executable code';
        }
        
        return $errors;
    }
    
    public static function generateSecureFilename(string $originalName): string {
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $allowedExtensions = ['dcm', 'nii', 'gz', 'png', 'jpg', 'jpeg', 'zip', 'csv', 'json', 'tar'];
        
        if (!in_array($extension, $allowedExtensions, true)) {
            $extension = 'bin';
        }
        
        return bin2hex(random_bytes(16)) . '.' . $extension;
    }
    
    public static function encryptData(string $data, string $key): string {
        $iv = random_bytes(16);
        $encrypted = openssl_encrypt($data, 'AES-256-GCM', $key, OPENSSL_RAW_DATA, $iv, $tag);
        return base64_encode($iv . $tag . $encrypted);
    }
    
    public static function decryptData(string $data, string $key): ?string {
        $data = base64_decode($data);
        $iv = substr($data, 0, 16);
        $tag = substr($data, 16, 16);
        $ciphertext = substr($data, 32);
        $decrypted = openssl_decrypt($ciphertext, 'AES-256-GCM', $key, OPENSSL_RAW_DATA, $iv, $tag);
        return $decrypted !== false ? $decrypted : null;
    }
    
    public static function hashPassword(string $password): string {
        return password_hash($password, PASSWORD_ARGON2ID, [
            'memory_cost' => 65536,
            'time_cost' => 4,
            'threads' => 3
        ]);
    }
    
    public static function verifyPassword(string $password, string $hash): bool {
        return password_verify($password, $hash);
    }
    
    public static function needsRehash(string $hash): bool {
        return password_needs_rehash($hash, PASSWORD_ARGON2ID);
    }
    
    public static function sanitizeOutput(string $data): string {
        return htmlspecialchars($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
    
    public static function stripTags(string $data): string {
        return strip_tags($data, self::ALLOWED_TAGS);
    }
    
    public static function validateEmail(string $email): bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    public static function validateIP(string $ip): bool {
        return filter_var($ip, FILTER_VALIDATE_IP) !== false;
    }
    
    public static function logSecurityEvent(string $event, array $context = []): void {
        if (VERCEL_MODE) return;
        $logEntry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'event' => $event,
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            'request_uri' => $_SERVER['REQUEST_URI'] ?? 'unknown',
            'context' => $context
        ];
        
        $logDir = __DIR__ . '/../storage/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0750, true);
        }
        
        $logFile = $logDir . '/security-' . date('Y-m-d') . '.log';
        file_put_contents($logFile, json_encode($logEntry) . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
    
    public static function isLoggedIn(): bool {
        return isset($_SESSION['user_id']) && is_int($_SESSION['user_id']) && $_SESSION['user_id'] > 0;
    }
    
    public static function requireLogin(): void {
        if (!self::isLoggedIn()) {
            header('Location: ?page=login');
            exit;
        }
    }
    
    public static function regenerateSession(): void {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
    }
    
    public static function setSecureCookie(string $name, string $value, int $expiry = 86400): void {
        setcookie($name, $value, [
            'expires' => time() + $expiry,
            'path' => '/',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);
    }
    
    public static function destroyCookie(string $name): void {
        setcookie($name, '', [
            'expires' => time() - 3600,
            'path' => '/',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);
        unset($_COOKIE[$name]);
    }
    
    public static function getHoneypotField(): string {
        return '<div style="position:absolute;left:-9999px;top:-9999px;opacity:0"><input type="text" name="website_url" tabindex="-1" autocomplete="off"></div>';
    }
    
    public static function checkHoneypot(): bool {
        return empty($_POST['website_url']);
    }
    
    public static function validateJSON(string $json): bool {
        json_decode($json);
        return json_last_error() === JSON_ERROR_NONE;
    }
    
    public static function getRequestBody(): ?array {
        $body = file_get_contents('php://input');
        if (empty($body)) {
            return null;
        }
        $data = json_decode($body, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }
        return self::deepSanitize($data);
    }
}

class InputValidator
{
    private array $errors = [];
    private array $data;
    
    public function __construct(array $data) {
        $this->data = $data;
    }
    
    public function required(string $field): self {
        if (!isset($this->data[$field]) || trim($this->data[$field]) === '') {
            $this->errors[$field][] = "$field is required";
        }
        return $this;
    }
    
    public function email(string $field): self {
        if (isset($this->data[$field]) && !SecurityManager::validateEmail($this->data[$field])) {
            $this->errors[$field][] = "Invalid email format";
        }
        return $this;
    }
    
    public function minLength(string $field, int $min): self {
        if (isset($this->data[$field]) && strlen($this->data[$field]) < $min) {
            $this->errors[$field][] = "$field must be at least $min characters";
        }
        return $this;
    }
    
    public function maxLength(string $field, int $max): self {
        if (isset($this->data[$field]) && strlen($this->data[$field]) > $max) {
            $this->errors[$field][] = "$field must be at most $max characters";
        }
        return $this;
    }
    
    public function alphanumeric(string $field): self {
        if (isset($this->data[$field]) && !ctype_alnum(str_replace(['_', '-'], '', $this->data[$field]))) {
            $this->errors[$field][] = "$field must be alphanumeric";
        }
        return $this;
    }
    
    public function numeric(string $field): self {
        if (isset($this->data[$field]) && !is_numeric($this->data[$field])) {
            $this->errors[$field][] = "$field must be numeric";
        }
        return $this;
    }
    
    public function inArray(string $field, array $allowed): self {
        if (isset($this->data[$field]) && !in_array($this->data[$field], $allowed, true)) {
            $this->errors[$field][] = "$field has an invalid value";
        }
        return $this;
    }
    
    public function date(string $field): self {
        if (isset($this->data[$field])) {
            $date = DateTime::createFromFormat('Y-m-d', $this->data[$field]);
            if (!$date || $date->format('Y-m-d') !== $this->data[$field]) {
                $this->errors[$field][] = "$field must be a valid date (YYYY-MM-DD)";
            }
        }
        return $this;
    }
    
    public function passes(): bool {
        return empty($this->errors);
    }
    
    public function fails(): bool {
        return !empty($this->errors);
    }
    
    public function errors(): array {
        return $this->errors;
    }
    
    public function firstError(): ?string {
        if (empty($this->errors)) {
            return null;
        }
        $first = reset($this->errors);
        return is_array($first) ? reset($first) : $first;
    }

    public static function deepSanitizeString(string $input): string {
        return htmlspecialchars(stripslashes(trim($input)), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}

if (php_sapi_name() !== 'cli') {
    SecurityManager::init();
}
