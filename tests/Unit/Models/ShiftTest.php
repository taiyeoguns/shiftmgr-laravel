<?php

namespace Tests\Unit\Models;

use App\Models\Manager;
use App\Models\Member;
use App\Models\Shift;
use App\Models\Task;
use App\Models\User;
use Bouncer;
use Carbon\Carbon;
use Tests\TestCase;

class ShiftTest extends TestCase
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
    public function shift_is_created()
    {
        $dateText = '02/11/2018';
        $carbonDate = Carbon::createFromFormat('d/m/Y', $dateText);

        $shift = new Shift();
        $shift->manager()->associate($this->manager);
        $shift->date = $dateText;
        $shift->save();

        $this->assertDatabaseHas('shifts', ['manager_id' => $this->manager->id, 'shift_date' => $carbonDate]);
        $this->assertInstanceOf(Carbon::class, $shift->date);
        $this->assertEquals($shift->manager, $this->manager);
        $this->assertInstanceOf(Manager::class, $shift->manager);
    }

    /**
     * @test
     *
     */
    public function shift_can_be_created_with_request()
    {
        $members = factory(Member::class, 3)->create();
        $date = "13/04/2019";

        $response = $this->actingAs($this->manager->user)->json("POST", route("shifts.store"), [
            "shift_date" => $date,
            "manager" => $this->manager->id,
            "members" => $members->pluck('id')
        ]);

        $response->assertRedirect(route("shifts.index"));
        $response->assertSessionHas("flash_notification");
        $this->assertDatabaseHas(
            "shifts",
            [
                "manager_id" => $this->manager->id,
            ]
        );
    }

    /**
     * @test
     *
     */
    public function shift_with_duplicate_date_is_not_saved()
    {
        $members = factory(Member::class, 3)->create();

        factory(Shift::class)->create([
            "shift_date" => Carbon::create(2019, 4, 13),
            "manager_id" => $this->manager->id
        ]);

        Bouncer::assign('admin')->to($this->manager->user);

        $response = $this->actingAs($this->manager->user)->json("POST", route("shifts.store"), [
            "shift_date" => "13/04/2019",
            "manager" => $this->manager->id,
            "members" => $members->pluck('id')
        ]);

        $this->assertCount(1, Shift::all());
        $response->assertRedirect(route("shifts.index"));
        $response->assertSessionHas("flash_notification");
    }

    /**
     * @test
     *
     */
    public function shift_can_have_members()
    {
        $shift = factory(Shift::class)->make();
        $shift->manager()->associate($this->manager);
        $shift->save();

        factory(Member::class, 5)->create()->each(function ($member) use ($shift) {
            $member->shifts()->attach($shift->id);
            $member->save();
        });

        $this->assertCount(5, $shift->members);
    }

    /**
     * @test
     *
     */
    public function shift_can_be_retrieved_by_uuid()
    {
        $shift = factory(Shift::class)->make();
        $shift->manager()->associate($this->manager);
        $shift->save();

        $response = $this->actingAs($this->manager->user)->json("GET", route("shifts.show", ["uuid" => $shift->uuid]));

        $response->assertSee($shift->manager->user->name);
    }

    /**
     * @test
     *
     */
    public function shift_url()
    {
        $uuid = "11111111-1111-1111-1111-111111111111";

        $shift = factory(Shift::class)->make();
        $shift->manager()->associate($this->manager);
        $shift->uuid = $uuid;
        $shift->save();

        $this->assertEquals($shift->url, route("shifts.show", ["uuid" => $uuid]));

        $response = $this->actingAs($this->manager->user)->json("GET", $shift->url);
        $response->assertStatus(200);
    }

    /**
     * @test
     *
     */
    public function shift_is_today()
    {
        Carbon::setTestNow(Carbon::create(2019, 5, 27));

        $shift = factory(Shift::class)->make();
        $shift->shift_date = Carbon::today();
        $shift->manager()->associate($this->manager);
        $shift->save();

        $this->assertTrue($shift->isToday());
    }

    /**
     * @test
     *
     */
    public function user_tasks_returns_tasks_for_member()
    {
        $shift = factory(Shift::class)->create([
            "manager_id" => $this->manager->id
        ]);

        $member = factory(Member::class)->create();
        $user = factory(User::class)->create();
        $member->user()->save($user);

        $task1 = factory(Task::class)->create(["title" => "Task 1", "shift_id" => $shift->id]);
        factory(Task::class)->create(["title" => "Task 2", "shift_id" => $shift->id]);

        $shift->members()->attach($member->id);
        $member->tasks()->save($task1);

        $this->actingAs($member->user);

        $this->assertCount(1, $shift->userTasks());
        $this->assertEquals($shift->userTasks()->first()->title, "Task 1");
        $this->assertTrue(auth()->user()->isMember());
    }

    /**
     * @test
     *
     */
    public function user_tasks_returns_tasks_for_manager()
    {
        $shift = factory(Shift::class)->create([
            "manager_id" => $this->manager->id
        ]);

        $task1 = factory(Task::class)->create(["title" => "Task 1"]);
        $task2 = factory(Task::class)->create(["title" => "Task 2"]);

        $shift->tasks()->saveMany([$task1, $task2]);

        $this->actingAs($this->manager->user);

        $this->assertCount(2, $shift->userTasks());
        $this->assertTrue(auth()->user()->isManager());
    }

    /**
     * @test
     *
     */
    public function get_groups_data()
    {
        $shift = factory(Shift::class)->create([
            "manager_id" => $this->manager->id
        ]);

        $member1 = factory(Member::class)->create();
        $member1->user()->save(factory(User::class)->create(["first_name" => "User", "last_name" => "One"]));

        $member2 = factory(Member::class)->create();
        $member2->user()->save(factory(User::class)->create(["first_name" => "User", "last_name" => "Two"]));

        $shift->members()->attach([$member1->id, $member2->id]);

        $expectedGroupsData = json_encode(
            [
                ["id" => 1, "content" => "User One"],
                ["id" => 2, "content" => "User Two"],
            ]
        );

        $this->assertJsonStringEqualsJsonString($expectedGroupsData, $shift->getGroupsData());
    }

    /**
     * @test
     *
     */
    public function get_timeline_data()
    {
        $shift = factory(Shift::class)->create([
            "manager_id" => $this->manager->id
        ]);

        $member = factory(Member::class)->create();
        $user = factory(User::class)->create();
        $member->user()->save($user);

        $task1 = factory(Task::class)->create(["title" => "Task 1", "shift_id" => $shift->id]);

        $shift->members()->attach($member->id);
        $member->tasks()->save($task1);

        $expectedTimelineData = json_encode(
            [
                [
                    "id" => $task1->id,
                    "content" => "Task 1",
                    "group" => $task1->owner->id,
                    "start" => $task1->start->toDateTimeString(),
                    "end" => $task1->end->toDateTimeString()
                ],
            ]
        );

        $this->actingAs($member->user);

        $this->assertJsonStringEqualsJsonString($expectedTimelineData, $shift->getTimelineData());
    }

    /**
     * @test
     *
     */
    public function get_member_tasks()
    {
        $shift = factory(Shift::class)->create([
            "manager_id" => $this->manager->id
        ]);

        $member = factory(Member::class)->create();
        $user = factory(User::class)->create();
        $member->user()->save($user);

        $task1 = factory(Task::class)->create(["title" => "Task 1", "shift_id" => $shift->id]);
        $task2 = factory(Task::class)->create(["title" => "Task 2", "shift_id" => $shift->id]);

        $shift->members()->attach($member->id);
        $member->tasks()->saveMany([$task1, $task2]);

        $expectedMemberTasks = json_encode(
            [
                [
                    "member" => $member->user->name,
                    "count" => 2
                ],
            ]
        );

        $this->actingAs($member->user);

        $this->assertJsonStringEqualsJsonString($expectedMemberTasks, $shift->getMemberTasks());
    }
}
