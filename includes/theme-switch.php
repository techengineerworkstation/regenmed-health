<?php
declare(strict_types=1);

if (!defined('VERCEL_MODE')) {
    define('VERCEL_MODE', isset($_SERVER['VERCEL']) || getenv('VERCEL') !== false);
}

require_once __DIR__ . '/security.php';
require_once __DIR__ . '/themes.php';
require_once __DIR__ . '/theme-manager.php';

if (!VERCEL_MODE) {
    SessionManager::start();
}
ThemeManager::init();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $theme = $_POST['theme'] ?? '';
    if (!empty($theme)) {
        ThemeManager::setCurrentTheme($theme);
    }
}
