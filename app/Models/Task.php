<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $dates = ["start", "end"];

    /**
     * Shfit this task belongs to
     */
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    /**
     * Member who owns this task
     */
    public function owner()
    {
        return $this->belongsTo(Member::class, "member_id");
    }
}
