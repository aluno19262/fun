<?php
/**
 *
 * @var $company \App\Models\Company;
 * @var $errors Illuminate\View\Middleware\ShareErrorsFromSession
 */
view()->share('pageTitle', __('Create Company'));
view()->share('hideSubHeader', true);
?>
<x-base-layout>
    @section('breadcrumbs')
        {{ Breadcrumbs::render('companies.create') }}
    @endsection

    <div class="row gy-10 gx-xl-10">
        <!--begin::Col-->
        <div class="col-xl-12">
            {{ theme()->getView('home/navbar', array('class' => 'card-xxl-stretch mb-5 mb-xl-10','associate' => $associate)) }}
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                {{ __('Dados da Empresa/Empregador') }}
            </h3>
        </div>
        {!! Form::model($company, ['route' => ['companies.store'], 'method' => 'post', 'enctype'=>"multipart/form-data", 'class' => "form"]) !!}

        <div class="card-body">
                @include('companies.fields')
             </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <!--<button type="reset" class="btn btn-light btn-active-light-primary me-2">{{ __('Cancel') }}</button>-->
                <button type="submit" class="btn btn-primary" {{auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled'}}>{{ __('Save') }}</button>
            </div>
        {!! Form::close() !!}
    </div>
</x-base-layout>
