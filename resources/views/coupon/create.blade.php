{{ Form::open(['route' => 'coupon.store', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}

@if (isset(auth()->user()->currentPlan) && auth()->user()->currentPlan->enable_chatgpt == 'on')
    <div class="mb-1 d-flex justify-content-end">
        <a href="#" class="btn btn-primary me-2 ai-btn" data-size="lg" data-ajax-popup-over="true"
            data-url="{{ route('generate', ['coupan']) }}" data-bs-toggle="tooltip" data-bs-placement="top"
            title="{{ __('Generate') }}" data-title="{{ __('Generate Content With AI') }}">
            <i class="fas fa-robot"></i> {{ __('Generate with AI') }}
        </a>
    </div>
@endif


<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
        {{ Form::text('coupon_name', old('coupon_name'), ['class' => 'form-control font-style', 'required' => 'required']) }}
    </div>

    <div class="form-group col-md-12">
        {!! Form::label('', __('Type'), ['class' => 'form-label']) !!}
        {!! Form::select(
            'coupon_type',
            ['percentage' => 'Percentage', 'flat' => 'Flat'],
            old('coupon_type'),
            ['class' => 'form-control', 'id' => 'category'],
        ) !!}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('discount', __('Discount'), ['class' => 'form-label']) }}
        {{ Form::number('discount_amount', old('discount_amount'), ['class' => 'form-control', 'required' => 'required', 'min' => '1', 'max' => '100', 'step' => '0.01']) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('coupon_expiry_date', __('Expiry Date'), ['class' => 'form-label']) }}
        {{ Form::date('coupon_expiry_date', old('coupon_expiry_date'), ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Select date']) }}
    </div>
    <div class="form-group">
        <div class="d-flex radio-check">
            <div class="m-1 form-check">
                <input type="radio" id="manual_code" value="manual" name="icon-input" class="form-check-input code"
                    checked="checked">
                <label class="form-check-label" for="manual_code">{{ __('Manual') }}</label>
            </div>
            <div class="m-1 form-check">
                <input type="radio" id="auto_code" value="auto" name="icon-input" class="form-check-input code">
                <label class="form-check-label" for="auto_code">{{ __('Auto Generate') }}</label>
            </div>
        </div>
    </div>
    <div class="form-group col-md-12">
        <div class="row">
            <div class="col-md-10" id="code_text">
                <input class="form-control" name="coupon_code" type="text" id="auto-code"
                    placeholder="{{ __('Generate Code') }}">
            </div>
            <div class="col-md-2" id="autogerate_button">
                <a href="#" class="btn btn-primary" id="code-generate"><i class="ti ti-history"></i></a>
            </div>
        </div>
    </div>

    <div class="pb-0 modal-footer">
        <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="{{__('Create')}}" class="btn btn-primary">
    </div>
</div>
{!! Form::close() !!}


<script>
    $(document).ready(function() {
        

        // On form submit
        $('form').on('submit', function(e) {
            // Remove any existing error message
            $('.error-message').remove();

            // Get the selected coupon type
            var couponType = $('#category').val();
            
            // Get the minimum spend amount and discount amount
            var minimumSpend = parseFloat($('input[name="minimum_spend"]').val());
            var discountAmount = parseFloat($('input[name="discount_amount"]').val());

            // Check if the coupon type is "Flat" and if the discount amount is greater than the minimum spend
            if (couponType !== 'percentage' && discountAmount > minimumSpend) {
                // Prevent form submission
                e.preventDefault();

                // Show error message
                var errorMessage = '<div class="alert alert-danger error-message">{{__('Discount amount cannot be greater than the minimum spend amount for flat type coupons.')}}</div>';
                $(this).prepend(errorMessage);
            }
        });
    });

    $(document).ready(function() {
        $(document).on('change', '#category', function() {
            var selectedType = $(this).val();
            if (selectedType != 'percentage') {
                // Remove min and max attributes
                $('.discount_amount').removeAttr('min');
                $('.discount_amount').removeAttr('max');
            } else {
                // Add min and max attributes
                $('.discount_amount').attr({
                    'min': '1',
                    'max': '100'
                });
            }
        });
    });
</script>
