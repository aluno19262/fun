<!-- Name Field -->
<div class="mb-10">
    {!! Form::label('name', $product->getAttributeLabel('name'), ['class' => 'form-label ']) !!}
    {!! Form::text('name', null, ['class' => 'form-control form-control-solid '.($errors->has('name') ? 'is-invalid' : ''),'maxlength' => 255]) !!}
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<!-- Price Field -->
<div class="mb-10">
    {!! Form::label('price', $product->getAttributeLabel('price'), ['class' => 'form-label']) !!}
    {!! Form::number('price', null, ['class' => 'form-control form-control-solid '.($errors->has('price') ? 'is-invalid' : '')]) !!}
    @error('price')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<!-- Reduced Price Field -->
<div class="mb-10">
    {!! Form::label('reduced_price', $product->getAttributeLabel('reduced_price'), ['class' => 'form-label']) !!}
    {!! Form::number('reduced_price', null, ['class' => 'form-control form-control-solid '.($errors->has('reduced_price') ? 'is-invalid' : '')]) !!}
    @error('reduced_price')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<!-- Description Field -->
<div class="mb-10">
    {!! Form::label('description', $product->getAttributeLabel('description'), ['class' => 'form-label ']) !!}
    {!! Form::text('description', null, ['class' => 'form-control form-control-solid '.($errors->has('description') ? 'is-invalid' : ''),'maxlength' => 255]) !!}
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<!-- Excerpt Field -->
<div class="mb-10">
    {!! Form::label('excerpt', $product->getAttributeLabel('excerpt'), ['class' => 'form-label ']) !!}
    {!! Form::text('excerpt', null, ['class' => 'form-control form-control-solid '.($errors->has('excerpt') ? 'is-invalid' : ''),'maxlength' => 255]) !!}
    @error('excerpt')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<!-- Notes Field -->
<div class="mb-10">
    {!! Form::label('notes', $product->getAttributeLabel('notes'), ['class' => 'form-label ']) !!}
    {!! Form::text('notes', null, ['class' => 'form-control form-control-solid '.($errors->has('notes') ? 'is-invalid' : ''),'maxlength' => 255]) !!}
    @error('notes')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<!-- Visible Field -->
<div class="mb-10">
    <div class="form-check form-check-custom form-check-solid">
        {!! Form::hidden('visible', 0) !!}
        {!! Form::checkbox('visible', '1', null,['class' => 'form-check-input']) !!}
        {!! Form::label('visible', $product->getAttributeLabel('visible'), ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Tax Field -->
<div class="mb-10">
    {!! Form::label('tax', $product->getAttributeLabel('tax'), ['class' => 'form-label']) !!}
    {!! Form::number('tax', null, ['class' => 'form-control form-control-solid '.($errors->has('tax') ? 'is-invalid' : '')]) !!}
    @error('tax')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- vat Field -->
<div class="mb-10">
    {!! Form::label('vat', $product->getAttributeLabel('vat'), ['class' => 'form-label ']) !!}
    {!! Form::number('vat', null, ['class' => 'form-control form-control-solid '.($errors->has('vat') ? 'is-invalid' : ''),'step' => 0.01]) !!}
    @error('vat')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Tax Field -->
<div class="mb-10">
    {!! Form::label('moloni_category_id', $product->getAttributeLabel('moloni_category_id'), ['class' => 'form-label']) !!}
    {!! Form::number('moloni_category_id', null, ['class' => 'form-control form-control-solid '.($errors->has('moloni_category_id') ? 'is-invalid' : '')]) !!}
    @error('moloni_category_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Tax Field -->
<div class="mb-10">
    {!! Form::label('moloni_product_id', $product->getAttributeLabel('moloni_product_id'), ['class' => 'form-label']) !!}
    {!! Form::number('moloni_product_id', null, ['class' => 'form-control form-control-solid '.($errors->has('moloni_product_id') ? 'is-invalid' : '')]) !!}
    @error('moloni_product_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-10">
    {!! Form::label('moloni_tax_id', $product->getAttributeLabel('moloni_tax_id'), ['class' => 'form-label']) !!}
    {!! Form::number('moloni_tax_id', null, ['class' => 'form-control form-control-solid '.($errors->has('moloni_tax_id') ? 'is-invalid' : '')]) !!}
    @error('moloni_tax_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>



<!-- Status Field -->
<div class="mb-10">
    {!! Form::label('status', $product->getAttributeLabel('status'), ['class' => 'form-label']) !!}
    {!! Form::number('status', null, ['class' => 'form-control form-control-solid '.($errors->has('status') ? 'is-invalid' : '')]) !!}
    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
