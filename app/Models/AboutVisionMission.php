<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutVisionMission extends Model
{
    use HasFactory;

    protected $table = 'about_vision_mission';

    protected $fillable = [
        'about_id',
        'vision',
        'mission',
    ];

    public function about()
    {
        return $this->belongsTo(AboutUs::class, 'about_id');
    }
}
