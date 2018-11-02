<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Shift extends Model
{
    protected $dates = ['shift_date'];
    protected $fillable = ['shift_date', 'manager_id'];

    public function manager()
	{
		return $this->belongsTo('App\Manager');
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
