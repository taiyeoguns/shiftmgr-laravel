@extends('master')

@section('page-css')
<link rel="stylesheet" href="{{ mix('css/shifts/show.min.css') }}">
@endsection

@section('content')

<div class="row">
    <div class="col-md-3">

        <div>

            <p><a href="{{ route('shifts.index') }}" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back to Shifts</a></p>
            @can('admin')
            <p><a href="#" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back to All Shifts</a></p>
            @endcan

        </div>

    </div>

    <div class="col-md-6">

        @if(auth()->user()->can('create-tasks') && $shift->members->count() > 0)
        @if($shift->isToday() || auth()->user()->isAn('admin'))
        <p class="text-center">

            <button type="button" class="btn btn-sm btn-success" id="add_task_btn" data-toggle="modal" data-target="#modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Task</button>

        </p>
        @endif
        @endif

    </div>

    <div class="col-md-3">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title" id="shift_date">{{ $shift->date->format('D, d/m/Y') }}</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">

                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <td><strong>Manager</strong></td>
                            <td>{{ $shift->manager->user->name }}</td>
                        </tr>
                        @if(!auth()->user()->isMember())
                        <tr>
                            <td><strong>Members</strong></td>
                            <td><a href="" title="View members for this shift" data-toggle="modal" data-target="#members_modal">View</a>
                                @if((auth()->user()->isAn('admin')) || ($shift->manager->id == auth()->user()->userable_id && $shift->isToday() ))
                                | <a href="" title="Add members to this shift" data-toggle="modal" data-target="#add_modal">Add</a>
                                @endif
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>

<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Timeline</a></li>
        <li><a href="#tab_2" data-toggle="tab">List</a></li>
        @can('create-tasks')
        <li><a href="#tab_3" data-toggle="tab">Summary</a></li>
        @endcan
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">

            <div id="timeline">
                <div class="menu">
                    <button class="fa fa-search-plus" id="zoomIn" title="Zoom in"></button>
                    <button class="fa fa-search-minus" id="zoomOut" title="Zoom out"></button>
                    <button class="fa fa-angle-double-left" id="moveLeft" title="Move left"></button>
                    <button class="fa fa-angle-double-right" id="moveRight" title="Move right"></button>
                </div>
            </div>

        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane" id="tab_2">
            @if(!$shift->userTasks() || $shift->userTasks()->isEmpty())
            <em>No tasks available</em>
            @else
            <table class="table table-bordered table-hover table-striped" id="tasks-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        @if(!auth()->user()->isMember())
                        <th>Member</th>
                        @endif
                        <th>Start</th>
                        <th>End</th>
                        <th>Status</th>
                        <th>Priority</th>
                        @if(auth()->user()->can('create-tasks'))
                        @if($shift->isToday() || auth()->user()->isAn('admin'))
                        <th>Action</th>
                        @endif
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($shift->userTasks() as $task)
                    <tr id="{{ $task->id }}">
                        <td data-task="{{ $task->id }}"><a href="{{ $task->id }}" target="_blank">{{ $task->title }}</a></td>
                        @if(!auth()->user()->isMember())
                        <td data-member="{{ $task->owner->id }}">{{ $task->owner->user->name }}</td>
                        @endif
                        <td data-start="{{ $task->start->format('h:i A') }}">{{ $task->start->format('h:i A') }}</td>
                        <td @if($task->end != null) data-end="{{ $task->end->format('h:i A') }}" @endif>@if($task->end != null) {{ $task->end->format('h:i A') }} @endif</td>
                        <td data-status="{{ $task->status_id }}">{{ $task->status }}</td>
                        <td data-priority="{{ $task->priority_id }}">{{ $task->priority }}</td>
                        @if(auth()->user()->can('create-tasks'))
                        @if($shift->isToday() || auth()->user()->isAn('admin'))
                        <td>
                            <button type="button" class="btn btn-xs btn-primary task_edit_btn">Edit</button>
                            <button type="button" class="btn btn-xs btn-primary task_delete_btn">Delete</button>
                        </td>
                        @endif
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
        <!-- /.tab-pane -->

        @can('create-tasks')
        <div class="tab-pane" id="tab_3">

            @if($shift->userTasks()->count() < 1) <p><i>No summary generated</i></p>
                @else
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Tasks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shift->getMemberTasks() as $task)
                        <tr>
                            <td width="30%">{{ $task['member'] }}</td>
                            <td>{{ $task['count'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @endif

        </div>
        <!-- /.tab-pane -->
        @endcan

    </div>
    <!-- /.tab-content -->
</div>

@endsection

@javascript('is_member', auth()->user()->isMember())
@javascript('timeline_data', $shift->getTimelineData())

@if(!auth()->user()->isMember())
@javascript('groups_data', $shift->getGroupsData())
@endif

@section('page-js')
<script src="{{ mix('js/shifts/show.min.js') }}"></script>
@endsection
