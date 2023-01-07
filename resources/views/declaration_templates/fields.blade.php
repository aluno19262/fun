<div class="row">
    @if(!empty($declarationTemplate->getFirstMedia('declaration_template_document')))
        <div class="mb-10 col-md-12" id="set_files">
            <a class="btn bg-primary text-white" href="{{$declarationTemplate->getFirstMediaUrl('declaration_template_document')}}" target="_blank">{{__('Download') . " " . !empty($declarationTemplate->getFirstMedia('declaration_template_document')) ? $declarationTemplate->getFirstMedia('declaration_template_document')->name : ''}}</a>
            <a class="btn bg-danger text-white" onclick="deleteFile(this)" target="_blank">{{__('Delete') . " " .$declarationTemplate->getFirstMedia('declaration_template_document')['file_name']. !empty($declarationTemplate->getFirstMedia('declaration_template_document')) ? $declarationTemplate->getFirstMedia('declaration_template_document')['file_name'] : ''}}</a>
            {!! Form::hidden('delete_file', false) !!}
        </div>
    @endif
    <div class="mb-10 col-md-12">
        {!! Form::label('file', $declarationTemplate->getAttributeLabel('file'), ['class' => 'form-label ']) !!}
        {!! Form::file('file', ['class' => 'form-control '.($errors->has('file') ? 'is-invalid' : '')]) !!}
        @error('file')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>
@push('scripts')
    <script>
        function deleteFile(elem){
            console.log($('input[name="delete_file"]').val());
            $('input[name="delete_file"]').val(true);
            console.log($('input[name="delete_file"]').val());
            $('#set_files').hide();
        }
    </script>
@endpush

<div class="row">
    <!-- Name Field -->
    <div class="mb-10 col-md-8">
        {!! Form::label('name', $declarationTemplate->getAttributeLabel('name'), ['class' => 'form-label ']) !!}
        {!! Form::text('name', null, ['class' => 'form-control form-control-solid '.($errors->has('name') ? 'is-invalid' : ''),'maxlength' => 255]) !!}
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    <!-- Order Field -->
    <div class="mb-10 col-md-2">
        {!! Form::label('order', $declarationTemplate->getAttributeLabel('order'), ['class' => 'form-label']) !!}
        {!! Form::number('order', null, ['class' => 'form-control form-control-solid '.($errors->has('order') ? 'is-invalid' : '')]) !!}
        @error('order')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Order Field -->
    <div class="mb-10 col-md-2">
        {!! Form::label('value', $declarationTemplate->getAttributeLabel('value'), ['class' => 'form-label']) !!}
        {!! Form::number('value', null, ['class' => 'form-control form-control-solid '.($errors->has('value') ? 'is-invalid' : ''),'step' => 0.01]) !!}
        @error('value')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div id="kt_repeater_1" class="mb-10">
    <div class="form-group">
        <h3 class="mb-10">{{ __('Template Questions') }}</h3>
        <div data-repeater-list="DeclarationTemplateQuestions" class="">
            @forelse($declarationTemplate->declarationTemplateQuestions as $key => $question)
                <div data-repeater-item="" class="form-group row align-items-center  orderitem-item">
                    {!! Form::hidden('DeclarationTemplateQuestions['.$key.'][id]', null, []) !!}
                    {{--<div class="mb-10 col-lg-3">
                        {!! Form::label('DeclarationTemplateQuestions['.($key).'][type]', __('Type')) !!}
                        {!! Form::select('DeclarationTemplateQuestions['.($key).'][type]', \App\Models\DeclarationTemplateQuestion::getTypeArray(), null, ['class' => 'form-control form-control-solid '.($errors->has('DeclarationTemplateQuestions.'.($key).'.type') ? 'is-invalid' : ''), 'placeholder' => __('Select a type')]) !!}
                        @error('DeclarationTemplateQuestions.'.($key).'.type')
                            <div class="error invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>--}}
                    <div class="mb-10 col-md-6">
                        {!! Form::label('DeclarationTemplateQuestions['.($key).'][question]', __('Question')) !!}
                        {!! Form::text('DeclarationTemplateQuestions['.($key).'][question]', null, ['class' => 'form-control form-control-solid '.($errors->has('DeclarationTemplateQuestions.'.($key).'.question') ? 'is-invalid' : '')]) !!}
                        @error('DeclarationTemplateQuestions.'.($key).'.question')
                            <div class="error invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-10 col-md-4">
                        {!! Form::label('DeclarationTemplateQuestions['.($key).'][code]', __('Code')) !!}
                        {!! Form::text('DeclarationTemplateQuestions['.($key).'][code]', null, ['class' => 'form-control form-control-solid '.($errors->has('DeclarationTemplateQuestions.'.($key).'.code') ? 'is-invalid' : '')]) !!}
                        @error('DeclarationTemplateQuestions.'.($key).'.code')
                        <div class="error invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-2 mb-10 ">
                        <label>&nbsp;</label><br>
                        <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger">
                            <i class="la la-trash-o"></i>Delete</a>
                    </div>
                </div>
            @empty
                <div data-repeater-item="" class="form-group row align-items-center orderitem-item">
                    {!! Form::hidden('DeclarationTemplateQuestions[0][id]', null, []) !!}

                    {{--<div class="mb-10 col-md-3">
                        {!! Form::label('DeclarationTemplateQuestions[0][type]', __('Type')) !!}
                        {!! Form::select('DeclarationTemplateQuestions[0][type]', \App\Models\DeclarationTemplateQuestion::getTypeArray(), null, ['class' => 'form-control form-control-solid '.($errors->has('DeclarationTemplateQuestions.0.type') ? 'is-invalid' : ''), 'placeholder' => __('Select a type')]) !!}
                        @error('DeclarationTemplateQuestions.0.type')
                        <div class="error invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>--}}
                    <div class="mb-10 col-md-6">
                        {!! Form::label('DeclarationTemplateQuestions[0][question]', __('Question')) !!}
                        {!! Form::text('DeclarationTemplateQuestions[0][question]', null, ['class' => 'form-control form-control-solid '.($errors->has('DeclarationTemplateQuestions.0.question') ? 'is-invalid' : '')]) !!}
                        @error('DeclarationTemplateQuestions.0.question')
                        <div class="error invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-10 col-md-4">
                        {!! Form::label('DeclarationTemplateQuestions[0][code]', __('Code')) !!}
                        {!! Form::text('DeclarationTemplateQuestions[0][code]', null, ['class' => 'form-control form-control-solid '.($errors->has('DeclarationTemplateQuestions.0.code') ? 'is-invalid' : '')]) !!}
                        @error('DeclarationTemplateQuestions.0.code')
                            <div class="error invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-2 mb-10">
                        <label>&nbsp;</label><br>
                        <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger">
                            <i class="la la-trash-o"></i>{{ __('Delete') }}</a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    <div class="form-group row">
        <div class="col">
            <a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary">
                <i class="la la-plus"></i>{{ __('Add') }}</a>
            @error('DeclarationTemplateQuestions')
                <div class="error invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

    </div>
</div>
@push('scripts')
    <script>
        jQuery(document).ready(function() {
            $('#kt_repeater_1').repeater({
                initEmpty: false,

                defaultValues: {
                    'text-input': 'foo'
                },

                show: function () {
                    $(this).slideDown();
                },

                hide: function (deleteElement) {
                    $(this).slideUp(deleteElement);
                }
            });
        });
        /*jQuery(document).ready(function() {
            $('#kt_repeater_1').repeater({
                initEmpty: false,

                show: function () {
                    $(this).slideDown();
                },

                hide: function (deleteElement) {
                    $(this).slideUp(deleteElement);
                    //calculatePrices();
                },
                isFirstItemUndeletable: true
            });
        });*/
    </script>
@endpush



<!-- Status Field -->
<div class="mb-10">
    {!! Form::label('status', $declarationTemplate->getAttributeLabel('status'), ['class' => 'form-label']) !!}
    {!! Form::select('status', $declarationTemplate->getStatusArray() ,null, ['class' => 'form-control form-control-solid '.($errors->has('status') ? 'is-invalid' : '')]) !!}
    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
