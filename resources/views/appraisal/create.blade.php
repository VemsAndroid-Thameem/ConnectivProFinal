@php
    $chatgpt = Utility::getValByName('enable_chatgpt');
@endphp

{{ Form::open(['url' => 'appraisal', 'method' => 'post']) }}
<div class="modal-body">

    @if ($chatgpt == 'on')
    <div class="card-footer text-end">
        <a href="#" class="btn btn-sm btn-primary" data-size="medium" data-ajax-popup-over="true"
            data-url="{{ route('generate', ['appraisal']) }}" data-bs-toggle="tooltip" data-bs-placement="top"
            title="{{ __('Generate') }}" data-title="{{ __('Generate Content With AI') }}">
            <i class="fas fa-robot"></i>{{ __(' Generate With AI') }}
        </a>
    </div>
    @endif

    <!-- //APPRAISAL MODULE CHANGES -->
    <div class="row">
    @if ($isTypeEmployee)
    <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('branch', __('Branch*'), ['class' => 'col-form-label']) }}
                <input name="brances" id="brances" required class="form-control" value="{{$branchID}}" readonly hidden/>
                <input name="brances2" id="brances2"  class="form-control" value="{{$branchName}}" readonly/>
            </div>
        </div>
    <div class="col-md-6 mt-2">
            <div class="form-group">
                {{ Form::label('employee', __('Employee*'), ['class' => 'form-label']) }}

                <div class="employee_div">

                    <input name="employee" id="employee" class="form-control" value="{{$employee->search(\Auth::user()->name)}}" required readonly hidden/>
                    <input name="employee2" id="employee2" class="form-control" value="{{\Auth::user()->name}}"  readonly/>

                </div>
            </div>
        </div>

    @else

        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('branch', __('Branch*'), ['class' => 'col-form-label']) }}

                <select name="brances" id="brances" required class="form-control ">
                    <option selected disabled value="0">Select Category</option>

                    @foreach ($brances as $value)
                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="col-md-6 mt-2">
            <div class="form-group">
                {{ Form::label('employee', __('Employee*'), ['class' => 'form-label']) }}

                <div class="employee_div">

                    <select name="employee" id="employee" class="form-control " required>
                    </select>
                </div>
            </div>
        </div>
        @endif



        <div class="col-md-6 mt-2">
            <div class="form-group">
                {{ Form::label('appraisal_date', __('Select Month*'), ['class' => 'form-label']) }}
                {{ Form::month('appraisal_date', '', ['class' => 'form-control ', 'autocomplete' => 'off', 'required' => 'required', 'id' => 'current_month']) }}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('description', __('Description'), ['class' => 'col-form-label']) }}
                {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '3', 'placeholder' => 'Enter description']) }}
            </div>
        </div>
         <!-- made remark only available for admins -->
    @if (\Auth::user()->type != 'employee')
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
                {{ Form::textarea('remark', null, ['class' => 'form-control grammer_textarea', 'placeholder' => __('Appraisal Remark'), 'rows' => '3']) }}
            </div>
        </div>
    </div>
    @endif
    </div>
    <div class="row" id="stares">
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Submit') }}" class="btn btn-primary">
</div>
{{ Form::close() }}



<script>

    //APPRAISAL MODULE CHANGES
    var condition = <?php echo json_encode($isTypeEmployee); ?>;
    var employeeID = <?php echo json_encode($employee->search(\Auth::user()->name)); ?>;

    if(condition){
        $(document).ready(function() {

        var emp_id = employeeID;
        console.log(emp_id);

        $.ajax({
            url: "{{ route('empByStar') }}",
            type: "post",
            data: {
                "employee": emp_id,
                "_token": "{{ csrf_token() }}",
            },

            cache: false,
            success: function(data) {
                $('#stares').append('<h5>Click to add your Ratings!</h5>');
                $('#stares').append(data.html);
            }
        })
    });
    }else{
        $('#employee').change(function() {

        var emp_id = $('#employee').val();
        console.log(emp_id);
        $.ajax({
            url: "{{ route('empByStar') }}",
            type: "post",
            data: {
                "employee": emp_id,
                "_token": "{{ csrf_token() }}",
            },

            cache: false,
            success: function(data) {
                $('#stares').append('<h5>Click to add your Ratings!</h5>');
                $('#stares').append(data.html);
            }
        })
    });
    }


</script>

<script>
    $('#brances').on('change', function() {
        var branch_id = this.value;

        $.ajax({
            url: "{{ route('getemployee') }}",
            type: "post",
            data: {
                "branch_id": branch_id,
                "_token": "{{ csrf_token() }}",
            },

            cache: false,
            success: function(data) {

                $('#employee').html('<option value="">Select Employee</option>');
                $.each(data.employee, function(key, value) {
                    $("#employee").append('<option value="' + value.id + '">' + value.name +
                        '</option>');
                });

            }
        })
    });
</script>

<script>
    document.getElementById('current_month').valueAsDate = new Date();
</script>
