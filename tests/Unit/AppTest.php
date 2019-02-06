<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Support\Facades\Session;

use Tests\TestCase;

class AppTest extends TestCase
{
    /**
     * @test
     */
    public function home_page_is_loaded()
    {
        //given user tries to access home page
        $response = $this->get(url('/'));

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

    /**
     * @test
     */
    public function logged_in_user_gets_redirected_to_home_page_from_login_page()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)->get(route('login'))->assertRedirect(route('home'));
    }

    /**
     * @test
     */
    public function logged_in_user_can_view_home_page()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('home'));

        $response->assertViewIs('dashboard');
    }

    /**
     * @test
     */
    public function user_can_be_registered()
    {

        //Session::start();

        $user = [
            'first_name' => $fn = $this->faker->firstName,
            'last_name' => $ln = $this->faker->lastName,
            'email' => strtolower(sprintf('%s.%s@dutymanager.local', $fn, $ln)),
            'password' => 'Password123',
            'password_confirmation' => 'Password123'

        ];

        $response = $this->post(route('register'), $user);

        $response->assertRedirect('/home');
        $this->assertDatabaseHas('users', [
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email']
        ]);
        $this->assertCount(1, $users = User::all());
    }

    /**
     * @test
     */
    public function user_full_name_is_returned()
    {
        $user = factory(User::class)->make();

        $this->assertEquals($user->name, sprintf('%s %s', $user->first_name, $user->last_name));
    }
}
