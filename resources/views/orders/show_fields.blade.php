@if(auth()->user()->can('manageApp'))
    <!-- Associate Id Field -->
    <div class="row mb-7">
        <label class="col-lg-4 fw-bold text-muted">{{ $order->getAttributeLabel('associate_id') }}</label>
        <div class="col-lg-8">
            <span class="fw-bolder fs-6 text-gray-800">{{ $order->associate_id }}</span>
        </div>
    </div>

    <!-- User Id Field -->
    <div class="row mb-7">
        <label class="col-lg-4 fw-bold text-muted">{{ $order->getAttributeLabel('user_id') }}</label>
        <div class="col-lg-8">
            <span class="fw-bolder fs-6 text-gray-800">{{ $order->user_id }}</span>
        </div>
    </div>

    <!-- Name Field -->
    <div class="row mb-7">
        <label class="col-lg-4 fw-bold text-muted">{{ $order->getAttributeLabel('name') }}</label>
        <div class="col-lg-8">
            <span class="fw-bolder fs-6 text-gray-800">{{ $order->name }}</span>
        </div>
    </div>

    <!-- Email Field -->
    <div class="row mb-7">
        <label class="col-lg-4 fw-bold text-muted">{{ $order->getAttributeLabel('email') }}</label>
        <div class="col-lg-8">
            <span class="fw-bolder fs-6 text-gray-800">{{ $order->email }}</span>
        </div>
    </div>

    <!-- Address Field -->
    <div class="row mb-7">
        <label class="col-lg-4 fw-bold text-muted">{{ $order->getAttributeLabel('address') }}</label>
        <div class="col-lg-8">
            <span class="fw-bolder fs-6 text-gray-800">{{ $order->address }}</span>
        </div>
    </div>

    <!-- Zip Field -->
    <div class="row mb-7">
        <label class="col-lg-4 fw-bold text-muted">{{ $order->getAttributeLabel('zip') }}</label>
        <div class="col-lg-8">
            <span class="fw-bolder fs-6 text-gray-800">{{ $order->zip }}</span>
        </div>
    </div>

    <!-- Location Field -->
    <div class="row mb-7">
        <label class="col-lg-4 fw-bold text-muted">{{ $order->getAttributeLabel('location') }}</label>
        <div class="col-lg-8">
            <span class="fw-bolder fs-6 text-gray-800">{{ $order->location }}</span>
        </div>
    </div>

    <!-- Phone Field -->
    <div class="row mb-7">
        <label class="col-lg-4 fw-bold text-muted">{{ $order->getAttributeLabel('phone') }}</label>
        <div class="col-lg-8">
            <span class="fw-bolder fs-6 text-gray-800">{{ $order->phone }}</span>
        </div>
    </div>

    <!-- Vat Field -->
    <div class="row mb-7">
        <label class="col-lg-4 fw-bold text-muted">{{ $order->getAttributeLabel('vat') }}</label>
        <div class="col-lg-8">
            <span class="fw-bolder fs-6 text-gray-800">{{ $order->vat }}</span>
        </div>
    </div>

    <!-- Delivery Date Field -->
    <div class="row mb-7">
        <label class="col-lg-4 fw-bold text-muted">{{ $order->getAttributeLabel('delivery_date') }}</label>
        <div class="col-lg-8">
            <span class="fw-bolder fs-6 text-gray-800">{{ $order->delivery_date }}</span>
        </div>
    </div>

    <!-- Notes Field -->
    <div class="row mb-7">
        <label class="col-lg-4 fw-bold text-muted">{{ $order->getAttributeLabel('notes') }}</label>
        <div class="col-lg-8">
            <span class="fw-bolder fs-6 text-gray-800">{{ $order->notes }}</span>
        </div>
    </div>
@endif

<div class="row">
    <div class="col-md-6">
        <!-- Coupon Field -->
        <div class="row mb-7">
            <label class="col-lg-4 fw-bold text-muted">{{ $order->getAttributeLabel('coupon') }}</label>
            <div class="col-lg-8">
                <span class="fw-bolder fs-6 text-gray-800">{{ $order->coupon ?? '---' }}</span>
            </div>
        </div>

        <!-- Discount Field -->
        <div class="row mb-7">
            <label class="col-lg-4 fw-bold text-muted">{{ $order->getAttributeLabel('discount') }}</label>
            <div class="col-lg-8">
                <span class="fw-bolder fs-6 text-gray-800">{{ $order->discount . ' €'}}</span>
            </div>
        </div>

        <!-- Subtotal Field -->
        <div class="row mb-7">
            <label class="col-lg-4 fw-bold text-muted">{{ $order->getAttributeLabel('subtotal') }}</label>
            <div class="col-lg-8">
                <span class="fw-bolder fs-6 text-gray-800">{{ $order->subtotal . ' €' }}</span>
            </div>
        </div>

        <!-- Vat Value Field -->
        <div class="row mb-7">
            <label class="col-lg-4 fw-bold text-muted">{{ $order->getAttributeLabel('vat_value') }}</label>
            <div class="col-lg-8">
                <span class="fw-bolder fs-6 text-gray-800">{{ $order->vat_value . ' €' }}</span>
            </div>
        </div>

        <!-- Total Field -->
        <div class="row mb-7">
            <label class="col-lg-4 fw-bold text-muted">{{ $order->getAttributeLabel('total') }}</label>
            <div class="col-lg-8">
                <span class="fw-bolder fs-6 text-gray-800">{{ $order->total . ' €' }}</span>
            </div>
        </div>

        <!-- Payment Method Field -->
        <div class="row mb-7">
            <label class="col-lg-4 fw-bold text-muted">{{ $order->getAttributeLabel('payment_method') }}</label>
            <div class="col-lg-8">
                <span class="fw-bolder fs-6 text-gray-800">{{ $order->getPaymentMethodLabelAttribute() }}</span>
            </div>
        </div>

        <!-- Mb Ent Field -->
        <div class="row mb-7">
            <label class="col-lg-4 fw-bold text-muted">{{ $order->getAttributeLabel('mb_ent') }}</label>
            <div class="col-lg-8">
                <span class="fw-bolder fs-6 text-gray-800">{{ $order->mb_ent }}</span>
            </div>
        </div>

        <!-- Mb Ref Field -->
        <div class="row mb-7">
            <label class="col-lg-4 fw-bold text-muted">{{ $order->getAttributeLabel('mb_ref') }}</label>
            <div class="col-lg-8">
                <span class="fw-bolder fs-6 text-gray-800">{{ $order->mb_ref }}</span>
            </div>
        </div>

        <!-- Mb Limit Date Field -->
        <div class="row mb-7">
            <label class="col-lg-4 fw-bold text-muted">{{ $order->getAttributeLabel('mb_limit_date') }}</label>
            <div class="col-lg-8">
                <span class="fw-bolder fs-6 text-gray-800">{{ $order->mb_limit_date }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <!-- Mbway Ref Field -->
        <div class="row mb-7">
            <label class="col-lg-4 fw-bold text-muted">{{ $order->getAttributeLabel('mbway_ref') }}</label>
            <div class="col-lg-8">
                <span class="fw-bolder fs-6 text-gray-800">{{ $order->mbway_ref }}</span>
            </div>
        </div>

        <!-- Mbway Alias Field -->
        <div class="row mb-7">
            <label class="col-lg-4 fw-bold text-muted">{{ $order->getAttributeLabel('mbway_alias') }}</label>
            <div class="col-lg-8">
                <span class="fw-bolder fs-6 text-gray-800">{{ $order->mbway_alias }}</span>
            </div>
        </div>

        <!-- Payment Ref Field -->
        <div class="row mb-7">
            <label class="col-lg-4 fw-bold text-muted">{{ $order->getAttributeLabel('payment_ref') }}</label>
            <div class="col-lg-8">
                <span class="fw-bolder fs-6 text-gray-800">{{ $order->payment_ref }}</span>
            </div>
        </div>

        <!-- Invoice Id Field -->
        <div class="row mb-7">
            <label class="col-lg-4 fw-bold text-muted">{{ $order->getAttributeLabel('invoice_id') }}</label>
            <div class="col-lg-8">
                <span class="fw-bolder fs-6 text-gray-800">{{ $order->invoice_id }}</span>
            </div>
        </div>

        <!-- Invoice Link Field -->
        <div class="row mb-7">
            <label class="col-lg-4 fw-bold text-muted">{{ $order->getAttributeLabel('invoice_link') }}</label>
            <div class="col-lg-8">
                <span class="fw-bolder fs-6 text-gray-800">{{ $order->invoice_link }}</span>
            </div>
        </div>

        <!-- Payment Limit Date Field -->
        <div class="row mb-7">
            <label class="col-lg-4 fw-bold text-muted">{{ $order->getAttributeLabel('payment_limit_date') }}</label>
            <div class="col-lg-8">
                <span class="fw-bolder fs-6 text-gray-800">{{ $order->payment_limit_date }}</span>
            </div>
        </div>

        <!-- Invoice Status Field -->
        <div class="row mb-7">
            <label class="col-lg-4 fw-bold text-muted">{{ $order->getAttributeLabel('invoice_status') }}</label>
            <div class="col-lg-8">
                <span class="fw-bolder fs-6 text-gray-800">{{ $order->getInvoiceStatusLabelAttribute() }}</span>
            </div>
        </div>

        <!-- Status Field -->
        <div class="row mb-7">
            <label class="col-lg-4 fw-bold text-muted">{{ $order->getAttributeLabel('status') }}</label>
            <div class="col-lg-8">
                <span class="fw-bolder fs-6 text-gray-800">{{ $order->getStatusLabelAttribute() }}</span>
            </div>
        </div>
    </div>
</div>






