<?php
// app/Services/SEO/AdSEOService.php

namespace App\Services\SEO;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class AdSEOService implements SEOInterface
{
    protected string $locale;

    public function __construct(string $locale = null)
    {
        $this->locale = $locale ?? app()->getLocale();
    }

    public function generate(array $ad): array
    {
        $title = $ad['name_' . $this->locale] ?? config('app.name');
        $image=$ad['images'][0]['url'];
        $description = $this->generateDescription($ad['description_' . $this->locale] ?? '');
        $keywords = $this->generateKeywords($ad);

        return compact('title', 'description', 'keywords','image');
    }

    protected function generateDescription(string $text): string
    {
        return Str::limit(strip_tags($text), 160);
    }

    protected function generateKeywords(array $ad): string
    {
        $keywords = collect();

        if (!empty($ad['description_' . $this->locale])) {
            $keywords = $keywords->merge($this->extractKeywordsFromText($ad['description_' . $this->locale]));
        }

        $structured = collect([
            $ad['brand']['name_' . $this->locale] ?? null,
            $ad['model']['name_' . $this->locale] ?? null,
            $ad['category']['name_' . $this->locale] ?? null,
            $ad['subcategory']['name_' . $this->locale] ?? null,
            strtolower(($ad['brand']['name_' . $this->locale] ?? '') . ' ' . ($ad['model']['name_' . $this->locale] ?? '')),
            strtolower(($ad['category']['name_' . $this->locale] ?? '') . ' under ' . $this->priceRange($ad['price'] ?? 0)),
        ])->filter();

        $keywords = $keywords->merge($structured)->unique();

        return $keywords->implode(',');
    }

    protected function extractKeywordsFromText(string $text): array
    {
        $stopWords = ['for', 'and', 'the', 'in', 'by', 'of', 'is', 'to', 'with', 'a', 'an', 'on', 'this', 'that', 'it'];
        $words = explode(' ', strtolower(strip_tags($text)));

        return collect($words)
            ->map(fn($w) => trim(preg_replace('/[^a-z0-9\-]/', '', $w)))
            ->filter(fn($w) => strlen($w) > 2 && !in_array($w, $stopWords))
            ->unique()
            ->values()
            ->toArray();
    }

    protected function priceRange(float $price): string
    {
        if ($price < 5000) return '5000';
        if ($price < 10000) return '10000';
        if ($price < 20000) return '20000';
        return 'premium';
    }
}
