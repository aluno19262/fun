{!! Form::hidden('associate_id',$associate->id) !!}

<div class="row">
    <!-- Name Field -->
    <div class="mb-10 col-md-4">
        {!! Form::label('name', $findAp->getAttributeLabel('name') . ' *', ['class' => 'form-label ']) !!}
        {!! Form::text('name', null, ['class' => 'form-control form-control-solid '.($errors->has('name') ? 'is-invalid' : ''),'maxlength' => 255,'required' => true]) !!}
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <!-- Email Field -->
    <div class="mb-10 col-md-4">
        {!! Form::label('email', $findAp->getAttributeLabel('email') . ' *', ['class' => 'form-label']) !!}
        {!! Form::email('email', null, ['class' => 'form-control form-control-solid '.($errors->has('email') ? 'is-invalid' : ''),'maxlength' => 128,'required' => true]) !!}
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Phone Field -->
    <div class="mb-10 col-md-4">
        {!! Form::label('phone', $findAp->getAttributeLabel('phone') . ' *', ['class' => 'form-label ']) !!}
        {!! Form::text('phone', null, ['class' => 'form-control form-control-solid '.($errors->has('phone') ? 'is-invalid' : ''),'maxlength' => 32,'required' => true]) !!}
        @error('phone')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>


<div class="row mb-10">
    <!-- Address Field -->
    <div class="mb-10 col-md-4">
        {!! Form::label('address', $findAp->getAttributeLabel('address'), ['class' => 'form-label ']) !!}
        {!! Form::text('address', null, ['class' => 'form-control form-control-solid '.($errors->has('address') ? 'is-invalid' : ''),'maxlength' => 512]) !!}
        <span class="text-muted">A morada é um dado opcional, mas importante para um total aproveitamento da ferramenta Encontre um AP.</span>
        @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <!-- Address Field -->
    <div class="mb-10 col-md-2">
        {!! Form::label('zip', $findAp->getAttributeLabel('zip') . ' *', ['class' => 'form-label ']) !!}
        {!! Form::text('zip', null, ['class' => 'form-control form-control-solid '.($errors->has('zip') ? 'is-invalid' : ''),'maxlength' => 16,'required' => true]) !!}
        @error('zip')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <!-- Address Field -->
    <div class="mb-10 col-md-3">
        {!! Form::label('location', $findAp->getAttributeLabel('location') . ' *', ['class' => 'form-label ']) !!}
        {!! Form::text('location', null, ['class' => 'form-control form-control-solid '.($errors->has('location') ? 'is-invalid' : ''),'maxlength' => 128,'required' => true]) !!}
        @error('location')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-10 col-md-3">
        {!! Form::label('country', $findAp->getAttributeLabel('country') . ' *', ['class' => 'form-label ']) !!}
        {!! Form::text('country', null, ['class' => 'form-control form-control-solid '.($errors->has('country') ? 'is-invalid' : ''),'maxlength' => 128,'required' => true]) !!}
        @error('country')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-check form-switch form-check-custom form-check-solid">
        <label class="form-check-label me-2" for="flexSwitchChecked">
            Inativo
        </label>
        <input class="form-check-input" type="checkbox" name="status" value={{$findAp->status}} {{ $findAp->status == false ? "" : "checked" }} />
        <label class="form-check-label" for="flexSwitchChecked">
            Ativo
        </label>
    </div>
</div>

<div class="row">
    <div class="mb-10">
        {!! Form::label('specialtyAreas[]', $findAp->getAttributeLabel('specialtyAreas'), ['class'=>'form-label']) !!}
        {!! Form::select('specialtyAreas[]', \App\Models\FindApSpecialtyArea::getSpecialtyAreaArray(), null ,  ['id' => 'select-find-ap-specialty-areas','class' => 'form-select form-select-solid '.($errors->has('specialtyAreas') ? "is-invalid" : ""), 'multiple', 'data-control'=>"select2", 'data-placeholder'=>__('Select a Specialty Area')]) !!}
        @error('specialtyAreas')
            <div class="error invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>



@push('scripts')
    <script>
        $('input[name="status"]').on('click',function (){
            if($(this).val() === "0"){
                $(this).val(1);
            }else{
                $(this).val(0);
            }
        })
    </script>
@endpush
    {{--<div class="mb-10">
        {!! Form::label('status', $findAp->getAttributeLabel('status'), ['class' => 'form-label']) !!}
        {!! Form::select('status', $findAp->getStatusArray(),null, ['class' => 'form-control form-control-solid '.($errors->has('status') ? 'is-invalid' : ''),'required' => true]) !!}
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>--}}
{{--@endif--}}

<div class="row">
    <span class="text-muted">A presença na ferramenta Encontre um AP depende da regularização de quotas. O não pagamento de quotas implica a exclusão da ferramenta Encontre um AP, mesmo que este formulário esteja preenchido.</span>
</div>
