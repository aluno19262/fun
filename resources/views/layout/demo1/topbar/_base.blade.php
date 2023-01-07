@php
    $toolbarButtonMarginClass = "ms-1 ms-lg-3";
    $toolbarButtonHeightClass = "w-40px h-40px";
    $toolbarUserAvatarHeightClass = "symbol-40px";
    $toolbarButtonIconSizeClass = "svg-icon-1";
@endphp

{{--begin::Toolbar wrapper--}}
<div class="d-flex align-items-stretch flex-shrink-0">
    @if(false)
        {{--begin::Search--}}
        <div class="d-flex align-items-stretch {{ $toolbarButtonMarginClass }}">
            {{ theme()->getView('partials/search/_base') }}
        </div>
        {{--end::Search--}}
    @endif

    @if(false)
        {{--begin::Activities--}}
        <div class="d-flex align-items-center {{ $toolbarButtonMarginClass }}">
            {{--begin::drawer toggle--}}
            <div class="btn btn-icon btn-active-light-primary {{ $toolbarButtonHeightClass }}" id="kt_activities_toggle">
                {!! theme()->getSvgIcon("icons/duotune/general/gen032.svg", $toolbarButtonIconSizeClass) !!}
            </div>
            {{--end::drawer toggle--}}
        </div>
        {{--end::Activities--}}
    @endif

    @if(false)
        {{--begin::Notifications--}}
        <div class="d-flex align-items-center {{ $toolbarButtonMarginClass }}">
            {{--begin::Menu--}}
            <div class="btn btn-icon btn-active-light-primary position-relative {{ $toolbarButtonHeightClass }}" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                {!! theme()->getSvgIcon("icons/duotune/communication/com012.svg", $toolbarButtonIconSizeClass) !!}

                <span class="bullet bullet-dot bg-success h-6px w-6px position-absolute translate-middle top-0 start-50 animation-blink">
                </span>
            </div>
            {{ theme()->getView('partials/topbar/_notifications-menu') }}
            {{--end::Menu--}}
        </div>
        {{--end::Notifications--}}
    @endif
    @if(false)
        {{--begin::Quick links--}}
        <div class="d-flex align-items-center {{ $toolbarButtonMarginClass }}">
            {{--begin::Menu--}}
            <a class="btn btn-icon btn-active-light-primary {{ $toolbarButtonHeightClass }}" href="{{route('contacts.create')}}">
                <i class="fas fa-life-ring" style="font-size: 1.5rem!important;"></i>

            </a>
            {{--<span class="text-muted">Centro de Ajuda</span>--}}
            {{--end::Menu--}}
        </div>
        {{--end::Quick links--}}
    @endif

    {{--begin::User--}}
    @if(Auth::check())
        <div class="d-flex align-items-center {{ $toolbarButtonMarginClass }}" id="kt_header_user_menu_toggle">
            {{--begin::Menu--}}
            <div class="d-flex cursor-pointer symbol {{ $toolbarUserAvatarHeightClass }}" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                @if(false)
                    <img src="{{ auth()->user()->avatar_url }}" alt="metronic"/>
                @endif
                    <div class="btn btn-active-light d-flex align-items-center bg-hover-light py-2 px-2 px-md-3" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        <!--begin::Name-->
                        <div class="d-none d-md-flex flex-column align-items-end justify-content-center me-2">
                            <span class="text-dark fs-7 fw-bolder mb-2 lh-1">{{auth()->user()->name}}</span>
                            <span class="text-muted fs-base  fw-bold lh-1 ">{{auth()->user()->email}}</span>
                        </div>
                        <!--end::Name-->
                        <!--begin::Symbol-->
                        <div class="symbol-label fs-2 fw-bold bg-primary text-inverse-primary">{{ auth()->user()->name[0] }}</div>
                        <!--end::Symbol-->
                    </div>
                {{--<div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2 ">
                    <div class="d-flex flex-column me-4 text-end">
                        <span class="text-dark font-weight-bolder font-size-base">{{auth()->user()->name}}</span>
                        <span class="text-dark ">{{auth()->user()->email}}</span>
                    </div>
                    <div class="symbol-label fs-2 fw-bold bg-primary text-inverse-primary">{{ auth()->user()->name[0] }}</div>
                </div>--}}

            </div>
            {{ theme()->getView('partials/topbar/_user-menu') }}
            {{--end::Menu--}}
        </div>
    @endif
    {{--end::User --}}

    {{--begin::Heaeder menu toggle--}}
    @if(theme()->getOption('layout', 'header/left') === 'menu')
        <div class="d-flex align-items-center d-lg-none ms-2 me-n3" data-bs-toggle="tooltip" title="Show header menu">
            <div class="btn btn-icon btn-active-light-primary" id="kt_header_menu_mobile_toggle">
                {!! theme()->getSvgIcon("icons/duotune/text/txt001.svg", "svg-icon-1") !!}
            </div>
        </div>
    @endif
    {{--end::Heaeder menu toggle--}}
</div>
{{--end::Toolbar wrapper--}}
