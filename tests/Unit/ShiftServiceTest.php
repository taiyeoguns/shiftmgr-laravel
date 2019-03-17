<?php

use App\Models\Manager;
use App\Models\Shift;
use App\Repositories\ShiftRepository;
use App\Services\ShiftService;
use Carbon\Carbon;
use Tests\TestCase;

class ShiftServiceTest extends TestCase
{
    /**
    * @test
    */
    public function get_shifts_returns_array()
    {
        $shiftRepository = app(ShiftRepository::class);
        $shiftService = new ShiftService($shiftRepository);

        $shifts = $shiftService->getShifts();

        $this->assertArrayHasKey('past_shifts', $shifts);
    }

    /**
     * @test
     */
    public function get_shifts_returns_past_shifts()
    {
        Carbon::setTestNow(Carbon::create(2019, 3, 16));

        $mgr = factory(Manager::class)->create();

        factory(Shift::class, 2)->make()->each(function ($shift) use ($mgr) {
            $shift->date = $this->faker->randomElement(["15/03/2019", "14/02/2019"]);
            $shift->manager()->associate($mgr);
            $shift->save();
        });

        $shiftRepository = app(ShiftRepository::class);
        $shiftService = new ShiftService($shiftRepository);

        $shifts = $shiftService->getShifts();

        $this->assertCount(2, $shifts['past_shifts']);
    }

    /**
     * @test
     */
    public function get_shifts_returns_upcoming_shifts()
    {
        Carbon::setTestNow(Carbon::create(2019, 3, 16));

        $mgr = factory(Manager::class)->create();

        factory(Shift::class, 2)->make()->each(function ($shift) use ($mgr) {
            $shift->date = $this->faker->randomElement(["10/04/2019", "14/05/2019"]);
            $shift->manager()->associate($mgr);
            $shift->save();
        });

        $shiftRepository = app(ShiftRepository::class);
        $shiftService = new ShiftService($shiftRepository);

        $shifts = $shiftService->getShifts();

        $this->assertCount(2, $shifts['upcoming_shifts']);
    }
}
