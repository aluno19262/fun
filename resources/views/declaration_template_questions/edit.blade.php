<?php
/**
 *
 * @var $declarationTemplateQuestion \App\Models\DeclarationTemplateQuestion
 * @var $errors Illuminate\View\Middleware\ShareErrorsFromSession
 */
view()->share('pageTitle', $declarationTemplateQuestion->id);
view()->share('hideSubHeader', true);
?>
<x-base-layout>
    @section('breadcrumbs')
        {{ Breadcrumbs::render('declaration-template-questions.edit', $declarationTemplateQuestion) }}
    @endsection
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                {{ $declarationTemplateQuestion->id }}
            </h3>
        </div>
        {!! Form::model($declarationTemplateQuestion, ['route' => ['declaration-template-questions.update', $declarationTemplateQuestion], 'method' => 'patch', 'enctype'=>"multipart/form-data", 'class' => "form"]) !!}
            <div class="card-body">
                @include('declaration_template_questions.fields')
             </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <!--<button type="reset" class="btn btn-light btn-active-light-primary me-2">{{ __('Cancel') }}</button>-->
                <button type="submit" class="btn btn-primary" >{{ __('Save') }}</button>
            </div>
        {!! Form::close() !!}
    </div>
</x-base-layout>
