<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Brand extends Model
{
    /** @use HasFactory<\Database\Factories\BrandFactory> */
    use HasFactory;
    protected $fillable = [
        'name_en',
        'name_ar',
        'slug',
        'logo',      
        'ad_type_id'
    ];
    protected static function booted()
    {
        static::creating(function ($brand) {
            $brand->slug = Str::slug($brand->name_en);

            // to make it unique
            $original = $brand->slug;
            $counter = 1;
            while (Brand::where('slug', $brand->slug)->exists()) {
                $brand->slug = $original . '-' . $counter++;
            }
        });
    }

    public function ads(): HasMany
    {
        return $this->hasMany(Ad::class);
    }

      public function adType(): BelongsTo
    {
        return $this->belongsTo(AdType::class);
    }
      public function models(): HasMany
    {
        return $this->hasMany(BrandModel::class);
    }

}
