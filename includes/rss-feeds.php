<?php
declare(strict_types=1);

class RssFeedManager
{
    private const CACHE_DIR = __DIR__ . '/../data/rss_cache';
    private const CACHE_TTL = 1800; // 30 minutes

    private static array $tipFeeds = [
        'https://www.mayoclinic.org/feeds/healthy-lifestyle',
        'https://www.healthline.com/health-news/feed',
        'https://www.medicalnewstoday.com/rss',
        'https://www.who.int/rss-feeds/news-english.xml',
    ];

    private static array $newsFeeds = [
        'https://www.mayoclinic.org/feeds/news',
        'https://www.sciencedaily.com/rss/health_medicine.xml',
        'https://www.medicalnewstoday.com/rss',
        'https://www.fda.gov/about-fda/contact-fda/stay-informed/rss-feeds/press-releases/rss.xml',
    ];

    public static function init(): void
    {
        if (!is_dir(self::CACHE_DIR)) {
            mkdir(self::CACHE_DIR, 0755, true);
        }
    }

    public static function getTips(int $limit = 8): array
    {
        $cacheFile = self::CACHE_DIR . '/tips.json';
        $cached = self::readCache($cacheFile);
        if ($cached !== null) {
            return array_slice($cached, 0, $limit);
        }

        $items = [];
        foreach (self::$tipFeeds as $feedUrl) {
            $feedItems = self::fetchFeed($feedUrl);
            $items = array_merge($items, $feedItems);
        }

        $items = self::deduplicate($items);
        usort($items, fn($a, $b) => strtotime($b['date'] ?? 'now') - strtotime($a['date'] ?? 'now'));
        self::writeCache($cacheFile, $items);

        return array_slice($items, 0, $limit);
    }

    public static function getNews(int $limit = 8): array
    {
        $cacheFile = self::CACHE_DIR . '/news.json';
        $cached = self::readCache($cacheFile);
        if ($cached !== null) {
            return array_slice($cached, 0, $limit);
        }

        $items = [];
        foreach (self::$newsFeeds as $feedUrl) {
            $feedItems = self::fetchFeed($feedUrl);
            $items = array_merge($items, $feedItems);
        }

        $items = self::deduplicate($items);
        usort($items, fn($a, $b) => strtotime($b['date'] ?? 'now') - strtotime($a['date'] ?? 'now'));
        self::writeCache($cacheFile, $items);

        return array_slice($items, 0, $limit);
    }

    private static function fetchFeed(string $url): array
    {
        $items = [];
        $ctx = stream_context_create([
            'http' => [
                'timeout' => 10,
                'header' => "User-Agent: RegenMedHealth/2.0 RSS Reader\r\n",
            ],
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ]);

        $raw = @file_get_contents($url, false, $ctx);
        if ($raw === false) {
            return $items;
        }

        $xml = @simplexml_load_string($raw, 'SimpleXMLElement', LIBXML_NOERROR);

        if ($xml === false) {
            return $items;
        }

        $namespaces = $xml->getNamespaces(true);

        // RSS 2.0
        if (isset($xml->channel->item)) {
            foreach ($xml->channel->item as $item) {
                $items[] = self::parseItem($item, $namespaces);
            }
        }

        // Atom
        if (isset($xml->entry)) {
            foreach ($xml->entry as $entry) {
                $items[] = [
                    'title' => (string)($entry->title ?? ''),
                    'link' => (string)($entry->link['href'] ?? $entry->link ?? ''),
                    'description' => strip_tags((string)($entry->summary ?? $entry->content ?? '')),
                    'date' => (string)($entry->updated ?? $entry->published ?? ''),
                    'source' => self::extractDomain($url),
                ];
            }
        }

        return $items;
    }

    private static function parseItem(\SimpleXMLElement $item, array $namespaces): array
    {
        $description = (string)($item->description ?? '');

        if (isset($item->children('content', true)->encoded)) {
            $description = strip_tags((string)$item->children('content', true)->encoded);
        } elseif (isset($item->children('media', true)->description)) {
            $description = strip_tags((string)$item->children('media', true)->description);
        }

        $description = trim(strip_tags($description));
        if (mb_strlen($description) > 200) {
            $description = mb_substr($description, 0, 200) . '…';
        }

        return [
            'title' => trim((string)($item->title ?? '')),
            'link' => (string)($item->link ?? ''),
            'description' => $description,
            'date' => (string)($item->pubDate ?? $item->date ?? ''),
            'source' => self::extractDomain((string)($item->link ?? '')),
        ];
    }

    private static function extractDomain(string $url): string
    {
        $host = @parse_url($url, PHP_URL_HOST);
        if ($host === null) return 'unknown';
        $parts = explode('.', $host);
        if (count($parts) >= 2) {
            return $parts[count($parts) - 2];
        }
        return $host;
    }

    private static function deduplicate(array $items): array
    {
        $seen = [];
        $unique = [];
        foreach ($items as $item) {
            $key = strtolower(trim($item['title'] ?? ''));
            if ($key !== '' && !in_array($key, $seen, true)) {
                $seen[] = $key;
                $unique[] = $item;
            }
        }
        return $unique;
    }

    private static function readCache(string $file): ?array
    {
        if (!file_exists($file)) return null;
        if (time() - filemtime($file) > self::CACHE_TTL) return null;
        $data = @file_get_contents($file);
        if ($data === false) return null;
        $decoded = json_decode($data, true);
        return is_array($decoded) ? $decoded : null;
    }

    private static function writeCache(string $file, array $data): void
    {
        @file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
    }
}
