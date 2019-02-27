<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $dates = ['shift_date'];
    protected $fillable = ['shift_date', 'manager_id'];

    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }

    public function setDateAttribute($date)
    {
        $this->attributes['shift_date'] = Carbon::createFromFormat('d/m/Y', $date);
    }

    public function getDateAttribute()
    {
        return Carbon::parse($this->attributes['shift_date']);
    }
}
