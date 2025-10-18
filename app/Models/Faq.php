<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutFaq extends Model
{
    use HasFactory;

    protected $table = 'faqs';

    protected $fillable = [
        'about_id',
        'question',
        'answer',
        'order',
    ];

    public function about()
    {
        return $this->belongsTo(AboutUs::class, 'about_id');
    }
}
