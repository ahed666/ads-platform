<?php
// app/Services/SEO/SEOServiceFactory.php

namespace App\Services\SEO;

use InvalidArgumentException;

class SEOServiceFactory
{
    /**
     * Create SEO service based on type.
     *
     * @param string $type
     * @param string|null $locale
     * @return SEOInterface
     * @throws InvalidArgumentException
     */
    public static function make(string $type, ?string $locale = null): SEOInterface
    {
        return match(strtolower($type)) {
            'ad' => new AdSEOService($locale),
            'category' => new CategorySEOService($locale),
            default => throw new InvalidArgumentException("Unknown SEO service type: $type"),
        };
    }
}
