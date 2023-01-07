<?php
/**
 *
 * @var $findApSpecialtyArea \App\Models\FindApSpecialtyArea
 * @var $errors Illuminate\View\Middleware\ShareErrorsFromSession
 */
view()->share('pageTitle', $findApSpecialtyArea->id);
view()->share('hideSubHeader', true);
?>
<x-base-layout>
    @section('breadcrumbs')
        {{ Breadcrumbs::render('find-ap-specialty-areas.edit', $findApSpecialtyArea) }}
    @endsection
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                {{ $findApSpecialtyArea->id }}
            </h3>
        </div>
        {!! Form::model($findApSpecialtyArea, ['route' => ['find-ap-specialty-areas.update', $findApSpecialtyArea], 'method' => 'patch', 'enctype'=>"multipart/form-data", 'class' => "form"]) !!}
            <div class="card-body">
                @include('find_ap_specialty_areas.fields')
             </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <!--<button type="reset" class="btn btn-light btn-active-light-primary me-2">{{ __('Cancel') }}</button>-->
                <button type="submit" class="btn btn-primary" >{{ __('Save') }}</button>
            </div>
        {!! Form::close() !!}
    </div>
</x-base-layout>
