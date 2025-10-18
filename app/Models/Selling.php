<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Selling extends Model
{
    use HasFactory;

    protected $table = 'selling';

    protected $fillable = [
        'about_id',
        'title',
        'description',
        'image',
        'price',
        'link',
        'order',
    ];

    public function about()
    {
        return $this->belongsTo(AboutUs::class, 'about_id');
    }
}
