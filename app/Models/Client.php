<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $fillable = [
        'about_id',
        'client_name',
        'logo',
        'website',
        'order',
    ];

    public function about()
    {
        return $this->belongsTo(AboutUs::class, 'about_id');
    }
}
