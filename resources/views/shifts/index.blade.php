@extends('master')

@section('page-css')
<link rel="stylesheet" href="{{ mix('css/shifts/index.min.css') }}">

@endsection

@section('content')

<br />

@if($ongoingShift != null)
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Today&apos;s Shift</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>

    </div>
    <div class="box-body">
        <!---->

        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Shift Date</th>
                    @if(auth()->user()->isMember() || auth()->user()->isAn('admin'))
                    <th>Manager</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                <tr href="{{ url('shifts', [$ongoingShift->id]) }}">
                    <td>{{ $ongoingShift->date->format('d/m/Y') }}</td>
                    @if(auth()->user()->isMember() || auth()->user()->isAn('admin'))
                    <td>{{ $ongoingShift->manager->user->name }}</td>
                    @endif
                </tr>
            </tbody>
        </table>

        <!---->
    </div>
</div>
@endif

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Upcoming Shifts</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>

    </div>
    <div class="box-body">
        <!---->
        @if($upcomingShifts->isEmpty())
        <em>No upcoming shifts.</em>
        @else
        <table class="table table-bordered table-hover table-striped shifts-table">
            <thead>
                <tr>
                    <th>Shift Date</th>
                    @if(auth()->user()->isMember())
                    <th>Manager</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($upcomingShifts as $shift)
                <tr href="{{ url('shifts', [$shift->id]) }}" id="{{ $shift->id }}">
                    <td>{{ $shift->date->format('d/m/Y') }}</td>
                    @if(auth()->user()->isMember())
                    <td>{{ $shift->manager->user->name }}</td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
        <!---->
    </div>
</div>


@unless($pastShifts->isEmpty())
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Past Shifts</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>

    </div>
    <div class="box-body">
        <!---->

        <table class="table table-bordered table-hover table-striped past-shifts-table">
            <thead>
                <tr>
                    <th>Shift Date</th>
                    @cannot('create-calls')
                    <th>Manager</th>
                    @endcannot
                </tr>
            </thead>
            <tbody>
                @foreach($pastShifts as $shift)
                <tr href="{{ url('shifts', [$shift->id]) }}">
                    <td>{{ $shift->date->format('d/m/Y') }}</td>
                    @cannot('create-calls')
                    <td>{{ $shift->manager->user->name }}</td>
                    @endcannot
                </tr>
                @endforeach
            </tbody>
        </table>

        <!---->
    </div>
</div>
@endunless

@endsection

@section('page-js')
<script src="{{ mix('js/shifts/index.min.js') }}"></script>
@endsection 
