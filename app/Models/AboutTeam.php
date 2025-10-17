<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutTeam extends Model
{
    use HasFactory;

    protected $table = 'about_team';

    protected $fillable = [
        'about_id',
        'name',
        'position',
        'photo',
        'description',
        'social_links',
        'order',
    ];

    protected $casts = [
        'social_links' => 'array', // otomatis decode/encode JSON
    ];

    public function about()
    {
        return $this->belongsTo(AboutUs::class, 'about_id');
    }
}
