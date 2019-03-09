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
}
