<?php
declare(strict_types=1);

/**
 * Regen Med Health — Supabase Client (PostgREST + Storage)
 * Works locally and on Vercel. Uses SUPABASE_URL + SUPABASE_ANON_KEY / SERVICE_ROLE_KEY env vars.
 * No Composer dependency — uses plain curl/file_get_contents.
 */

class SupabaseClient {
    private string $url;
    private string $anonKey;
    private string $serviceKey;

    public function __construct() {
        $cfg = require __DIR__ . '/../config.php';
        $sb = $cfg['supabase'] ?? [];
        $this->url = rtrim((string)($sb['url'] ?? getenv('SUPABASE_URL') ?: ''), '/');
        $this->anonKey = (string)($sb['anon_key'] ?? getenv('SUPABASE_ANON_KEY') ?: '');
        $this->serviceKey = (string)($sb['service_key'] ?? getenv('SUPABASE_SERVICE_ROLE_KEY') ?: '');
    }

    public function isConfigured(): bool {
        return $this->url !== '' && ($this->anonKey !== '' || $this->serviceKey !== '');
    }

    private function key(): string {
        return $this->serviceKey !== '' ? $this->serviceKey : $this->anonKey;
    }

    private function request(string $method, string $path, $body = null, array $extraHeaders = []): array {
        $url = $this->url . $path;
        $headers = [
            'apikey: ' . $this->key(),
            'Authorization: Bearer ' . $this->key(),
            'Content-Type: application/json',
        ];
        foreach ($extraHeaders as $h) $headers[] = $h;
        $ctx = stream_context_create([
            'http' => [
                'method' => $method,
                'header' => implode("\r\n", $headers),
                'content' => $body !== null ? json_encode($body) : null,
                'timeout' => 15,
                'ignore_errors' => true,
            ]
        ]);
        $raw = @file_get_contents($url, false, $ctx);
        $status = 0;
        if (isset($http_response_header[0]) && preg_match('/\s(\d{3})\s/', $http_response_header[0], $m)) $status = (int)$m[1];
        $data = $raw !== false ? json_decode($raw, true) : null;
        return ['status' => $status, 'data' => $data, 'raw' => $raw, 'headers' => $http_response_header ?? []];
    }

    // ---- Registrants ----
    public function createRegistrant(array $fields): array {
        return $this->request('POST', '/rest/v1/registrants', $fields, ['Prefer: return=representation']);
    }
    public function listRegistrants(int $limit = 50, int $offset = 0): array {
        return $this->request('GET', '/rest/v1/registrants?select=*&order=created_at.desc&limit=' . $limit . '&offset=' . $offset);
    }
    // ---- Practitioners ----
    public function createPractitioner(array $fields): array {
        return $this->request('POST', '/rest/v1/health_practitioners', $fields, ['Prefer: return=representation']);
    }
    public function listPractitioners(int $limit = 50, int $offset = 0): array {
        return $this->request('GET', '/rest/v1/health_practitioners?select=*&order=created_at.desc&limit=' . $limit . '&offset=' . $offset);
    }
    // ---- Scan submissions ----
    public function createScanSubmission(array $fields): array {
        return $this->request('POST', '/rest/v1/scan_submissions', $fields, ['Prefer: return=representation']);
    }

    public function healthCheck(): array {
        if (!$this->isConfigured()) return ['ok' => false, 'error' => 'SUPABASE_URL / SUPABASE_ANON_KEY not set. Add them in .env and Vercel Dashboard > Settings > Environment Variables.'];
        $res = $this->request('GET', '/rest/v1/registrants?select=id&limit=1');
        if ($res['status'] >= 200 && $res['status'] < 300) return ['ok' => true, 'message' => 'Supabase connected'];
        return ['ok' => false, 'error' => 'Supabase error HTTP ' . $res['status'], 'raw' => substr((string)$res['raw'], 0, 600)];
    }
}
