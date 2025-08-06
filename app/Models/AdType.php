<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AdType extends Model
{
    /** @use HasFactory<\Database\Factories\AdTypeFactory> */
    use HasFactory;
    protected $fillable = ['name_en', 'name_ar', 'slug', 'description'];

      protected static function booted()
    {
        static::creating(function ($type) {
            $type->slug = Str::slug($type->name_en);

            // to make it unique
            $original = $type->slug;
            $counter = 1;
            while (AdType::where('slug', $type->slug)->exists()) {
                $type->slug = $original . '-' . $counter++;
            }
        });
    }
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function brands(): HasMany
    {
        return $this->hasMany(Brand::class);
    }

    public function ads(): HasMany
    {
        return $this->hasMany(Ad::class,'ad_type_id');
    }
}
