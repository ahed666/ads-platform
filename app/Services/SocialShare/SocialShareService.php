<?php
namespace App\Services\SocialShare;

use App\Models\Ad;

class SocialShareService
{
    protected array $platforms = [];

    public function __construct()
    {
       
        $this->platforms['facebook'] = new FacebookShare();
        //$this->platforms['whatsapp'] = new WhatsappShare();
        
    }

    public function share(Ad $ad): void
    {
        foreach ($this->platforms as $platform) {
            $platform->share($ad);
        }
    }
}
