<?php

namespace Tests\Unit\Models;

use App\Models\Manager;
use App\Models\Member;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    private $user;

    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->make([
            'first_name' => 'John',
            'last_name' => 'Doe'
        ]);
    }

    /**
     * @test
     */
    public function user_full_name_is_returned()
    {
        $this->assertEquals($this->user->name, 'John Doe');
    }

    /**
     * @test
     */
    public function userable_is_returned()
    {
        $member = factory(Member::class)->create();

        $member->user()->save($this->user);

        $this->assertInstanceOf(Member::class, $this->user->userable);
    }

    /**
     * @test
     */
    public function checks_if_user_is_a_member()
    {
        $member = factory(Member::class)->create();

        $member->user()->save($this->user);

        $this->assertTrue($this->user->isMember());
    }

    /**
     * @test
     */
    public function checks_if_user_is_a_manager()
    {
        $manager = factory(Manager::class)->create();

        $manager->user()->save($this->user);

        $this->assertTrue($this->user->isManager());
    }
}
