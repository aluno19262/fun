<!-- Name Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $declarationTemplate->getAttributeLabel('name') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $declarationTemplate->name }}</span>
    </div>
</div>


<!-- Order Field -->
<div class="row mb-7">
    <label class="col-lg-4 fw-bold text-muted">{{ $declarationTemplate->getAttributeLabel('order') }}</label>
    <div class="col-lg-8">
        <span class="fw-bolder fs-6 text-gray-800">{{ $declarationTemplate->order }}</span>
    </div>
</div>

@if(!empty($declarationTemplate->declarationTemplateQuestions))
    <!-- Order Field -->
    <div class="row mb-7">
        <label class="col-lg-4 fw-bold text-muted">{{ $declarationTemplate->getAttributeLabel('order') }}</label>

            <div class="col-lg-8">
                @foreach($declarationTemplate->declarationTemplateQuestions as $question)
                    <span class="fw-bolder fs-6 text-gray-800">{{ $question->question . ' - ' . $question->code }}</span><br>
                @endforeach
            </div>

    </div>
@endif

@if(auth()->user()->can('manageApp'))
    <!-- Status Field -->
    <div class="row mb-7">
        <label class="col-lg-4 fw-bold text-muted">{{ $declarationTemplate->getAttributeLabel('status') }}</label>
        <div class="col-lg-8">
            <span class="fw-bolder fs-6 text-gray-800">{{ $declarationTemplate->getStatusLabelAttribute() }}</span>
        </div>
    </div>
@endif

@if(!empty($declarationTemplate->getFirstMedia('declaration_template_document')))
    <!-- Order Field -->
    <div class="row mb-7">
        <label class="col-lg-4 fw-bold text-muted">{{ __('File') }}</label>
        <div class="col-lg-8">
            <a class="btn bg-primary text-white" href="{{$declarationTemplate->getFirstMediaUrl('declaration_template_document')}}" target="_blank">{{__('Download') . " " .$declarationTemplate->getFirstMedia('declaration_template_document')['file_name']}}</a>
        </div>
    </div>
@endif
