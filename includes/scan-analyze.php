<?php
declare(strict_types=1);

if (!defined('VERCEL_MODE')) {
    define('VERCEL_MODE', isset($_SERVER['VERCEL']) || getenv('VERCEL') !== false);
}

require_once __DIR__ . '/security.php';

header('Content-Type: application/json');

$cfg = require __DIR__ . '/../config.php';
$ai = $cfg['ai'] ?? [];
$localEndpoint = rtrim((string)($ai['local_endpoint'] ?? 'http://127.0.0.1:8080'), '/');
$cloudEndpoint = rtrim((string)($ai['cloud_endpoint'] ?? ''), '/');
$model = (string)($ai['model'] ?? 'llava-v1.6');

function probeGPU(string $endpoint): array {
    if ($endpoint === '') return ['online' => false, 'accelerated' => false, 'type' => null];
    $ctx = stream_context_create(['http' => ['timeout' => 2, 'ignore_errors' => true]]);
    $raw = @file_get_contents($endpoint . '/props', false, $ctx);
    if ($raw === false) return ['online' => false, 'accelerated' => false, 'type' => null];
    $json = strtolower($raw);
    $type = null;
    if (str_contains($json, 'cuda')) $type = 'CUDA';
    elseif (str_contains($json, 'vulkan')) $type = 'Vulkan';
    elseif (str_contains($json, 'rocm')) $type = 'ROCm';
    elseif (str_contains($json, 'metal')) $type = 'Metal';
    return ['online' => true, 'accelerated' => $type !== null, 'type' => $type];
}

function analyzeWithAI(string $endpoint, string $model, string $imagePath, string $modality, string $notes): ?string {
    $data = @file_get_contents($imagePath);
    if ($data === false) return null;
    $ext = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
    $mime = $ext === 'png' ? 'image/png' : ($ext === 'webp' ? 'image/webp' : 'image/jpeg');
    $b64 = base64_encode($data);
    if (strlen($b64) > 3_500_000) return null;
    $prompt = "You are a medical imaging analysis assistant. Scan type: {$modality}. "
        . ($notes !== '' ? "Clinician notes: {$notes}. " : '')
        . "Provide concisely: 1) Image quality, 2) Key observations, 3) Possible findings (educational only, not a diagnosis), 4) Recommended follow-up lab scans.";
    $payload = json_encode([
        'model' => $model,
        'messages' => [[
            'role' => 'user',
            'content' => [
                ['type' => 'text', 'text' => $prompt],
                ['type' => 'image_url', 'image_url' => ['url' => "data:{$mime};base64,{$b64}"]],
            ],
        ]],
        'max_tokens' => 600,
    ]);
    $ctx = stream_context_create(['http' => [
        'method' => 'POST',
        'header' => "Content-Type: application/json\r\n",
        'content' => $payload,
        'timeout' => 120,
        'ignore_errors' => true,
    ]]);
    $raw = @file_get_contents($endpoint . '/v1/chat/completions', false, $ctx);
    if ($raw === false) return null;
    $json = json_decode($raw, true);
    $text = $json['choices'][0]['message']['content'] ?? null;
    return (is_string($text) && trim($text) !== '') ? trim($text) : null;
}

function heuristicAnalysis(string $imagePath, string $modality): array {
    $info = @getimagesize($imagePath);
    if (!$info) return ['quality' => 'Image unreadable', 'observations' => [], 'followup' => []];
    [$w, $h] = $info;
    if (!function_exists('imagecreatefromjpeg')) {
        return [
            'quality' => 'Basic metrics only (GD extension unavailable on this host)',
            'observations' => [sprintf('Resolution %dx%d px — %s', (int)$w, (int)$h, min($w, $h) >= 512 ? 'adequate detail' : 'below typical diagnostic detail')],
            'followup' => ['Configure a GPU backend (host llama.cpp or cloud VPS) for full AI analysis'],
        ];
    }
    $img = match($info[2]) {
        IMAGETYPE_JPEG => @imagecreatefromjpeg($imagePath),
        IMAGETYPE_PNG => @imagecreatefrompng($imagePath),
        IMAGETYPE_WEBP => @imagecreatefromwebp($imagePath),
        default => false,
    };
    if (!$img) return ['quality' => 'Image decode failed', 'observations' => [], 'followup' => []];
    [$w, $h] = $info;
    $small = imagecreatetruecolor(64, 64);
    imagecopyresampled($small, $img, 0, 0, 0, 0, 64, 64, (int)$w, (int)$h);
    $sum = $sqSum = 0.0;
    $edge = 0;
    $prev = null;
    for ($y = 0; $y < 64; $y++) {
        for ($x = 0; $x < 64; $x++) {
            $rgb = imagecolorat($small, $x, $y);
            $lum = 0.2126 * (($rgb >> 16) & 255) + 0.7152 * (($rgb >> 8) & 255) + 0.0722 * ($rgb & 255);
            $sum += $lum;
            $sqSum += $lum * $lum;
            if ($prev !== null && abs($lum - $prev) > 30) $edge++;
            $prev = $lum;
        }
    }
    imagedestroy($small);
    imagedestroy($img);
    $mean = $sum / 4096;
    $std = sqrt(max(0.0, $sqSum / 4096 - $mean * $mean));
    $edgeDensity = $edge / 4096 * 100;
    $quality = $std > 35 ? 'Good contrast — structures well delineated' : ($std > 18 ? 'Moderate contrast — review recommended' : 'Low contrast — rescan advised');
    $observations = [
        sprintf('Resolution %dx%d px — %s', (int)$w, (int)$h, min($w, $h) >= 512 ? 'adequate detail' : 'below typical diagnostic detail'),
        sprintf('Mean luminance %.0f/255 (%s)', $mean, $mean > 170 ? 'bright exposure' : ($mean < 60 ? 'dark exposure' : 'balanced exposure')),
        sprintf('Edge density %.1f%% — %s structural complexity', $edgeDensity, $edgeDensity > 12 ? 'high' : ($edgeDensity > 5 ? 'typical anatomical' : 'low')),
    ];
    $followup = [
        'Knee MRI' => 'Coronal + axial T2 series; cartilage mapping sequences',
        'Retinal OCT' => 'Macular cube OCT-A; compare contra-lateral eye',
        'Prostate mpMRI' => 'Multiparametric T2/DWI with PI-RADS v2.1 scoring',
        'Fertility Ultrasound' => 'Doppler study of relevant vessels; cycle-timed repeat',
    ][$modality] ?? 'Confirm modality and acquire a standardized protocol series';
    return ['quality' => $quality, 'observations' => $observations, 'followup' => [$followup]];
}

if (isset($_GET['action']) && $_GET['action'] === 'status') {
    echo json_encode([
        'local' => probeGPU($localEndpoint),
        'cloud' => $cloudEndpoint !== '' ? probeGPU($cloudEndpoint) : ['online' => false, 'accelerated' => false, 'type' => null],
        'vercel_mode' => VERCEL_MODE,
    ], JSON_UNESCAPED_SLASHES);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['scan'])) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'No scan file received']);
    exit;
}

$f = $_FILES['scan'];
$maxBytes = VERCEL_MODE ? 4 * 1024 * 1024 : 20 * 1024 * 1024;
if ($f['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Upload failed (code ' . $f['error'] . ')']);
    exit;
}
if ($f['size'] > $maxBytes) {
    http_response_code(413);
    echo json_encode(['ok' => false, 'error' => 'File too large (max ' . round($maxBytes / 1048576) . 'MB)']);
    exit;
}

$allowedMimes = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
$mime = (new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']) ?: '';
if (!isset($allowedMimes[$mime])) {
    http_response_code(415);
    echo json_encode(['ok' => false, 'error' => 'Only JPEG/PNG/WebP scans accepted']);
    exit;
}

$dir = VERCEL_MODE ? sys_get_temp_dir() . '/regenmed-scans' : dirname(__DIR__) . '/uploads/scans';
@mkdir($dir, 0755, true);
$name = date('Ymd-His') . '-' . bin2hex(random_bytes(6)) . '.' . $allowedMimes[$mime];
$path = $dir . '/' . $name;
if (!move_uploaded_file($f['tmp_name'], $path)) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Could not store upload']);
    exit;
}

$modality = InputValidator::deepSanitizeString($_POST['modality'] ?? 'General');
$notes = InputValidator::deepSanitizeString($_POST['notes'] ?? '');

$backend = 'heuristic';
$gpu = ['accelerated' => false, 'type' => null];
$aiText = null;
$cloudStatus = probeGPU($cloudEndpoint);
$localStatus = probeGPU($localEndpoint);

if ($cloudStatus['online']) {
    $aiText = analyzeWithAI($cloudEndpoint, $model, $path, $modality, $notes);
    if ($aiText !== null) {
        $backend = 'cloud-gpu';
        $gpu = ['accelerated' => $cloudStatus['accelerated'], 'type' => $cloudStatus['type']];
    }
}
if ($aiText === null && $localStatus['online']) {
    $aiText = analyzeWithAI($localEndpoint, $model, $path, $modality, $notes);
    if ($aiText !== null) {
        $backend = 'local-gpu';
        $gpu = ['accelerated' => $localStatus['accelerated'], 'type' => $localStatus['type']];
    }
}

$heuristic = heuristicAnalysis($path, $modality);

echo json_encode([
    'ok' => true,
    'backend' => $backend,
    'gpu' => $gpu,
    'ai_text' => $aiText,
    'heuristic' => $heuristic,
    'modality' => $modality,
    'file' => basename($path),
    'disclaimer' => 'Educational analysis only — not a medical diagnosis. Consult a qualified clinician.',
], JSON_UNESCAPED_SLASHES);
