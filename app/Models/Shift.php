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
     *
     * @return void
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get tasks for currently logged in user
     *
     * @return void
     */
    public function userTasks()
    {
        if (auth()->user()->isMember()) {
            return $this->tasks()->where("member_id", auth()->user()->userable_id)->get();
        } else {
            return $this->tasks;
        }
    }

    /**
     * Check if shift is for current day
     */
    public function isToday()
    {
        return $this->shift_date->eq(Carbon::today());
    }

    /**
     * Gets groups data for Vis Timeline
     *
     * @return void
     */
    public function getGroupsData()
    {
        return $this->members->map(function ($member) {
            $data = [];
            $data['id'] = $member->id;
            $data['content'] = $member->user->name;

            return $data;
        });
    }

    /**
     * Gets data for Vis Timeline
     *
     * @return void
     */
    public function getTimelineData()
    {
        return $this->userTasks()->map(function ($task) {
            $data = [];
            $data['id'] = $task->id;
            $data['content'] = $task->title;
            $data['group'] = $task->owner->id;
            $data['start'] = $task->start->toDateTimeString();
            if ($task->end != null) {
                $data['end'] = $task->end->toDateTimeString();
            }

            return $data;
        });
    }

    /**
     * Gets task count for each member in this shift
     *
     * @return void
     */
    public function getMemberTasks()
    {
        return $this->members->map(function ($member) {
            $data = [];
            $data['member'] = $member->user->name;
            $data['count'] = $this->userTasks()->filter(function ($task) use ($member) {
                return $task->owner->id == $member->id;
            })->count();

            return $data;
        })->filter(function ($task) {
            return $task['count'] > 0;
        });
    }
}
