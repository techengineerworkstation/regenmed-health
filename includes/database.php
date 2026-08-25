<?php
/**
 * Regen Med Health - Database Layer
 * MySQL with automatic SQLite fallback for local development
 *
 * @security Uses PDO prepared statements to prevent SQL injection
 * @version 2.1.0
 */

declare(strict_types=1);

class RegenMedDatabase {
    private static ?PDO $instance = null;
    private static ?string $driver = null;

    private static function getConfig(): array {
        static $config = null;
        if ($config === null) {
            $config = require __DIR__ . '/../config.php';
        }
        return $config['database'];
    }

    public static function getDriver(): string {
        return self::$driver ?? 'unknown';
    }

    private static function connectMySQL(array $cfg): ?PDO {
        if (!extension_loaded('pdo_mysql')) {
            return null;
        }
        try {
            $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=%s', $cfg['host'], $cfg['port'], $cfg['dbname'], $cfg['charset']);
            $pdo = new PDO($dsn, $cfg['username'], $cfg['password'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci",
            ]);
            $pdo->exec("SET FOREIGN_KEY_CHECKS=1");
            return $pdo;
        } catch (PDOException $e) {
            error_log('MySQL connection failed, will try SQLite: ' . $e->getMessage());
            return null;
        }
    }

    private static function connectSQLite(): PDO {
        $dbPath = __DIR__ . '/../data/regenmed.sqlite';
        $dir = dirname($dbPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0750, true);
        }
        $pdo = new PDO('sqlite:' . $dbPath, null, null, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
        $pdo->exec('PRAGMA journal_mode=WAL');
        $pdo->exec('PRAGMA foreign_keys=ON');
        $pdo->exec('PRAGMA busy_timeout=5000');
        return $pdo;
    }

    public static function getInstance(): PDO {
        if (self::$instance === null) {
            $cfg = self::getConfig();

            $pdo = self::connectMySQL($cfg);
            if ($pdo !== null) {
                self::$driver = 'mysql';
                self::$instance = $pdo;
                self::initializeTablesMySQL();
            } else {
                self::$driver = 'sqlite';
                self::$instance = self::connectSQLite();
                self::initializeTablesSQLite();
            }
        }
        return self::$instance;
    }

    private static function initializeTablesMySQL(): void {
        $db = self::$instance;

        $db->exec("CREATE TABLE IF NOT EXISTS users (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) UNIQUE NOT NULL,
            email VARCHAR(255) UNIQUE NOT NULL,
            password_hash VARCHAR(255) NOT NULL,
            display_name VARCHAR(100),
            role VARCHAR(20) DEFAULT 'user' CHECK(role IN ('user', 'admin', 'clinician', 'researcher')),
            institution VARCHAR(255),
            is_active TINYINT(1) DEFAULT 1,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            last_login DATETIME
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $db->exec("CREATE TABLE IF NOT EXISTS sessions (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT UNSIGNED,
            session_token VARCHAR(64) UNIQUE NOT NULL,
            ip_address VARCHAR(45),
            user_agent TEXT,
            is_active TINYINT(1) DEFAULT 1,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            expires_at DATETIME,
            last_activity DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $db->exec("CREATE TABLE IF NOT EXISTS browsing_history (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT UNSIGNED,
            session_id INT UNSIGNED,
            page VARCHAR(255) NOT NULL,
            query_string TEXT,
            referer TEXT,
            ip_address VARCHAR(45),
            user_agent TEXT,
            response_time_ms INT UNSIGNED,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (session_id) REFERENCES sessions(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $db->exec("CREATE TABLE IF NOT EXISTS patients (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT UNSIGNED NOT NULL,
            patient_id VARCHAR(50) NOT NULL,
            first_name VARCHAR(100),
            last_name VARCHAR(100),
            date_of_birth DATE,
            gender VARCHAR(10) CHECK(gender IN ('male', 'female', 'other')),
            medical_record_number VARCHAR(100),
            notes TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            UNIQUE KEY uniq_user_patient (user_id, patient_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $db->exec("CREATE TABLE IF NOT EXISTS scans (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT UNSIGNED NOT NULL,
            patient_id INT UNSIGNED,
            condition_type VARCHAR(50) NOT NULL CHECK(condition_type IN ('knee_arthritis', 'retinal_degeneration', 'male_factor_enhancing_fertility', 'female_factor_enhancing_fertility', 'prostate_disease', 'other')),
            modality VARCHAR(20) NOT NULL CHECK(modality IN ('MRI', 'CT', 'Ultrasound', 'OCT', 'X-ray', 'PET', 'Other')),
            severity_grade TINYINT UNSIGNED CHECK(severity_grade BETWEEN 1 AND 5),
            file_name VARCHAR(255),
            file_path VARCHAR(500),
            file_size INT UNSIGNED,
            file_type VARCHAR(50),
            dicom_metadata JSON,
            clinical_notes TEXT,
            ai_findings TEXT,
            ai_confidence DECIMAL(5,2),
            status VARCHAR(20) DEFAULT 'pending' CHECK(status IN ('pending', 'processing', 'reviewed', 'archived')),
            uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            reviewed_at DATETIME,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $db->exec("CREATE TABLE IF NOT EXISTS training_data (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT UNSIGNED NOT NULL,
            dataset_name VARCHAR(255) NOT NULL,
            model_type VARCHAR(30) NOT NULL CHECK(model_type IN ('segmentation', 'classification', 'detection', 'registration', 'reconstruction', 'other')),
            condition_type VARCHAR(50) NOT NULL,
            gpu_provider VARCHAR(30) CHECK(gpu_provider IN ('google_colab', 'runpod', 'lambda', 'vastai', 'intel_tiber', 'local', 'other')),
            file_name VARCHAR(255),
            file_path VARCHAR(500),
            file_size INT UNSIGNED,
            sample_count INT UNSIGNED,
            label_status VARCHAR(20) DEFAULT 'unlabeled' CHECK(label_status IN ('fully_labeled', 'partially_labeled', 'unlabeled', 'synthetic')),
            augmentation_notes TEXT,
            status VARCHAR(20) DEFAULT 'active' CHECK(status IN ('active', 'training', 'completed', 'archived')),
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $db->exec("CREATE TABLE IF NOT EXISTS inferences (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT UNSIGNED NOT NULL,
            scan_id INT UNSIGNED,
            training_data_id INT UNSIGNED,
            model_name VARCHAR(255) NOT NULL,
            model_version VARCHAR(50),
            condition_type VARCHAR(50) NOT NULL,
            result_type VARCHAR(30) NOT NULL CHECK(result_type IN ('positive_finding', 'negative', 'requires_review', 'segmentation_complete', 'classification_result', 'detection_result', 'other')),
            confidence_score DECIMAL(5,2),
            output_file_path VARCHAR(500),
            findings_summary TEXT,
            recommendation TEXT,
            is_validated TINYINT(1) DEFAULT 0,
            validated_by INT UNSIGNED,
            inference_time_ms INT UNSIGNED,
            gpu_provider VARCHAR(30),
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (scan_id) REFERENCES scans(id) ON DELETE SET NULL,
            FOREIGN KEY (training_data_id) REFERENCES training_data(id) ON DELETE SET NULL,
            FOREIGN KEY (validated_by) REFERENCES users(id) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $db->exec("CREATE TABLE IF NOT EXISTS treatment_recommendations (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT UNSIGNED NOT NULL,
            inference_id INT UNSIGNED,
            patient_id INT UNSIGNED,
            condition_type VARCHAR(50) NOT NULL,
            focus_area VARCHAR(20) NOT NULL CHECK(focus_area IN ('comprehensive', 'stem_cell', 'pemf', 'supplements', 'imaging', 'protocol')),
            recommendation_json JSON NOT NULL,
            status VARCHAR(20) DEFAULT 'active' CHECK(status IN ('active', 'in_progress', 'completed', 'archived')),
            outcome_notes TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            completed_at DATETIME,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (inference_id) REFERENCES inferences(id) ON DELETE SET NULL,
            FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $db->exec("CREATE TABLE IF NOT EXISTS api_requests (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT UNSIGNED,
            session_id INT UNSIGNED,
            request_method VARCHAR(10) NOT NULL,
            endpoint VARCHAR(500) NOT NULL,
            request_body TEXT,
            response_code SMALLINT UNSIGNED,
            response_time_ms INT UNSIGNED,
            ip_address VARCHAR(45),
            user_agent TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (session_id) REFERENCES sessions(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $db->exec("CREATE TABLE IF NOT EXISTS user_preferences (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT UNSIGNED UNIQUE NOT NULL,
            theme VARCHAR(10) DEFAULT 'light' CHECK(theme IN ('light', 'dark', 'auto')),
            default_gpu_provider VARCHAR(50) DEFAULT 'google_colab',
            items_per_page INT UNSIGNED DEFAULT 25,
            email_notifications TINYINT(1) DEFAULT 1,
            data_retention_days INT UNSIGNED DEFAULT 365,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $db->exec("CREATE TABLE IF NOT EXISTS upload_sessions (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT UNSIGNED NOT NULL,
            upload_token VARCHAR(64) UNIQUE NOT NULL,
            upload_type VARCHAR(20) NOT NULL CHECK(upload_type IN ('scan', 'training', 'inference', 'bulk')),
            total_files INT UNSIGNED DEFAULT 0,
            processed_files INT UNSIGNED DEFAULT 0,
            failed_files INT UNSIGNED DEFAULT 0,
            file_paths TEXT,
            status VARCHAR(20) DEFAULT 'pending' CHECK(status IN ('pending', 'uploading', 'processing', 'completed', 'failed')),
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            completed_at DATETIME,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $db->exec("CREATE TABLE IF NOT EXISTS magic_links (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT UNSIGNED NOT NULL,
            token VARCHAR(64) UNIQUE NOT NULL,
            email VARCHAR(255) NOT NULL,
            expires_at DATETIME NOT NULL,
            used TINYINT(1) DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $db->exec("CREATE INDEX IF NOT EXISTS idx_sessions_token ON sessions(session_token)");
        $db->exec("CREATE INDEX IF NOT EXISTS idx_sessions_user ON sessions(user_id)");
        $db->exec("CREATE INDEX IF NOT EXISTS idx_browsing_user ON browsing_history(user_id)");
        $db->exec("CREATE INDEX IF NOT EXISTS idx_browsing_session ON browsing_history(session_id)");
        $db->exec("CREATE INDEX IF NOT EXISTS idx_browsing_page ON browsing_history(page)");
        $db->exec("CREATE INDEX IF NOT EXISTS idx_browsing_created ON browsing_history(created_at)");
        $db->exec("CREATE INDEX IF NOT EXISTS idx_scans_user ON scans(user_id)");
        $db->exec("CREATE INDEX IF NOT EXISTS idx_scans_condition ON scans(condition_type)");
        $db->exec("CREATE INDEX IF NOT EXISTS idx_inferences_user ON inferences(user_id)");
        $db->exec("CREATE INDEX IF NOT EXISTS idx_inferences_created ON inferences(created_at)");
        $db->exec("CREATE INDEX IF NOT EXISTS idx_magic_links_token ON magic_links(token)");
    }

    private static function initializeTablesSQLite(): void {
        $db = self::$instance;

        $db->exec("CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE NOT NULL,
            email TEXT UNIQUE NOT NULL,
            password_hash TEXT NOT NULL,
            display_name TEXT,
            role TEXT DEFAULT 'user' CHECK(role IN ('user', 'admin', 'clinician', 'researcher')),
            institution TEXT,
            is_active INTEGER DEFAULT 1,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            last_login DATETIME
        )");

        $db->exec("CREATE TABLE IF NOT EXISTS sessions (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER,
            session_token TEXT UNIQUE NOT NULL,
            ip_address TEXT,
            user_agent TEXT,
            is_active INTEGER DEFAULT 1,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            expires_at DATETIME,
            last_activity DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )");

        $db->exec("CREATE TABLE IF NOT EXISTS browsing_history (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER,
            session_id INTEGER,
            page TEXT NOT NULL,
            query_string TEXT,
            referer TEXT,
            ip_address TEXT,
            user_agent TEXT,
            response_time_ms INTEGER,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (session_id) REFERENCES sessions(id) ON DELETE CASCADE
        )");

        $db->exec("CREATE TABLE IF NOT EXISTS patients (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            patient_id TEXT NOT NULL,
            first_name TEXT,
            last_name TEXT,
            date_of_birth DATE,
            gender TEXT CHECK(gender IN ('male', 'female', 'other')),
            medical_record_number TEXT,
            notes TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            UNIQUE(user_id, patient_id)
        )");

        $db->exec("CREATE TABLE IF NOT EXISTS scans (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            patient_id INTEGER,
            condition_type TEXT NOT NULL CHECK(condition_type IN ('knee_arthritis', 'retinal_degeneration', 'male_factor_enhancing_fertility', 'female_factor_enhancing_fertility', 'prostate_disease', 'other')),
            modality TEXT NOT NULL CHECK(modality IN ('MRI', 'CT', 'Ultrasound', 'OCT', 'X-ray', 'PET', 'Other')),
            severity_grade INTEGER CHECK(severity_grade BETWEEN 1 AND 5),
            file_name TEXT,
            file_path TEXT,
            file_size INTEGER,
            file_type TEXT,
            dicom_metadata TEXT,
            clinical_notes TEXT,
            ai_findings TEXT,
            ai_confidence REAL,
            status TEXT DEFAULT 'pending' CHECK(status IN ('pending', 'processing', 'reviewed', 'archived')),
            uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            reviewed_at DATETIME,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE SET NULL
        )");

        $db->exec("CREATE TABLE IF NOT EXISTS training_data (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            dataset_name TEXT NOT NULL,
            model_type TEXT NOT NULL CHECK(model_type IN ('segmentation', 'classification', 'detection', 'registration', 'reconstruction', 'other')),
            condition_type TEXT NOT NULL,
            gpu_provider TEXT CHECK(gpu_provider IN ('google_colab', 'runpod', 'lambda', 'vastai', 'intel_tiber', 'local', 'other')),
            file_name TEXT,
            file_path TEXT,
            file_size INTEGER,
            sample_count INTEGER,
            label_status TEXT DEFAULT 'unlabeled' CHECK(label_status IN ('fully_labeled', 'partially_labeled', 'unlabeled', 'synthetic')),
            augmentation_notes TEXT,
            status TEXT DEFAULT 'active' CHECK(status IN ('active', 'training', 'completed', 'archived')),
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )");

        $db->exec("CREATE TABLE IF NOT EXISTS inferences (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            scan_id INTEGER,
            training_data_id INTEGER,
            model_name TEXT NOT NULL,
            model_version TEXT,
            condition_type TEXT NOT NULL,
            result_type TEXT NOT NULL CHECK(result_type IN ('positive_finding', 'negative', 'requires_review', 'segmentation_complete', 'classification_result', 'detection_result', 'other')),
            confidence_score REAL,
            output_file_path TEXT,
            findings_summary TEXT,
            recommendation TEXT,
            is_validated INTEGER DEFAULT 0,
            validated_by INTEGER,
            inference_time_ms INTEGER,
            gpu_provider TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (scan_id) REFERENCES scans(id) ON DELETE SET NULL,
            FOREIGN KEY (training_data_id) REFERENCES training_data(id) ON DELETE SET NULL,
            FOREIGN KEY (validated_by) REFERENCES users(id) ON DELETE SET NULL
        )");

        $db->exec("CREATE TABLE IF NOT EXISTS treatment_recommendations (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            inference_id INTEGER,
            patient_id INTEGER,
            condition_type TEXT NOT NULL,
            focus_area TEXT NOT NULL CHECK(focus_area IN ('comprehensive', 'stem_cell', 'pemf', 'supplements', 'imaging', 'protocol')),
            recommendation_json TEXT NOT NULL,
            status TEXT DEFAULT 'active' CHECK(status IN ('active', 'in_progress', 'completed', 'archived')),
            outcome_notes TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            completed_at DATETIME,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (inference_id) REFERENCES inferences(id) ON DELETE SET NULL,
            FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE SET NULL
        )");

        $db->exec("CREATE TABLE IF NOT EXISTS api_requests (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER,
            session_id INTEGER,
            request_method TEXT NOT NULL,
            endpoint TEXT NOT NULL,
            request_body TEXT,
            response_code INTEGER,
            response_time_ms INTEGER,
            ip_address TEXT,
            user_agent TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (session_id) REFERENCES sessions(id) ON DELETE CASCADE
        )");

        $db->exec("CREATE TABLE IF NOT EXISTS user_preferences (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER UNIQUE NOT NULL,
            theme TEXT DEFAULT 'light' CHECK(theme IN ('light', 'dark', 'auto')),
            default_gpu_provider TEXT DEFAULT 'google_colab',
            items_per_page INTEGER DEFAULT 25,
            email_notifications INTEGER DEFAULT 1,
            data_retention_days INTEGER DEFAULT 365,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )");

        $db->exec("CREATE TABLE IF NOT EXISTS upload_sessions (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            upload_token TEXT UNIQUE NOT NULL,
            upload_type TEXT NOT NULL CHECK(upload_type IN ('scan', 'training', 'inference', 'bulk')),
            total_files INTEGER DEFAULT 0,
            processed_files INTEGER DEFAULT 0,
            failed_files INTEGER DEFAULT 0,
            file_paths TEXT,
            status TEXT DEFAULT 'pending' CHECK(status IN ('pending', 'uploading', 'processing', 'completed', 'failed')),
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            completed_at DATETIME,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )");

        $db->exec("CREATE TABLE IF NOT EXISTS magic_links (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            token TEXT UNIQUE NOT NULL,
            email TEXT NOT NULL,
            expires_at DATETIME NOT NULL,
            used INTEGER DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )");

        $db->exec("CREATE INDEX IF NOT EXISTS idx_sessions_token ON sessions(session_token)");
        $db->exec("CREATE INDEX IF NOT EXISTS idx_sessions_user ON sessions(user_id)");
        $db->exec("CREATE INDEX IF NOT EXISTS idx_browsing_user ON browsing_history(user_id)");
        $db->exec("CREATE INDEX IF NOT EXISTS idx_browsing_session ON browsing_history(session_id)");
        $db->exec("CREATE INDEX IF NOT EXISTS idx_browsing_page ON browsing_history(page)");
        $db->exec("CREATE INDEX IF NOT EXISTS idx_browsing_created ON browsing_history(created_at)");
        $db->exec("CREATE INDEX IF NOT EXISTS idx_scans_user ON scans(user_id)");
        $db->exec("CREATE INDEX IF NOT EXISTS idx_scans_condition ON scans(condition_type)");
        $db->exec("CREATE INDEX IF NOT EXISTS idx_inferences_user ON inferences(user_id)");
        $db->exec("CREATE INDEX IF NOT EXISTS idx_inferences_created ON inferences(created_at)");
        $db->exec("CREATE INDEX IF NOT EXISTS idx_magic_links_token ON magic_links(token)");
    }

    public static function logPageView(?int $userId, ?int $sessionId, string $page, ?string $queryString = null, ?string $referer = null, ?int $responseTime = null): void {
        $db = self::getInstance();
        $stmt = $db->prepare("INSERT INTO browsing_history (user_id, session_id, page, query_string, referer, ip_address, user_agent, response_time_ms) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $userId,
            $sessionId,
            $page,
            $queryString,
            $referer,
            $_SERVER['REMOTE_ADDR'] ?? null,
            $_SERVER['HTTP_USER_AGENT'] ?? null,
            $responseTime
        ]);
    }

    public static function getBrowsingHistory(?int $userId, int $limit = 100): array {
        $db = self::getInstance();
        $stmt = $db->prepare("SELECT * FROM browsing_history WHERE user_id = ? OR ? IS NULL ORDER BY created_at DESC LIMIT ?");
        $stmt->execute([$userId, $userId, $limit]);
        return $stmt->fetchAll();
    }

    public static function createUser(string $username, string $email, string $password, string $displayName = '', string $role = 'user'): int {
        $db = self::getInstance();
        $stmt = $db->prepare("INSERT INTO users (username, email, password_hash, display_name, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$username, $email, password_hash($password, PASSWORD_ARGON2ID), $displayName, $role]);
        return (int)$db->lastInsertId();
    }

    public static function authenticateUser(string $username, string $password): ?array {
        $db = self::getInstance();
        $stmt = $db->prepare("SELECT * FROM users WHERE (username = ? OR email = ?) AND is_active = 1");
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password_hash'])) {
            $updateStmt = $db->prepare("UPDATE users SET last_login = CURRENT_TIMESTAMP WHERE id = ?");
            $updateStmt->execute([$user['id']]);
            return $user;
        }
        return null;
    }

    public static function createSession(int $userId): string {
        $db = self::getInstance();
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+8 hours'));
        $stmt = $db->prepare("INSERT INTO sessions (user_id, session_token, ip_address, user_agent, expires_at) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$userId, $token, $_SERVER['REMOTE_ADDR'] ?? null, $_SERVER['HTTP_USER_AGENT'] ?? null, $expires]);
        return $token;
    }

    public static function validateSession(string $token): ?array {
        $db = self::getInstance();
        $stmt = $db->prepare("SELECT s.*, u.username, u.role, u.display_name FROM sessions s JOIN users u ON s.user_id = u.id WHERE s.session_token = ? AND s.is_active = 1 AND s.expires_at > CURRENT_TIMESTAMP");
        $stmt->execute([$token]);
        return $stmt->fetch() ?: null;
    }

    public static function invalidateSession(string $token): void {
        $db = self::getInstance();
        $stmt = $db->prepare("UPDATE sessions SET is_active = 0 WHERE session_token = ?");
        $stmt->execute([$token]);
    }

    public static function saveScan(int $userId, array $data): int {
        $db = self::getInstance();
        $stmt = $db->prepare("INSERT INTO scans (user_id, patient_id, condition_type, modality, severity_grade, file_name, file_path, file_size, file_type, clinical_notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $userId,
            $data['patient_id'] ?? null,
            $data['condition_type'],
            $data['modality'],
            $data['severity_grade'] ?? null,
            $data['file_name'] ?? null,
            $data['file_path'] ?? null,
            $data['file_size'] ?? null,
            $data['file_type'] ?? null,
            $data['clinical_notes'] ?? null
        ]);
        return (int)$db->lastInsertId();
    }

    public static function saveInference(int $userId, array $data): int {
        $db = self::getInstance();
        $stmt = $db->prepare("INSERT INTO inferences (user_id, scan_id, model_name, model_version, condition_type, result_type, confidence_score, findings_summary, recommendation, gpu_provider) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $userId,
            $data['scan_id'] ?? null,
            $data['model_name'],
            $data['model_version'] ?? null,
            $data['condition_type'],
            $data['result_type'],
            $data['confidence_score'] ?? null,
            $data['findings_summary'] ?? null,
            $data['recommendation'] ?? null,
            $data['gpu_provider'] ?? null
        ]);
        return (int)$db->lastInsertId();
    }

    public static function createMagicLink(string $email): ?array {
        $db = self::getInstance();
        $stmt = $db->prepare("SELECT id, username, email, display_name FROM users WHERE email = ? AND is_active = 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user) {
            $username = substr($email, 0, strpos($email, '@'));
            $userId = self::createUser($username, $email, bin2hex(random_bytes(16)), $username);
            $stmt = $db->prepare("SELECT id, username, email, display_name FROM users WHERE id = ?");
            $stmt->execute([$userId]);
            $user = $stmt->fetch();
        }

        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+15 minutes'));

        $stmt = $db->prepare("INSERT INTO magic_links (user_id, token, email, expires_at) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user['id'], $token, $email, $expires]);

        return ['token' => $token, 'user' => $user];
    }

    public static function verifyMagicLink(string $token): ?array {
        $db = self::getInstance();
        $stmt = $db->prepare("SELECT ml.*, u.username, u.email, u.display_name FROM magic_links ml JOIN users u ON ml.user_id = u.id WHERE ml.token = ? AND ml.used = 0 AND ml.expires_at > CURRENT_TIMESTAMP");
        $stmt->execute([$token]);
        $link = $stmt->fetch() ?: null;

        if ($link) {
            $stmt = $db->prepare("UPDATE magic_links SET used = 1 WHERE token = ?");
            $stmt->execute([$token]);
        }

        return $link;
    }

    public static function getUserStats(int $userId): array {
        $db = self::getInstance();
        $stats = [];

        $stmt = $db->prepare("SELECT COUNT(*) as count FROM scans WHERE user_id = ?");
        $stmt->execute([$userId]);
        $stats['total_scans'] = $stmt->fetchColumn();

        $stmt = $db->prepare("SELECT COUNT(*) as count FROM inferences WHERE user_id = ?");
        $stmt->execute([$userId]);
        $stats['total_inferences'] = $stmt->fetchColumn();

        $stmt = $db->prepare("SELECT COUNT(*) as count FROM training_data WHERE user_id = ?");
        $stmt->execute([$userId]);
        $stats['total_training_sets'] = $stmt->fetchColumn();

        $stmt = $db->prepare("SELECT COUNT(*) as count FROM treatment_recommendations WHERE user_id = ?");
        $stmt->execute([$userId]);
        $stats['total_recommendations'] = $stmt->fetchColumn();

        $stmt = $db->prepare("SELECT COUNT(*) as count FROM browsing_history WHERE user_id = ?");
        $stmt->execute([$userId]);
        $stats['page_views'] = $stmt->fetchColumn();

        return $stats;
    }
}

class SessionManager {
    public static function start(): void {
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.cookie_httponly', '1');
            ini_set('session.use_strict_mode', '1');
            ini_set('session.cookie_samesite', 'Strict');
            if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
                ini_set('session.cookie_secure', '1');
            }
            session_start();

            if (!isset($_SESSION['created'])) {
                $_SESSION['created'] = time();
            } elseif (time() - $_SESSION['created'] > 1800) {
                session_regenerate_id(true);
                $_SESSION['created'] = time();
            }
        }
    }

    public static function getUserId(): ?int {
        return $_SESSION['user_id'] ?? null;
    }

    public static function setUserId(int $userId): void {
        $_SESSION['user_id'] = $userId;
    }

    public static function isLoggedIn(): bool {
        return isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0;
    }

    public static function logout(): void {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
    }

    public static function generateCSRFToken(): string {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function validateCSRFToken(string $token): bool {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}
