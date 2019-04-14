<div class="modal" id="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Add Shift</h4>
            </div>
            <div class="modal-body">
                <form id="shift-form" method="post" action="{{ url('shifts') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label for="shift_date">Date</label>
                                <input type="text" class="form-control required" name="shift_date" id="shift_date" placeholder="Date" />
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label for="manager">Manager</label><br />
                                <select class="form-control required" name="manager" id="manager" data-placeholder="Select a Manager">
                                    <option></option>
                                    @foreach($managers as $manager)
                                    <option value="{{ $manager->id }}">{{ $manager->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="members">Members</label>
                        <select class="form-control required" name="members[]" id="members" multiple="multiple" data-placeholder="Choose Members" data-msg="Select members">
                            <option></option>
                            @foreach($members as $member)
                            <option value="{{ $member->id }}">{{ $member->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" id="modalCloseBtn" data-dismiss="modal">Close</button>
                <input type="submit" name="submit" id="modalSubmitBtn" value="Add" class="btn btn-primary" />
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
