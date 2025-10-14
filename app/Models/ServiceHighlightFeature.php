<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceHighlightFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'highlight_id',
        'icon',
        'title',
        'description',
    ];

    /**
     * Relasi balik ke highlight utama
     */
    public function highlight()
    {
        return $this->belongsTo(ServiceHighlight::class, 'highlight_id');
    }
}
