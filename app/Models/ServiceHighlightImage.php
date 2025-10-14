<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceHighlightImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'highlight_id',
        'image_path',
    ];

    /**
     * Relasi balik ke highlight utama
     */
    public function highlight()
    {
        return $this->belongsTo(ServiceHighlight::class, 'highlight_id');
    }
}
