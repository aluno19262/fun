{!! Form::hidden('associate_id',$associate->id) !!}
<div class="row">
    <!-- Name Field -->
    <div class="mb-10 col-md-4">
        {!! Form::label('name', $company->getAttributeLabel('name') . ' *', ['class' => 'form-label ']) !!}
        {!! Form::text('name', null, ['class' => 'form-control form-control-solid '.($errors->has('name') ? 'is-invalid' : ''),'maxlength' => 255,auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    <!-- Email Field -->
    <div class="mb-10 col-md-4">
        {!! Form::label('email', $company->getAttributeLabel('email') . ' *', ['class' => 'form-label']) !!}
        {!! Form::email('email', null, ['class' => 'form-control form-control-solid '.($errors->has('email') ? 'is-invalid' : ''),'maxlength' => 128,auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <!-- Phone Field -->
    <div class="mb-10 col-md-4">
        {!! Form::label('phone', $company->getAttributeLabel('phone') . ' *', ['class' => 'form-label ']) !!}
        {!! Form::text('phone', null, ['class' => 'form-control form-control-solid '.($errors->has('phone') ? 'is-invalid' : ''),'maxlength' => 32,auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
        @error('phone')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>
<div class="row">
    <!-- Address Field -->
    <div class="mb-10 col-md-5">
        {!! Form::label('address', $company->getAttributeLabel('address') . ' *', ['class' => 'form-label ']) !!}
        {!! Form::text('address', null, ['class' => 'form-control form-control-solid '.($errors->has('address') ? 'is-invalid' : ''),'maxlength' => 512,auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
        @error('address')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <!-- Zip Field -->
    <div class="mb-10 col-md-3">
        {!! Form::label('zip', $company->getAttributeLabel('zip') . ' *', ['class' => 'form-label ']) !!}
        {!! Form::text('zip', null, ['class' => 'form-control form-control-solid '.($errors->has('zip') ? 'is-invalid' : ''),'maxlength' => 16,auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
        @error('zip')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    <!-- Location Field -->
    <div class="mb-10 col-md-4">
        {!! Form::label('location', $company->getAttributeLabel('location') . ' *', ['class' => 'form-label ']) !!}
        {!! Form::text('location', null, ['class' => 'form-control form-control-solid '.($errors->has('location') ? 'is-invalid' : ''),'maxlength' => 128,auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
        @error('location')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>


<div class="row">
    <!-- Vat Field -->
    <div class="mb-10 col-md-12">
        {!! Form::label('vat', $company->getAttributeLabel('vat') . ' *', ['class' => 'form-label ']) !!}
        {!! Form::text('vat', null, ['class' => 'form-control form-control-solid '.($errors->has('vat') ? 'is-invalid' : ''),'maxlength' => 32,auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
        @error('vat')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
{{--<div class="mb-10">
    {!! Form::label('preferential_contact', $associate->getAttributeLabel('preferential_contact') . ' *', ['class' => 'form-label ']) !!}
    {!! Form::select('preferential_contact', \App\Models\Associate::getPreferentialContactArray() , null , ['class' => 'form-select form-select-solid '.($errors->has('preferential_contact') ? 'is-invalid' : ''), 'required' => true,auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled']) !!}
    @error('preferential_contact')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>--}}

{!! Form::hidden('status',$company->status) !!}

