<!--begin::Menu-->
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <div class="menu-content d-flex align-items-center px-3">
            <!--begin::Avatar-->
            <div class="symbol symbol-50px me-5">
                @if(false)
                    <img alt="Logo" src="{{ auth()->user()->avatar_url }}"/>
                @endif
                <div class="symbol-label fs-2 fw-bold bg-primary text-inverse-primary">{{ auth()->user()->name[0] }}</div>
            </div>
            <!--end::Avatar-->

            <!--begin::Username-->
            <div class="d-flex flex-column">
                <div class="fw-bolder d-flex align-items-center fs-5">
                    {{ auth()->user()->name }}
                    <span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2"></span>
                </div>
                <a href="#" class="fw-bold text-muted text-hover-primary fs-7">{{ auth()->user()->email }}</a>
            </div>
            <!--end::Username-->
        </div>
    </div>
    <!--end::Menu item-->

    <!--begin::Menu separator-->
    <div class="separator my-2"></div>
    <!--end::Menu separator-->

    @if(!auth()->user()->can('accessAsUser') && !empty(auth()->user()->associate))
        <div class="menu-item px-5">
            <a href="{{ route('associates.edit', auth()->user()->associate) }}" class="menu-link px-5">
                {{ __('Ficha de Associado') }}
            </a>
        </div>
    @endif
    @if(!empty(auth()->user()->associate))
        <!--begin::Menu item-->
        <div class="menu-item px-5">
            <a href="{{ route('associates.preferential_contacts', auth()->user()->associate) }}" class="menu-link px-5">
                {{ __('Dados de Acesso') }}
            </a>
        </div>
    @else
        <div class="menu-item px-5">
            <a href="{{ route('users.edit', auth()->user()) }}" class="menu-link px-5">
                {{ __('Dados de Acesso') }}
            </a>
        </div>
    @endif
    <div class="menu-item px-5">
        <a href="{{ route('contacts.create') }}" class="menu-link px-5">
            {{ __('Centro de Ajuda') }}
        </a>
    </div>
    <!--end::Menu item-->
    @if(false)
        <!--begin::Menu item-->
        <div class="menu-item px-5" data-kt-menu-trigger="hover" data-kt-menu-placement="left-start" data-kt-menu-flip="center, top">
            <a href="#" class="menu-link px-5">
                <span class="menu-title">{{ __('My Subscription') }}</span>
                <span class="menu-arrow"></span>
            </a>

            <!--begin::Menu sub-->
            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-5">
                        {{ __('Referrals') }}
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-5">
                        {{ __('Billing') }}
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-5">
                        {{ __('Payments') }}
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="#" class="menu-link d-flex flex-stack px-5">
                        {{ __('Statements') }}

                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="View your statements"></i>
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu separator-->
                <div class="separator my-2"></div>
                <!--end::Menu separator-->

                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <div class="menu-content px-3">
                        <label class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input w-30px h-20px" type="checkbox" value="1" checked="checked" name="notifications"/>
                            <span class="form-check-label text-muted fs-7">
                                {{ __('Notifications') }}
                            </span>
                        </label>
                    </div>
                </div>
                <!--end::Menu item-->
            </div>
            <!--end::Menu sub-->
        </div>
        <!--end::Menu item-->

        <!--begin::Menu item-->
        <div class="menu-item px-5">
            <a href="#" class="menu-link px-5">
                {{ __('My Statements') }}
            </a>
        </div>
        <!--end::Menu item-->
    @endif

    <!--begin::Menu separator-->
    <div class="separator my-2"></div>
    <!--end::Menu separator-->

    @if(false)
        <!--begin::Menu item-->
        <div class="menu-item px-5" data-kt-menu-trigger="hover" data-kt-menu-placement="left-start" data-kt-menu-flip="center, top">
            <a href="#" class="menu-link px-5">
                <span class="menu-title position-relative">
                    {{ __('Language') }}

                    <span class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">
                        {{ __('English') }} <img class="w-15px h-15px rounded-1 ms-2" src="{{ asset(theme()->getMediaUrlPath() . 'flags/united-states.svg') }}" alt="metronic"/>
                    </span>
                </span>
            </a>

            <!--begin::Menu sub-->
            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="#" class="menu-link d-flex px-5 active">
                        <span class="symbol symbol-20px me-4">
                            <img class="rounded-1" src="{{ asset(theme()->getMediaUrlPath() . 'flags/united-states.svg') }}" alt="metronic"/>
                        </span>
                        {{ __('English') }}
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="#" class="menu-link d-flex px-5">
                        <span class="symbol symbol-20px me-4">
                            <img class="rounded-1" src="{{ asset(theme()->getMediaUrlPath() . 'flags/spain.svg') }}" alt="metronic"/>
                        </span>
                        {{ __('Spanish') }}
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="#" class="menu-link d-flex px-5">
                        <span class="symbol symbol-20px me-4">
                            <img class="rounded-1" src="{{ asset(theme()->getMediaUrlPath() . 'flags/germany.svg') }}" alt="metronic"/>
                        </span>
                        {{ __('German') }}
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="#" class="menu-link d-flex px-5">
                        <span class="symbol symbol-20px me-4">
                            <img class="rounded-1" src="{{ asset(theme()->getMediaUrlPath() . 'flags/japan.svg') }}" alt="metronic"/>
                        </span>
                        {{ __('Japanese') }}
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="#" class="menu-link d-flex px-5">
                        <span class="symbol symbol-20px me-4">
                            <img class="rounded-1" src="{{ asset(theme()->getMediaUrlPath() . 'flags/france.svg') }}" alt="metronic"/>
                        </span>
                        {{ __('French') }}
                    </a>
                </div>
                <!--end::Menu item-->
            </div>
            <!--end::Menu sub-->
        </div>
        <!--end::Menu item-->
    @endif

    @impersonating
        <!--begin::Menu item-->
        <div class="menu-item px-5 my-1">
            <a href="{{ route('impersonate.leave') }}" class="menu-link px-5">
                {{ __('Leave impersonation') }}
            </a>
        </div>
        <!--end::Menu item-->
    @endImpersonating

    <!--begin::Menu item-->
    <div class="menu-item px-5">
        <a href="#" data-action="{{ route('logout') }}" data-method="post" data-csrf="{{ csrf_token() }}" data-reload="true" class="button-ajax menu-link px-5">
            {{ __('Logout') }}
        </a>
    </div>
    <!--end::Menu item-->

    @if (theme()->isDarkModeEnabled())
        <!--begin::Menu separator-->
        <div class="separator my-2"></div>
        <!--end::Menu separator-->

        <!--begin::Menu item-->
        <div class="menu-item px-5">
            <div class="menu-content px-5">
                <label class="form-check form-switch form-check-custom form-check-solid pulse pulse-success" for="kt_user_menu_dark_mode_toggle">
                    <input class="form-check-input w-30px h-20px" type="checkbox" value="1" name="skin" id="kt_user_menu_dark_mode_toggle" {{ theme()->isDarkMode() ? 'checked' : '' }} data-kt-url="{{ theme()->getPageUrl('index', '', theme()->isDarkMode() ? '' : 'dark') }}"/>
                    <span class="pulse-ring ms-n1"></span>

                    <span class="form-check-label text-gray-600 fs-7">
                        {{ __('Dark Mode') }}
                    </span>
                </label>
            </div>
        </div>
        <!--end::Menu item-->
    @endif
</div>
<!--end::Menu-->
