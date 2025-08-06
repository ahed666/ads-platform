<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use App\Models\Ad;
use App\Services\SocialShare\SocialShareService;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
class ShareAdToSocialMedia implements ShouldQueue
{
      use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

      public Ad $ad;
    /**
     * Create a new job instance.
     */
    public function __construct(Ad $ad)
    {
                $this->ad = $ad;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $socialShare = new SocialShareService();
        $socialShare->share($this->ad);
    }
}
