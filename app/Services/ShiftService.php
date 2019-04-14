<?php

namespace App\Services;

use App\Repositories\ShiftRepository;
use Carbon\Carbon;

class ShiftService
{
    protected $shiftRepository;

    public function __construct(ShiftRepository $shiftRepository)
    {
        $this->shiftRepository = $shiftRepository;
    }

    public function getShifts()
    {
        $shifts = $this->shiftRepository->all();

        $pastShifts = $shifts
            ->filter(function ($shift, $key) {
                return $shift->date->lt(Carbon::today());
            })
            ->sortByDesc(function ($shift, $key) {
                return $shift->date;
            });

        $upcomingShifts = $shifts
            ->filter(function ($shift, $key) {
                return $shift->date->gt(Carbon::today());
            })->sortBy(function ($shift, $key) {
                return $shift->date;
            });

        $ongoingShift = $shifts
            ->filter(function ($shift) {
                return $shift->date->isSameDay(Carbon::today());
            })
            ->first();

        return [
            'pastShifts' => $pastShifts,
            'upcomingShifts' => $upcomingShifts,
            'ongoingShift' => $ongoingShift
        ];
    }

    public function addShift($date, $manager, $members)
    {
        $shift = $this->shiftRepository->create(['shift_date' => Carbon::createFromFormat('d/m/Y', $date), 'manager_id' => $manager]);

        $shift->members()->attach($members);

        return $shift;
    }
}
