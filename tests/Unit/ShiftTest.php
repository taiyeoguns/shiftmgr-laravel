<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Shift;
use App\Manager;
use Carbon\Carbon;

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

    }
}
