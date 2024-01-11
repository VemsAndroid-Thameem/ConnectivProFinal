@extends('layouts.admin')

@section('page-title')
   {{ __("Manage Reimbursement Type") }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __("Home") }}</a></li>
    <li class="breadcrumb-item">{{ __("Reimbursement Type") }}</li>
@endsection

@section('action-button')

    <div class="row align-items-center m-1">
        @can('Create Reimbursement Type')
            <div class="col-auto pe-0">
                <a href="#" class="btn btn-sm btn-primary btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Create Reimbursement')}}" data-ajax-popup="true" data-size="md" data-title="{{__('Create Reimbursement Type')}}" data-url="{{route('reimbursement_type.create')}}"><i class="ti ti-plus text-white"></i></a>
            </div>
        @endcan
    </div>

@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{__('Reimbursement Type')}}</li>
@endsection

@section('content')
        <div class="col-sm-12">
        <div class="row">
        <div class="col-xl-3">
            @include('layouts.hrm_setup')
        </div>
        <div class="col-xl-9">
            <div class="card">
                <div class="card-body table-border-style">

                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>{{__('Reimbursement Type')}}</th>
                                    <th width="250px">{{__('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody >
                                @foreach ($reimbursementTypes as $reimbursementType)
                                <tr>
                                    <td>{{ $reimbursementType->name }}</td>
                                    <td class="Action">
                                        <span>
                                        @can('Edit Reimbursement Type')
                                                <div class="action-btn bg-info ms-2">
                                                    <a href="#" data-size="md" data-url="{{ URL::to('reimbursement_type/'.$reimbursementType->id.'/edit') }}" data-ajax-popup="true" data-title="{{__('Edit Reimbursement Type')}}" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Edit Reimbursement Type')}}" ><i class="ti ti-pencil text-white"></i></a>
                                                </div>
                                            @endcan
                                            @can('Delete Reimbursement Type')
                                                <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['reimbursement_type.destroy', $reimbursementType->id]]) !!}
                                                        <a href="#!" class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Delete')}}">
                                                           <span class="text-white"> <i class="ti ti-trash"></i></span></a>
                                                    {!! Form::close() !!}
                                                </div>
                                            @endif
                                        </span>
                                    </td>
                                </tr>
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
