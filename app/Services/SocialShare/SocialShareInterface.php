<?php
namespace App\Services\SocialShare;

use App\Models\Ad;

interface SocialShareInterface
{
    public function share(Ad $ad): bool;
}
