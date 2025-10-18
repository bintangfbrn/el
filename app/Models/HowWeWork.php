<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HowWeWork extends Model
{
    use HasFactory;

    protected $table = 'how_we_work';

    protected $fillable = [
        'about_id',
        'title',
        'description',
        'icon',
        'order',
    ];

    public function about()
    {
        return $this->belongsTo(AboutUs::class, 'about_id');
    }
}
