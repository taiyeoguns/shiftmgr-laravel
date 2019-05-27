<?php

namespace Tests\Unit\Models;

use App\Models\Manager;
use App\Models\Member;
use App\Models\Shift;
use App\Models\Task;
use App\Models\User;
use Tests\TestCase;

class TaskTest extends TestCase
{
    private $manager;

    protected function setUp()
    {
        parent::setUp();

        $user = factory(User::class)->create();
        $this->manager = factory(Manager::class)->create();

        $this->manager->user()->save($user);
    }

    /**
     * @test
     */
    public function test_task_can_belong_to_shift()
    {
        $task = factory(Task::class)->create(['title' => 'A Task']);
        $shift = factory(Shift::class)->create([
            'manager_id' => $this->manager->id
        ]);

        $task->shift()->associate($shift);
        $task->save();

        $this->assertDatabaseHas('tasks', ['shift_id' => $shift->id, 'title' => "A Task"]);
        $this->assertEquals($task->shift->id, $shift->id);
    }

    /**
     * @test
     */
    public function test_task_owner_is_a_member()
    {
        $member = factory(Member::class)->create();
        $task = factory(Task::class)->create(['member_id' => $member->id, 'title' => 'A Task']);

        $this->assertInstanceOf(Member::class, $task->owner);
        $this->assertEquals($task->owner->id, $member->id);
    }
}
