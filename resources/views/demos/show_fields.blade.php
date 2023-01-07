<!-- Name Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $demo->getAttributeLabel('name') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $demo->name }}</span>
    </div>
</div>


<!-- Body Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $demo->getAttributeLabel('body') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{!! nl2br($demo->body) !!}</span>
    </div>
</div>


<!-- Optional Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $demo->getAttributeLabel('optional') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $demo->optional }}</span>
    </div>
</div>


<!-- Body Optional Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $demo->getAttributeLabel('body_optional') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $demo->body_optional }}</span>
    </div>
</div>


<!-- Value Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $demo->getAttributeLabel('value') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $demo->value }}</span>
    </div>
</div>


<!-- Date Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $demo->getAttributeLabel('date') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $demo->date }}</span>
    </div>
</div>


<!-- Datetime Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $demo->getAttributeLabel('datetime') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $demo->datetime }}</span>
    </div>
</div>


<!-- Checkbox Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $demo->getAttributeLabel('checkbox') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $demo->checkbox }}</span>
    </div>
</div>


<!-- Privacy Policy Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $demo->getAttributeLabel('privacy_policy') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $demo->privacy_policy }}</span>
    </div>
</div>


<!-- Status Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $demo->getAttributeLabel('status') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $demo->status }}</span>
    </div>
</div>


