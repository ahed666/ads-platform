<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class SEOService
{
    protected $locale;
    public function __construct()
    {
       $this->locale = app()->getLocale();
        
    }
    public  function generate(array $ad): array
    {
        
        $title = $ad['name_' . $this->locale] ?? config('app.name');
        $description = self::generateDescription($ad['description_' . $this->locale] ?? '');
        $keywords = self::generateKeywords($ad);

        return compact('title', 'description', 'keywords');
    }

    protected  function generateDescription(string $text): string
    {
        return Str::limit(strip_tags($text), 160);
    }

    protected  function generateKeywords(array $ad): string
    {
        $keywords = collect();

        // From description
        if (!empty($ad['description_' . $this->locale])) {
            $keywords = $keywords->merge(self::extractKeywordsFromText($ad['description_' .$this->locale]));
        }

        // Structured: brand, model, category, etc.
        $structured = collect([
            $ad['brand'] ?? null,
            $ad['model'] ?? null,
            $ad['category'] ?? null,
            $ad['subcategory'] ?? null,
            strtolower(($ad['brand'] ?? '') . ' ' . ($ad['model'] ?? '')),
            strtolower(($ad['category'] ?? '') . ' under ' . self::priceRange($ad['price'] ?? 0)),
        ])->filter();

        $keywords = $keywords->merge($structured)->unique();

        return $keywords->implode(',');
    }

    protected  function extractKeywordsFromText(string $text): array
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

    protected  function priceRange(float $price): string
    {
        if ($price < 5000) return '5000';
        if ($price < 10000) return '10000';
        if ($price < 20000) return '20000';
        return 'premium';
    }
}
