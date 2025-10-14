<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'style',
        'description',
        'estimated_cost',
        'estimated_duration',
        'image'
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
