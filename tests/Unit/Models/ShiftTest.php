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
    /**
     * @test
     */
    public function shift_is_created()
    {
        $mgr = factory(Manager::class)->create();
        $dateText = '02/11/2018';
        $carbonDate = Carbon::createFromFormat('d/m/Y', $dateText);

        $shift = new Shift();
        $shift->manager()->associate($mgr);
        $shift->date = $dateText;
        $shift->save();

        $this->assertDatabaseHas('shifts', ['manager_id' => $mgr->id, 'shift_date' => $carbonDate]);
        $this->assertInstanceOf(Carbon::class, $shift->date);
        $this->assertEquals($shift->manager, $mgr);
        $this->assertInstanceOf(Manager::class, $shift->manager);
    }

    /**
     * @test
     *
     */
    public function shifts_index_page_returns_shifts()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('shifts.index'));

        $response->assertViewHas('pastShifts');
        $response->assertViewHas('upcomingShifts');
    }

    /**
     * @test
     *
     */
    public function shift_can_have_members()
    {
        $mgr = factory(Manager::class)->create();

        $shift = factory(Shift::class)->make();
        $shift->manager()->associate($mgr);
        $shift->save();

        factory(Member::class, 5)->create()->each(function ($member) use ($shift) {
            $member->shifts()->attach($shift->id);
            $member->save();
        });

        $this->assertCount(5, $shift->members);
    }
}
