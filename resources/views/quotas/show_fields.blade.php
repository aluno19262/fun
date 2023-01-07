<!-- Associate Id Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $quota->getAttributeLabel('associate_id') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $quota->associate_id }}</span>
    </div>
</div>

<!-- Year Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $quota->getAttributeLabel('year') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $quota->year }}</span>
    </div>
</div>


<!-- Semester Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $quota->getAttributeLabel('semester') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $quota->semester }}</span>
    </div>
</div>


<!-- Payment Limit Date Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $quota->getAttributeLabel('payment_limit_date') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $quota->payment_limit_date }}</span>
    </div>
</div>


<!-- Price Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $quota->getAttributeLabel('price') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $quota->price }}</span>
    </div>
</div>


<!-- Status Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $quota->getAttributeLabel('status') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $quota->status }}</span>
    </div>
</div>


