@php
    $chatgpt = Utility::getValByName('enable_chatgpt');
@endphp

{{ Form::open(['url' => 'deposit', 'method' => 'post']) }}
<div class="modal-body">

    @if ($chatgpt == 'on')
    <div class="card-footer text-end">
        <a href="#" class="btn btn-sm btn-primary" data-size="medium" data-ajax-popup-over="true"
            data-url="{{ route('generate', ['deposit']) }}" data-bs-toggle="tooltip" data-bs-placement="top"
            title="{{ __('Generate') }}" data-title="{{ __('Generate Content With AI') }}">
            <i class="fas fa-robot"></i>{{ __(' Generate With AI') }}
        </a>
    </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('account_id', __('Account'), ['class' => 'col-form-label']) }}
                {{ Form::select('account_id', $accounts, null, ['class' => 'form-control select2', 'placeholder' => __('Choose Account')]) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('amount', __('Amount'), ['class' => 'col-form-label']) }}
                {{ Form::number('amount', null, ['class' => 'form-control', 'placeholder' => __('Amount'), 'step' => '0.01']) }}
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('date', __('Date'), ['class' => 'col-form-label']) }}
                {{ Form::text('date', null, ['class' => 'form-control d_week current_date', 'autocomplete' => 'off']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('income_category_id', __('Category'), ['class' => 'col-form-label']) }}
                {{ Form::select('income_category_id', $incomeCategory, null, ['class' => 'form-control select2', 'placeholder' => __('Choose A Category')]) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('payer_id', __('Payer'), ['class' => 'col-form-label']) }}
                {{ Form::select('payer_id', $payers, null, ['class' => 'form-control select2']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('payment_type_id', __('Payment Method'), ['class' => 'col-form-label']) }}
                {{ Form::select('payment_type_id', $paymentTypes, null, ['class' => 'form-control select2', 'placeholder' => __('Choose Payment Method')]) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('referal_id', __('Ref#'), ['class' => 'col-form-label']) }}
                {{ Form::text('referal_id', null, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('description', __('Description'), ['class' => 'col-form-label']) }}
                {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Description'), 'rows' => '3']) }}
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
</div>
{{ Form::close() }}

<script>
    $(document).ready(function() {
        var now = new Date();
        var month = (now.getMonth() + 1);
        var day = now.getDate();
        if (month < 10) month = "0" + month;
        if (day < 10) day = "0" + day;
        var today = now.getFullYear() + '-' + month + '-' + day;
        $('.current_date').val(today);
    });
</script>
