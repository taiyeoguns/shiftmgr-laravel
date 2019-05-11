<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShift;
use App\Models\Shift;
use App\Repositories\ManagerRepository;
use App\Repositories\MemberRepository;
use App\Services\ShiftService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    protected $shiftService;

    public function __construct(ShiftService $shiftService)
    {
        $this->middleware('auth');

        $this->shiftService = $shiftService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ManagerRepository $managerRepository, MemberRepository $memberRepository)
    {
        $shifts = $this->shiftService->getShifts();
        $pastShifts = $shifts['pastShifts'];
        $upcomingShifts = $shifts['upcomingShifts'];
        $ongoingShift = $shifts['ongoingShift'];

        $managers = $managerRepository->with('user')->all();
        $members = $memberRepository->with('user')->all();

        return view('shifts.index', compact([
            'pastShifts',
            'upcomingShifts',
            'ongoingShift',
            'managers',
            'members'
        ]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreShift $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreShift $request)
    {
        try {
            $shift = $this->shiftService->addShift($request->shift_date, $request->manager, $request->members);

            flash("Shift created successfully!")->success();
            info("Shift created", ["id" => $shift->id]);
        } catch (QueryException $e) {
            flash("Date already exists")->error()->important();
            logger()->error($e->getMessage());
        }

        return redirect()->route('shifts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  str  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show(Shift $shift)
    {
        $page_title = sprintf("Shift: %s", $shift->date->format('l, d/m/Y'));

        return view('shifts.show', compact(['shift', 'page_title']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
