<?php

namespace App\Http\Composers;

use Illuminate\View\View;

class TopComposer
{
    //
	public function __construct()
	{

	}

	public function compose(View $view)
	{
		$view->with('user', \Auth::user());
	}
}
