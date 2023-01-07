<?php
/**
 *
 * @var $associate \App\Models\Associate
 */

view()->share('pageTitle', __('Acessos e Contactos') );
view()->share('hideSubHeader', true);
?>
<x-base-layout>
    @section('breadcrumbs')
        {{ Breadcrumbs::render('associates.evaluations', $associate) }}
    @endsection
    <div class="row gy-10 gx-xl-10">
        <!--begin::Col-->
        <div class="col-xl-12">
            {{ theme()->getView('home/navbar', array('class' => 'card-xxl-stretch mb-5 mb-xl-10','associate' => $associate)) }}
        </div>
    </div>
    @if(!empty($associate))
        <div class="card mb-10" >
            <!--begin::Vote-->
            <!--begin::Card header-->
            <div class="card-header" >
                <h3 class="card-title">
                    {{__('Preferential Contact')}}
                </h3>
            </div>
            {!! Form::model($associate, ['route' => ['associates.update_contact', $associate], 'method' => 'post', 'enctype'=>"multipart/form-data", 'class' => "form"]) !!}
                <div class="card-body">
                    <!--begin:Option-->
                    <div class="row">
                        <div class="col-md-2">
                            <label class="d-flex mb-5 cursor-pointer">
                                <!--begin:Label-->
                                <span class="me-5">Pessoal</span>
                                <!--begin:Input-->
                                <span class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="radio"  name="preferential_contact" value="0" {{$associate->preferential_contact == false ? 'checked' : ''}}/>
                            </span>
                                <!--end:Input-->
                            </label>
                        </div>

                        <div class="col-md-2 col-sm-6">
                            <label class="d-flex mb-5 cursor-pointer">
                                <!--begin:Label-->
                                <span class="me-5">Empresa</span>
                                <!--begin:Input-->
                                <span class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="radio"  name="preferential_contact" value="1" {{$associate->preferential_contact == true ? 'checked' : ''}}/>
                            </span>
                                <!--end:Input-->
                            </label>
                        </div>
                    </div>
                    <!--end::Option-->
                </div>
                @push('scripts')
                    <script>
                        /*$('input[name="preferential_contact"]').on('click',function (){
                            if($(this).val() === "0"){
                                $(this).val(1);
                            }else{
                                $(this).val(0);
                            }
                        })*/
                    </script>
                @endpush
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="submit" id="saveButton" class="btn btn-primary" >{{ __('Save') }}</button>
                </div>
            {!! Form::close() !!}
        </div>
        <div class="card mb-10" >
            <!--begin::Vote-->
            <!--begin::Card header-->
            <div class="card-header" >
                <h3 class="card-title">
                    {{__('Preferential Billing Declarations')}}
                </h3>
            </div>
            {!! Form::model($associate, ['route' => ['associates.update_billing_declarations', $associate], 'method' => 'post', 'enctype'=>"multipart/form-data", 'class' => "form"]) !!}
            <div class="card-body">
                <!--begin:Option-->
                <div class="row">
                    <div class="col-md-2">
                        <label class="d-flex mb-5 cursor-pointer">
                            <!--begin:Label-->
                            <span class="me-5">Pessoal</span>
                            <!--begin:Input-->
                            <span class="form-check form-check-custom form-check-solid">
                            <input class="form-check-input" type="radio"  name="preferential_billing_declarations" value="{{\App\Models\Associate::PREFERENTIAL_BILLING_DECLARATIONS_PERSONAL}}" {{$associate->preferential_billing_declarations == 1 ? 'checked' : ''}}/>
                        </span>
                            <!--end:Input-->
                        </label>
                    </div>

                    <div class="col-md-2 col-sm-6">
                        <label class="d-flex mb-5 cursor-pointer">
                            <!--begin:Label-->
                            <span class="me-5">Empresa</span>
                            <!--begin:Input-->
                            <span class="form-check form-check-custom form-check-solid">
                            <input class="form-check-input" type="radio"  name="preferential_billing_declarations" value="{{\App\Models\Associate::PREFERENTIAL_BILLING_DECLARATIONS_COMPANY}}" {{$associate->preferential_billing_declarations == 2 ? 'checked' : ''}}/>
                        </span>
                            <!--end:Input-->
                        </label>
                    </div>
                </div>
                <!--end::Option-->
            </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="submit" class="btn btn-primary" >{{ __('Save') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
            <div class="card mb-10" >
                <!--begin::Vote-->
                <!--begin::Card header-->
                <div class="card-header" >
                    <h3 class="card-title">
                        {{__('Preferential Billing Quotas')}}
                    </h3>
                </div>
                {!! Form::model($associate, ['route' => ['associates.update_billing_quotas', $associate], 'method' => 'post', 'enctype'=>"multipart/form-data", 'class' => "form"]) !!}
                <div class="card-body">
                    <!--begin:Option-->
                    <div class="row">
                        <div class="col-md-2">
                            <label class="d-flex mb-5 cursor-pointer">
                                <!--begin:Label-->
                                <span class="me-5">Pessoal</span>
                                <!--begin:Input-->
                                <span class="form-check form-check-custom form-check-solid">
                            <input class="form-check-input" type="radio"  name="preferential_billing_quotas" value="{{\App\Models\Associate::PREFERENTIAL_BILLING_QUOTAS_PERSONAL}}" {{$associate->preferential_billing_quotas == 1 ? 'checked' : ''}}/>
                        </span>
                                <!--end:Input-->
                            </label>
                        </div>

                        <div class="col-md-2 col-sm-6">
                            <label class="d-flex mb-5 cursor-pointer">
                                <!--begin:Label-->
                                <span class="me-5">Empresa</span>
                                <!--begin:Input-->
                                <span class="form-check form-check-custom form-check-solid">
                            <input class="form-check-input" type="radio"  name="preferential_billing_quotas" value="{{\App\Models\Associate::PREFERENTIAL_BILLING_QUOTAS_COMPANY}}" {{$associate->preferential_billing_quotas == 2 ? 'checked' : ''}}/>
                        </span>
                                <!--end:Input-->
                            </label>
                        </div>
                    </div>
                    <!--end::Option-->
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="submit" class="btn btn-primary" >{{ __('Save') }}</button>
                </div>
                {!! Form::close() !!}
            </div>

        <div class="card">
            <div class="card-header" >
                <h3 class="card-title">
                    {{__('Dados de Acesso')}}
                </h3>
            </div>
            <div class="card-body">
                {!! Form::model($associate->user, ['route' => ['associates.update_user',$associate->user], 'method' => 'post', 'class' => "form", 'enctype' => "multipart/form-data"]) !!}
                    <div class="card-body">
                        <div class="mb-10">
                            {!! Form::label('name', __('Name'), ['class' => 'form-label required']) !!}
                            {!! Form::text('name', null, ['class' => 'form-control form-control-solid '.($errors->has('name') ? 'is-invalid' : ''), 'placeholder' => __('Name'), request()->routeIs('users.edit') && !auth()->user()->can('adminApp') ? 'readonly' : 'false' ]) !!}
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-10">
                            {!! Form::label('email', __('E-Mail address'), ['class' => 'form-label required']) !!}
                            {!! Form::email('email', null, ['class' => 'form-control form-control-solid '.($errors->has('email') ? 'is-invalid' : ''), 'placeholder' => __('E-Mail address'), request()->routeIs('users.edit') ? 'readonly' : '' ]) !!}
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-10">
                            {!! Form::label('password', __('Password'), ['class' => 'form-label']) !!}
                            {!! Form::password('password', ['class' => 'form-control form-control-solid '.($errors->has('password') ? 'is-invalid' : ''), 'placeholder' => __('Password')]) !!}
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-10">
                            {!! Form::label('password_confirmation', __('Confirm password'), ['class' => 'form-label']) !!}
                            {!! Form::password('password_confirmation', ['class' => 'form-control form-control-solid '.($errors->has('password_confirmation') ? 'is-invalid' : ''), 'placeholder' => __('Confirm password')]) !!}
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="submit" class="btn btn-primary" >{{ __('Save') }}</button>
                    </div>
                {!! Form::close() !!}
            </div>

        </div>
    @endif



</x-base-layout>
