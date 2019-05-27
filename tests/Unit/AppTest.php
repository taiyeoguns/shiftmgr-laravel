<?php

namespace Tests\Unit;

use App\Models\Manager;
use App\Models\Shift;
use App\Models\User;
use Bouncer;
use Carbon\Carbon;

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
        $response = $this->get(route('shifts.index'));

        //when they are a guest

        //then confirm they are guest and redirect to login page
        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function logged_in_user_gets_redirected_to_shifts_page_from_login_page()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)->get(route('login'))->assertRedirect(route('shifts.index'));
    }

    /**
     * @test
     */
    public function logged_in_user_can_view_shifts_page()
    {
        $user = factory(User::class)->create();
        $manager = factory(Manager::class)->create();

        $manager->user()->save($user);
        Bouncer::assign('manager')->to($user);

        factory(Shift::class)->create([
            "shift_date" => Carbon::now(),
            "manager_id" => $manager->id,
        ]);

        $response = $this->actingAs($user)->get(route('shifts.index'));

        $response->assertViewIs('shifts.index');
    }

    /**
     * @test
     */
    public function user_can_be_registered()
    {
        $user = [
            'first_name' => $fn = $this->faker->firstName,
            'last_name' => $ln = $this->faker->lastName,
            'email' => strtolower(sprintf('%s.%s@shiftmanager.local', $fn, $ln)),
            'phone' => $this->faker->phoneNumber,
            'type'  => $this->faker->randomElement(['member', 'manager']),
            'password' => 'Password123',
            'password_confirmation' => 'Password123'

        ];

        $response = $this->post(route('register'), $user);

        $response->assertRedirect('/shifts');
        $this->assertDatabaseHas('users', [
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email']
        ]);
        $this->assertCount(1, User::all());
    }
}
