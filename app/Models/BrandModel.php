<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class BrandModel extends Model
{
    /** @use HasFactory<\Database\Factories\BrandModelFactory> */
    use HasFactory;

    protected $fillable = ['name_en', 'name_ar','slug', 'brand_id'];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->brand->name_en . ' ' . $model->name_en);
            }
        });
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function ads()
    {
        return $this->hasMany(Ad::class, 'model_id');
    }
}
