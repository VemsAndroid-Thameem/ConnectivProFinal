@extends('layouts.admin')

@section('page-title')
    {{ __('Dashboard') }}
@endsection

@php
    $setting = App\Models\Utility::settings();
    //remote login
    use App\Models\AttendanceEmployee;
    use App\Models\Employee;
@endphp

{{-- @section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
@endsection --}}

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif


    @if (\Auth::user()->type == 'employee')
            <div class="col-xxl-6">
                <div class="card">
                <div class="card-header">
                        <div class = "row">
                            <div class="col">
                                <h5>{{ __('Mark Attendance') }}</h5>
                            </div>
                            <!-- remote login-->
                            <div class="col justify-content-right text-right">
                               <div class="row">
                               <div class="col">
                                <h5 style="text-align:left;" id="RemoteText">{{ __('Remote') }}</h5>
                        <p style="text-align:left;margin:0%;font-size:9px;" id="RemoteTextStatus" hidden></p>

                                </div>
                                 <div class="col-2 form-check form-switch mr-auto rtl-hide">
                                 <input type="checkbox" class="form-check-input" style="width:40px;" name="remote1" id="remote1">
                                                       <!-- <input type="checkbox" name="remote" id="remote" value="1" {{ old('remote') ? 'checked' : '' }}> -->
                                 </div>
                               </div>
                            </div>
                        </div>
                        <!-- remote login-->
                        <div class="row">
                        <div class="form-group" style="margin-top:4%;" id="remoteReason" hidden>
            {{ Form::label('remote_reason1', __('Reason/Description'), ['class' => 'col-form-label']) }}
            {{ Form::textarea('remote_reason1', null, ['class' => 'form-control', 'placeholder' => __('Decribe your reason in few words'), 'rows' => '1']) }}
                        </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-muted pb-0-5">
                            {{ __('My Office Time: ' . $officeTime['startTime'] . ' to ' . $officeTime['endTime']) }}</p>
                        <div class="row">
                            <div class="col-sm-6 col-6 float-right border-right">
                                {{ Form::open(['url' => 'attendanceemployee/attendance', 'method' => 'post']) }}
                                <input type="checkbox" name="remote" id="remote" hidden><!-- remote login-->
                                <input type="text" name="remote_reason" id="remote_reason" hidden><!-- remote login -->
                                @if (empty($employeeAttendance) || $employeeAttendance->clock_out != '00:00:00')
                                    <button type="submit" value="0" name="in" id="clock_in"
                                        class="btn btn-primary">{{ __('CLOCK') }}<i class="ti ti-login-2"></i></button>
                                @else
                                    <button type="submit" value="0" name="in" id="clock_in"
                                        class="btn btn-secondary disabled" disabled>{{ __('DONE👍') }}</button>
                                    <!-- remote login  -->
                                    <script>
                                        //remote login
                                        getIsRemoteChecked();
                                        function getIsRemoteChecked() {
                                            const remote1 = document.getElementById('remote1');
                                            const remoteText = document.getElementById('RemoteText');
                                            const remoteTextStatus = document.getElementById('RemoteTextStatus');
                                            remote1.parentNode.style.display = "none";
                                            // Get the value from PHP and convert it to JavaScript
                                            @php
                                                $attendanceEmployee = AttendanceEmployee::where('created_by', '=', \Auth::user()->id)
                                                                        ->where('date',date('Y-m-d'))
                                                                        ->first();

                                                $isRemote = $attendanceEmployee ? $attendanceEmployee->isRemote : '';
                                                $remote_status = $attendanceEmployee ? $attendanceEmployee->remote_status : '';
                                            @endphp

                                            console.log("isRemote? "+"{{ $isRemote }}");
                                            if ("{{ $isRemote }}" === "1") {
                                            remoteText.textContent = "You have clocked in remotely!";
                                            remoteTextStatus.hidden = false;
                                            remoteTextStatus.textContent ="({{$remote_status}})";


                                            }else{
                                            remoteText.textContent = "You have clocked in!";
                                            }
                                        }
                                    </script>
                                @endif
                                {{ Form::close() }}
                            </div>
                            <div class="col-sm-6 col-6 float-left">
                                @if (!empty($employeeAttendance) && $employeeAttendance->clock_out == '00:00:00')
                                    {{ Form::model($employeeAttendance, ['route' => ['attendanceemployee.update', $employeeAttendance->id], 'method' => 'PUT']) }}
                                    <button type="submit" value="1" name="out" id="clock_out"
                                        class="btn btn-danger">{{ __('CLOCK OUT') }}<i class="ti ti-logout"></i></button>
                                @else
                                    <button type="submit" value="1" name="out" id="clock_out"
                                        class="btn btn-danger disabled" disabled>{{ __('GO HOME👋') }}</button>
                                @endif
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="card" style="height: 462px;">
                <div class="card-header card-body table-border-style">
                    <h5>{{ __('Meeting schedule') }}</h5>
                </div>
                <div class="card-body" style="height: 320px">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Meeting title') }}</th>
                                    <th>{{ __('Meeting Date') }}</th>
                                    <th>{{ __('Meeting Time') }}</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($meetings as $meeting)
                                    <tr>
                                        <td>{{ $meeting->title }}</td>
                                        <td>{{ \Auth::user()->dateFormat($meeting->date) }}</td>
                                        <td>{{ \Auth::user()->timeFormat($meeting->time) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

                    <div class="col-xxl-6">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <h5>{{ __('Calendar') }}</h5>
                                <input type="hidden" id="path_admin" value="{{ url('/') }}">
                            </div>
                            <div class="col-lg-6">
                                {{-- <div class="form-group"> --}}
                                <label for=""></label>
                                @if (isset($setting['is_enabled']) && $setting['is_enabled'] == 'on')
                                    <select class="form-control" name="calender_type" id="calender_type"
                                        style="float: right;width: 155px;" onchange="get_data()">
                                        <option value="google_calender">{{ __('Google Calendar') }}</option>
                                        <option value="local_calender" selected="true">
                                            {{ __('Local Calendar') }}</option>
                                    </select>
                                @endif
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id='event_calendar' class='calendar'></div>
                    </div>
                </div>
            </div>
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header card-body table-border-style">
                    <h5>{{ __('Announcement List') }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Start Date') }}</th>
                                    <th>{{ __('End Date') }}</th>
                                    <th>{{ __('Description') }}</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                            @php    
                            $myID=Employee::where('user_id', \Auth::user()->id)->get()->value('id');
                            @endphp
                                {{\Log::info($myID)}}
                                {{\Log::info(\Auth::user()->id)}}
                                @foreach ($announcements as $announcement)
                                {{\Log::info($announcement)}}
                                @if(in_array($myID, json_decode($announcement->employee_id)))
                                    <tr>
                                        <td>{{ $announcement->title }}</td>
                                        <td>{{ \Auth::user()->dateFormat($announcement->start_date) }}</td>
                                        <td>{{ \Auth::user()->dateFormat($announcement->end_date) }}</td>
                                        <td>{{ $announcement->description }}</td>
                                    </tr>
                                @else
                                @continue
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-xxl-12">
 
            {{-- start --}}
            @if(\Auth::user()->type!=="manager")
            <div class="row">

                <div class="col-lg-4 col-md-6">

                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-auto mb-3 mb-sm-0">
                                    <div class="d-flex align-items-center">
                                        <div class="theme-avtar bg-primary">
                                            <i class="ti ti-users"></i>
                                        </div>
                                        <div class="ms-3">
                                            <small class="text-muted">{{ __('Total') }}</small>
                                            <h6 class="m-0 text-primary">{{ __('Staff') }}({{ $countUser + $countEmployee }})</h6>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-auto text-end">
                                    <h4 class="m-0 text-primary">{{ $countUser + $countEmployee }}</h4>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">

                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-auto mb-3 mb-sm-0">
                                    <div class="d-flex align-items-center">
                                        <div class="theme-avtar bg-primary">
                                            <i class="ti ti-ticket"></i>
                                        </div>
                                        <div class="ms-3">
                                            <small class="text-muted">{{ __('Total') }}</small>
                                            <h6 class="m-0 text-primary">{{ __('Tickets') }}({{ $countTicket }})</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-auto mb-3 mb-sm-0">
                            <div class="d-flex align-items-center">
                                    <div class="theme-avtar bg-primary">
                                        <i class="ti ti-briefcase"></i>
                                    </div>
                                    <div class="ms-3">
                                        <small class="text-muted">{{ __('Total') }}</small>
                                        <h6 class="m-0 text-primary">{{ __('Jobs') }}({{ $activeJob + $inActiveJOb }})</h6>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">

                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-auto mb-3 mb-sm-0">
                                    <div class="d-flex align-items-center">
                                        <div class="theme-avtar bg-primary" style="position: relative;">
                                            <i class="ti ti-briefcase"></i>
                                            <div class="notification-dot" style="width: 15px; height: 15px; background-color: green; border-radius: 										50%; position: absolute; top: -5px; right: -5px;"></div>
                                        </div>
                                        <div class="ms-3">
                                            <small class="text-muted">{{ __('Active') }}</small>
                                            <h6 class="m-0 text-primary">{{ __('Jobs') }}({{ $activeJob }})</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">

                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-auto mb-3 mb-sm-0">
                            <div class="d-flex align-items-center">
                                <div class="theme-avtar bg-primary" style="position: relative;">
                                    <i class="ti ti-briefcase"></i>
                                <div class="notification-dot" style="width: 15px; height: 15px; background-color: red; border-radius: 50%; 										position: absolute; top: -5px; right: -5px;"></div>
                                    </div>
                                        <div class="ms-3">
                                            <small class="text-muted">{{ __('Inactive') }}</small>
                                            <h6 class="m-0 text-warning">{{ __('Jobs') }}({{ $inActiveJOb }})</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                       <div class="col-auto mb-3 mb-sm-0">
                            <div class="d-flex align-items-center">
                                <div class="theme-avtar bg-primary">
                                    <i class="ti ti-wallet"></i>
                                </div>
                                <div class="ms-3">
                                    <small class="text-muted">{{ __('Total Balance') }}</small>
                                    <h6 class="m-0 text-primary">{{ \Auth::user()->priceFormat($accountBalance) }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-4 col-md-6">

            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <div class="d-flex align-items-center">
                                <div class="theme-avtar bg-primary">
                                    <i class="ti ti-wallet"></i>
                                </div>
                                <div class="ms-3">
                                    <small class="text-muted">{{ __('Total Expenses') }}</small>
                                    <h6 class="m-0 text-warning">{{ $cnt_expense['this_month'] }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">

            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <div class="d-flex align-items-center">
                                <div class="theme-avtar bg-primary">
                                    <i class="ti ti-wallet"></i>
                                </div>
                                <div class="ms-3">
                                    <small class="text-muted">{{ __('Total Income') }}</small>
                                    <h6 class="m-0 text-primary">{{ $cnt_income['this_month'] }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @else
        <div class="card" style="background-color: #ffffd1;">
        <div class="card-header card-body table-border-style">
        <h3>You have limited access to dashboard!</h3>                       
        </div>
        </div>
        @endif

        {{-- </div> --}}

        {{-- end --}}

        <div class="col-xxl-12">
            <div class="row">
                <div class="col-xl-5">
                @if(\Auth::user()->type!=="manager")
                    <div class="card">
                        <div class="card-header card-body table-border-style">
                            <h5>{{ __('Meeting schedule') }}</h5>
                        </div>
                        <div class="card-body" style="height: 324px; overflow:auto">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Title') }}</th>
                                            <th>{{ __('Date') }}</th>
                                            <th>{{ __('Time') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list">
                                        @foreach ($meetings as $meeting)
                                            <tr>
                                                <td>{{ $meeting->title }}</td>
                                                <td>{{ \Auth::user()->dateFormat($meeting->date) }}</td>
                                                <td>{{ \Auth::user()->timeFormat($meeting->time) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

         
                    <div class="card">
                        <div class="card-header card-body table-border-style">
                            <h5>{{ __("Today's absences for clocking in") }}</h5>
                        </div>
                        <div class="card-body" style="height: 324px; overflow:auto">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list">
                                        @foreach ($notClockIns as $notClockIn)
                                            <tr>
                                                <td>{{ $notClockIn->name }}</td>
                                                <td><span class="absent-btn">{{ __('Absent') }}</span></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="card">
                        <div class="card-header card-body table-border-style">
                            <h5>{{ __('Meeting schedule') }}</h5>
                        </div>
                        <div class="card-body" style="height: 740px; overflow:auto">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Title') }}</th>
                                            <th>{{ __('Date') }}</th>
                                            <th>{{ __('Time') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list">
                                        @foreach ($meetings as $meeting)
                                            <tr>
                                                <td>{{ $meeting->title }}</td>
                                                <td>{{ \Auth::user()->dateFormat($meeting->date) }}</td>
                                                <td>{{ \Auth::user()->timeFormat($meeting->time) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    @endif

                </div>
                <div class="col-xl-7">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h5>{{ __('Calendar') }}</h5>
                                    <input type="hidden" id="path_admin" value="{{ url('/') }}">
                                </div>
                                <div class="col-lg-6">
                                    {{-- <div class="form-group"> --}}
                                        <label for=""></label>
                                        @if (isset($setting['is_enabled']) && $setting['is_enabled'] == 'on')
                                            <select class="form-control" name="calender_type" id="calender_type"
                                            style="float: right;width: 155px;" onchange="get_data()">
                                                <option value="google_calender">{{ __('Google Calendar') }}</option>
                                                <option value="local_calender" selected="true">
                                                    {{ __('Local Calendar') }}</option>
                                            </select>
                                        @endif
                                    {{-- </div> --}}
                                </div>
                            </div>
                        </div>
                        <div class="card-body card-635">
                            <div id='calendar' class='calendar'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header card-body table-border-style">
                    <h5>{{ __('Announcement List') }}</h5>
                </div>
                <div class="card-body" style="height: 270px; overflow:auto">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Start Date') }}</th>
                                    <th>{{ __('End Date') }}</th>
                                    <th>{{ __('Description') }}</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($announcements as $announcement)
                                    <tr>
                                        <td>{{ $announcement->title }}</td>
                                        <td>{{ \Auth::user()->dateFormat($announcement->start_date) }}</td>
                                        <td>{{ \Auth::user()->dateFormat($announcement->end_date) }}</td>
                                        <td>{{ $announcement->description }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        </div>
    @endif
@endsection

@push('script-page')
    <script src="{{ asset('assets/js/plugins/main.min.js') }}"></script>

    @if (Auth::user()->type !== 'employee')
    <script type="text/javascript">
        $(document).ready(function() {
            get_data();
        });

        function get_data() {
            var calender_type = $('#calender_type :selected').val();
            console.log(calender_type);
            $('#calendar').removeClass('local_calender');
            $('#calendar').removeClass('google_calender');
            if (calender_type == undefined) {
                calender_type = 'local_calender';
            }
            $('#calendar').addClass(calender_type);

            $.ajax({
                url: $("#path_admin").val() + "/event/get_event_data",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'calender_type': calender_type
                },
                success: function(data) {
                    (function() {
                        var etitle;
                        var etype;
                        var etypeclass;
                        var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                            headerToolbar: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'dayGridMonth,timeGridWeek,timeGridDay'
                            },
                            buttonText: {
                                timeGridDay: "{{ __('Day') }}",
                                timeGridWeek: "{{ __('Week') }}",
                                dayGridMonth: "{{ __('Month') }}"
                            },
                            // slotLabelFormat: {
                            //     hour: '2-digit',
                            //     minute: '2-digit',
                            //     hour12: false,
                            // },
                            themeSystem: 'bootstrap',
                            slotDuration: '00:10:00',
                            allDaySlot: true,
                            navLinks: true,
                            droppable: true,
                            selectable: true,
                            selectMirror: true,
                            editable: true,
                            dayMaxEvents: true,
                            handleWindowResize: true,
                            events: data,
                            // height: 'auto',
                            // timeFormat: 'H(:mm)',
                        });
                        calendar.render();
                    })();
                }
            });

        }
    </script>
    @else
    <script>
        $(document).ready(function() {
            get_data();
        });

        function get_data() {
            var calender_type = $('#calender_type :selected').val();
            console.log(calender_type);
            $('#event_calendar').removeClass('local_calender');
            $('#event_calendar').removeClass('google_calender');
            if (calender_type == undefined) {
                calender_type = 'local_calender';
            }
            $('#event_calendar').addClass(calender_type);

            $.ajax({
                url: $("#path_admin").val() + "/event/get_event_data",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'calender_type': calender_type
                },
                success: function(data) {
                    (function() {
                        var etitle;
                        var etype;
                        var etypeclass;
                        var calendar = new FullCalendar.Calendar(document.getElementById(
                        'event_calendar'), {
                            headerToolbar: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'dayGridMonth,timeGridWeek,timeGridDay'
                            },
                            buttonText: {
                                timeGridDay: "{{ __('Day') }}",
                                timeGridWeek: "{{ __('Week') }}",
                                dayGridMonth: "{{ __('Month') }}"
                            },
                            // slotLabelFormat: {
                            //     hour: '2-digit',
                            //     minute: '2-digit',
                            //     hour12: false,
                            // },
                            themeSystem: 'bootstrap',
                            slotDuration: '00:10:00',
                            allDaySlot: true,
                            navLinks: true,
                            droppable: true,
                            selectable: true,
                            selectMirror: true,
                            editable: true,
                            dayMaxEvents: true,
                            handleWindowResize: true,
                            events: data,
                            // height: 'auto',
                            // timeFormat: 'H(:mm)',
                        });
                        calendar.render();
                    })();
                }
            });

        }
    </script>
    <script>
        // remote login
        const remote1= document.getElementById('remote1')
        const remote= document.getElementById('remote')
        const remoteReason= document.getElementById('remoteReason')
        const clockInBtn= document.getElementById('clock_in')
        const remote_Reason = document.getElementById('remote_reason')
        const remote_Reason1 = document.getElementById('remote_reason1')

        function syncInputs(){
            remote.checked = remote1.checked;
            if(remote1.checked){
                remoteReason.hidden = false;
                clockInBtn.disabled = true;
            }else{
                remoteReason.hidden = true;
                clockInBtn.disabled = false;
            }
        }

        remote1.addEventListener('change',syncInputs);

        remote_Reason1.addEventListener('keyup', (event) => {
    const inputValue = String(event.target.value);
    remote_Reason.value = remote_Reason1.value;

    if (inputValue.length < 12) {
        clockInBtn.disabled = true;
    } else {
        clockInBtn.disabled = false;
    }
});
        function isEmpty(val){
    return ((val !== '') && (val !== undefined) && (val.length > 0) && (val !== null));
}
    </script>
    @endif
@endpush
