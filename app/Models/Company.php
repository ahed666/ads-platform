<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Company extends Model
{
    /** @use HasFactory<\Database\Factories\CompanyFactory> */
    use HasFactory;
    protected $fillable = [
    'name',
    'slug',
    'owner_id',
    'logo',
    'description',
    'website',
    'industry',
    'tax_id',
    'registration_number',
    'is_verified',
    'is_active',
];
protected $casts = [
    'is_verified' => 'boolean',
    'is_active' => 'boolean',
    'latitude' => 'float',
    'longitude' => 'float',
];

    protected static function booted()
    {
        static::creating(function ($company) {
            $company->slug = Str::slug($company->name);

            // to make it unique
            $original = $company->slug;
            $counter = 1;
            while (Company::where('slug', $company->slug)->exists()) {
                $company->slug = $original . '-' . $counter++;
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
