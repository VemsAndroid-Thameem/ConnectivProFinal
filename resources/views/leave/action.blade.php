{{ Form::open(['url' => 'leave/changeaction', 'method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <table class="table modal-table" id="pc-dt-simple">
                <tr role="row">
                    <th>{{ __('Employee') }}</th>
                    <td>{{ !empty($employee->name) ? $employee->name : '' }}</td>
                </tr>
                <tr>
                    <th>{{ __('Leave Type ') }}</th>
                    <td>{{ !empty($leavetype->title) ? $leavetype->title : '' }}</td>
                </tr>
                <tr>
                    <th>{{ __('Appplied On') }}</th>
                    <td>{{ \Auth::user()->dateFormat($leave->applied_on) }}</td>
                </tr>
                <tr>
                    <th>{{ __('Start Date') }}</th>
                    <td>{{ \Auth::user()->dateFormat($leave->start_date) }}</td>
                </tr>
                <tr>
                    <th>{{ __('End Date') }}</th>
                    <td>{{ \Auth::user()->dateFormat($leave->end_date) }}</td>
                </tr>
                <tr>
                    <th>{{ __('Leave Reason') }}</th>
                    <td>{{ !empty($leave->leave_reason) ? $leave->leave_reason : '' }}</td>
                </tr>
                <tr>
                    <th>{{ __('Status') }}</th>
                    <td>{{ !empty($leave->status) ? $leave->status : '' }}</td>
                </tr>
                <input type="hidden" value="{{ $leave->id }}" name="leave_id">
            </table>
        </div>
    </div>
</div>
<!-- changes made for two way Approval -->
@if (Auth::user()->type == 'company' || Auth::user()->type == 'hr')
@if($leave->status=='Reviewed')
<div class="modal-footer">
    <input type="submit" value="{{ __('Approve') }}" class="btn btn-success rounded" name="status">
    <input type="submit" value="{{ __('Reject') }}" class="btn btn-danger rounded" name="status">
</div>
@elseif($leave->status=='Approved')
<div class="modal-footer">
    <input type="submit" value="{{ __('Approved') }}" class="btn btn-success rounded" name="status" disabled>
</div>
@else
<div class="modal-footer">
    <input type="submit" value="{{ __('Not yet Reviewed') }}" class="btn btn-info rounded" name="status" disabled>
</div>
@endif

@elseif(Auth::user()->type == 'manager')
@if($leave->status=='Pending')
<div class="modal-footer">
<input type="submit" value="{{ __('Review') }}" class="btn btn-info rounded" name="status">
<input type="submit" value="{{ __('Reject') }}" class="btn btn-danger rounded" name="status">
</div>
@elseif($leave->status=='Reviewed')
<div class="modal-footer">
<input type="submit" value="{{ $leave->status }}" class="btn btn-info rounded" name="status" disabled>
</div>
@else
<div class="modal-footer">
    <input type="submit" value="{{ __('Approved') }}" class="btn btn-success rounded" name="status" disabled>
</div>
@endif
@endif


{{ Form::close() }}