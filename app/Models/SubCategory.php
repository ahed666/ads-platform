<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class SubCategory extends Model
{
    /** @use HasFactory<\Database\Factories\SubCategoryFactory> */
    use HasFactory;
     protected static function booted()
    {
        static::creating(function ($subCategory) {
            $subCategory->slug = Str::slug($subCategory->name_en);

            // to make it unique
            $original = $subCategory->slug;
            $counter = 1;
            while (SubCategory::where('slug', $subCategory->slug)->exists()) {
                $subCategory->slug = $original . '-' . $counter++;
            }
        });
    }
protected $fillable = [
       'name_en',
       'name_ar',
        'slug',
        'category_id',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
