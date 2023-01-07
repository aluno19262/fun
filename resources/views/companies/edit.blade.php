<?php
/**
 *
 * @var $company \App\Models\Company
 * @var $errors Illuminate\View\Middleware\ShareErrorsFromSession
 */
view()->share('pageTitle', $company->id);
view()->share('hideSubHeader', true);
?>
<x-base-layout>
    @section('breadcrumbs')
        {{ Breadcrumbs::render('companies.edit', $company) }}
    @endsection

    <div class="row gy-10 gx-xl-10">
        <!--begin::Col-->
        <div class="col-xl-12">
            {{ theme()->getView('home/navbar', array('class' => 'card-xxl-stretch mb-5 mb-xl-10','associate' => $associate)) }}
        </div>
    </div>

    <div class="card">
        {{--<div class="card-header">
            <h3 class="card-title">
                {{ $company->id }}
            </h3>
        </div>--}}
        {!! Form::model($company, ['route' => ['companies.update', $company], 'method' => 'patch', 'enctype'=>"multipart/form-data", 'class' => "form"]) !!}

        <div class="card-body">
                @include('companies.fields')
             </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <!--<button type="reset" class="btn btn-light btn-active-light-primary me-2">{{ __('Cancel') }}</button>-->
                <button type="button" class="btn btn-bg-light btn-color-danger delete-confirmation mx-9" {{auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled'}} data-delete-url="{{route('companies.destroy', $company)}}" onclick="destroyConfirmation(this)" title="{{__('Eliminar dados')}}">{{__('Delete data')}}</button>
                <button type="submit" class="btn btn-primary" {{auth()->user()->checkPermissionToEdit($associate) ? '' : 'disabled'}}>{{ __('Save') }}</button>
            </div>
        {!! Form::close() !!}
    </div>

    @push('scripts')
        <script>
            function destroyConfirmation(e){
                var _this =  jQuery(e);
                swal.fire({
                    title: '{{ __('Are you sure you want to delete this?') }}',
                    text: "{!! __("You won't be able to revert this!") !!}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "{{ __('Yes, delete it!') }}"
                }).then(function(result) {
                    console.log(result);
                    if (result.value) {

                        jQuery.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        jQuery.ajax({
                            url: _this.data('delete-url'),
                            type: 'POST',
                            dataType: 'json',
                            data: {_method: 'DELETE'},
                            success: function(result){
                                console.log(result);
                                if(result.success){
                                    toastr.success('Dados da empresa eliminados com sucesso.');
                                    window.location.href = result.redirect;
                                }else{
                                    toastr.error('Ocorreu um erro. Tente novamente.');
                                }
                            }
                        });
                    }
                });
            }
        </script>
    @endpush
</x-base-layout>
