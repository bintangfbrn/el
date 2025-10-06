<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Flag;

class LogStatus extends Model
{
    protected $table = 'log_status';

    protected $guarded = [];

    public function flag()
    {
        return $this->hasOne(Flag::class, 'id', 'id_flag');
    }
}
