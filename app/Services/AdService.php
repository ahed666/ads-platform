<?php
namespace App\Services;

use App\Models\Ad;
use App\Models\Media;
use App\Repositories\AdRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AdService
{
    const MAX_PRODUCT_IMAGES = 5;
    const MAX_PRODUCT_VIDEOS = 1;
   
    public function __construct(protected AdRepository $adRepo)
    {
        $this->isAdmin = $this->isInAdminContext();
        
    }

   // AdService.php

    public function getAllAds($withOwner=false)
    {
        $userId = $this->isAdmin ? auth()->user()?->id : null;
        return $this->adRepo->all($userId,$withOwner);
    }

    public function paginateAds(int $perPage = 15,$withOwner=false)
    {
        $userId = $this->isAdmin ? auth()->user()?->id : null;
        return $this->adRepo->paginate($perPage, $userId,$withOwner);
    }

    public function paginateQueryAds($query,int $perPage = 20,$withOwner=false)
    {
        
        $userId = $this->isAdmin? auth()->user()?->id : null;
        
        return $this->adRepo->paginateQuery($query, $perPage, $userId,$withOwner);
    }


    public function getById($id,$withOwner=false)
    {
        
        return $this->adRepo->find($id,$withOwner);
    }

    
    public function create(array $data, array $uploadedMedia = [])
    {
            return DB::transaction(function () use ($data, $uploadedMedia) {
                $data['user_id'] = auth()->user()->id;
                $ad = $this->adRepo->create($data);
                
                $this->storeMediaForAd($ad, $uploadedMedia);

                return $ad;
            });
    }
    


    public function update(Ad $ad, array $data,array $deletedMedia=[],array $uploadedMedia = [])
    {
        
        return DB::transaction(function () use ($ad, $data,$deletedMedia,$uploadedMedia) {
            $ad = $this->adRepo->update($ad, $data);
            log::info('data:',[$data]);
            if($uploadedMedia)
            $this->storeMediaForAd($ad, $uploadedMedia);

                 if (!empty($deletedMedia))
            $this->deleteMedia($deletedMedia);
            

            return $ad;
        });
    }

    public function deleteMedia($deletedMedia){
 log::info('delete:',[$deletedMedia]);
            Media::whereIn('id', $deletedMedia)->each(function ($media) {
                Storage::disk('public')->delete($media->path);
                
                $media->delete();
            });
        

    }

    public function delete(Ad $ad)
    {
        return $this->adRepo->delete($ad);
    }

    // store media for ad
    public function storeMediaForAd(Ad $ad, array $mediaFiles = []): void
    {
        $manager = new ImageManager(new Driver());

        log::info('ad:',[$ad]);
        foreach ($mediaFiles as $file) {
            $extension = $file->getClientOriginalExtension();
            $isVideo = in_array(strtolower($extension), ['mp4', 'mov', 'avi', 'webm']);

            // type for file 
            $type = $isVideo ? 'video' : 'image';

            // allow only one video for ad
            if ($isVideo && $ad->video()->exists()) {
            
                $ad->video()->delete();
            }

            if(!$isVideo)
            {
                // Read the image
            $image = $manager->read($file->getRealPath());

            // Resize & watermark (if needed)
            $image->resize(height: 800,width:600); // Will keep aspect ratio

            // Encode and store
            $encoded = $image->toJpg();
            $filename = uniqid('ad_') . '.jpg';
            $path = "ads/$filename";

            Storage::disk('public')->put($path, $encoded);

            }
            else{
            $path = $file->store('ads', 'public');

            }



            Media::create([
                'path' => $path,
                'type' => $type,
                'ad_id' => $ad->id,
            ]);
        }
    }
    private function isInAdminContext(): bool
    {
        return auth()->check() && auth()->user()->hasRole('admin');
    }


    

    

}