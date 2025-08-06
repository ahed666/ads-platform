<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Ad extends Model
{
    const TYPES = ['for_sale', 'for_rent'];
const STATUSES = ['active', 'inactive', 'archived'];

    /** @use HasFactory<\Database\Factories\AdFactory> */
    use HasFactory;
    protected $fillable = [
        'name_en',
        'name_ar',
        'slug',
        'description_en',
        'description_ar',
        'price',
        'quantity',
        'ad_type_id',
        'brand_id',
        'category_id',
        'subcategory_id',
        'model_id',
        'user_id',
        'is_active',
        'type',
        'status',
        'availability',
        'features',
        'attributes'
    ];
    protected $casts = [
    'attributes' => 'array',
    'features' => 'array',
    ];
    protected static function booted()
    {
        static::creating(function ($ad) {
            $ad->slug = Str::slug($ad->name);

            // to make it unique
            $original = $ad->slug;
            $counter = 1;
            while (Ad::where('slug', $ad->slug)->exists()) {
                $ad->slug = $original . '-' . $counter++;
            }
        });
    }


    public function media():HasMany
    {
        return $this->HasMany(Media::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(AdType::class,'ad_type_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
    public function model(): BelongsTo
    {
        return $this->belongsTo(BrandModel::class,'model_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function video()
    {
        return $this->hasOne(Media::class)->where('type', 'video');
    }
}
