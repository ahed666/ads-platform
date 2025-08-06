<?php
// app/Services/SEO/SEOInterface.php

namespace App\Services\SEO;

interface SEOInterface
{
    /**
     * Generate SEO metadata from given data.
     *
     * @param array $data
     * @return array ['title' => string, 'description' => string, 'keywords' => string]
     */
    public function generate(array $data): array;
}
