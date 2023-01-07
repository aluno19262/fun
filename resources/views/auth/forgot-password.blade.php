<x-auth-layout>
    <div class=" bg-white rounded shadow-sm p-10 p-lg-15 mx-auto {{request()->routeIs('policies.*') ? "" : "w-lg-500px"}}">
        <div class="row align-center">
            <a href="{{ route('home') }}" class="mb-12 d-flex justify-content-center">
                <img alt="Logo" src="{{ asset(theme()->getMediaUrlPath() . 'logos/apap-logo.png') }}" class="h-125px"/>
            </a>
        </div>

        <!--begin::Forgot Password Form-->
        <form method="POST" action="{{ route('password.email') }}" class="form w-100" novalidate="novalidate" id="kt_password_reset_form">
        @csrf

        <!--begin::Heading-->
            <div class="text-center mb-10">
                <!--begin::Title-->
                <h1 class="text-dark mb-3">
                    {{ __('Forgot Password ?') }}
                </h1>
                <!--end::Title-->

                <!--begin::Link-->
                <div class="text-gray-400 fw-bold fs-4">
                    {{ __('Enter your email to reset your password.') }}
                </div>
                <!--end::Link-->
            </div>
            <!--begin::Heading-->

            <!--begin::Input group-->
            <div class="fv-row mb-10">
                <label class="form-label fw-bolder text-gray-900 fs-6">{{ __('Email') }}</label>
                <input class="form-control form-control-solid" type="email" name="email" autocomplete="off" value="{{ old('email') }}" required autofocus/>
                @error('email')
                <div class="fv-plugins-message-container invalid-feedback">
                    <div>{{ $message }}</div>
                </div>
                @enderror
            </div>
            <!--end::Input group-->

            <!--begin::Actions-->
            <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                <button type="submit" id="kt_password_reset_submit" class="btn btn-lg btn-primary fw-bolder me-4">
                    @include('partials.general._button-indicator')
                </button>

                <a href="{{ route('login') }}" class="btn btn-lg btn-light-primary fw-bolder">{{ __('Cancel') }}</a>
            </div>
            <!--end::Actions-->
        </form>
        <!--end::Forgot Password Form-->
    </div>


</x-auth-layout>
