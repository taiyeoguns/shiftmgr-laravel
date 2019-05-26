<?php

namespace App\Models;

use Carbon\Carbon;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use GeneratesUuid;

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

    /**
     * Direct URL to this shift
     *
     * @return void
     */
    public function getUrlAttribute()
    {
        return route("shifts.show", ["uuid" => $this->attributes['uuid']]);
    }

    /**
     * Route key
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * Tasks for this shift
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function userTasks()
    {
        if (auth()->user()->isMember()) {
            return $this->tasks()->where("member_id", auth()->user()->userable_id)->get();
        } else {
            return $this->tasks;
        }
    }
}
