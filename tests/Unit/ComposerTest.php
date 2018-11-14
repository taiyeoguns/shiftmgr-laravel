<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ComposerTest extends TestCase
{

	protected $route;
	protected $view;

    public function setUp()
    {
        parent::setUp();

        $this->view = 'partials.header';

        $this->route = 'home';

        app('router')->get($this->route, [function() {
        	return view($this->view);
        }]);
    }

    /**
     * @test
     */
    public function home_view_has_user_data_passed_from_composer()
    {
    	$this->get($this->route)->assertViewHas('user');
    }
}
