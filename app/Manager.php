<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    public function shifts()
	{
		return $this->hasMany('App\Shift');
	}
}
