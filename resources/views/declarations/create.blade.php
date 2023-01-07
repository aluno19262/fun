<?php
/**
 *
 * @var $declaration \App\Models\Declaration;
 * @var $errors Illuminate\View\Middleware\ShareErrorsFromSession
 */
view()->share('pageTitle', __('Create Declaration'));
view()->share('hideSubHeader', true);
?>
<x-base-layout>
    @section('breadcrumbs')
        {{ Breadcrumbs::render('declarations.create') }}
    @endsection

    <div class="row gy-10 gx-xl-10">
        <!--begin::Col-->
        <div class="col-xl-12">
            {{ theme()->getView('home/navbar', array('associate' => $associate,'class' => 'card-xxl-stretch mb-5 mb-xl-10')) }}
        </div>
    </div>

    <div class="card">
        {{--<div class="card-header">
            <h3 class="card-title">
                {{ __('Create Declaration') }}
            </h3>
        </div>--}}
        {!! Form::model($declaration, ['route' => ['declarations.store'], 'method' => 'post', 'enctype'=>"multipart/form-data", 'class' => "form"]) !!}
            <div class="card-body">
                @include('declarations.fields')
             </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <!--<button type="reset" class="btn btn-light btn-active-light-primary me-2">{{ __('Cancel') }}</button>-->
                <button type="submit" class="btn btn-primary" >{{ __('Efetuar Pedido') }}</button>
            </div>
        {!! Form::close() !!}
    </div>
</x-base-layout>
