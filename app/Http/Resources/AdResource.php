<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;

use Illuminate\Support\Facades\Log;
class AdResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    { 
        
        return [
        'id' => $this->id,
        'category_id' => $this->category_id,
        'ad_type_id' => $this->ad_type_id,
        'subcategory_id' => $this->subcategory_id,
        'brand_id' => $this->brand_id,
        'model_id' => $this->model_id,
        'name_en' => $this->name_en,
        'name_ar' => $this->name_ar,
        'description_en' => $this->description_en,
        'description_ar' => $this->description_ar,
        'price' =>(float) $this->price,
        'company' => $this->company,
        'type'=>$this->whenLoaded('type'),
        'category' => $this->whenLoaded('category'),
        'brand' => $this->whenLoaded('brand'),
        'subcategory' => $this->whenLoaded('subcategory'),
        'model' => $this->whenLoaded('model'),
        'user' => $this->whenLoaded('user', function () {
            return (new UserResource($this->user))->toArray(request());
        }),      
        'purpose' => $this->purpose,
        'status' => $this->status,
        'availability'=>$this->availability,
        'features'=>$this->features,
        'attributes'=>$this->attributes,

        'images' => $this->media
            ->where('type', 'image')
            ->map(function ($media) {
                return [
                    'id' => $media->id,
                    'url' =>  asset('storage/' . $media->path), // or $media->url
                ];
            })
            ->values(),
        'video' => $this->media
            ->where('type', 'video')
            ->map(function ($media) {
                return [
                    'id' => $media->id,
                    'url' =>  asset('storage/' . $media->path),
                ];
            })
            ->first(),
    ];
    }
}
