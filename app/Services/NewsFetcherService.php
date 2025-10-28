<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NewsFetcherService
{
    public function fetchFromUrl(string $url, int $limit = 5)
    {
        try {
            // Detecta se a URL já é de feed
            if ($this->isFeedUrl($url)) {
                return $this->fetchFromFeed($url, $limit);
            }

            //Tenta encontrar um feed associado (ex: /feed ou /rss)
            $feedUrl = $this->tryFindFeed($url);
            if ($feedUrl) {
                return $this->fetchFromFeed($feedUrl, $limit);
            }

            // Se não encontrar feed, tenta extrair direto do HTML
            return $this->fetchFromHtml($url, $limit);

        } catch (\Exception $e) {
            Log::error("Erro ao buscar notícias de {$url}", ['erro' => $e->getMessage()]);
            return collect();
        }
    }

    private function isFeedUrl(string $url): bool
    {
        return str_contains($url, 'rss') || str_contains($url, 'feed');
    }

    private function tryFindFeed(string $baseUrl): ?string
    {
        try {
            $html = Http::get($baseUrl)->body();

            // Procura por tags <link rel="alternate" type="application/rss+xml" ...>
            if (preg_match('/<link[^>]+type=["\']application\/rss\+xml["\'][^>]+href=["\']([^"\']+)["\']/', $html, $match)) {
                $feedUrl = $match[1];
                return str_starts_with($feedUrl, 'http') ? $feedUrl : rtrim($baseUrl, '/') . '/' . ltrim($feedUrl, '/');
            }

            // Tenta URLs comuns
            $candidates = [
                rtrim($baseUrl, '/') . '/feed',
                rtrim($baseUrl, '/') . '/rss',
            ];

            foreach ($candidates as $candidate) {
                $response = Http::get($candidate);
                if ($response->ok() && str_contains($response->body(), '<rss')) {
                    return $candidate;
                }
            }
        } catch (\Exception $e) {
            Log::warning("Falha ao tentar detectar feed em {$baseUrl}: {$e->getMessage()}");
        }

        return null;
    }

    private function fetchFromFeed(string $feedUrl, int $limit)
    {
        $response = Http::get($feedUrl);
        $xml = @simplexml_load_string($response->body());

        if (!$xml || !isset($xml->channel->item)) {
            return collect();
        }

        $items = [];
        foreach ($xml->channel->item as $item) {
            $items[] = [
                'title' => (string) $item->title,
                'link' => (string) $item->link,
                'date' => (string) $item->pubDate,
            ];
        }

        return collect($items)->take($limit);
    }

    private function fetchFromHtml(string $url, int $limit)
    {
        $html = Http::get($url)->body();
        preg_match_all('/<a[^>]+href="([^"]+)"[^>]*>(.*?)<\/a>/', $html, $matches);

        $articles = collect($matches[2])
            ->zip($matches[1])
            ->map(function ($pair) {
                [$title, $link] = $pair;
                return [
                    'title' => strip_tags($title),
                    'link' => $link,
                ];
            })
            ->filter(fn($a) => strlen($a['title']) > 15)
            ->take($limit);

        return $articles;
    }
}
