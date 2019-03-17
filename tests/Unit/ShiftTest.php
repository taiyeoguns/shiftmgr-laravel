<?php

namespace Tests\Unit;

use App\Models\Manager;
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
        $date_text = '02/11/2018';
        $carbon_date = Carbon::createFromFormat('d/m/Y', $date_text);

        $shift = new Shift();
        $shift->manager()->associate($mgr);
        $shift->date = $date_text;
        $shift->save();

        $this->assertDatabaseHas('shifts', ['manager_id' => $mgr->id, 'shift_date' => $carbon_date]);
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

        $response = $this->actingAs($user)->get(route('shifts-index'));

        $response->assertViewHas('past_shifts');
        $response->assertViewHas('upcoming_shifts');
    }
}
