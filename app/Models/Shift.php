<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $dates = ['shift_date'];
    protected $fillable = ['shift_date', 'manager_id'];

    /**
     * Manager of this shift
     *
     * @return void
     */
    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }

    /**
     * 'date' set mutator
     *
     * @param string $date
     * @return Carbon
     */
    public function setDateAttribute($date)
    {
        $this->attributes['shift_date'] = Carbon::createFromFormat('d/m/Y', $date);
    }

    /**
     * 'date' get mutator
     *
     * @return Carbon
     */
    public function getDateAttribute()
    {
        return Carbon::parse($this->attributes['shift_date']);
    }

    /**
     * Members belonging to this shift
     *
     * @return void
     */
    public function members()
    {
        return $this->belongsToMany(Member::class)->withTimestamps();
    }
}
