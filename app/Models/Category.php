<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;
    protected $fillable = [
       'name_en',
       'name_ar',
        'slug',
        'ad_type_id',
    ];

    protected static function booted()
    {
        static::creating(function ($category) {
            $category->slug = Str::slug($category->name_en);

            // to make it unique
            $original = $category->slug;
            $counter = 1;
            while (Category::where('slug', $category->slug)->exists()) {
                $category->slug = $original . '-' . $counter++;
            }
        });
    }
  
    public function adType(): BelongsTo
    {
        return $this->belongsTo(AdType::class);
    }
    public function subcategories():HasMany
    {
        return $this->hasMany(Subcategory::class);
    }
    public function subcategoryAds()
    {
        return $this->hasMany(Ad::class, 'subcategory_id');
    }
    public function ads(): HasMany
    {
        return $this->hasMany(Ad::class);
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class);
    }


}
