<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Media extends Model
{
    protected $fillable = [
    'company_id',
    'type',      // 'image' or 'video'
    'path',
    'alt',
    'ad_id',
];
    
    public function ad():BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }
    public function getUrl(): string
{
    return asset('storage/' . $this->path); // assuming you have 'path' column
}
}
