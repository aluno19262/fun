<!-- Declaration Template Id Field -->
<div class="mb-10">
    {!! Form::label('declaration_template_id', $declarationTemplateQuestion->getAttributeLabel('declaration_template_id'), ['class' => 'form-label']) !!}
    {!! Form::number('declaration_template_id', null, ['class' => 'form-control form-control-solid '.($errors->has('declaration_template_id') ? 'is-invalid' : '')]) !!}
    @error('declaration_template_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<!-- Type Field -->
<div class="mb-10">
    {!! Form::label('type', $declarationTemplateQuestion->getAttributeLabel('type'), ['class' => 'form-label']) !!}
    {!! Form::number('type', null, ['class' => 'form-control form-control-solid '.($errors->has('type') ? 'is-invalid' : '')]) !!}
    @error('type')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<!-- Question Field -->
<div class="mb-10">
    {!! Form::label('question', $declarationTemplateQuestion->getAttributeLabel('question'), ['class' => 'form-label ']) !!}
    {!! Form::text('question', null, ['class' => 'form-control form-control-solid '.($errors->has('question') ? 'is-invalid' : ''),'maxlength' => 255]) !!}
    @error('question')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<!-- Code Field -->
<div class="mb-10">
    {!! Form::label('code', $declarationTemplateQuestion->getAttributeLabel('code'), ['class' => 'form-label ']) !!}
    {!! Form::text('code', null, ['class' => 'form-control form-control-solid '.($errors->has('code') ? 'is-invalid' : ''),'maxlength' => 255]) !!}
    @error('code')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<!-- Data Field -->
<div class="mb-10">
    {!! Form::label('data', $declarationTemplateQuestion->getAttributeLabel('data'), ['class' => 'form-label ']) !!}
    {!! Form::textarea('data', null, ['class' => 'form-control form-control-solid '.($errors->has('data') ? 'is-invalid' : '')]) !!}
    @error('data')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<!-- Status Field -->
<div class="mb-10">
    {!! Form::label('status', $declarationTemplateQuestion->getAttributeLabel('status'), ['class' => 'form-label']) !!}
    {!! Form::number('status', null, ['class' => 'form-control form-control-solid '.($errors->has('status') ? 'is-invalid' : '')]) !!}
    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
