<?php

namespace Tests\Unit\Services;

use App\Models\Manager;
use App\Models\Member;
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

        $this->assertArrayHasKey('pastShifts', $shifts);
    }

    /**
     * @test
     */
    public function get_shifts_returns_past_shifts()
    {
        Carbon::setTestNow(Carbon::create(2019, 3, 16));

        $mgr = factory(Manager::class)->create();

        for ($i = 1; $i <= 2; $i++) {
            factory(Shift::class)->create([
                "shift_date" => Carbon::now()->subDays($i),
                "manager_id" => $mgr->id,
            ]);
        }

        $shiftRepository = app(ShiftRepository::class);
        $shiftService = new ShiftService($shiftRepository);

        $shifts = $shiftService->getShifts();

        $this->assertCount(2, $shifts['pastShifts']);
    }

    /**
     * @test
     */
    public function get_shifts_returns_upcoming_shifts()
    {
        Carbon::setTestNow(Carbon::create(2019, 3, 16));

        $mgr = factory(Manager::class)->create();

        for ($i = 1; $i <= 2; $i++) {
            factory(Shift::class)->create([
                "shift_date" => Carbon::now()->addDays($i),
                "manager_id" => $mgr->id,
            ]);
        }

        $shiftRepository = app(ShiftRepository::class);
        $shiftService = new ShiftService($shiftRepository);

        $shifts = $shiftService->getShifts();

        $this->assertCount(2, $shifts['upcomingShifts']);
    }

    /**
     * @test
     */
    public function get_shifts_returns_ongoing_shift()
    {
        Carbon::setTestNow(Carbon::create(2019, 3, 16));

        $mgr = factory(Manager::class)->create();

        $shift = new Shift();
        $shift->date = "16/03/2019";
        $shift->manager()->associate($mgr);
        $shift->save();

        $shiftRepository = app(ShiftRepository::class);
        $shiftService = new ShiftService($shiftRepository);

        $shifts = $shiftService->getShifts();

        $this->assertTrue($shift->is($shifts['ongoingShift']));
    }

    /**
     * @test
     */
    public function add_shift_creates_new_shift()
    {
        $shiftRepository = app(ShiftRepository::class);
        $shiftService = new ShiftService($shiftRepository);

        $mgr = factory(Manager::class)->create();
        $mbrs = factory(Member::class, 3)->create();

        $shift = $shiftService->addShift("09/04/2019", $mgr->id, $mbrs->pluck('id'));

        $this->assertDatabaseHas('shifts', ['id' => $shift->id]);
        $this->assertCount(3, $shift->members);
    }
}
