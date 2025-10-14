<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceHighlight extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
    ];

    /**
     * Relasi ke fitur (why choose us features)
     */
    public function features()
    {
        return $this->hasMany(ServiceHighlightFeature::class, 'highlight_id');
    }

    /**
     * Relasi ke gambar (why choose us images)
     */
    public function images()
    {
        return $this->hasMany(ServiceHighlightImage::class, 'highlight_id');
    }
}
