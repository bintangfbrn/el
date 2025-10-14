<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'design_id',
        'designer_id',
        'status',
        'estimated_cost',
        'final_cost',
        'estimated_finish',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function designer()
    {
        return $this->belongsTo(User::class, 'designer_id');
    }

    public function design()
    {
        return $this->belongsTo(Design::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function revisions()
    {
        return $this->hasMany(Revision::class);
    }
}
