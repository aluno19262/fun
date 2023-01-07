<?php
/**
 *
 * @var $associate \App\Models\Associate
 * @var $errors Illuminate\View\Middleware\ShareErrorsFromSession
 */

view()->share('pageTitle', $associate->name);
view()->share('hideSubHeader', true);
?>
<x-base-layout>
    @section('breadcrumbs')
        {{ Breadcrumbs::render('associates.edit', $associate) }}
    @endsection


    <div class="row gy-10 gx-xl-10">
        <!--begin::Col-->
        <div class="col-xl-12">
            {{ theme()->getView('home/navbar', array('class' => 'card-xxl-stretch mb-5 mb-xl-10','associate' => $associate)) }}
        </div>
    </div>

    <div class="card">
        @if(auth()->user()->checkPermissionToEdit($associate))
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="button" class="btn btn-primary" onclick="$('#saveButton').click()" >{{ __('Save') }}</button>
            </div>
        @endcan
        {!! Form::model($associate, ['route' => ['associates.update', $associate], 'method' => 'patch', 'enctype'=>"multipart/form-data", 'class' => "form"]) !!}
        <div class="card-body">
            @include('associates.fields')
         </div>
        @if(auth()->user()->checkPermissionToEdit($associate))
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="submit" id="saveButton" class="btn btn-primary" >{{ __('Save') }}</button>
            </div>
        @endcan
        {!! Form::close() !!}
    </div>
</x-base-layout>
