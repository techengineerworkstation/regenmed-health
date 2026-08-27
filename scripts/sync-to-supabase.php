<?php
declare(strict_types=1);
// CLI: php scripts/sync-to-supabase.php [--dry-run]
// Syncs local MySQL/SQLite users+patients to Supabase registrants & health_practitioners

if (php_sapi_name() !== 'cli') { http_response_code(403); exit('CLI only'); }

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/supabase.php';
require_once __DIR__ . '/../includes/database.php';

$dry = in_array('--dry-run', $argv, true);
$sb = new SupabaseClient();

echo "Supabase configured: " . ($sb->isConfigured() ? "yes" : "NO - set SUPABASE_URL/KEY") . PHP_EOL;
$hc = $sb->healthCheck();
echo ($hc['ok'] ? "✓ " . $hc['message'] : "✗ " . $hc['error']) . PHP_EOL;
if (!$hc['ok']) exit(1);
if ($dry) echo "(dry-run — no writes)\n";

$local = RegenMedDatabase::getInstance();
if (!$local) { echo "Local DB not available (VERCEL_MODE?). Run locally.\n"; exit(1); }

// Pull local users -> registrants, and clinicians -> practitioners
$users = $local->query("SELECT id, username, email, display_name, role, institution, created_at FROM users ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
echo "Local users: " . count($users) . PHP_EOL;

$ok = $fail = 0;
foreach ($users as $u) {
    $isPractitioner = in_array($u['role'], ['clinician','researcher','admin'], true);
    if ($isPractitioner) {
        $payload = [
            'full_name' => $u['display_name'] ?: $u['username'],
            'email' => $u['email'],
            'specialization' => 'General',
            'qualification' => $u['institution'] ?? '',
            'institution' => $u['institution'] ?? '',
            'years_experience' => 0,
            'status' => 'active',
        ];
        if ($dry) { echo "  dry: practitioner {$u['email']}\n"; $ok++; continue; }
        $res = $sb->createPractitioner($payload);
        if ($res['status'] === 201) { $ok++; echo "  + practitioner {$u['email']}\n"; }
        else { $fail++; echo "  ! practitioner {$u['email']} HTTP {$res['status']} " . substr((string)$res['raw'],0,200) . "\n"; }
    } else {
        $payload = [
            'full_name' => $u['display_name'] ?: $u['username'],
            'email' => $u['email'],
            'phone' => '',
            'status' => 'active',
        ];
        if ($dry) { echo "  dry: registrant {$u['email']}\n"; $ok++; continue; }
        $res = $sb->createRegistrant($payload);
        if ($res['status'] === 201) { $ok++; echo "  + registrant {$u['email']}\n"; }
        else { $fail++; echo "  ! registrant {$u['email']} HTTP {$res['status']} " . substr((string)$res['raw'],0,200) . "\n"; }
    }
}
echo "Done: {$ok} synced, {$fail} failed\n";
