<?php
declare(strict_types=1);

if (php_sapi_name() !== 'cli' && (!defined('APP_RUNNING') || !APP_RUNNING)) {
    http_response_code(403);
    exit('Access denied');
}

require_once __DIR__ . '/security.php';

function seedDatabase(): void {
    $config = require dirname(__DIR__) . '/config.php';
    $cfg = $config['database'];
    
    $dsn = sprintf('mysql:host=%s;port=%d;charset=%s', $cfg['host'], $cfg['port'], $cfg['charset']);
    $db = new PDO($dsn, $cfg['username'], $cfg['password'], [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
    
    $db->exec("CREATE DATABASE IF NOT EXISTS `{$cfg['dbname']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $db->exec("USE `{$cfg['dbname']}`");
    
    echo "  Database: connected to MySQL ({$cfg['dbname']})\n";
    
    require_once __DIR__ . '/database.php';
    echo "  Tables: created/verified via Regen Med Health Database";
    
    $stmt = $db->prepare("SELECT COUNT(*) FROM users");
    $stmt->execute();
    
    if ($stmt->fetchColumn() == 0) {
        $stmt = $db->prepare("INSERT INTO users (username, email, password_hash, display_name, role) VALUES (?, '', ?, ?, 'admin')");
        $stmt->execute(['admin', SecurityManager::hashPassword('admin123'), 'System Administrator']);
        $adminId = (int)$db->lastInsertId();
        
        $prefStmt = $db->prepare("INSERT INTO user_preferences (user_id, theme, default_gpu_provider) VALUES (?, 'light', 'google_colab')");
        $prefStmt->execute([$adminId]);
        
        echo "  Admin user: created (admin/admin123)\n";
    } else {
        echo "  Admin user: already exists\n";
    }
    
    $stmt = $db->prepare("SELECT COUNT(*) FROM patients");
    $stmt->execute();
    
    if ($stmt->fetchColumn() == 0) {
        $stmt = $db->prepare("SELECT id FROM users WHERE role = 'admin' LIMIT 1");
        $stmt->execute();
        $admin = $stmt->fetch();
        
        if ($admin) {
            $patientStmt = $db->prepare("INSERT INTO patients (user_id, patient_id, first_name, last_name, date_of_birth, gender) VALUES (?, ?, ?, ?, ?, ?)");
            $patients = [
                ['DEMO-001', 'John', 'Smith', '1965-03-15', 'male'],
                ['DEMO-002', 'Sarah', 'Johnson', '1978-07-22', 'female'],
                ['DEMO-003', 'Robert', 'Chen', '1958-11-08', 'male'],
            ];
            foreach ($patients as $p) {
                $patientStmt->execute([$admin['id'], $p[0], $p[1], $p[2], $p[3], $p[4]]);
            }
            echo "  Sample patients: created (3)\n";
        }
    } else {
        echo "  Sample patients: already exist\n";
    }
}

if (php_sapi_name() === 'cli') {
    $config = require dirname(__DIR__) . '/config.php';
    $cfg = $config['database'];
    
    echo "Regen Med Health Database Setup (MySQL)\n";
    echo str_repeat('-', 40) . "\n";
    
    $dsn = sprintf('mysql:host=%s;port=%d', $cfg['host'], $cfg['port']);
    try {
        $db = new PDO($dsn, $cfg['username'], $cfg['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
        echo "  Connected to MySQL as {$cfg['username']}\n";
    } catch (PDOException $e) {
        echo "  MySQL connection failed: {$e->getMessage()}\n";
        echo "  Attempting to create database and user...\n";
        try {
            $db = new PDO($dsn, 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            $db->exec("CREATE DATABASE IF NOT EXISTS `{$cfg['dbname']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $db->exec("CREATE USER IF NOT EXISTS '{$cfg['username']}'@'{$cfg['host']}' IDENTIFIED BY '{$cfg['password']}'");
            $db->exec("GRANT ALL PRIVILEGES ON `{$cfg['dbname']}`.* TO '{$cfg['username']}'@'{$cfg['host']}'");
            $db->exec("FLUSH PRIVILEGES");
            echo "  Database '{$cfg['dbname']}' and user '{$cfg['username']}' created\n";
            $db = new PDO($dsn, $cfg['username'], $cfg['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);
        } catch (PDOException $e2) {
            echo "  FATAL: Could not create database: {$e2->getMessage()}\n";
            echo "  Run: sudo mysql -e \"CREATE DATABASE regenmed; CREATE USER regenmed@127.0.0.1 IDENTIFIED BY 'regenmed_secure_2024'; GRANT ALL ON regenmed.* TO regenmed@127.0.0.1; FLUSH PRIVILEGES;\"\n";
            exit(1);
        }
    }
    
    seedDatabase();
    echo "\nDatabase seeding complete!\n";
}
