<!-- Associate Id Field -->
<div class="mb-10">
    {!! Form::label('associate_id', $associateEvaluation->getAttributeLabel('associate_id'), ['class' => 'form-label']) !!}
    {!! Form::number('associate_id', null, ['class' => 'form-control form-control-solid '.($errors->has('associate_id') ? 'is-invalid' : '')]) !!}
    @error('associate_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<!-- User Id Field -->
<div class="mb-10">
    {!! Form::label('user_id', $associateEvaluation->getAttributeLabel('user_id'), ['class' => 'form-label']) !!}
    {!! Form::number('user_id', null, ['class' => 'form-control form-control-solid '.($errors->has('user_id') ? 'is-invalid' : '')]) !!}
    @error('user_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<!-- Phase Field -->
<div class="mb-10">
    {!! Form::label('phase', $associateEvaluation->getAttributeLabel('phase'), ['class' => 'form-label']) !!}
    {!! Form::number('phase', null, ['class' => 'form-control form-control-solid '.($errors->has('phase') ? 'is-invalid' : '')]) !!}
    @error('phase')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<!-- Note Field -->
<div class="mb-10">
    {!! Form::label('note', $associateEvaluation->getAttributeLabel('note'), ['class' => 'form-label ']) !!}
    {!! Form::textarea('note', null, ['class' => 'form-control form-control-solid '.($errors->has('note') ? 'is-invalid' : '')]) !!}
    @error('note')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<!-- Status Field -->
<div class="mb-10">
    {!! Form::label('status', $associateEvaluation->getAttributeLabel('status'), ['class' => 'form-label']) !!}
    {!! Form::number('status', null, ['class' => 'form-control form-control-solid '.($errors->has('status') ? 'is-invalid' : '')]) !!}
    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
