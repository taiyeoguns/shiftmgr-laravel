<?php

namespace Tests\Unit\Composers;

use App\Models\User;

use Tests\TestCase;

class ComposerTest extends TestCase
{
    protected $route;
    protected $view;

    public function setUp()
    {
        parent::setUp();

        $this->view = 'partials.header';

        $this->route = 'shifts';

        app('router')->get($this->route, [function () {
            return view($this->view);
        }]);
    }

    /**
     * @test
     */
    public function shifts_view_has_user_data_passed_from_composer()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)->get($this->route)->assertViewHas('user', $user);
    }
}
