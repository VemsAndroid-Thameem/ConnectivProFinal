@php
    $chatgpt = Utility::getValByName('enable_chatgpt');
@endphp
{{ Form::open(['url' => 'appraisal/changeshow', 'method' => 'post']) }}
<div class="modal-body">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="info text-sm">
                <strong>{{ __('Branch') }} : </strong>
                <span>{{ !empty($appraisal->branches) ? $appraisal->branches->name : '' }}</span>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="info text-sm font-style">
                <strong>{{ __('Employee') }} : </strong>
                <span>{{ !empty($appraisal->employees) ? $appraisal->employees->name : '' }}</span>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="info text-sm font-style">
                <strong>{{ __('Appraisal Date') }} : </strong>
                <span>{{ $appraisal->appraisal_date }}</span>
            </div>
        </div>
    </div>
    <div class="row" style="margin-bottom:2%;">
    <!-- //APPRAISAL MODULE CHANGES -->
    <hr>
        <div class="col-4 ">
            <h5>{{ __('Skill') }}</h5>
        </div>
        <div class="col-4"></div>

        <div class="col-4">
            <h5>{{ __('Rating') }}</h5>
        </div>
        
    </div>
    <hr>

    
        @php
        $countYes=0;
        @endphp
        <div class="row">
        <b class="text-primary" style="font-size:14px; margin-bottom:2%;">{{ __("Employer's Rating") }}</b>
            @foreach($appraisal_details as $appraisal_detail)
            @if($appraisal_detail->is_manager==='no')
        <div class="row">
                   <div class="col-4">
                   {{ $appraisal_detail->input_value }}
                   </div>
                   <div class="col-4"></div>
                   <div class="col-4">
                   <!-- {{ $appraisal_detail->rating }} -->

                   <fieldset id='demo1' class="rate" style="display: flex; flex-direction: row-reverse; align-items: center; justify-content: center;">
                        <input class="stars" type="radio" id="technical-5-{{ $appraisal_detail->id }}"
                            name="rating[{{ $appraisal_detail->id }}]" value="5"
                            {{ $appraisal_detail->rating == 5 ? 'checked' : '' }} disabled>
                        <label class="full" for="technical-5-{{ $appraisal_detail->id }}" title="Awesome - 5 stars"></label>
                        <input class="stars" type="radio" id="technical-4-{{ $appraisal_detail->id }}"
                            name="rating[{{ $appraisal_detail->id }}]" value="4"
                            {{ $appraisal_detail->rating == 4 ? 'checked' : '' }} disabled>
                        <label class="full" for="technical-4-{{ $appraisal_detail->id }}"
                            title="Pretty good - 4 stars"></label>
                        <input class="stars" type="radio" id="technical-3-{{ $appraisal_detail->id }}"
                            name="rating[{{ $appraisal_detail->id }}]" value="3"
                            {{ $appraisal_detail->rating == 3 ? 'checked' : '' }} disabled>
                        <label class="full" for="technical-3-{{ $appraisal_detail->id }}" title="Meh - 3 stars"></label>
                        <input class="stars" type="radio" id="technical-2-{{ $appraisal_detail->id }}"
                            name="rating[{{ $appraisal_detail->id }}]" value="2"
                            {{ $appraisal_detail->rating == 2 ? 'checked' : '' }} disabled>
                        <label class="full" for="technical-2-{{ $appraisal_detail->id }}"
                            title="Kinda bad - 2 stars"></label>
                        <input class="stars" type="radio" id="technical-1-{{ $appraisal_detail->id }}"
                            name="rating[{{ $appraisal_detail->id }}]" value="1"
                            {{ $appraisal_detail->rating == 1 ? 'checked' : '' }} disabled>
                        <label class="full" for="technical-1-{{ $appraisal_detail->id }}"
                            title="Sucks big time - 1 star"></label>
                    </fieldset>
                   </div>
                </div>
                

            @else
            @php
        $countYes++
        @endphp
                @continue
            @endif
            @endforeach
            </div>


            @if($countYes>0)
            <div class="row">
                <b class="text-primary" style="font-size:14px;  margin-bottom:2%;">{{ __("Manager's Rating") }}</b>
                @foreach($appraisal_details as $appraisal_detail)
                    @if($appraisal_detail->is_manager==='yes')

                        <div class="row">
                            <div class="col-4">
                                {{ $appraisal_detail->input_value }}
                            </div>
                        <div class="col-4"></div>
                        <div class="col-4">
                   <!-- {{ $appraisal_detail->rating }} -->

                   <fieldset id='demo1' class="rate" style="display: flex; flex-direction: row-reverse; align-items: center; justify-content: center;">
                        <input class="stars" type="radio" id="technical-5-{{ $appraisal_detail->id }}"
                            name="rating[{{ $appraisal_detail->id }}]" value="5"
                            {{ $appraisal_detail->rating == 5 ? 'checked' : '' }} disabled>
                        <label class="full" for="technical-5-{{ $appraisal_detail->id }}" title="Awesome - 5 stars"></label>
                        <input class="stars" type="radio" id="technical-4-{{ $appraisal_detail->id }}"
                            name="rating[{{ $appraisal_detail->id }}]" value="4"
                            {{ $appraisal_detail->rating == 4 ? 'checked' : '' }} disabled>
                        <label class="full" for="technical-4-{{ $appraisal_detail->id }}"
                            title="Pretty good - 4 stars"></label>
                        <input class="stars" type="radio" id="technical-3-{{ $appraisal_detail->id }}"
                            name="rating[{{ $appraisal_detail->id }}]" value="3"
                            {{ $appraisal_detail->rating == 3 ? 'checked' : '' }} disabled>
                        <label class="full" for="technical-3-{{ $appraisal_detail->id }}" title="Meh - 3 stars"></label>
                        <input class="stars" type="radio" id="technical-2-{{ $appraisal_detail->id }}"
                            name="rating[{{ $appraisal_detail->id }}]" value="2"
                            {{ $appraisal_detail->rating == 2 ? 'checked' : '' }} disabled>
                        <label class="full" for="technical-2-{{ $appraisal_detail->id }}"
                            title="Kinda bad - 2 stars"></label>
                        <input class="stars" type="radio" id="technical-1-{{ $appraisal_detail->id }}"
                            name="rating[{{ $appraisal_detail->id }}]" value="1"
                            {{ $appraisal_detail->rating == 1 ? 'checked' : '' }} disabled>
                        <label class="full" for="technical-1-{{ $appraisal_detail->id }}"
                            title="Sucks big time - 1 star"></label>
                    </fieldset>
                   </div>
                </div>

@else
                @continue
            @endif
            @endforeach
            </div>
            @endif


        <div class="row" id="stares">
    </div>
        <!-- @foreach ($performance_types as $performance_type)
            <div class="col-md-12 mt-3">
                <h6>{{ $performance_type->name }}</h6>
                <hr class="mt-0">
            </div>

            @foreach ($performance_type->types as $types)
                <div class="col-4">
                    {{ $types->name }}
                </div>
                <div class="col-4"> -->
                    <!-- <fieldset id='demo' class="rate">
                        <input class="stars" type="radio" id="technical-5*-{{ $types->id }}"
                            name="ratings[{{ $types->id }}]" value="5"
                            {{ isset($ratings[$types->id]) && $ratings[$types->id] == 5 ? 'checked' : '' }} disabled>
                        <label class="full" for="technical-5*-{{ $types->id }}" title="Awesome - 5 stars"></label>
                        <input class="stars" type="radio" id="technical-4*-{{ $types->id }}"
                            name="ratings[{{ $types->id }}]" value="4"
                            {{ isset($ratings[$types->id]) && $ratings[$types->id] == 4 ? 'checked' : '' }} disabled>
                        <label class="full" for="technical-4*-{{ $types->id }}"
                            title="Pretty good - 4 stars"></label>
                        <input class="stars" type="radio" id="technical-3*-{{ $types->id }}"
                            name="ratings[{{ $types->id }}]" value="3"
                            {{ isset($ratings[$types->id]) && $ratings[$types->id] == 3 ? 'checked' : '' }} disabled>
                        <label class="full" for="technical-3*-{{ $types->id }}" title="Meh - 3 stars"></label>
                        <input class="stars" type="radio" id="technical-2*-{{ $types->id }}"
                            name="ratings[{{ $types->id }}]" value="2"
                            {{ isset($ratings[$types->id]) && $ratings[$types->id] == 2 ? 'checked' : '' }} disabled>
                        <label class="full" for="technical-2*-{{ $types->id }}"
                            title="Kinda bad - 2 stars"></label>
                        <input class="stars" type="radio" id="technical-1*-{{ $types->id }}"
                            name="ratings[{{ $types->id }}]" value="1"
                            {{ isset($ratings[$types->id]) && $ratings[$types->id] == 1 ? 'checked' : '' }} disabled>
                        <label class="full" for="technical-1*-{{ $types->id }}"
                            title="Sucks big time - 1 star"></label>
                    </fieldset> -->
                <!-- </div>
                <div class="col-4">
                    <fieldset id='demo1' class="rate">
                        <input class="stars" type="radio" id="technical-5-{{ $types->id }}"
                            name="rating[{{ $types->id }}]" value="5"
                            {{ isset($rating[$types->id]) && $rating[$types->id] == 5 ? 'checked' : '' }} disabled>
                        <label class="full" for="technical-5-{{ $types->id }}" title="Awesome - 5 stars"></label>
                        <input class="stars" type="radio" id="technical-4-{{ $types->id }}"
                            name="rating[{{ $types->id }}]" value="4"
                            {{ isset($rating[$types->id]) && $rating[$types->id] == 4 ? 'checked' : '' }} disabled>
                        <label class="full" for="technical-4-{{ $types->id }}"
                            title="Pretty good - 4 stars"></label>
                        <input class="stars" type="radio" id="technical-3-{{ $types->id }}"
                            name="rating[{{ $types->id }}]" value="3"
                            {{ isset($rating[$types->id]) && $rating[$types->id] == 3 ? 'checked' : '' }} disabled>
                        <label class="full" for="technical-3-{{ $types->id }}" title="Meh - 3 stars"></label>
                        <input class="stars" type="radio" id="technical-2-{{ $types->id }}"
                            name="rating[{{ $types->id }}]" value="2"
                            {{ isset($rating[$types->id]) && $rating[$types->id] == 2 ? 'checked' : '' }} disabled>
                        <label class="full" for="technical-2-{{ $types->id }}"
                            title="Kinda bad - 2 stars"></label>
                        <input class="stars" type="radio" id="technical-1-{{ $types->id }}"
                            name="rating[{{ $types->id }}]" value="1"
                            {{ isset($rating[$types->id]) && $rating[$types->id] == 1 ? 'checked' : '' }} disabled>
                        <label class="full" for="technical-1-{{ $types->id }}"
                            title="Sucks big time - 1 star"></label>
                    </fieldset>
                </div>
            @endforeach
        @endforeach -->
    
    <div class="row">
        <div class="col-md-12">
            <hr>
            <h6>{{ __('Description') }}</h6>
        </div>
        <div class="col-md-12 mt-3">
            <p class="text-sm">{{ $appraisal->description }}</p>
        </div>
        <input type="hidden" value="{{ $appraisal->id }}" name="appraisal_id">
    </div>
    <div class="row">
        <div class="col-md-12">
            <hr>
            <h6>{{ __('Remark') }}</h6>
        </div>
        <div class="col-md-12 mt-3">
<!-- made remark only available for admins -->
@if (\Auth::user()->type != 'employee')
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                @if ($chatgpt == 'on')
                    <a href="#" data-size="md" class="btn btn-primary btn-icon btn-sm" data-ajax-popup-over="true"
                        id="grammarCheck" data-url="{{ route('grammar', ['grammar']) }}" data-bs-placement="top"
                        data-title="{{ __('Grammar check with AI') }}">
                        <i class="ti ti-rotate"></i> <span>{{ __('Grammar check with AI') }}</span>
                    </a>
                @endif
                {{ Form::textarea('remark', null, [
    'class' => 'form-control grammer_textarea',
    'placeholder' => $appraisal->remark ? $appraisal->remark : __('Add a Remark here..'),
    'rows' => '3'
]) }}
            </div>
        </div>
    </div>
    @endif
        </div>
    </div>

    
    <!-- changes made for two way Approval -->
@if (Auth::user()->type == 'company' || Auth::user()->type == 'hr')
@if($appraisal->appraisal_status=='Review')
<div class="modal-footer">
    <input type="submit" value="{{ __('Approve') }}" class="btn btn-success rounded" name="status">
    <input type="submit" value="{{ __('Reject') }}" class="btn btn-danger rounded" name="status">
</div>
@elseif($appraisal->appraisal_status=='Approve')
<div class="modal-footer">
    <input type="submit" value="{{ __('Approved') }}" class="btn btn-success rounded" name="status" disabled>
</div>
@elseif($appraisal->appraisal_status=='Reject')
<div class="modal-footer">
    <input type="submit" value="{{ __('Rejected') }}" class="btn btn-danger rounded" name="status" disabled>
</div>
@else
<div class="modal-footer">
    <input type="submit" value="{{ __('Not yet Reviewed') }}" class="btn btn-info rounded" name="status" disabled>
</div>
@endif

@elseif(Auth::user()->type == 'manager')
@if($appraisal->appraisal_status=='Pending')
<div class="modal-footer">
<input type="submit" value="{{ __('Review') }}" class="btn btn-info rounded" name="status">
<input type="submit" value="{{ __('Reject') }}" class="btn btn-danger rounded" name="status">
</div>
@elseif($appraisal->appraisal_status=='Review')
<div class="modal-footer">
<input type="submit" value="{{ __('Reviewed') }}" class="btn btn-info rounded" name="status" disabled>
</div>
@elseif($appraisal->appraisal_status=='Reject')
<div class="modal-footer">
    <input type="submit" value="{{ __('Rejected') }}" class="btn btn-danger rounded" name="status" disabled>
</div>
@else
<div class="modal-footer">
    <input type="submit" value="{{ __('Approved') }}" class="btn btn-success rounded" name="status" disabled>
</div>
@endif
@endif

</div>

<script>
     var condition = <?php echo json_encode($isTypeManager); ?>;
    var employeeID = <?php echo json_encode($employee2->search($employee->name)); ?>;
    var isPending = <?php echo json_encode($appraisal->appraisal_status=='Pending'); ?>;

    if(condition && isPending){
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
                $('#stares').append('<h5>Click to add your Ratings seperately</h5>');
                $('#stares').append(data.html);
            }
        })
    });
    }
</script>
