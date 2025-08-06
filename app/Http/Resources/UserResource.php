<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (!$this->resource || $this->resource instanceof MissingValue) {
        return [];
    }

        return [
            // Basic Info
            'name'          => $this->name,
            'email'         => $this->email,
            'account_type'  => $this->account_type,

            // Contact Info
            'phone'         => $this->phone,
            'whatsapp'      => $this->whatsapp,

            // Location Info
            'country_id'    => $this->country_id,
            'city_id'       => $this->city_id,
            'address'       => $this->address,
            'latitude'      => $this->latitude,
            'longitude'     => $this->longitude,

            // Social Media
            'facebook'      => $this->facebook,
            'instagram'     => $this->instagram,

            // Company (optional)
            'company'       => $this->whenLoaded('company', function () {
                return [
                    'name'                 => $this->company->name,
                    'slug'                 => $this->company->slug,
                    'logo'                 => $this->company->logo,
                    'description'          => $this->company->description,
                    'website'              => $this->company->website,
                    'industry'             => $this->company->industry,
                    'tax_id'               => $this->company->tax_id,
                    'registration_number'  => $this->company->registration_number,
                    'is_verified'          => $this->company->is_verified,
                    'is_active'            => $this->company->is_active,
                ];
            }),
        ];
    }
}
