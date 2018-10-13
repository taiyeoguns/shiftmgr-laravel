<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShiftTest extends TestCase
{
    /**
     * @test
     */
    public function home_page_is_loaded()
    {
    	//given user tries to access home page
        $response = $this->get('/');

        //when authenticated or not

        //then confirm that the status is 200-ok
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function home_page_is_displayed()
    {
    	//given user tries to access home page
    	$response = $this->get(url('/'));

    	//when they are authenticated or not

    	//then confirm that text can be seen
    	$response->assertSee('Shift Manager');
    }

    /**
     * @test
     */
    public function guest_is_redirected_to_login()
    {
    	//given user tries to go to authenticated view
    	$response = $this->get(route('home'));

    	//when they are a guest

    	//then confirm they are guest and redirect to login page
    	$this->assertGuest();
    	$response->assertRedirect(route('login'));
    }
}
