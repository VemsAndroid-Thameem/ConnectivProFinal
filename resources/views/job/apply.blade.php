@php
    $logo = \App\Models\Utility::get_file('uploads/logo/');
    $setting = App\Models\Utility::colorset();
    $color = !empty($setting['theme_color']) ? $setting['theme_color'] : 'theme-3';
    $SITE_RTL = \App\Models\Utility::getValByName('SITE_RTL');
    $company_logo_light = Utility::getValByName('company_logo_light');
    $company_favicon = Utility::getValByName('company_favicon');

    $getseo = App\Models\Utility::getSeoSetting();
    $metatitle = isset($getseo['meta_title']) ? $getseo['meta_title'] : '';
    $metadesc = isset($getseo['meta_description']) ? $getseo['meta_description'] : '';
    $meta_image = \App\Models\Utility::get_file('uploads/meta/');
    $meta_logo = isset($getseo['meta_image']) ? $getseo['meta_image'] : '';
    $enable_cookie = \App\Models\Utility::getCookieSetting('enable_cookie');

@endphp

<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $SITE_RTL == 'on' ? 'rtl' : '' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        {{ !empty($companySettings['title_text']) ? $companySettings['title_text']->value : config('app.name', 'HRMGO') }}
        - {{ __('Career') }}</title>

    <!-- SEO META -->
    <meta name="title" content="{{ $metatitle }}">
    <meta name="description" content="{{ $metadesc }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ env('APP_URL') }}">
    <meta property="og:title" content="{{ $metatitle }}">
    <meta property="og:description" content="{{ $metadesc }}">
    <meta property="og:image"
        content="{{ isset($meta_logo) && !empty(asset('storage/uploads/meta/' . $meta_logo)) ? asset('storage/uploads/meta/' . $meta_logo) : 'hrmgo.png' }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ env('APP_URL') }}">
    <meta property="twitter:title" content="{{ $metatitle }}">
    <meta property="twitter:description" content="{{ $metadesc }}">
    <meta property="twitter:image"
        content="{{ isset($meta_logo) and !empty(asset('storage/uploads/meta/' . $meta_logo)) ? asset('storage/uploads/meta/' . $meta_logo) : 'hrmgo.png' }}">
    <link rel="icon"
        href="{{ $logo . '/' . (isset($company_favicon) and !empty($company_favicon) ? $company_favicon .'?'.time() : 'favicon.png' .'?'.time()) }}"
        type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}" id="stylesheet">
    @if (isset($setting['dark_mode']) and $setting['dark_mode'] == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    @endif
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    @if (isset($setting['dark_mode']) and $setting['dark_mode'] == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/custom-dark.css') }}">
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        #applicationStatusModal .page-body{
  max-width:300px;
  background-color:#FFFFFF;
  margin:10% auto;
}
 #applicationStatusModal .page-body .head{
  text-align:center;
}
/* #applicationStatusModal .tic{
  font-size:186px;
} */
#applicationStatusModal .close{
      opacity: 1;
    position: absolute;
    right: 0px;
    font-size: 30px;
    padding: 3px 15px;
  margin-bottom: 10px;
}
#applicationStatusModal .checkmark-circle {
  width: 150px;
  height: 150px;
  position: relative;
  display: inline-block;
  vertical-align: top;
}
.checkmark-circle .background {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  background: #1DA91A;
  position: absolute;
}
#applicationStatusModal .checkmark-circle .checkmark {
  border-radius: 5px;
}
#applicationStatusModal .checkmark-circle .checkmark.draw:after {
  -webkit-animation-delay: 300ms;
  -moz-animation-delay: 300ms;
  animation-delay: 300ms;
  -webkit-animation-duration: 1s;
  -moz-animation-duration: 1s;
  animation-duration: 1s;
  -webkit-animation-timing-function: ease;
  -moz-animation-timing-function: ease;
  animation-timing-function: ease;
  -webkit-animation-name: checkmark;
  -moz-animation-name: checkmark;
  animation-name: checkmark;
  -webkit-transform: scaleX(-1) rotate(135deg);
  -moz-transform: scaleX(-1) rotate(135deg);
  -ms-transform: scaleX(-1) rotate(135deg);
  -o-transform: scaleX(-1) rotate(135deg);
  transform: scaleX(-1) rotate(135deg);
  -webkit-animation-fill-mode: forwards;
  -moz-animation-fill-mode: forwards;
  animation-fill-mode: forwards;
}
#applicationStatusModal .checkmark-circle .checkmark:after {
  opacity: 1;
  height: 75px;
  width: 37.5px;
  -webkit-transform-origin: left top;
  -moz-transform-origin: left top;
  -ms-transform-origin: left top;
  -o-transform-origin: left top;
  transform-origin: left top;
  border-right: 15px solid #fff;
  border-top: 15px solid #fff;
  border-radius: 2.5px !important;
  content: '';
  left: 35px;
  top: 80px;
  position: absolute;
}

@-webkit-keyframes checkmark {
  0% {
    height: 0;
    width: 0;
    opacity: 1;
  }
  20% {
    height: 0;
    width: 37.5px;
    opacity: 1;
  }
  40% {
    height: 75px;
    width: 37.5px;
    opacity: 1;
  }
  100% {
    height: 75px;
    width: 37.5px;
    opacity: 1;
  }
}
@-moz-keyframes checkmark {
  0% {
    height: 0;
    width: 0;
    opacity: 1;
  }
  20% {
    height: 0;
    width: 37.5px;
    opacity: 1;
  }
  40% {
    height: 75px;
    width: 37.5px;
    opacity: 1;
  }
  100% {
    height: 75px;
    width: 37.5px;
    opacity: 1;
  }
}
@keyframes checkmark {
  0% {
    height: 0;
    width: 0;
    opacity: 1;
  }
  20% {
    height: 0;
    width: 37.5px;
    opacity: 1;
  }
  40% {
    height: 75px;
    width: 37.5px;
    opacity: 1;
  }
  100% {
    height: 75px;
    width: 37.5px;
    opacity: 1;
  }
}
    </style>
</head>

<body class="{{ $color }}">
    <div class="job-wrapper">
        <div class="job-content">
            <nav class="navbar">
                <div class="container">
                    <a class="navbar-brand" href="#">
                        <img src="{{ $logo . '/' . (isset($company_logo_light) && !empty($company_logo_light) ? $company_logo_light .'?'.time() : 'logo-light.png' .'?'.time()) }}"
                            alt="logo" style="width: 90px">
                    </a>
                </div>
            </nav>
            <section class="job-banner">
                <div class="job-banner-bg">
                    <img src="{{ asset('/storage/uploads/job/banner1.jpg') }}" alt="">
                </div>
                <div class="container">
                    <div class="job-banner-content text-center text-white">
                        <h1 class="text-white mb-3">
                            {{ __(' We help') }} <br> {{ __('businesses grow') }}
                        </h1>
                        <p>{{ __('Find the dream job you’ve always wanted..') }}</p>
                    </div>
                </div>
            </section>
            <section class="apply-job-section">
                <div class="container">
                    <div class="apply-job-wrapper bg-light">
                        <div class="section-title text-center">
                            <h2 class="h1 mb-3"> {{ $job->title }}</h2>
                            <div class="d-flex flex-wrap justify-content-center gap-1 mb-4">
                                @foreach (explode(',', $job->skill) as $skill)
                                    <span class="badge rounded p-2 bg-primary">{{ $skill }}</span>
                                @endforeach
                            </div>
                            @if (!empty($job->branches) ? $job->branches->name : '')
                                <p> <i class="ti ti-map-pin ms-1"></i>
                                    {{ !empty($job->branches) ? $job->branches->name : '' }}</p>
                            @endif
                        </div>
                        <div class="apply-job-form">
                            <h2 class="mb-4">{{ __('Apply for this job') }}</h2>
                            {{ Form::open(['route' => ['job.apply.data', $job->code], 'method' => 'post', 'enctype' => 'multipart/form-data']) }}

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                                        {{ Form::text('name', null, ['class' => 'form-control name', 'required' => 'required']) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('email', __('Email'), ['class' => 'form-label']) }}
                                        {{ Form::text('email', null, ['class' => 'form-control', 'required' => 'required']) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class "form-group">
                                        {{ Form::label('phone', __('Phone'), ['class' => 'form-label']) }}
                                        {{ Form::text('phone', null, ['class' => 'form-control', 'required' => 'required']) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    @if (!empty($job->applicant) and in_array('dob', explode(',', $job->applicant)))
                                        <div class="form-group">
                                            {!! Form::label('dob', __('Date of Birth'), ['class' => 'form-label']) !!}
                                            {!! Form::date('dob', old('dob'), ['class' => 'form-control datepicker w-100', 'required' => 'required']) !!}
                                        </div>
                                    @endif
                                </div>
                                @if (!empty($job->applicant) and in_array('gender', explode(',', $job->applicant)))
                                    <div class="form-group col-md-6 ">
                                        {!! Form::label('gender', __('Gender'), ['class' => 'form-label']) !!}
                                        <div class="d-flex radio-check">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="g_male" value="Male" name="gender"
                                                    class="custom-control-input">
                                                <label class="custom-control-label"
                                                    for="g_male">{{ __('Male') }}</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="g_female" value="Female" name="gender"
                                                    class="custom-control-input">
                                                <label class="custom-control-label"
                                                    for="g_female">{{ __('Female') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if (!empty($job->applicant) and in_array('country', explode(',', $job->applicant)))
                                    <div class="form-group col-md-6 ">
                                        {{ Form::label('country', __('Country'), ['class' => 'form-label']) }}
                                        {{ Form::text('country', null, ['class' => 'form-control', 'required' => 'required']) }}
                                    </div>
                                    <div class="form-group col-md-6 country">
                                        {{ Form::label('state', __('State'), ['class' => 'form-label']) }}
                                        {{ Form::text('state', null, ['class' => 'form-control', 'required' => 'required']) }}
                                    </div>
                                    <div class="form-group col-md-6 country">
                                        {{ Form::label('city', __('City'), ['class' => 'form-label']) }}
                                        {{ Form::text('city', null, ['class' => 'form-control', 'required' => 'required']) }}
                                    </div>
                                @endif
                                @if (!empty($job->visibility) and in_array('profile', explode(',', $job->visibility)))
                                    <div class="form-group col-md-6 ">
                                        {{ Form::label('profile', __('Profile'), ['class' => 'col-form-label']) }}
                                        <input type="file" class="form-control" name="profile" id="profile"
                                            data-filename="profile_create"
                                            onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                                        <img id="blah" src="" class="mt-3" width="25%" />
                                        <p class="profile_create"></p>
                                    </div>
                                @endif
                                @if (!empty($job->visibility) and in_array('resume', explode(',', $job->visibility)))
                                    <div class="form-group col-md-6 ">
                                        {{ Form::label('resume', __('CV / Resume'), ['class' => 'col-form-label']) }}
                                        <input type="file" class="form-control" name="resume" id="resume"
                                            data-filename="resume_create"
                                            onchange="document.getElementById('blah1').src = window.URL.createObjectURL(this files[0])"
                                            required>
                                        <img id="blah1" class="mt-3" src="" width="25%" />
                                        <p class="resume_create"></p>
                                    </div>
                                @endif
                                @if (!empty($job->visibility) and in_array('letter', explode(',', $job->visibility)))
                                    <div class="form-group col-md-12 ">
                                        {{ Form::label('cover_letter', __('Cover Letter'), ['class' => 'form-label']) }}
                                        {{ Form::textarea('cover_letter', null, ['class' => 'form-control', 'rows' => '3']) }}
                                    </div>
                                @endif
                                @foreach ($questions as $question)
                                    <div class="form-group col-md-12  question question_{{ $question->id }}">
                                        {{ Form::label($question->question, $question->question, ['class' => 'form-label']) }}
                                        <input type="text" class="form-control" name="question[{{ $question->question }}]" {{ $question->is_required ==
                                        'yes' ? 'required' : '' }}>
                                    </div>
                                    @endforeach
                                    <div class="col-12">
                                        <div class="text-center mt-4">
                                            <button type="submit" class="btn btn-primary" id="submitApplication" data-toggle="modal">
                                                {{ __('Submit your application') }}
                                            </button>
                                        </div>
                                    </div>
                                    </div>
                                    {{ Form::close() }}
                                    </div>
                                    </div>
                                    </div>
                                    </section>
                                    </div>
                                    </div>
                                    <div class="position-fixed top-0 end-0 p-3" style="z-index: 99999">
                                        <div id="liveToast" class="toast text-white  fade" role="alert" aria-live="assertive" aria-atomic="true">
                                            <div class="d-flex">
                                                <div class="toast-body"> </div>
                                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                                                    aria-label="Close"></button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Add this modal to show application status -->
                                    <div id="applicationStatusModal" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <a class="close" href="#" data-dismiss="modal">&times;</a>
                                                <div class="page-body">
                                                    <div class="head">
                                                        <h3 style="margin-top:5px;">Awesome!</h3>
                                                        <p>Your Application submitted successsfully. Check your email for detials.</p>
                                                    </div>
                                                    <h1 style="text-align:center;">
                                                        <div class="checkmark-circle">
                                                            <div class="background"></div>
                                                            <div class="checkmark draw"></div>
                                                        </div>
                                                </div>
                                                <div class="head">
                                                        <!-- <h3 style="margin-top:5px;">Awesome!</h3> -->
                                                        <a href="{{ route('career', [\Auth::user()->creatorId(), 'en']) }}">
                                                        <button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Close</button>
                                                    </a>
                                                </div>

                                                <!-- <div class="modal-footer text-center">
                                                    <a href="{{ route('career', [\Auth::user()->creatorId(), 'en']) }}">
                                                        <button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Close</button>
                                                    </a>
                                                </div> -->
                                            </div>
                                        </div>

                                    </div>

                                    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
                                    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
                                    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
                                    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
                                    <script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
                                    <script src="{{ asset('js/site.core.js') }}"></script>
                                    <script src="{{ asset('js/site.js') }}"></script>
                                    <script src="{{ asset('js/demo.js') }} "></script>
                                    <script src="{{ asset('js/custom.js') }}"></script>

                                    <script>
                                        // Function to show a Bootstrap modal with application status
                                        function showApplicationStatusModal(status, message) {
                                            const modal = $('#applicationStatusModal');
                                            const modalMessage = $('#applicationStatusMessage');
                                            modalMessage.html(message);
                                            modal.modal('show');
                                        }

                                        // $('#submitApplication').on('click', function (e) {
                                        //     e.preventDefault();

                                        //     // Simulate a delay to mimic application submission
                                        //     // In your real implementation, you should send the data to the server
                                        //     // and show the status returned by the server in the modal
                                        //     setTimeout(function () {
                                        //         const status = 'Success'; // Replace with your actual application status
                                        //         const message = 'Your application has been submitted successfully!'; // Replace with your actual message
                                        //         showApplicationStatusModal(status, message);
                                        //     }, 2000); // Delay for 2 seconds (simulated)
                                        // });

                                        // Add an event listener to the form submission
                                        $('#submitApplication').on('click', function(e) {
                                            e.preventDefault();

                                            // Get form data and submit it to the server
                                            const form = $('form');
                                            $.ajax({
                                                url: form.attr('action'),
                                                type: form.attr('method'),
                                                data: new FormData(form[0]),
                                                processData: false,
                                                contentType: false,
                                                success: function(response) {
                                                    const status = response.status; // Replace with the key in your response object
                                                    const message = response.message; // Replace with the key in your response object
                                                    showApplicationStatusModal(status, message);
                                                },
                                                error: function(error) {
                                                    // Handle the error and display an error message if needed
                                                    console.error('Error:', error);
                                                    const status = 'Error'; // Set to 'Error' or another status code
                                                    const message = 'An error occurred while submitting your application.'; // Set your error message
                                                    showApplicationStatusModal(status, message);
                                                }
                                            });
                                        });

                                            // Function to check if all required fields are filled
                                        function areAllFieldsFilled() {
                                            // Add all required fields' conditions here
                                            const name = $('#name').val();
                                            const email = $('#email').val();
                                            const phone = $('#phone').val();
                                            const dob = $('#dob').val(); // Add other required fields if necessary

                                            return name && email && phone && dob; // Update with all required fields
                                        }

                                        // Function to enable/disable the submit button
                                        function updateSubmitButtonState() {
                                            const submitButton = $('#submitApplication');
                                            submitButton.prop('disabled', !areAllFieldsFilled());
                                        }

                                        // Add input event listeners for required fields
                                        $('#name, #email, #phone, #dob').on('input', function() {
                                            updateSubmitButtonState();
                                        });

                                        // Add an event listener to the form submission
                                        $('#submitApplication').on('click', function(e) {
                                            if (!areAllFieldsFilled()) {
                                                e.preventDefault(); // Prevent form submission if required fields are not filled
                                                // You can show an error message here if needed
                                            }
                                        });

                                        // Initial state of the submit button
                                        updateSubmitButtonState();

                                    </script>


                                    @if ($message = Session::get('success'))
                                    <script>
                                        show_toastr('{{ 'success' }}', '{!! $message !!}');
                                    </script>
                                    @endif
                                    @if ($message = Session::get('error'))
                                    <script>
                                        show_toastr('{{ 'error' }}', '{!! $message !!}');
                                    </script>
                                    @endif

                                    @stack('custom-scripts')
                                    @if($enable_cookie['enable_cookie'] == 'on')
                                    @include('layouts.cookie_consent')
                                    @endif
                                    </body>

                                    </html>

