<?php

namespace Tests\Unit\Services;

use App\Mail\ShiftCreated;
use App\Models\Manager;
use App\Models\Member;
use App\Models\Shift;
use App\Models\User;
use App\Repositories\ShiftRepository;
use App\Services\ShiftService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ShiftServiceTest extends TestCase
{
    private $shiftService;
    private $manager;

    protected function setUp()
    {
        parent::setUp();

        $shiftRepository = app(ShiftRepository::class);

        $this->shiftService = new ShiftService($shiftRepository);

        $this->manager = factory(Manager::class)->create();
    }

    /**
     * @test
     */
    public function get_shifts_returns_array()
    {
        $shifts = $this->shiftService->getShifts();

        $this->assertArrayHasKey('pastShifts', $shifts);
    }

    /**
     * @test
     */
    public function get_shifts_returns_past_shifts()
    {
        Carbon::setTestNow(Carbon::create(2019, 3, 16));

        for ($i = 1; $i <= 2; $i++) {
            factory(Shift::class)->create([
                "shift_date" => Carbon::now()->subDays($i),
                "manager_id" => $this->manager->id,
            ]);
        }

        $shifts = $this->shiftService->getShifts();

        $this->assertCount(2, $shifts['pastShifts']);
    }

    /**
     * @test
     */
    public function get_shifts_returns_upcoming_shifts()
    {
        Carbon::setTestNow(Carbon::create(2019, 3, 16));

        for ($i = 1; $i <= 2; $i++) {
            factory(Shift::class)->create([
                "shift_date" => Carbon::now()->addDays($i),
                "manager_id" => $this->manager->id,
            ]);
        }

        $shifts = $this->shiftService->getShifts();

        $this->assertCount(2, $shifts['upcomingShifts']);
    }

    /**
     * @test
     */
    public function get_shifts_returns_ongoing_shift()
    {
        Carbon::setTestNow(Carbon::create(2019, 3, 16));

        $shift = new Shift();
        $shift->date = "16/03/2019";
        $shift->manager()->associate($this->manager);
        $shift->save();

        $shifts = $this->shiftService->getShifts();

        $this->assertTrue($shift->is($shifts['ongoingShift']));
    }

    /**
     * @test
     */
    public function add_shift_creates_new_shift()
    {
        $user = factory(User::class)->create();
        $members = factory(Member::class, 3)->create();

        $this->manager->user()->save($user);

        Mail::fake();

        $shift = $this->shiftService->addShift("09/04/2019", $this->manager->id, $members->pluck('id'));

        $this->assertDatabaseHas('shifts', ['id' => $shift->id]);
        $this->assertCount(3, $shift->members);

        Mail::assertSent(ShiftCreated::class, function ($mail) use ($shift) {
            $mail->build();

            return $mail->shift->id === $shift->id &&
                $mail->hasTo($shift->manager->user) &&
                $mail->subject == "Shift Assigned";
        });
    }
}
