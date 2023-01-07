<?php
/**
 *
 * @var $declarationTemplate \App\Models\DeclarationTemplate
 * @var $errors Illuminate\View\Middleware\ShareErrorsFromSession
 */
view()->share('pageTitle', $declarationTemplate->id);
view()->share('hideSubHeader', true);
?>
<x-base-layout>
    @section('breadcrumbs')
        {{ Breadcrumbs::render('declaration_templates.edit', $declarationTemplate) }}
    @endsection

    <div class="card">
        {{--<div class="card-header">
            <h3 class="card-title">
                {{ $declarationTemplate->id }}
            </h3>
        </div>--}}
        {!! Form::model($declarationTemplate, ['route' => ['declaration_templates.update', $declarationTemplate], 'method' => 'patch', 'enctype'=>"multipart/form-data", 'class' => "form"]) !!}
            <div class="card-body">
                @include('declaration_templates.fields')
             </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <!--<button type="reset" class="btn btn-light btn-active-light-primary me-2">{{ __('Cancel') }}</button>-->
                <button type="submit" class="btn btn-primary" >{{ __('Save') }}</button>
            </div>
        {!! Form::close() !!}
    </div>
</x-base-layout>
