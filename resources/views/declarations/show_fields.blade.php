<!-- Declaration Number Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $declaration->getAttributeLabel('declaration_number') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $declaration->declaration_number }}</span>
    </div>
</div>

@if(!empty($declaration->declaration_template_id))
    <!-- Declaration Template Field -->
    <div class="row mb-7">
        <label class="col-lg-4 fw-bold text-muted">{{ $declaration->getAttributeLabel('declaration_template_id') }}</label>
        <div class="col-lg-8">
            <span class="fw-bolder fs-6 text-gray-800">{{ $declaration->declarationTemplate->name }}</span>
        </div>
    </div>
@endif

@if(!empty($declaration->verification_code))
    <!-- Declaration Template Field -->
    <div class="row mb-7">
        <label class="col-lg-4 fw-bold text-muted">{{ $declaration->getAttributeLabel('verification_code') }}</label>
        <div class="col-lg-8">
            <span class="fw-bolder fs-6 text-gray-800">{{ $declaration->verification_code }}</span>
        </div>
    </div>
@endif

<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $declaration->getAttributeLabel('is_renovation') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $declaration->is_renovation ? "Sim" : "Não" }}</span>
    </div>
</div>

@if($declaration->is_renovation)
    <div class="row mb-7">
        <label class="col-lg-4 fw-bold text-muted">{{ $declaration->getAttributeLabel('previous_declaration_number') }}</label>
        <div class="col-lg-8">
            <span class="fw-bolder fs-6 text-gray-800">{{ $declaration->previous_declaration_number }}</span>
        </div>
    </div>
@endif

@if(count($declaration->declarationQuestions) > 0)
    <!-- Questions Field -->
    <div class="row mb-7">
        <label class="col-lg-4 fw-bold text-muted">{{ __('Questions') }}</label>
        <div class="col-lg-8">
            @foreach($declaration->declarationQuestions as $question)
                <span class="fw-bolder fs-6 text-gray-800">{{ $question->declarationTemplateQuestion->question . ' - ' . $question->value }}</span><br>
            @endforeach
        </div>
    </div>
@endif

<!-- Status Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $declaration->getAttributeLabel('status') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $declaration->getStatusLabelAttribute() }}</span>
    </div>
</div>

@if($declaration->hasMedia('final_document'))
    <div class="row mb-7">
        <label class="col-lg-4 fw-bold text-muted">{{ __('Final Document') }}</label>
        <div class="col-lg-8">
            <a href="{{$declaration->getFirstMediaUrl('final_document')}}" target="_blank" class="btn btn-primary">{{ __('Download Document') }}</a>
        </div>
    </div>
@endif
@if(!empty($declaration->orderItems) && !empty($declaration->orderItems->first()->order) && $declaration->status == \App\Models\Declaration::STATUS_WAITING_PAYMENT)
    <!-- Status Field -->
    <div class="row mb-7">
        <label class="col-lg-4 fw-bold text-muted">{{__('Entidade')}}</label>
        <div class="col-lg-8">
            <span class="fw-bolder fs-6 text-gray-800">{{ $declaration->orderItems->first()->order->mb_ent }}</span>
        </div>
    </div>
    <!-- Status Field -->
    <div class="row mb-7">
        <label class="col-lg-4 fw-bold text-muted">{{__('Referência')}}</label>
        <div class="col-lg-8">
            <span class="fw-bolder fs-6 text-gray-800">{{ $declaration->orderItems->first()->order->mb_ref }}</span>
        </div>
    </div>
    <!-- Status Field -->
    <div class="row mb-7">
        <label class="col-lg-4 fw-bold text-muted">{{__('Total')}}</label>
        <div class="col-lg-8">
            <span class="fw-bolder fs-6 text-gray-800">{{ $declaration->orderItems->first()->order->total . '€'}}</span>
        </div>
    </div>
@endif

{{--@if(auth()->user()->hasAnyRole('Manager|SuperAdmin') && ($declaration->status == \App\Models\Declaration::STATUS_WAITING_APPROVAL || $declaration->status == \App\Models\Declaration::STATUS_ACTIVE))
    <div class="card-footer d-flex justify-content-end py-6 px-9">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_send_final_doc">{{ __('Send Final Document') }}</button>
    </div>

    <div class="modal fade" tabindex="-1" id="modal_send_final_doc">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Send Final Document')}}</h5>
                <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>
                {!! Form::model($declaration, ['route' => ['declarations.send_final_doc',$declaration], 'method' => 'post', 'enctype'=>"multipart/form-data", 'class' => "form",'id' => 'form-send-final-doc']) !!}
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-10">
                            {!! Form::label('final_document', __('Final Document'), ['class' => 'form-label ']) !!}
                            {!! Form::file('final_document', ['class' => 'form-control '.($errors->has('final_document') ? 'is-invalid' : '')]) !!}
                            @error('final_document')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" onclick="$('#form-send-final-doc')[0].reset()">{{__('Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('Send')}}</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endif--}}


