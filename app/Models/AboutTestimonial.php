<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutTestimonial extends Model
{
    use HasFactory;

    protected $table = 'about_testimonials';

    protected $fillable = [
        'about_id',
        'name',
        'company',
        'message',
        'photo',
        'rating',
        'order',
    ];

    public function about()
    {
        return $this->belongsTo(AboutUs::class, 'about_id');
    }
}
