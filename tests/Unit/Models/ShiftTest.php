<?php

namespace Tests\Unit\Models;

use App\Models\Manager;
use App\Models\Member;
use App\Models\Shift;
use App\Models\User;
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
}
