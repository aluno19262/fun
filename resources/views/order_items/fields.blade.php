<!-- Associate Id Field -->
<div class="mb-10">
    {!! Form::label('associate_id', $orderItem->getAttributeLabel('associate_id'), ['class' => 'form-label']) !!}
    {!! Form::number('associate_id', null, ['class' => 'form-control form-control-solid '.($errors->has('associate_id') ? 'is-invalid' : '')]) !!}
    @error('associate_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<!-- Declaration Id Field -->
<div class="mb-10">
    {!! Form::label('declaration_id', $orderItem->getAttributeLabel('declaration_id'), ['class' => 'form-label']) !!}
    {!! Form::number('declaration_id', null, ['class' => 'form-control form-control-solid '.($errors->has('declaration_id') ? 'is-invalid' : '')]) !!}
    @error('declaration_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<!-- Quota Id Field -->
<div class="mb-10">
    {!! Form::label('quota_id', $orderItem->getAttributeLabel('quota_id'), ['class' => 'form-label']) !!}
    {!! Form::number('quota_id', null, ['class' => 'form-control form-control-solid '.($errors->has('quota_id') ? 'is-invalid' : '')]) !!}
    @error('quota_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<!-- Order Id Field -->
<div class="mb-10">
    {!! Form::label('order_id', $orderItem->getAttributeLabel('order_id'), ['class' => 'form-label']) !!}
    {!! Form::number('order_id', null, ['class' => 'form-control form-control-solid '.($errors->has('order_id') ? 'is-invalid' : '')]) !!}
    @error('order_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<!-- Product Id Field -->
<div class="mb-10">
    {!! Form::label('product_id', $orderItem->getAttributeLabel('product_id'), ['class' => 'form-label']) !!}
    {!! Form::number('product_id', null, ['class' => 'form-control form-control-solid '.($errors->has('product_id') ? 'is-invalid' : '')]) !!}
    @error('product_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<!-- Cookie Field -->
<div class="mb-10">
    {!! Form::label('cookie', $orderItem->getAttributeLabel('cookie'), ['class' => 'form-label ']) !!}
    {!! Form::text('cookie', null, ['class' => 'form-control form-control-solid '.($errors->has('cookie') ? 'is-invalid' : ''),'maxlength' => 128]) !!}
    @error('cookie')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<!-- Name Field -->
<div class="mb-10">
    {!! Form::label('name', $orderItem->getAttributeLabel('name'), ['class' => 'form-label ']) !!}
    {!! Form::text('name', null, ['class' => 'form-control form-control-solid '.($errors->has('name') ? 'is-invalid' : ''),'maxlength' => 255]) !!}
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<!-- Quantity Field -->
<div class="mb-10">
    {!! Form::label('quantity', $orderItem->getAttributeLabel('quantity'), ['class' => 'form-label']) !!}
    {!! Form::number('quantity', null, ['class' => 'form-control form-control-solid '.($errors->has('quantity') ? 'is-invalid' : '')]) !!}
    @error('quantity')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<!-- Price Field -->
<div class="mb-10">
    {!! Form::label('price', $orderItem->getAttributeLabel('price'), ['class' => 'form-label']) !!}
    {!! Form::number('price', null, ['class' => 'form-control form-control-solid '.($errors->has('price') ? 'is-invalid' : '')]) !!}
    @error('price')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<!-- Notes Field -->
<div class="mb-10">
    {!! Form::label('notes', $orderItem->getAttributeLabel('notes'), ['class' => 'form-label ']) !!}
    {!! Form::text('notes', null, ['class' => 'form-control form-control-solid '.($errors->has('notes') ? 'is-invalid' : ''),'maxlength' => 255]) !!}
    @error('notes')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<!-- Vat Field -->
<div class="mb-10">
    {!! Form::label('vat', $orderItem->getAttributeLabel('vat'), ['class' => 'form-label']) !!}
    {!! Form::number('vat', null, ['class' => 'form-control form-control-solid '.($errors->has('vat') ? 'is-invalid' : '')]) !!}
    @error('vat')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>



<!-- Raw Data Field -->
<div class="mb-10">
    {!! Form::label('raw_data', $orderItem->getAttributeLabel('raw_data'), ['class' => 'form-label ']) !!}
    {!! Form::textarea('raw_data', null, ['class' => 'form-control form-control-solid '.($errors->has('raw_data') ? 'is-invalid' : '')]) !!}
    @error('raw_data')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<!-- Status Field -->
<div class="mb-10">
    {!! Form::label('status', $orderItem->getAttributeLabel('status'), ['class' => 'form-label']) !!}
    {!! Form::number('status', null, ['class' => 'form-control form-control-solid '.($errors->has('status') ? 'is-invalid' : '')]) !!}
    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
