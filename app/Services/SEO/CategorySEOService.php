<?php
// app/Services/SEO/CategorySEOService.php

namespace App\Services\SEO;

use Illuminate\Support\Str;

class CategorySEOService implements SEOInterface
{
    protected string $locale;

    public function __construct(string $locale = null)
    {
        $this->locale = $locale ?? app()->getLocale();
    }

    public function generate(array $category): array
    {
        $title = $category['name_' . $this->locale] ?? config('app.name');
        $description = Str::limit(strip_tags($category['name_' . $this->locale] ?? ''), 160);
        $keywords = $this->generateKeywords($category);

        return compact('title', 'description', 'keywords');
    }

    protected function generateKeywords(array $category): string
    {
        $keywords = [
            $category['name_' . $this->locale] ?? '',
            
        ];

        return implode(',', array_filter($keywords));
    }
}
