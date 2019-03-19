<?php

namespace Tests\Unit\Models;

use App\Models\Manager;
use App\Models\Member;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{

    /**
     * @test
     */
    public function user_full_name_is_returned()
    {
        $user = factory(User::class)->make([
            'first_name' => 'John',
            'last_name' => 'Doe'
        ]);

        $this->assertEquals($user->name, 'John Doe');
    }

    /**
     * @test
     */
    public function userable_is_returned()
    {
        $member = factory(Member::class)->create();
        $user = factory(User::class)->create();

        $member->user()->save($user);

        $this->assertInstanceOf(Member::class, $user->userable);
    }

    /**
     * @test
     */
    public function checks_if_user_is_a_member()
    {
        $member = factory(Member::class)->create();
        $user = factory(User::class)->create();

        $member->user()->save($user);

        $this->assertTrue($user->isMember());
    }

    /**
     * @test
     */
    public function checks_if_user_is_a_manager()
    {
        $manager = factory(Manager::class)->create();
        $user = factory(User::class)->create();

        $manager->user()->save($user);

        $this->assertTrue($user->isManager());
    }
}
