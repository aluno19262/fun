<!-- Name Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $product->getAttributeLabel('name') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $product->name }}</span>
    </div>
</div>


<!-- Price Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $product->getAttributeLabel('price') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $product->price }}</span>
    </div>
</div>


<!-- Reduced Price Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $product->getAttributeLabel('reduced_price') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $product->reduced_price }}</span>
    </div>
</div>


<!-- Description Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $product->getAttributeLabel('description') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $product->description }}</span>
    </div>
</div>


<!-- Excerpt Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $product->getAttributeLabel('excerpt') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $product->excerpt }}</span>
    </div>
</div>


<!-- Notes Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $product->getAttributeLabel('notes') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $product->notes }}</span>
    </div>
</div>


<!-- Visible Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $product->getAttributeLabel('visible') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $product->visible }}</span>
    </div>
</div>


<!-- Tax Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $product->getAttributeLabel('tax') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $product->tax }}</span>
    </div>
</div>


<!-- Status Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $product->getAttributeLabel('status') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $product->status }}</span>
    </div>
</div>


