<?php
namespace App\Services\SocialShare;

use App\Models\Ad;
use Illuminate\Support\Facades\Http;

class FacebookShare implements SocialShareInterface
{
    public function share(Ad $ad): bool
    {
        $url = route('ads.show', $ad->id);

        $response = Http::post("https://graph.facebook.com/" . config('services.facebook.page_id') . "/feed", [
            'message' => "📦 New Ad: {$ad->name_en}\nCheck it out: $url",
            'access_token' => config('services.facebook.token'),
        ]);

        if (isset($response['id'])) {
            $ad->update(['facebook_post_id' => $response['id']]);
            return true;
        }

        return false;
    }
}
