<?php
declare(strict_types=1);

// Vercel serverless entry point
// Detects Vercel environment and sets VERCEL_MODE constant
// The main app checks this to skip filesystem writes

define('VERCEL_MODE', true);

// Vercel's PHP runtime has a different working directory
// We need to set the root path for includes
$_SERVER['DOCUMENT_ROOT'] = dirname(__DIR__);

if (str_contains($_SERVER['REQUEST_URI'] ?? '', 'scan-analyze.php')) {
    require_once dirname(__DIR__) . '/includes/scan-analyze.php';
    exit;
}

// Include the main application
require_once dirname(__DIR__) . '/index.php';
