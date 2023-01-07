<!-- Find Ap Id Field -->
<div class="mb-10">
    {!! Form::label('find_ap_id', $findApSpecialtyArea->getAttributeLabel('find_ap_id'), ['class' => 'form-label']) !!}
    {!! Form::number('find_ap_id', null, ['class' => 'form-control form-control-solid '.($errors->has('find_ap_id') ? 'is-invalid' : '')]) !!}
    @error('find_ap_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<!-- Specialty Area Field -->
<div class="mb-10">
    {!! Form::label('specialty_area', $findApSpecialtyArea->getAttributeLabel('specialty_area'), ['class' => 'form-label']) !!}
    {!! Form::number('specialty_area', null, ['class' => 'form-control form-control-solid '.($errors->has('specialty_area') ? 'is-invalid' : '')]) !!}
    @error('specialty_area')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
