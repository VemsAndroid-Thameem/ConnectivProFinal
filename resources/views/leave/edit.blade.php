@php
    $chatgpt = Utility::getValByName('enable_chatgpt');
@endphp

{{ Form::model($leave, ['route' => ['leave.update', $leave->id], 'method' => 'PUT','enctype' => 'multipart/form-data'],) }}
<div class="modal-body">

    @if ($chatgpt == 'on')
    <div class="card-footer text-end">
        <a href="#" class="btn btn-sm btn-primary" data-size="medium" data-ajax-popup-over="true"
            data-url="{{ route('generate', ['leave']) }}" data-bs-toggle="tooltip" data-bs-placement="top"
            title="{{ __('Generate') }}" data-title="{{ __('Generate Content With AI') }}">
            <i class="fas fa-robot"></i>{{ __(' Generate With AI') }}
        </a>
    </div>
    @endif

    @if (\Auth::user()->type != 'employee')
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {{ Form::label('employee_id', __('Employee'), ['class' => 'col-form-label']) }}
                    {{ Form::select('employee_id', $employees, null, ['class' => 'form-control select2', 'placeholder' => __('Select Employee')]) }}
                </div>
            </div>
        </div>
    @else
        {!! Form::hidden('employee_id', !empty($employees) ? $employees->id : 0, ['id' => 'employee_id']) !!}
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('leave_type_id', __('Leave Type'), ['class' => 'col-form-label']) }}
                {{-- {{ Form::select('leave_type_id', $leavetypes, null, ['class' => 'form-control select', 'placeholder' => __('Select Leave Type')]) }} --}}
                <select name="leave_type_id" id="leave_type_id" class="form-control select">
                    @foreach ($leavetypes as $leave)
                        <option value="{{ $leave->id }}">{{ $leave->title }} (<p class="float-right pr-5">
                                {{ $leave->days }}</p>)</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('start_date', __('Start Date'), ['class' => 'col-form-label']) }}
                {{ Form::text('start_date', null, ['class' => 'form-control d_week', 'autocomplete' => 'off']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('end_date', __('End Date'), ['class' => 'col-form-label']) }}
                {{ Form::text('end_date', null, ['class' => 'form-control d_week', 'autocomplete' => 'off']) }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('leave_reason', __('Leave Reason'), ['class' => 'col-form-label']) }}
                {{ Form::textarea('leave_reason', null, ['class' => 'form-control', 'placeholder' => __('Leave Reason'), 'rows' => '3']) }}
            </div>
        </div>
    </div>
    <!-- Supporting Doc- only employee can edit this  -->
    @if (\Auth::user()->type == 'employee')
    <div class="row">
            <div class="form-group">
                {{ Form::label('supporting_document', __('Supporting Document'), ['class' => 'col-form-label']) }}
                <div class="choose-files ">
                    <label for="supporting_document">
                        <div class=" bg-primary document "> <i
                                class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                        </div>
                        <input style="margin-top: -50px" type="file" class="form-control file" name="supporting_document"  onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                        <p class="text-xs col-form-label" style="color:grey;">Max limit is 40Mb.</p>

                        <img id="blah" class="mt-3"  width="100" src="" />
                    </label>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('remark', __('Remark'), ['class' => 'col-form-label']) }}
                @if ($chatgpt == 'on')
                    <a href="#" data-size="md" class="btn btn-primary btn-icon btn-sm" data-ajax-popup-over="true"
                        id="grammarCheck" data-url="{{ route('grammar', ['grammar']) }}" data-bs-placement="top"
                        data-title="{{ __('Grammar check with AI') }}">
                        <i class="ti ti-rotate"></i> <span>{{ __('Grammar check with AI') }}</span>
                    </a>
                @endif
                {{ Form::textarea('remark', null, ['class' => 'form-control grammer_textarea', 'placeholder' => __('Add a Remark here..'), 'rows' => '3']) }}
            </div>
        </div>
    </div>
    @role('Company')
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {{ Form::label('status', __('Status'), ['class' => 'col-form-label']) }}
                    <select name="status" id="" class="form-control select2">
                        <option value="">{{ __('Select Status') }}</option>
                        <option value="pending" @if ($leave->status == 'Pending') selected="" @endif>{{ __('Pending') }}
                        </option>
                        <option value="approval" @if ($leave->status == 'Approval') selected="" @endif>{{ __('Approval') }}
                        </option>
                        <option value="reject" @if ($leave->status == 'Reject') selected="" @endif>{{ __('Reject') }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
    @endrole
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    <input type="submit" value="{{ __('Update') }}" class="btn  btn-primary">

</div>
{{ Form::close() }}

<script>
    $(document).ready(function() {
        setTimeout(() => {
            var employee_id = $('#employee_id').val();
            if (employee_id) {
                $('#employee_id').trigger('change');
            }
        }, 100);
    });
</script>