<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
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
     * Shifts belonging to this member
     *
     * @return void
     */
    public function shifts()
    {
        return $this->belongsToMany(Shift::class)->withTimestamps();
    }

    /**
     * Tasks belonging to this member
     *
     * @return void
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
