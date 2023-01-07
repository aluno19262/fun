<x-auth-layout>
    <div class=" bg-white rounded shadow-sm p-10 p-lg-15 mx-auto {{request()->routeIs('policies.*') ? "" : "w-lg-500px"}}">
        <div class="row align-center">
            <a href="{{ route('home') }}" class="mb-12 d-flex justify-content-center">
                <img alt="Logo" src="{{ asset(theme()->getMediaUrlPath() . 'logos/apap-logo.png') }}" class="h-125px"/>
            </a>
        </div>

        <!--begin::Signup Form-->
        <form method="POST" action="{{ route('register') }}" class="form w-100" novalidate="novalidate" id="kt_sign_up_form">
        @csrf

        <!--begin::Heading-->
            <div class="text-center mb-10">
                <!--begin::Title-->
                <h1 class="text-dark mb-3">
                    {{ __('Create an Account') }}
                </h1>
                <!--end::Title-->

                <!--begin::Link-->
                <div class="text-gray-400 fw-bold fs-4">
                    {{ __('Already have an account?') }}

                    <a href="{{ route('login') }}" class="link-primary fw-bolder">
                        {{ __('Sign in here') }}
                    </a>
                </div>
                <!--end::Link-->
            </div>
            <!--end::Heading-->
        @if(false)
            <!--begin::Action-->
                <button type="button" class="btn btn-light-primary fw-bolder w-100 mb-10">
                    <img alt="Logo" src="{{ asset('media/svg/brand-logos/google-icon.svg') }}" class="h-20px me-3"/>
                    {{ __('Sign in with Google') }}
                </button>
                <!--end::Action-->

                <!--begin::Separator-->
                <div class="d-flex align-items-center mb-10">
                    <div class="border-bottom border-gray-300 mw-50 w-100"></div>
                    <span class="fw-bold text-gray-400 fs-7 mx-2">{{ __('OR') }}</span>
                    <div class="border-bottom border-gray-300 mw-50 w-100"></div>
                </div>
                <!--end::Separator-->
        @endif
        <!--begin::Input group-->
            <div class="fv-row mb-7">
                <label class="form-label fw-bolder text-dark fs-6">{{ __('Name') .' *' }}</label>
                <input class="form-control form-control-lg form-control-solid" type="text" name="name" autocomplete="off" value="{{ old('name') }}"/>
                @error('name')
                <div class="fv-plugins-message-container invalid-feedback">
                    <div>{{ $message }}</div>
                </div>
                @enderror
            </div>
            <!--end::Input group-->

            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <label class="form-label fw-bolder text-dark fs-6">{{ __('Email') .' *' }}</label>
                <input class="form-control form-control-lg form-control-solid" type="email" name="email" autocomplete="off" value="{{ old('email') }}"/>
                @error('email')
                <div class="fv-plugins-message-container invalid-feedback">
                    <div>{{ $message }}</div>
                </div>
                @enderror
            </div>
            <!--end::Input group-->

            <!--begin::Input group-->
            <div class="mb-10 fv-row" data-kt-password-meter="true">
                <!--begin::Wrapper-->
                <div class="mb-1">
                    <!--begin::Label-->
                    <label class="form-label fw-bolder text-dark fs-6">
                        {{ __('Password')  .' *'}}
                    </label>
                    <!--end::Label-->

                    <!--begin::Input wrapper-->
                    <div class="position-relative mb-3">
                        <input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="new-password"/>

                        <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                        <i class="bi bi-eye-slash fs-2"></i>
                        <i class="bi bi-eye fs-2 d-none"></i>
                    </span>
                    </div>
                    <!--end::Input wrapper-->

                    <!--begin::Meter-->
                    <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                    </div>
                    <!--end::Meter-->
                </div>
                <!--end::Wrapper-->

                <!--begin::Hint-->
                <div class="text-muted">
                    {{ __('Use 8 or more characters with a mix of letters, numbers & symbols.') }}
                </div>
                <!--end::Hint-->
                @error('password')
                <div class="fv-plugins-message-container invalid-feedback">
                    <div>{{ $message }}</div>
                </div>
                @enderror
            </div>
            <!--end::Input group--->

            <!--begin::Input group-->
            <div class="fv-row mb-5">
                <label class="form-label fw-bolder text-dark fs-6">{{ __('Confirm Password')  .' *'}}</label>
                <input class="form-control form-control-lg form-control-solid" type="password" name="password_confirmation" autocomplete="off"/>
                @error('password_confirmation')
                <div class="fv-plugins-message-container invalid-feedback">
                    <div>{{ $message }}</div>
                </div>
                @enderror
            </div>
            <div class="fv-row mb-5">
                {!! Form::label('nationality', __('Nacionalidade'), ['class' => 'form-label ']) !!}
                {!! Form::select('nationality', \DvK\Laravel\Vat\Facades\Countries::all() , null , ['id'=> "nationality_select",'class' => 'form-select form-select-solid '.($errors->has('nationality') ? 'is-invalid' : ''), 'required' => true]) !!}
                @error('nationality')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            @push('scripts')
                <script>
                    jQuery(document).ready(function() {
                        $("#nationality_select").val('PT').change();
                        if($("#vat").val().length  == 0 && !$("#nationality_select").find('option:selected').val().includes("PT") && !$("#vat").val().includes($("#nationality_select").find('option:selected').val())  ){
                            var vat = $("#vat").val();
                            $("#vat").val($("#nationality_select").find('option:selected').val()  + vat);
                        }else if($("#nationality_select").find('option:selected').val().includes("PT")){
                            $("#vat").val( $("#vat").val().replace('PT',""));
                        }
                    });
                    var previous;

                    $("#nationality_select").on('focus', function () {
                        // Store the current value on focus and on change
                        previous = this.value;
                    }).change(function() {
                        // Do something with the previous value after the change
                        console.log(previous);
                        //alert(previous + " - " +previous.length);
                        // Make sure the previous value is updated
                        previous = this.value;
                        if($("#vat").val().length <= 2){
                            $("#vat").val("");
                        }
                        var value = $("#vat").val();
                        console.log('--inicio---')
                        if($("#vat").val().includes(previous)){
                            var new_value = $("#nationality_select").find('option:selected').val();
                            if(!new_value === "PT"){
                                console.log('if 1');
                                $("#vat").val(value.replace(previous,$("#nationality_select").find('option:selected').val()));
                            }else{
                                console.log('if 2');
                                $("#vat").val(value.replace(previous,""));
                            }
                        }else{
                            if($("#nationality_select").find('option:selected').val() === 'PT'){
                                $("#vat").val($("#vat").val().replace('PT',""));
                            }else{
                                $("#vat").val($("#nationality_select").find('option:selected').val() + $("#vat").val().replace(previous,""));
                            }
                        }

                    });
                </script>
        @endpush
            <!--end::Input group-->
            <div class="fv-row mb-10 ">
                {!! Form::label('vat', __('vat') .' *', ['class' => 'form-label fw-bolder text-dark fs-6 ']) !!}
                {!! Form::text('vat', null , ['class' => 'form-control form-control-lg form-control-solid '.($errors->has('vat') ? 'is-invalid' : ''), 'required' => true]) !!}
                @error('vat')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <!--end::Input group-->
            <div class="fv-row mb-10 ">
                {!! Form::label('cc_number', __('CC Number') .' *', ['class' => 'form-label fw-bolder text-dark fs-6 ']) !!}
                {!! Form::text('cc_number', null , ['class' => 'form-control form-control-lg form-control-solid '.($errors->has('cc_number') ? 'is-invalid' : ''), 'required' => true]) !!}
                <div class=" mt-4">
                    <span class="text-muted">Exemplo: 12233456 7 ZZ0</span>
                </div>

                @error('cc_number')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <p>Se já for associado APAP com um nº de associado atribuído, não efetue o registo. <a href="mailto:apap@apap.pt">Contacte a APAP</a>.</p>
            <div class="fv-row mb-10 ">
                {!! Form::label('category', __('category') .' *', ['class' => 'form-label fw-bolder text-dark fs-6 ']) !!}
                {!! Form::select('category', \App\Models\Associate::getRegisterCategoryArray() , null , ['class' => 'form-select form-select-solid '.($errors->has('category') ? 'is-invalid' : ''), 'required' => true]) !!}
                <div class="row mt-4">
                    <a href="https://apap.pt/admissao-de-associados/" target="_blank">Qual a minha categoria?</a>
                </div>
                @error('category')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <!--begin::Input group-->
            <div class="fv-row mb-10">
                <label class="form-check form-check-custom form-check-solid form-check-inline">
                    <input class="form-check-input" type="checkbox" name="toc" value="1" />
                    <span class="form-check-label fw-bold text-gray-700 fs-6">
                    {{ __('I Agree &') }} <a href="{{\App\Facades\Setting::getParam('privacy_policy_link')}}" target="_blank" class="ms-1 link-primary">{{ __('Terms and conditions') }}</a>.
                </span>
                </label>
                @error('toc')
                <div class="fv-plugins-message-container invalid-feedback">
                    <div>{{ $message }}</div>
                </div>
                @enderror
            </div>
            <div class="fv-row mb-10">
                <label class="form-check form-check-custom form-check-solid form-check-inline">
                    <input class="form-check-input" type="checkbox" name="gdpr_newsletter" value="1" />
                    <span class="form-check-label fw-bold text-gray-700 fs-6">
                    Aceita que os seus dados de associado sejam divulgados na newsletter?
                </span>
                </label>
                @error('gdpr_newsletter')
                <div class="fv-plugins-message-container invalid-feedback">
                    <div>{{ $message }}</div>
                </div>
                @enderror
            </div>
            <!--end::Input group-->

            <!--begin::Actions-->
            <div class="text-center">
                <button type="submit" id="kt_sign_up_submit" class="btn btn-lg btn-primary">
                    @include('partials.general._button-indicator')
                </button>
            </div>
            <!--end::Actions-->
        </form>
        @push('scripts')
            <script>
                jQuery(document).ready(function() {
                    @if(session()->has('needContact'))
                    Swal.fire({
                        title : "{{__('Acesso à Plataforma')}}",
                        html: "{!!"Em virtude da migração para a nova plataforma, deve contactar o apoio técnico para aceder à sua conta de associado:<br>apoio.tecnico@apap.pt • 213 950 025" !!}",
                        icon: "warning",
                        buttonsStyling: false,
                        confirmButtonText: "Ok!",
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-light"
                        }
                    })
                    @endif
                });
            </script>
            <!--end::Signup Form-->
        @endpush
    </div>

</x-auth-layout>


