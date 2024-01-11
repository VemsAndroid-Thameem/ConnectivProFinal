{!! Form::open(['route' => 'user.store', 'method' => 'post']) !!}
<div class="modal-body">
    <div class="row">
        <div class="form-group">
            {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
            <div class="form-icon-user">
                {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required','placeholder'=>'Enter Name']) !!}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('email', __('Email'), ['class' => 'form-label']) }}
            <div class="form-icon-user">
                {!! Form::text('email', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Enter Email']) !!}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('password', __('Password'), ['class' => 'form-label']) }}
            <div class="form-icon-user">
                {!! Form::password('password', ['class' => 'form-control', 'required' => 'required','placeholder'=>'Enter password']) !!}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('role', __('User Role'), ['class' => 'form-label']) }}
            <div class="form-icon-user">
                {!! Form::select('role', $roles, null, ['class' => 'form-control select2 ', 'required' => 'required', 'id' => 'userRole']) !!}
            </div>
            @error('role')
                <span class="invalid-role" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-md-12" id="branchContainer" style="display: none;">
            <div class="form-group">
                {{ Form::label('branch', __('Branch'), ['class' => 'col-form-label']) }}
                {{ Form::select('branch', $brances, null, ['class' => 'form-control select2 branch_id', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-12" id="departmentContainer" style="display: none;">
            <div class="form-group">
                {{ Form::label('department', __('Department'), ['class' => 'col-form-label']) }}
                <div class="department_div">
                    <select class="form-control  department_id select2" name="department" id="choices-multiple" placeholder="Select Department">
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">
</div>
<script>
$(document).ready(function() {
    $(document).on('change', 'select[name=role]', function() {
        var selectedRole = $(this).val();
        toggleBranchDepartmentInputs(selectedRole);
    });

    function toggleBranchDepartmentInputs(selectedRole) {
        if (selectedRole === '3') {
            $('#branchContainer').show();
            $('#departmentContainer').show();
            $('select[name="branch"]').prop('disabled', false);
            $('select[name="department"]').prop('disabled', false);
        } else {
            $('#branchContainer').hide();
            $('#departmentContainer').hide();
            $('select[name="branch"]').prop('disabled', true);
            $('select[name="department"]').prop('disabled', true);
        }
    }

    // Initialize the state based on the initial role value
    toggleBranchDepartmentInputs($('#userRole').val());

    $(document).on('change', 'select[name=branch]', function() {
        var branch_id = $(this).val();
        getdepartment(branch_id);
    });

    function getdepartment(bid) {
        $.ajax({
            url: '{{ route('employee.getdepartment') }}',
            type: 'POST',
            data: {
                "branch_id": bid,
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                $('.department_id').empty();
                var emp_selct = ` <select class="form-control department_id" name="department" id="choices-multiple" placeholder="Select Department"></select>`;
                $('.department_div').html(emp_selct);

                $('.department_id').append('<option value=""> {{ __('Select Department') }} </option>');
                $.each(data, function(key, value) {
                    $('.department_id').append('<option value="' + key + '">' + value + '</option>');
                });
                new Choices('#choices-multiple', {
                    removeItemButton: true,
                });
            }
        });
    }
});
</script>
{!! Form::close() !!}
