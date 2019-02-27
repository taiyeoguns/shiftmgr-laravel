<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Shift;

class Manager extends Model
{
    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }
}
