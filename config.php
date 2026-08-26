<?php
declare(strict_types=1);

// Detect Vercel environment
if (!defined('VERCEL_MODE')) {
    define('VERCEL_MODE', isset($_SERVER['VERCEL']) || getenv('VERCEL') !== false);
}

return [
    'database' => [
        'host'     => '127.0.0.1',
        'port'     => 3306,
        'dbname'   => 'regenmed',
        'username' => 'regenmed',
        'password' => 'regenmed_secure_2024',
        'charset'  => 'utf8mb4',
    ],
    'app' => [
        'name'  => 'Regen Med Health',
        'url'   => VERCEL_MODE ? 'https://' . ($_SERVER['HTTP_HOST'] ?? 'regenmed.vercel.app') : 'http://localhost:8081',
        'debug' => false,
    ],
    'vercel' => VERCEL_MODE,
    'ai' => [
        'local_endpoint' => getenv('SCAN_LOCAL_ENDPOINT') ?: 'http://127.0.0.1:8080',
        'cloud_endpoint' => getenv('SCAN_CLOUD_ENDPOINT') ?: '',
        'model' => 'llava-v1.6',
    ],
];
