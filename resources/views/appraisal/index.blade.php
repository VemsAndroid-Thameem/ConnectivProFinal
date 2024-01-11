@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Appraisal') }}
@endsection
@push('css-page')
    <style>
        @import url({{ asset('css/font-awesome.css') }});

    </style>
@endpush
@push('script-page')
    <script src="{{ asset('js/bootstrap-toggle.js') }}"></script>
    <script>
        $('document').ready(function() {
            $('.toggleswitch').bootstrapToggle();
            $("fieldset[id^='demo'] .stars").click(function() {
                alert($(this).val());
                $(this).attr("checked");
            });
        });

        $(document).ready(function() {
            var employee = $('.employee').val();
            getEmployee(employee);
        });

        $(document).on('change', 'select[name=branch]', function() {
            var branch = $(this).val();
            getEmployee(branch);
        });

        function getEmployee(did) {
            $.ajax({
                url: '{{ route('branch.employee.json') }}',
                type: 'POST',
                data: {
                    "branch": did,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    $('.employee').empty();
                    var emp_selct = ` <select class="form-control  employee" name="employee" id="choices-multiple"
                                            placeholder="Select Employee" >
                                            </select>`;
                    $('.employee_div').html(emp_selct);

                    $('.employee').append('<option value="0"> {{ __('All') }} </option>');
                    $.each(data, function(key, value) {
                        $('.employee').append('<option value="' + key + '">' + value +
                            '</option>');
                    });
                    new Choices('#choices-multiple', {
                        removeItemButton: true,
                    });
                }
            });
        }
    </script>
@endpush

@section('breadcrumb')
    <li class="breadcrumb-item mt-2"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item mt-2">{{ __('Appraisal') }}</li>
@endsection

@section('action-button')
    @can('Create Appraisal')
        <a href="#" data-url="{{ route('appraisal.create') }}" data-ajax-popup="true" data-size="lg"
            data-title="{{ __('Create New Appraisal') }}" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
            data-bs-original-title="{{ __('Create') }}">
            <i class="ti ti-plus"></i>
        </a>
    @endcan
@endsection

@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                {{-- <h5> </h5> --}}
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>{{ __('Branch') }}</th>
                                <th>{{ __('Department') }}</th>
                                <th>{{ __('Designation') }}</th>
                                <th>{{ __('Employee') }}</th>
                                <!-- <th>{{ __('Target Rating') }}</th> -->
                                <th>{{ __('Rating') }}</th>
                                <th>{{ __('Appraisal Date') }}</th>
                                <th>{{ __('Remarks') }}</th>
                                <th>{{ __('Status') }}</th>
                                @if (Gate::check('Edit Appraisal') || Gate::check('Delete Appraisal') || Gate::check('Show Appraisal'))
                                    <th width="200px">{{ __('Action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>


                            @foreach ($appraisals as $appraisal)
                            @php
                            $designation=!empty($appraisal->employees) ?  $appraisal->employees->designation->id : '-';
                            $targetRating =  Utility::getTargetrating($designation,$competencyCount);
                            if(!empty($appraisal->rating))
                            {
                                $rating = json_decode($appraisal->rating,true);
                                $starsum = array_sum($rating);
                                $starcount = count($rating);
                                $overallrating = $starsum/$starcount;
                            }
                            else{
                                $overallrating = 0;
                            }

                            //for branch oriented management
                            $appraisalDepartmentId = !empty($appraisal->employees) ? $appraisal->employees->department->id : null;
                            $appraisalBranchId = !empty($appraisal->employees) ? $appraisal->employees->branch->id : null;
                            $belongsToManagerDepartment = ((int)$appraisalDepartmentId == (int)$managerDepartmentId);
                            $belongsToManagerBranch = ((int)$appraisalBranchId == (int)$managerBranchId);

                            @endphp

                            @if(\Auth::user()->type=='manager')
                            @if($belongsToManagerDepartment && $belongsToManagerBranch)
                                <tr>
                                    <td>{{ !empty($appraisal->branches) ? $appraisal->branches->name : '' }}</td>
                                    <td>{{ !empty($appraisal->employees) ?  $appraisal->employees->department->name : '-'}}
                                    </td>
                                    <td>{{ !empty($appraisal->employees) ? $appraisal->employees->designation->name : '-' }}
                                    </td>
                                    <td>{{ !empty($appraisal->employees) ? $appraisal->employees->name : '-' }}</td>
                                    <!-- <td >
                                        @for($i=1; $i<=5; $i++)
                                         @if($targetRating < $i)
                                            @if(is_float($targetRating) && (round($targetRating) == $i))
                                            <i class="text-warning fas fa-star-half-alt"></i>
                                            @else
                                            <i class="fas fa-star"></i>
                                            @endif
                                         @else
                                         <i class="text-warning fas fa-star"></i>
                                         @endif
                                        @endfor

                                       <span class="theme-text-color">({{number_format($targetRating,1)}})</span>
                                    </td> -->
                                    <td>

                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($overallrating < $i)
                                                @if (is_float($overallrating) && round($overallrating) == $i)
                                                    <i class="text-warning fas fa-star-half-alt"></i>
                                                @else
                                                    <i class="fas fa-star"></i>
                                                @endif
                                            @else
                                                <i class="text-warning fas fa-star"></i>
                                            @endif
                                        @endfor
                                        <span class="theme-text-color">({{ number_format($overallrating, 1) }})</span>
                                    </td>
                                    <td>{{ $appraisal->appraisal_date }}</td>
                                    @if(\Auth::user()->type != 'employee')
                                    <td>{{ $appraisal->remark!='' ? $appraisal->remark : 'Edit to add a Remark' }}</td>
                                    @else
                                    <td>{{ $appraisal->remark!='' ? $appraisal->remark : 'Any remarks from admin will appear here' }}</td>
                                    @endif
                                    <td>
                                    @if ($appraisal->appraisal_status == 'Pending')
                                            <div class="badge bg-warning p-2 px-3 rounded">{{__('Pending')}}</div>
                                        @elseif($appraisal->appraisal_status == 'Approve')
                                            <div class="badge bg-success p-2 px-3 rounded">{{__('Approved')}}</div>
                                        @elseif($appraisal->appraisal_status == "Reject")
                                            <div class="badge bg-danger p-2 px-3 rounded">{{ __('Rejected')}}</div>
                                        @elseif($appraisal->appraisal_status == "Review")
                                            <div class="badge bg-info p-2 px-3 rounded">{{__('Reviewed')}}</div>
                                        @endif
                                    </td>
                                    <td class="Action">
                                        @if (Gate::check('Edit Appraisal') || Gate::check('Delete Appraisal') || Gate::check('Show Appraisal'))
                                            <span>


                                                @can('Show Appraisal')



                                                    <div class="action-btn bg-warning ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center" data-size="lg"
                                                            data-url="{{ route('appraisal.show', $appraisal->id) }}"
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                            title="" data-title="{{ __('Appraisal Detail') }}"
                                                            data-bs-original-title="{{ __('View') }}">
                                                            <i class='{{ \Auth::user()->type !== "employee" ? "ti ti-caret-right text-white" : "ti ti-eye text-white" }}'></i>
                                                        </a>
                                                    </div>
                                                @endcan


                                                @can('Edit Appraisal')
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center" data-size="lg"
                                                            data-url="{{ route('appraisal.edit', $appraisal->id) }}"
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                            title="" data-title="{{ __('Edit Appraisal') }}"
                                                            data-bs-original-title="{{ __('Edit') }}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                @endcan

                                                @can('Delete Appraisal')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['appraisal.destroy', $appraisal->id], 'id' => 'delete-form-' . $appraisal->id]) !!}
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                            data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                                                            aria-label="Delete"><i
                                                                class="ti ti-trash text-white text-white"></i></a>
                                                        </form>
                                                    </div>
                                                @endcan
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @else
                                @continue
                                @endif
                                @else
                                <tr>
                                    <td>{{ !empty($appraisal->branches) ? $appraisal->branches->name : '' }}</td>
                                    <td>{{ !empty($appraisal->employees) ?  $appraisal->employees->department->name : '-'}}
                                    </td>
                                    <td>{{ !empty($appraisal->employees) ? $appraisal->employees->designation->name : '-' }}
                                    </td>
                                    <td>{{ !empty($appraisal->employees) ? $appraisal->employees->name : '-' }}</td>
                                    <!-- <td >
                                        @for($i=1; $i<=5; $i++)
                                         @if($targetRating < $i)
                                            @if(is_float($targetRating) && (round($targetRating) == $i))
                                            <i class="text-warning fas fa-star-half-alt"></i>
                                            @else
                                            <i class="fas fa-star"></i>
                                            @endif
                                         @else
                                         <i class="text-warning fas fa-star"></i>
                                         @endif
                                        @endfor

                                       <span class="theme-text-color">({{number_format($targetRating,1)}})</span>
                                    </td> -->
                                    <td>

                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($overallrating < $i)
                                                @if (is_float($overallrating) && round($overallrating) == $i)
                                                    <i class="text-warning fas fa-star-half-alt"></i>
                                                @else
                                                    <i class="fas fa-star"></i>
                                                @endif
                                            @else
                                                <i class="text-warning fas fa-star"></i>
                                            @endif
                                        @endfor
                                        <span class="theme-text-color">({{ number_format($overallrating, 1) }})</span>
                                    </td>
                                    <td>{{ $appraisal->appraisal_date }}</td>
                                    @if(\Auth::user()->type != 'employee')
                                    <td>{{ $appraisal->remark!='' ? $appraisal->remark : 'Edit to add a Remark' }}</td>
                                    @else
                                    <td>{{ $appraisal->remark!='' ? $appraisal->remark : 'Any remarks from admin will appear here' }}</td>
                                    @endif
                                    <td>
                                    @if ($appraisal->appraisal_status == 'Pending')
                                            <div class="badge bg-warning p-2 px-3 rounded">{{__('Pending')}}</div>
                                        @elseif($appraisal->appraisal_status == 'Approve')
                                            <div class="badge bg-success p-2 px-3 rounded">{{__('Approved')}}</div>
                                        @elseif($appraisal->appraisal_status == "Reject")
                                            <div class="badge bg-danger p-2 px-3 rounded">{{ __('Rejected')}}</div>
                                        @elseif($appraisal->appraisal_status == "Review")
                                            <div class="badge bg-info p-2 px-3 rounded">{{__('Reviewed')}}</div>
                                        @endif
                                    </td>
                                    <td class="Action">
                                        @if (Gate::check('Edit Appraisal') || Gate::check('Delete Appraisal') || Gate::check('Show Appraisal'))
                                            <span>


                                                @can('Show Appraisal')



                                                    <div class="action-btn bg-warning ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center" data-size="lg"
                                                            data-url="{{ route('appraisal.show', $appraisal->id) }}"
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                            title="" data-title="{{ __('Appraisal Detail') }}"
                                                            data-bs-original-title="{{ __('View') }}">
                                                            <i class='{{ \Auth::user()->type !== "employee" ? "ti ti-caret-right text-white" : "ti ti-eye text-white" }}'></i>
                                                        </a>
                                                    </div>
                                                @endcan


                                                @can('Edit Appraisal')
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center" data-size="lg"
                                                            data-url="{{ route('appraisal.edit', $appraisal->id) }}"
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                            title="" data-title="{{ __('Edit Appraisal') }}"
                                                            data-bs-original-title="{{ __('Edit') }}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                @endcan

                                                @can('Delete Appraisal')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['appraisal.destroy', $appraisal->id], 'id' => 'delete-form-' . $appraisal->id]) !!}
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                            data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                                                            aria-label="Delete"><i
                                                                class="ti ti-trash text-white text-white"></i></a>
                                                        </form>
                                                    </div>
                                                @endcan
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @endif

                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
