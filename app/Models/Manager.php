<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }
}
