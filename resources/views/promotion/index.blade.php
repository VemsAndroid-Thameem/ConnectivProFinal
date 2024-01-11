@extends('layouts.admin')
@php
use App\Models\Employee;
@endphp
@section('page-title')
    {{ __('Manage Promotion') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Promotion') }}</li>
@endsection

@section('action-button')
    @can('Create Promotion')
        <a href="#" data-url="{{ route('promotion.create') }}" data-ajax-popup="true"
            data-title="{{ __('Create New Promotion') }}" data-size="lg" data-bs-toggle="tooltip" title=""
            class="btn btn-sm btn-primary" data-bs-original-title="{{ __('Create') }}">
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
                                    <th>{{ __('Employee Name') }}</th>
                                <th>{{ __('Designation') }}</th>
                                <th>{{ __('Promotion Title') }}</th>
                                <th>{{ __('Promotion Date') }}</th>
                                <th>{{ __('Description') }}</th>
                                @if (Gate::check('Edit Promotion') || Gate::check('Delete Promotion'))
                                    <th width="200px">{{ __('Action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            


                            @foreach ($promotions as $promotion)
                            @if(\Auth::user()->type=='manager')
                                @php
                            //for branch oriented management
                            $employee = Employee::where('id', '=', $promotion->employee_id)->first(); // Use first() instead of get()

$promotionDepartmentId = !empty($employee->department_id) ? $employee->department_id : null;
$promotionBranchId = !empty($employee->branch_id) ? $employee->branch_id : null;
$belongsToManagerDepartment = ((int)$promotionDepartmentId === (int)$managerDepartmentId);
$belongsToManagerBranch = ((int)$promotionBranchId === (int)$managerBranchId);


                            \Log::info('promotionDepartmentId: '.$promotionDepartmentId .' promotionBranchId: '.$promotionBranchId);

                            @endphp

                            @if($belongsToManagerDepartment && $belongsToManagerBranch)
                                <tr>
                                        <td>{{ !empty($promotion->employee()) ? $promotion->employee()->name : '' }}</td>
                                    <td>{{ !empty($promotion->designation()) ? $promotion->designation()->name : '' }}
                                    </td>
                                    <td>{{ $promotion->promotion_title }}</td>
                                    <td>{{ \Auth::user()->dateFormat($promotion->promotion_date) }}</td>
                                    <td>{{ $promotion->description }}</td>
                                    <td class="Action">
                                        @if (Gate::check('Edit Promotion') || Gate::check('Delete Promotion'))
                                            <span>
                                                @can('Edit Promotion')
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center" data-size="lg"
                                                            data-url="{{ URL::to('promotion/' . $promotion->id . '/edit') }}"
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                            title="" data-title="{{ __('Edit Promotion') }}"
                                                            data-bs-original-title="{{ __('Edit') }}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                @endcan

                                                @can('Delete Promotion')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['promotion.destroy', $promotion->id], 'id' => 'delete-form-' . $promotion->id]) !!}
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
                                        <td>{{ !empty($promotion->employee()) ? $promotion->employee()->name : '' }}</td>
                                    <td>{{ !empty($promotion->designation()) ? $promotion->designation()->name : '' }}
                                    </td>
                                    <td>{{ $promotion->promotion_title }}</td>
                                    <td>{{ \Auth::user()->dateFormat($promotion->promotion_date) }}</td>
                                    <td>{{ $promotion->description }}</td>
                                    <td class="Action">
                                        @if (Gate::check('Edit Promotion') || Gate::check('Delete Promotion'))
                                            <span>
                                                @can('Edit Promotion')
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center" data-size="lg"
                                                            data-url="{{ URL::to('promotion/' . $promotion->id . '/edit') }}"
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                            title="" data-title="{{ __('Edit Promotion') }}"
                                                            data-bs-original-title="{{ __('Edit') }}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                @endcan

                                                @can('Delete Promotion')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['promotion.destroy', $promotion->id], 'id' => 'delete-form-' . $promotion->id]) !!}
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
