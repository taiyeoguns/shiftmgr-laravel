<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    /**
     * Gets user object
     *
     * @return void
     */
    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    /**
     * Gets shifts for this manager instance
     *
     * @return void
     */
    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }
}
