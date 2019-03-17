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

        $past_shifts = $shifts
            ->filter(function ($shift, $key) {
                return $shift->date->lt(Carbon::today());
            })
            ->sortByDesc(function ($shift, $key) {
                return $shift->date;
            });

        $upcoming_shifts = $shifts
            ->filter(function ($shift, $key) {
                return $shift->date->gt(Carbon::today());
            })->sortBy(function ($shift, $key) {
                return $shift->date;
            });

        $ongoing_shift = $shifts
            ->filter(function ($shift) {
                return $shift->date->eq(Carbon::today());
            })
            ->first();

        return [
            'past_shifts' => $past_shifts,
            'upcoming_shifts' => $upcoming_shifts,
            'ongoing_shift' => $ongoing_shift
        ];
    }
}
