@extends('layouts.admin')
@php
use App\Models\Employee;
@endphp
@section('page-title')
    {{ __('Reimbursement') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Reimbursement') }}</li>
@endsection

@section('action-button')
    <div class="row align-items-center m-1">
        @can('Create Reimbursement')
            <div class="btn btn-sm btn-primary btn-icon">
                <a href="#" class="" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Create Reimbursement') }}"
                    data-ajax-popup="true" data-size="lg" data-title="{{ __('Create Reimbursement') }}"
                    data-url="{{ route('reimbursement.create') }}"><i class="ti ti-plus text-white"></i></a>
            </div>
        @endcan
    </div>
@endsection

@section('content')
    <div class='col-xl-12'>
        <div class="row">
            <div class="col-xl-3">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-b-20">{{ __('Total Approved Reimbursement Amount') }}</h6>
                                <h3 class="text-primary">{{ $cnt_reimbursement['approved']  }}</h3>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-handshake bg-primary text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-b-20">{{ __('Pending Reimbursement Amount') }}</h6>
                                <h3 class="text-warning">{{ $cnt_reimbursement['pending'] }}</h3>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-handshake bg-warning text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="col-xl-3">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-b-20">{{ __('This Month Total Reimbursement') }}</h6>
                                <h3 class="text-info">{{ $cnt_reimbursement['this_month'] }}</h3>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-handshake bg-info text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-b-20">{{ __('This Week Total Reimbursement') }}</h6>
                                <h3 class="text-warning">{{ $cnt_reimbursement['this_week'] }}</h3>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-handshake bg-warning text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-b-20">{{ __('Last 30 Days Total Reimbursement') }}</h6>
                                <h3 class="text-danger">{{ $cnt_reimbursement['last_30days'] }}</h3>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-handshake bg-danger text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="col-xl-12">
                <div class="card table-card">
                    <div class="card-header card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table mb-0 pc-dt-simple" id="pc-dt-simple">
                                <thead>
                                    <tr>
                                        <th width="60px">{{ __('#') }}</th>
                                        <th>{{ __('Employee Name') }}</th>
                                        <th>{{ __('subject') }}</th>
                                        <th>{{ __('Value') }}</th>
                                        <th>{{ __('Type') }}</th>
                                        <th>{{ __('Start Date') }}</th>
                                        <th>{{ __('End Date') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Updated by') }}</th>
                                        <th width="150px">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reimbursements as $reimbursement)
                            @if(\Auth::user()->type=='manager')
                                @php
                            //for branch oriented management
                            $employee = Employee::where('user_id', '=', $reimbursement->employee_name)->first(); // Use first() instead of get()

$reimbursementDepartmentId = !empty($employee->department_id) ? $employee->department_id : null;
$reimbursementBranchId = !empty($employee->branch_id) ? $employee->branch_id : null;
$belongsToManagerDepartment = ((int)$reimbursementDepartmentId === (int)$managerDepartmentId);
$belongsToManagerBranch = ((int)$reimbursementBranchId === (int)$managerBranchId);


                            \Log::info('reimbursementDepartmentId: '.$reimbursementDepartmentId .' reimbursementBranchId: '.$reimbursementBranchId);

                            @endphp

                            @if($belongsToManagerDepartment && $belongsToManagerBranch)
                                        <tr>
                                            <td class="Id">
                                                {{-- @can('View reimbursement') --}}
                                                <a href="{{ route('reimbursement.show', $reimbursement->id) }}"
                                                    class="btn btn-outline-primary">{{ Auth::user()->reimbursementNumberFormat($reimbursement->id) }}</a>
                                                {{-- @else --}}
                                                {{-- {{ \Auth::User()->reimbursementNumberFormat($reimbursement->id) }} --}}
                                                {{-- @endcan --}}
                                            </td>
                                            <td>{{ $reimbursement->employee->name }}</td>
                                            <td>{{ $reimbursement->subject }}</td>
                                            <td>{{ Auth::user()->priceFormat($reimbursement->value) }}</td>
                                            <td>{{ $reimbursement->reimbursement_type->name }}</td>
                                            <td>{{ Auth::user()->dateFormat($reimbursement->start_date) }}</td>
                                            <td>{{ Auth::user()->dateFormat($reimbursement->end_date) }}</td>
                                            <td>
                                                @if ($reimbursement->status == 'accept')
                                                    <span
                                                        class="status_badge badge bg-primary  p-2 px-3 rounded">{{ __('Accepted') }}</span>
                                                @elseif($reimbursement->status == 'decline')
                                                    <span
                                                        class="status_badge badge bg-danger p-2 px-3 rounded">{{ __('Declined') }}</span>
                                                @elseif($reimbursement->status == 'pending')
                                                    <span
                                                        class="status_badge badge bg-warning p-2 px-3 rounded">{{ __('Pending') }}</span>
                                                @elseif($reimbursement->status == 'review')
                                                <span
                                                        class="status_badge badge bg-info p-2 px-3 rounded">{{ __('Reviewed') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                               {{$reimbursement->updated_by?$reimbursement->updated_by:'-'}}
                                               
                                            </td>
                                            <td class="Action">
                                                <span>
                                                    <!-- @can('Create Reimbursement')
                                                        @if ($reimbursement->status == 'accept')
                                                            <div class="action-btn bg-primary ms-2">
                                                                <a href="#" data-size="lg"
                                                                    data-url="{{ route('reimbursements.copy', $reimbursement->id) }}"
                                                                    data-ajax-popup="true"
                                                                    data-title="{{ __('Copy Reimbursement') }}"
                                                                    class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="{{ __('Duplicate') }}"><i
                                                                        class="ti ti-copy text-white"></i></a>
                                                            </div>
                                                        @endif
                                                    @endcan -->


                                                    {{-- @if (\Auth::user()->type == 'company' || \Auth::user()->type == 'hr' || \Auth::user()->type == 'employee') --}}
                                                    <div class="action-btn bg-warning ms-2">
                                                        <a href="{{ route('reimbursement.show', $reimbursement->id) }}"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="{{ __('View Reimbursement') }}"><i
                                                                class="ti ti-eye text-white"></i></a>
                                                    </div>
                                                    {{-- @endif --}}

                                                    @can('Edit Reimbursement')
                                                        <div class="action-btn bg-info ms-2">
                                                            <a href="#" data-size="lg"
                                                                data-url="{{ URL::to('reimbursement/' . $reimbursement->id . '/edit') }}"
                                                                data-ajax-popup="true" data-title="{{ __('Edit Reimbursement') }}"
                                                                class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="{{ __('Edit Reimbursement') }}"><i
                                                                    class="ti ti-pencil text-white"></i></a>
                                                        </div>
                                                    @endcan

                                                    @can('Delete Reimbursement')
                                                        <div class="action-btn bg-danger ms-2">
                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['reimbursement.destroy', $reimbursement->id]]) !!}
                                                            <a href="#!"
                                                                class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="{{ __('Delete Reimbursement') }}">
                                                                <span class="text-white"> <i class="ti ti-trash"></i></span>
                                                            </a>
                                                            {!! Form::close() !!}
                                                        </div>
                                                    @endcan

                                                </span>
                                            </td>
                                        </tr>
                                        @else
                                @continue
                                @endif
                                @else
                                <tr>
                                            <td class="Id">
                                                {{-- @can('View reimbursement') --}}
                                                <a href="{{ route('reimbursement.show', $reimbursement->id) }}"
                                                    class="btn btn-outline-primary">{{ Auth::user()->reimbursementNumberFormat($reimbursement->id) }}</a>
                                                {{-- @else --}}
                                                {{-- {{ \Auth::User()->reimbursementNumberFormat($reimbursement->id) }} --}}
                                                {{-- @endcan --}}
                                            </td>
                                            <td>{{ $reimbursement->employee->name }}</td>
                                            <td>{{ $reimbursement->subject }}</td>
                                            <td>{{ Auth::user()->priceFormat($reimbursement->value) }}</td>
                                            <td>{{ $reimbursement->reimbursement_type->name }}</td>
                                            <td>{{ Auth::user()->dateFormat($reimbursement->start_date) }}</td>
                                            <td>{{ Auth::user()->dateFormat($reimbursement->end_date) }}</td>
                                            <td>
                                                @if ($reimbursement->status == 'accept')
                                                    <span
                                                        class="status_badge badge bg-primary  p-2 px-3 rounded">{{ __('Accepted') }}</span>
                                                @elseif($reimbursement->status == 'decline')
                                                    <span
                                                        class="status_badge badge bg-danger p-2 px-3 rounded">{{ __('Declined') }}</span>
                                                @elseif($reimbursement->status == 'pending')
                                                    <span
                                                        class="status_badge badge bg-warning p-2 px-3 rounded">{{ __('Pending') }}</span>
                                                @elseif($reimbursement->status == 'review')
                                                <span
                                                        class="status_badge badge bg-info p-2 px-3 rounded">{{ __('Reviewed') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                               {{$reimbursement->updated_by?$reimbursement->updated_by:'-'}}
                                               
                                            </td>
                                            <td class="Action">
                                                <span>
                                                    <!-- @can('Create Reimbursement')
                                                        @if ($reimbursement->status == 'accept')
                                                            <div class="action-btn bg-primary ms-2">
                                                                <a href="#" data-size="lg"
                                                                    data-url="{{ route('reimbursements.copy', $reimbursement->id) }}"
                                                                    data-ajax-popup="true"
                                                                    data-title="{{ __('Copy Reimbursement') }}"
                                                                    class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="{{ __('Duplicate') }}"><i
                                                                        class="ti ti-copy text-white"></i></a>
                                                            </div>
                                                        @endif
                                                    @endcan -->


                                                    {{-- @if (\Auth::user()->type == 'company' || \Auth::user()->type == 'hr' || \Auth::user()->type == 'employee') --}}
                                                    <div class="action-btn bg-warning ms-2">
                                                        <a href="{{ route('reimbursement.show', $reimbursement->id) }}"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="{{ __('View Reimbursement') }}"><i
                                                                class="ti ti-eye text-white"></i></a>
                                                    </div>
                                                    {{-- @endif --}}

                                                    @can('Edit Reimbursement')
                                                        <div class="action-btn bg-info ms-2">
                                                            <a href="#" data-size="lg"
                                                                data-url="{{ URL::to('reimbursement/' . $reimbursement->id . '/edit') }}"
                                                                data-ajax-popup="true" data-title="{{ __('Edit Reimbursement') }}"
                                                                class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="{{ __('Edit Reimbursement') }}"><i
                                                                    class="ti ti-pencil text-white"></i></a>
                                                        </div>
                                                    @endcan

                                                    @can('Delete Reimbursement')
                                                        <div class="action-btn bg-danger ms-2">
                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['reimbursement.destroy', $reimbursement->id]]) !!}
                                                            <a href="#!"
                                                                class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="{{ __('Delete Reimbursement') }}">
                                                                <span class="text-white"> <i class="ti ti-trash"></i></span>
                                                            </a>
                                                            {!! Form::close() !!}
                                                        </div>
                                                    @endcan

                                                </span>
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
        </div>
    </div>
@endsection

