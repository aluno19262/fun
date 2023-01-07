<div class="row">
    <!-- Associate Id Field -->
    <div class="mb-10 col-md-6">
        {!! Form::label('associate_id', $order->getAttributeLabel('associate_id'), ['class' => 'form-label']) !!}
        {!! Form::number('associate_id', null, ['class' => 'form-control form-control-solid '.($errors->has('associate_id') ? 'is-invalid' : '')]) !!}
        @error('associate_id')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    <!-- User Id Field -->
    <div class="mb-10 col-md-6">
        {!! Form::label('user_id', $order->getAttributeLabel('user_id'), ['class' => 'form-label']) !!}
        {!! Form::number('user_id', null, ['class' => 'form-control form-control-solid '.($errors->has('user_id') ? 'is-invalid' : '')]) !!}
        @error('user_id')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<!-- Name Field -->
<div class="mb-10">
    {!! Form::label('name', $order->getAttributeLabel('name'), ['class' => 'form-label ']) !!}
    {!! Form::text('name', null, ['class' => 'form-control form-control-solid '.($errors->has('name') ? 'is-invalid' : ''),'maxlength' => 255]) !!}
    @error('name')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <!-- Email Field -->
    <div class="mb-10 col-md-4">
        {!! Form::label('email', $order->getAttributeLabel('email'), ['class' => 'form-label']) !!}
        {!! Form::email('email', null, ['class' => 'form-control form-control-solid '.($errors->has('email') ? 'is-invalid' : ''),'maxlength' => 255]) !!}
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <!-- Phone Field -->
    <div class="mb-10 col-md-4">
        {!! Form::label('phone', $order->getAttributeLabel('phone'), ['class' => 'form-label ']) !!}
        {!! Form::text('phone', null, ['class' => 'form-control form-control-solid '.($errors->has('phone') ? 'is-invalid' : ''),'maxlength' => 32]) !!}
        @error('phone')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <!-- Vat Field -->
    <div class="mb-10 col-md-4">
        {!! Form::label('vat', $order->getAttributeLabel('vat'), ['class' => 'form-label ']) !!}
        {!! Form::text('vat', null, ['class' => 'form-control form-control-solid '.($errors->has('vat') ? 'is-invalid' : ''),'maxlength' => 32]) !!}
        @error('vat')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <!-- Address Field -->
    <div class="mb-10 col-md-5">
        {!! Form::label('address', $order->getAttributeLabel('address'), ['class' => 'form-label ']) !!}
        {!! Form::text('address', null, ['class' => 'form-control form-control-solid '.($errors->has('address') ? 'is-invalid' : ''),'maxlength' => 512]) !!}
        @error('address')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    <!-- Zip Field -->
    <div class="mb-10 col-md-2">
        {!! Form::label('zip', $order->getAttributeLabel('zip'), ['class' => 'form-label ']) !!}
        {!! Form::text('zip', null, ['class' => 'form-control form-control-solid '.($errors->has('zip') ? 'is-invalid' : ''),'maxlength' => 16]) !!}
        @error('zip')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    <!-- Location Field -->
    <div class="mb-10 col-md-5">
        {!! Form::label('location', $order->getAttributeLabel('location'), ['class' => 'form-label ']) !!}
        {!! Form::text('location', null, ['class' => 'form-control form-control-solid '.($errors->has('location') ? 'is-invalid' : ''),'maxlength' => 128]) !!}
        @error('location')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <!-- Subtotal Field -->
    <div class="mb-10 col-md-4">
        {!! Form::label('subtotal', $order->getAttributeLabel('subtotal'), ['class' => 'form-label']) !!}
        {!! Form::number('subtotal', null, ['class' => 'form-control form-control-solid '.($errors->has('subtotal') ? 'is-invalid' : '')]) !!}
        @error('subtotal')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Vat Value Field -->
    <div class="mb-10 col-md-4">
        {!! Form::label('vat_value', $order->getAttributeLabel('vat_value'), ['class' => 'form-label']) !!}
        {!! Form::number('vat_value', null, ['class' => 'form-control form-control-solid '.($errors->has('vat_value') ? 'is-invalid' : '')]) !!}
        @error('vat_value')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Total Field -->
    <div class="mb-10 col-md-4">
        {!! Form::label('total', $order->getAttributeLabel('total'), ['class' => 'form-label']) !!}
        {!! Form::number('total', null, ['class' => 'form-control form-control-solid '.($errors->has('total') ? 'is-invalid' : '')]) !!}
        @error('total')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row d-none">
    <!-- Coupon Field -->
    <div class="mb-10 col-md-6">
        {!! Form::label('coupon', $order->getAttributeLabel('coupon'), ['class' => 'form-label ']) !!}
        {!! Form::text('coupon', null, ['class' => 'form-control form-control-solid '.($errors->has('coupon') ? 'is-invalid' : ''),'maxlength' => 64]) !!}
        @error('coupon')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Discount Field -->
    <div class="mb-10 col-md-6">
        {!! Form::label('discount', $order->getAttributeLabel('discount'), ['class' => 'form-label']) !!}
        {!! Form::number('discount', null, ['class' => 'form-control form-control-solid '.($errors->has('discount') ? 'is-invalid' : '')]) !!}
        @error('discount')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<!-- Delivery Date Field -->
<div class="mb-10  d-none">
    {!! Form::label('delivery_date', $order->getAttributeLabel('delivery_date'), ['class' => 'form-label']) !!}
    <div class="position-relative d-flex align-items-center">
        <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
        <span class="svg-icon svg-icon-2 position-absolute mx-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="black"></path>
                <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="black"></path>
                <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="black"></path>
            </svg>
        </span>
        <!--begin::Datepicker-->
        {!! Form::text('delivery_date', null, ['class' => 'form-control form-control-solid ps-12 '.($errors->has('delivery_date') ? 'is-invalid' : ''), 'placeholder' => __('Pick a date') ]) !!}
        <!--end::Datepicker-->
    </div>
    @error('delivery_date')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
@push('scripts')
    <script>
         $(function(){
            $("#delivery_date").flatpickr();
         });
    </script>
@endpush






<div class="row">
    <!-- Mb Ent Field -->
    <div class="mb-10 col-md-4">
        {!! Form::label('mb_ent', $order->getAttributeLabel('mb_ent'), ['class' => 'form-label ']) !!}
        {!! Form::text('mb_ent', null, ['class' => 'form-control form-control-solid '.($errors->has('mb_ent') ? 'is-invalid' : ''),'maxlength' => 5]) !!}
        @error('mb_ent')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Mb Ref Field -->
    <div class="mb-10 col-md-4">
        {!! Form::label('mb_ref', $order->getAttributeLabel('mb_ref'), ['class' => 'form-label ']) !!}
        {!! Form::text('mb_ref', null, ['class' => 'form-control form-control-solid '.($errors->has('mb_ref') ? 'is-invalid' : ''),'maxlength' => 9]) !!}
        @error('mb_ref')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Mb Limit Date Field -->
    <div class="mb-10 col-md-4">
        {!! Form::label('mb_limit_date', $order->getAttributeLabel('mb_limit_date'), ['class' => 'form-label']) !!}
        <div class="position-relative d-flex align-items-center">
            <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
            <span class="svg-icon svg-icon-2 position-absolute mx-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="black"></path>
                <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="black"></path>
                <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="black"></path>
            </svg>
        </span>
            <!--begin::Datepicker-->
        {!! Form::text('mb_limit_date', null, ['class' => 'form-control form-control-solid ps-12 '.($errors->has('mb_limit_date') ? 'is-invalid' : ''), 'placeholder' => __('Pick a date') ]) !!}
        <!--end::Datepicker-->
        </div>
        @error('mb_limit_date')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    @push('scripts')
        <script>
            $(function(){
                $("#mb_limit_date").flatpickr();
            });
        </script>
    @endpush
</div>

<div class="row">
    <!-- Mbway Ref Field -->
    <div class="mb-10 col-md-6">
        {!! Form::label('mbway_ref', $order->getAttributeLabel('mbway_ref'), ['class' => 'form-label ']) !!}
        {!! Form::text('mbway_ref', null, ['class' => 'form-control form-control-solid '.($errors->has('mbway_ref') ? 'is-invalid' : ''),'maxlength' => 25]) !!}
        @error('mbway_ref')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Mbway Alias Field -->
    <div class="mb-10 col-md-6">
        {!! Form::label('mbway_alias', $order->getAttributeLabel('mbway_alias'), ['class' => 'form-label ']) !!}
        {!! Form::text('mbway_alias', null, ['class' => 'form-control form-control-solid '.($errors->has('mbway_alias') ? 'is-invalid' : ''),'maxlength' => 32]) !!}
        @error('mbway_alias')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="row">
    @if(false)
        <!-- Invoice Id Field -->
        <div class="mb-10 col-md-4">
            {!! Form::label('invoice_id', $order->getAttributeLabel('invoice_id'), ['class' => 'form-label ']) !!}
            {!! Form::text('invoice_id', null, ['class' => 'form-control form-control-solid '.($errors->has('invoice_id') ? 'is-invalid' : ''),'maxlength' => 64]) !!}
            @error('invoice_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    @endif

    <!-- Invoice Id Field -->
    <div class="mb-10 col-md-4">
        {!! Form::label('invoice_number', $order->getAttributeLabel('invoice_number'), ['class' => 'form-label ']) !!}
        {!! Form::text('invoice_number', null, ['class' => 'form-control form-control-solid '.($errors->has('invoice_number') ? 'is-invalid' : ''),'maxlength' => 64]) !!}
        @error('invoice_number')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Invoice Link Field -->
    <div class="mb-10 col-md-4">
        {!! Form::label('invoice_link', $order->getAttributeLabel('invoice_link'), ['class' => 'form-label ']) !!}
        {!! Form::text('invoice_link', null, ['class' => 'form-control form-control-solid '.($errors->has('invoice_link') ? 'is-invalid' : ''),'maxlength' => 255]) !!}
        @error('invoice_link')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Invoice Status Field -->
    <div class="mb-10 col-md-4">
        {!! Form::label('invoice_status', $order->getAttributeLabel('invoice_status'), ['class' => 'form-label ']) !!}
        {!! Form::select('invoice_status', \App\Models\Order::getInvoiceStatusArray() , null , ['class' => 'form-select form-select-solid '.($errors->has('invoice_status') ? 'is-invalid' : ''), 'required' => true]) !!}
        @error('invoice_status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <!-- Payment Method Field -->
    <div class="mb-10 col-md-4">
        {!! Form::label('payment_method', $order->getAttributeLabel('payment_method'), ['class' => 'form-label ']) !!}
        {!! Form::select('payment_method', \App\Models\Order::getPaymentMethodArray() , null , ['class' => 'form-select form-select-solid '.($errors->has('payment_method') ? 'is-invalid' : ''), 'required' => true]) !!}
        @error('payment_method')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <!-- Payment Ref Field -->
    <div class="mb-10 col-md-4">
        {!! Form::label('payment_ref', $order->getAttributeLabel('payment_ref'), ['class' => 'form-label ']) !!}
        {!! Form::text('payment_ref', null, ['class' => 'form-control form-control-solid '.($errors->has('payment_ref') ? 'is-invalid' : ''),'maxlength' => 64]) !!}
        @error('payment_ref')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Payment Limit Date Field -->
    <div class="mb-10 col-md-4">
        {!! Form::label('payment_limit_date', $order->getAttributeLabel('payment_limit_date'), ['class' => 'form-label']) !!}
        <div class="position-relative d-flex align-items-center">
            <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
            <span class="svg-icon svg-icon-2 position-absolute mx-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="black"></path>
                <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="black"></path>
                <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="black"></path>
            </svg>
        </span>
            <!--begin::Datepicker-->
        {!! Form::text('payment_limit_date', null, ['class' => 'form-control form-control-solid ps-12 '.($errors->has('payment_limit_date') ? 'is-invalid' : ''), 'placeholder' => __('Pick a date') ]) !!}
        <!--end::Datepicker-->
        </div>
        @error('payment_limit_date')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    @push('scripts')
        <script>
            $(function(){
                $("#payment_limit_date").flatpickr();
            });
        </script>
    @endpush
</div>



<!-- Notes Field -->
<div class="mb-10">
    {!! Form::label('notes', $order->getAttributeLabel('notes'), ['class' => 'form-label ']) !!}
    {!! Form::text('notes', null, ['class' => 'form-control form-control-solid '.($errors->has('notes') ? 'is-invalid' : ''),'maxlength' => 512]) !!}
    @error('notes')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<!-- Status Field -->
<div class="mb-10">
    {!! Form::label('status', $order->getAttributeLabel('status'), ['class' => 'form-label ']) !!}
    {!! Form::select('status', \App\Models\Order::getStatusArray() , null , ['class' => 'form-select form-select-solid '.($errors->has('status') ? 'is-invalid' : ''), 'required' => true]) !!}
    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


