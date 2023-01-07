
@if(auth()->user()->can('manageApp'))
    <div class="row">
        <!-- Declaration Template Id Field -->
        <div class="mb-10 col-md-6">
            {!! Form::label('associate_id', $declaration->getAttributeLabel('associate_id'), ['class' => 'form-label']) !!}
            {!! Form::select('associate_id', !empty($associateOptions) ? $associateOptions : [] ,!empty(\Illuminate\Support\Facades\Request::all()['associate_id']) ? \Illuminate\Support\Facades\Request::all()['associate_id'] : null, ['class' => 'form-control form-control-solid '.($errors->has('associate_id') ? 'is-invalid' : ''),'readonly' => true]) !!}
            @error('associate_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <!-- Declaration Template Id Field -->
        <div class="mb-10 col-md-6">
            {!! Form::label('declaration_template_id', $declaration->getAttributeLabel('declaration_template_id'), ['class' => 'form-label']) !!}
            {!! Form::select('declaration_template_id', !empty(\App\Models\DeclarationTemplate::where('id','!=',8)->get()) ? \App\Models\DeclarationTemplate::where('id','!=',8)->get()->pluck('name','id')->toArray() : null  ,null, ['class' => 'form-control form-control-solid '.($errors->has('declaration_template_id') ? 'is-invalid' : ''),'placeholder' => __('Select a Template'), 'onchange' =>'changeTemplate(this)']) !!}
            @error('declaration_template_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>


@else
    {!! Form::hidden('associate_id',!empty(auth()->user()->associate) ? auth()->user()->associate->id : null ) !!}
    <!-- Declaration Template Id Field -->
    <div class="mb-10">
        {!! Form::label('declaration_template_id', $declaration->getAttributeLabel('declaration_template_id'), ['class' => 'form-label']) !!}
        {!! Form::select('declaration_template_id', !empty(\App\Models\DeclarationTemplate::where('id','!=',8)->get()) ? \App\Models\DeclarationTemplate::where('id','!=',8)->get()->pluck('name','id')->toArray() : null ,null, ['class' => 'form-control form-control-solid '.($errors->has('declaration_template_id') ? 'is-invalid' : ''),'placeholder' => __('Select a Template'), 'onchange' =>'changeTemplate(this)','required']) !!}
        @error('declaration_template_id')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
@endif
<div class="row">
    <!-- Renovation Field -->
    <div id="renovacao" class="mb-10 col-md-3 col-sm-6  align-self-center">
        <div class="form-check form-check-custom form-check-solid">
            {!! Form::hidden('is_renovation', 0) !!}
            {!! Form::checkbox('is_renovation', '1', null,['id' => "is_renovation",'class' => 'form-check-input']) !!}
            {!! Form::label('is_renovation', $declaration->getAttributeLabel('is_renovation'), ['class' => 'form-check-label']) !!}
        </div>
    </div>
    <div id="renovacao_declaracao_id" class="mb-10 col-md-4 col-sm-6 align-self-center {{ old('is_renovation', $declaration->is_renovation)  ? "" : "d-none" }}">
        {!! Form::label('previous_declaration_number', $declaration->getAttributeLabel('previous_declaration_number'), ['class' => 'form-label']) !!}
        {!! Form::text('previous_declaration_number', null, ['id' => "previous_declaration_id",'class' => 'form-control form-control-solid '.($errors->has('previous_declaration_number') ? 'is-invalid' : '')]) !!}
        @error('previous_declaration_number')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div id="template_questions">
{{--{{debugbar()->error(old())}}--}}
    @if(old('declaration_template_id', $declaration->declaration_template_id))
        @foreach(\App\Models\DeclarationTemplate::where('id',old('declaration_template_id', $declaration->declaration_template_id))->first()->declarationTemplateQuestions as $question)
            <div class="mb-10">
                <label class="mb-2">
                    {{$question->question}}
                </label>
                <input type="text" class="form-control form-control-solid"  name="{{$question->code}}" value="{{ old($question->code,!empty($declaration->id) && $question->declarationQuestions()->where('declaration_id',$declaration->id)->exists() ? $question->declarationQuestions()->where('declaration_id',$declaration->id)->first()->value : "")}}" required>
            </div>
        @endforeach
    @endif
</div>
<div id="payment_methods">
    <div class="mb-10">
        {!! Form::label('order_payment_method', $declaration->getAttributeLabel('order_payment_method'), ['class' => 'form-label']) !!}
        {!! Form::select('order_payment_method', !empty(\App\Models\Order::getPaymentMethodArray()) ? \App\Models\Order::getPaymentMethodArray() : null ,null, ['id' => "payment_method",'class' => 'form-control form-control-solid '.($errors->has('order_payment_method') ? 'is-invalid' : ''),'placeholder' => __('Select a Payment Method'),'required']) !!}
        @error('order_payment_method')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div id="mbway_number" class="mb-10 {{$declaration->order_payment_method != \App\Models\Order::PAYMENT_METHOD_MBWAY ? 'd-none' : ''}}">
        {!! Form::label('order_mbway_number', $declaration->getAttributeLabel('order_mbway_number'), ['class' => 'form-label']) !!}
        {!! Form::text('order_mbway_number', null, ['class' => 'form-control form-control-solid '.($errors->has('order_mbway_number') ? 'is-invalid' : '')]) !!}
        @error('order_mbway_number')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>


@push('scripts')
    <script>
        $('#declaration_template_id').on('change',function(){
            //se for modelo de seguro
            if($('#declaration_template_id').find('option:selected').val() == "8"){
                $('#dados_faturacao').addClass('d-none');
                $('#payment_methods').addClass('d-none');
                $('#renovacao').addClass('d-none');
            }else{
                $('#dados_faturacao').removeClass('d-none');
                $('#payment_methods').removeClass('d-none');
                $('#renovacao').removeClass('d-none');
            }
        })

        $('#renovacao input').on('change',function(){
            if( $('#is_renovation:checked').val() == "1"){
                $('#renovacao_declaracao_id').removeClass('d-none');
            } else{
                $('#renovacao_declaracao_id').addClass('d-none');
                $('#previous_declaration_number').val('');
            }
        });

        $('#payment_method').on('change',function(){
            //se for pagamento por mbway
            if($('#payment_method').val() === "2"){
                $('#mbway_number').removeClass('d-none');
                $('#mbway_number input').val("");
            }else{
                $('#mbway_number').addClass('d-none');
            }
        })
    </script>
@endpush
@php
  if($errors->has('order_name') || $errors->has('order_email') || $errors->has('order_address') || $errors->has('order_zip') || $errors->has('order_location') || $errors->has('order_phone') || $errors->has('order_vat')){
    $hasInvoiceErrors = true;
  }else{
      $hasInvoiceErrors = true;
  }

$hasInvoiceErrors = true;
@endphp
<span class="text-muted mb-5">Por defeito, a fatura da declaração é emitida com os seus dados pessoais. Para utilizar outros dados de faturação, deve clicar abaixo:</span>
<div id="dados_faturacao" class="card mt-5 mb-5" >
    <div class="accordion" id="kt_accordion_2">
        <div class="accordion-item">
            <!--begin::Vote-->
            <!--begin::Card header-->
            <h2 class="accordion-header" id="kt_accordion_2_header_1">
                <button class="accordion-button fs-4 fw-bold {{ $hasInvoiceErrors ? "" : "collapsed" }} " type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_2_body_1" aria-expanded="true" aria-controls="kt_accordion_2_body_1">
                    {{__('Dados de Faturação')}}
                </button>
            </h2>
            <div id="kt_accordion_2_body_1" class="{{ $hasInvoiceErrors ? "" : "accordion-collapse collapse" }}" aria-labelledby="kt_accordion_2_header_1" data-bs-parent="#kt_accordion_2">
                <div class="accordion-body">
                    <div class="row">
                        <div class="mb-10">
                            {!! Form::label('order_name', __('Name') . ' *', ['class' => 'form-label ']) !!}
                            {!! Form::text('order_name', null, ['class' => 'form-control form-control-solid '.($errors->has('order_name') ? 'is-invalid' : ''),'maxlength' => 255]) !!}
                            @error('order_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="mb-10">
                            {!! Form::label('order_email', __('Email') . ' *', ['class' => 'form-label']) !!}
                            {!! Form::email('order_email', null, ['class' => 'form-control form-control-solid '.($errors->has('order_email') ? 'is-invalid' : ''),'maxlength' => 128]) !!}
                            @error('order_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-10">
                            {!! Form::label('order_address', __('Address') . ' *', ['class' => 'form-label ']) !!}
                            {!! Form::text('order_address', null, ['class' => 'form-control form-control-solid '.($errors->has('order_address') ? 'is-invalid' : ''),'maxlength' => 255]) !!}
                            @error('order_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-10">
                            {!! Form::label('order_zip', __('Zip') . ' *', ['class' => 'form-label ']) !!}
                            {!! Form::text('order_zip', null, ['class' => 'form-control form-control-solid '.($errors->has('order_zip') ? 'is-invalid' : ''),'maxlength' => 12]) !!}
                            @error('order_zip')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-10">
                            {!! Form::label('order_location', __('Location') . ' *', ['class' => 'form-label ']) !!}
                            {!! Form::text('order_location', null, ['class' => 'form-control form-control-solid '.($errors->has('order_location') ? 'is-invalid' : ''),'maxlength' => 255]) !!}
                            @error('order_location')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-10">
                            {!! Form::label('order_phone', __('Phone') . ' *', ['class' => 'form-label ']) !!}
                            {!! Form::text('order_phone', null, ['class' => 'form-control form-control-solid '.($errors->has('order_phone') ? 'is-invalid' : ''),'maxlength' => 16]) !!}
                            @error('order_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-10">
                            {!! Form::label('order_vat', __('Vat') . ' *', ['class' => 'form-label ']) !!}
                            {!! Form::text('order_vat', null, ['class' => 'form-control form-control-solid '.($errors->has('order_vat') ? 'is-invalid' : ''),'maxlength' => 32]) !!}
                            @error('order_vat')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <!--end::Card body-->
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        var isEdit = {!! !empty($declaration->id) ? json_encode($declaration->id) : json_encode(false) !!};
        console.log(isEdit);
        function getTemplateQuestions(template){
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "{{route('declaration_templates.get_questions')}}",
                type: 'POST',
                dataType: 'json',
                data: {declaration_template_id : template, declaration_id : isEdit},
                success : function(response){
                    //console.log(response);
                    if(response.success){
                        $('#template_questions').html("");
                        if(response.questions.length > 0){
                            var questions = "";
                            for(i = 0; i < response.questions.length ; i++){
                                //console.log(response.questions[i].question);
                                console.log(response.questions[i]['value']);
                                questions = questions + '<div class="mb-10"><label class="mb-2">'+ response.questions[i]['question']['question'] +'</label><input type="text" class="form-control form-control-solid"  name="'+ response.questions[i]['question']['code'] +'" value="'+response.questions[i]['value']+'" required></div>'
                            }
                            $('#template_questions').html(questions);

                        }else{
                            toastr.success('Este Template não tem questões');
                        }

                    }else{
                        toastr.error('Ocorreu um erro. Tente novamente.');
                    }
                }
            });
        }
        /*if(isEdit !== false){
            console.log($('#declaration_template_id').find('option:selected').val());
            getTemplateQuestions($('#declaration_template_id').find('option:selected').val());
        }*/
        function changeTemplate(elem){
            if($(elem).find('option:selected').val() != null && $(elem).find('option:selected').val() !== ''){
                console.log($(elem).find('option:selected').val());
                getTemplateQuestions($(elem).find('option:selected').val());
            }
        }

        /*function showOrderInfo(){
            if($('#orderInfo').hasClass('d-none')){
                $('#orderInfo').removeClass('d-none');
                $('#orderInfo').addClass('d-flex');
            }else{
                $('#orderInfo').addClass('d-none');
                $('#orderInfo').removeClass('d-flex');
            }
        }*/
    </script>
@endpush
@if(auth()->user()->can('manageApp'))
    <div class="row">
        {!! Form::hidden('declaration_number',!empty($declaration->declaration_number) ? $declaration->declaration_number : null ) !!}
        {!! Form::hidden('value',!empty($declaration->value) ?$declaration->value : null ) !!}
    </div>

    <!-- Status Field -->
    <div class="mb-10">
        {!! Form::label('status', $declaration->getAttributeLabel('status'), ['class' => 'form-label']) !!}
        {!! Form::select('status', $declaration->getStatusArray() ,null, ['class' => 'form-control form-control-solid '.($errors->has('status') ? 'is-invalid' : '')]) !!}
        @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
@endif
<span class="text-muted">Declarações válidas durante 24 meses, desde que o associado mantenha as quotas regularizadas.</span>


