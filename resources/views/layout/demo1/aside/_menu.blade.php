{{--begin::Aside Menu--}}
@php
    //$menu = bootstrap()->getAsideMenu();
    //\App\Core\Adapters\Menu::filterMenuPermissions($menu->items);
@endphp


<div
    class="hover-scroll-overlay-y my-5 my-lg-5"
    id="kt_aside_menu_wrapper"
    data-kt-scroll="true"
    data-kt-scroll-activate="{default: false, lg: true}"
    data-kt-scroll-height="auto"
    data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer"
    data-kt-scroll-wrappers="#kt_aside_menu"
    data-kt-scroll-offset="0"
>
    {{--begin::Menu--}}
    <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true">

        <div class="menu-item">
            <a class="menu-link {{ request()->routeIs('home') ? "active" : "" }}" href="{{ route('home') }}">
                <span class="menu-icon justify-content-center me-4">
                    <!--begin::Svg Icon | path: assets/media/icons/duotone/Design/PenAndRuller.svg-->
                    <span class="svg-icon svg-icon-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3"></path>
                            <path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000"></path>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span>
                <span class="menu-title">{{ __('Statistics') }}</span>
            </a>
        </div>

        <div class="menu-item">
            <div class="menu-content pt-8 pb-2">
                <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ __('APAP') }}</span>
            </div>
        </div>
        @hasrole('Staff|SuperAdmin')
            <div class="menu-item">
                <a class="menu-link {{ request()->routeIs('users.*') ? "active" : "" }}" href="{{ route('users.index') }}">
                    <span class="menu-icon justify-content-center me-4">
                        <i class="fas fa-user fa-lg"></i>
                    </span>
                    <span class="menu-title">{{ __('Users') }}</span>
                </a>
            </div>
        @endhasrole
        <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{request()->routeIs('associates.*') ? "show hover" : ""}}">
            <span class="menu-link">
               <span class="menu-icon justify-content-center me-4">
                    <i class="fas fa-users fa-lg"></i>
                </span>
                <span class="menu-title active">{{ __('Associates') }}</span>
                <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion menu-active-bg">
            {{--<div class="menu-sub menu-sub-accordion menu-active-bg" style="display: none; overflow: hidden;">--}}
                <div class="menu-item">

                    <a class="menu-link {{ request()->routeIs('associates.index',['show-all' =>1]) && !empty(request()->query('show-all')) && request()->query('show-all') == "1" ? "active" : "" }}" href="{{ route('associates.index',['show-all' =>1]) }}">
                        <span class="menu-icon justify-content-center me-4">
                            <i class="fas fa-users fa-lg"></i>
                        </span>
                        <span class="menu-title">{{ __('Todos') }}</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('associates.index') && empty(request()->query('show-all')) ? "active" : "" }}" href="{{ route('associates.index') }}">
                        <span class="menu-icon justify-content-center me-4">
                            <i class="fas fa-users fa-lg"></i>
                        </span>
                        <span class="menu-title">{{ __('Ativos') }}</span>
                    </a>
                </div>
                @if(auth()->user()->can('manageApp') || auth()->user()->can('accessAsCAC') )
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('associates.in_evaluation_index') ? "active" : "" }}" href="{{ route('associates.in_evaluation_index') }}">
                            <span class="menu-icon justify-content-center me-4">
                                <i class="fas fa-user-clock fa-lg"></i>
                            </span>
                            @if(!auth()->user()->hasRole('CAC') &&\App\Models\Associate::whereIn('status',[\App\Models\Associate::STATUS_WAITING_BASIC_APPROVAL,\App\Models\Associate::STATUS_WAITING_ADMIN_APPROVAL,\App\Models\Associate::STATUS_WAITING_APPROVAL_CAC])->count() > 0)
                                <span class="menu-title">{{ __('Associates in Evaluation') }} <span style="background-color: red;color:white;padding-left:6px;border-radius: 25px;padding-right: 6px;margin-left: 5px;">{{\App\Models\Associate::whereIn('status',[\App\Models\Associate::STATUS_WAITING_BASIC_APPROVAL,\App\Models\Associate::STATUS_WAITING_ADMIN_APPROVAL,\App\Models\Associate::STATUS_WAITING_APPROVAL_CAC])->count()}}</span></span>
                            @elseif(auth()->user()->hasRole('CAC') && \App\Models\Associate::whereIn('status',[\App\Models\Associate::STATUS_WAITING_APPROVAL_CAC])->count() > 0)
                                <span class="menu-title">{{ __('Associates in Evaluation') }} <span style="background-color: red;color:white;padding-left:8px;border-radius: 25px;padding-right: 8px;margin-left: 5px;">{{\App\Models\Associate::whereIn('status',[\App\Models\Associate::STATUS_WAITING_APPROVAL_CAC])->count()}}</span></span>
                            @elseif(auth()->user()->can('manageApp') && \App\Models\Associate::whereIn('status',[\App\Models\Associate::STATUS_WAITING_ADMIN_APPROVAL])->count() > 0)
                                <span class="menu-title">{{ __('Associates in Evaluation') }} <span style="background-color: red;color:white;padding-left:8px;border-radius: 25px;padding-right: 8px;margin-left: 5px;">{{\App\Models\Associate::whereIn('status',[\App\Models\Associate::STATUS_WAITING_ADMIN_APPROVAL])->count()}}</span></span>
                            @else
                                <span class="menu-title">{{ __('Associates in Evaluation') }}</span>
                            @endif

                        </a>
                    </div>
                @endif
            </div>
        </div>
        @if(auth()->user()->can('manageApp'))
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{request()->routeIs('declarations.*') || request()->routeIs('declaration_templates.*') ? "show hover" : ""}}">
                <span class="menu-link">
                    <span class="menu-icon justify-content-center me-4">
                        <i class="fas fa-file-alt fa-lg"></i>
                    </span>
                    <span class="menu-title active">{{ __('Declarations') }}</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion menu-active-bg" >
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('declarations.*') && !request()->routeIs('declarations.waiting_approval')  ? "active" : "" }}" href="{{ route('declarations.index') }}">
                            <span class="menu-icon justify-content-center me-4">
                                <i class="fas fa-file-alt fa-lg"></i>
                            </span>
                            <span class="menu-title">{{ __('Todas') }}</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('declarations.waiting_approval') ? "active" : "" }}" href="{{ route('declarations.waiting_approval') }}">
                        <span class="menu-icon justify-content-center me-4">
                            <i class="fas fa-file-signature fa-lg"></i>
                        </span>
                            @if(\App\Models\Declaration::where('status',\App\Models\Declaration::STATUS_WAITING_APPROVAL)->count() > 0)
                                <span class="menu-title">{{ __('Pendentes') }} <span style="background-color: red;color:white;padding-left:8px;border-radius: 25px;padding-right: 8px;margin-left: 5px;">{{\App\Models\Declaration::where('status',\App\Models\Declaration::STATUS_WAITING_APPROVAL)->count()}}</span></span>
                            @else
                                <span class="menu-title">{{ __('Pendentes') }}</span>
                            @endif
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('declaration_templates.*') ? "active" : "" }}" href="{{ route('declaration_templates.index') }}">
                        <span class="menu-icon justify-content-center me-4">
                            <i class="fas fa-folder-open fa-lg"></i>
                        </span>
                            <span class="menu-title">{{ __('Modelos') }}</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="menu-item">
                <a class="menu-link {{ request()->routeIs('orders.*') ? "active" : "" }}" href="{{ route('orders.index') }}">
                        <span class="menu-icon justify-content-center me-4">
                            <i class="far fa-credit-card fa-lg"></i>
                        </span>
                    <span class="menu-title">{{ __('Orders') }}</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link {{ request()->routeIs('contacts.*') ? "active" : "" }}" href="{{ route('contacts.index') }}">
                    <span class="menu-icon justify-content-center me-4">
                        <i class="fas fa-life-ring fa-lg"></i>
                    </span>
                    <span class="menu-title">{{ __('Centro de Ajuda') }}</span>
                </a>
            </div>
        @endif
        @if(!empty(auth()->user()->associate))
            <div class="menu-item">
                <div class="menu-content pt-8 pb-2">
                    <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ __('Associado') }}</span>
                </div>
            </div>
            <div class="menu-item">
                <a class="menu-link {{ request()->routeIs('associates.edit') && !request()->routeIs('associates.in_evaluation_index') ? "active" : "" }}" href="{{ route('associates.edit',auth()->user()->associate) }}">
                    <span class="menu-icon justify-content-center me-4">
                        <i class="fas fa-user-circle fa-lg"></i>
                    </span>
                    <span class="menu-title">{{ __('informação') }}</span>
                </a>
            </div>
            @if(!empty(auth()->user()->associate->company))
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('companies.edit') ? "active" : "" }}" href="{{ route('companies.edit',auth()->user()->associate) }}">
                    <span class="menu-icon justify-content-center me-4">
                        <i class="fas fa-life-ring fa-lg"></i>
                    </span>
                        <span class="menu-title">{{ __('Company Info') }}</span>
                    </a>
                </div>
            @else
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('companies.create') ? "active" : "" }}" href="{{ route('companies.create',['associate_id' => auth()->user()->associate->id]) }}">
                    <span class="menu-icon justify-content-center me-4">
                        <i class="fas fa-table fa-lg"></i>
                    </span>
                        <span class="menu-title">{{ __('Company Info') }}</span>
                    </a>
                </div>
            @endif
            @if(!empty(auth()->user()->associate->findAp))
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('find-aps.edit') ? "active" : "" }}" href="{{ route('find-aps.edit',[auth()->user()->associate->findAp,'associate_id' =>auth()->user()->associate->id]) }}">
                    <span class="menu-icon justify-content-center me-4">
                        <i class="fas fa-street-view fa-lg"></i>
                    </span>
                        <span class="menu-title">{{ __('Find Ap Info') }}</span>
                    </a>
                </div>
            @else
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('find-aps.create') ? "active" : "" }}" href="{{ route('find-aps.create',['associate_id' =>auth()->user()->associate->id]) }}">
                    <span class="menu-icon justify-content-center me-4">
                        <i class="fas fa-street-view fa-lg"></i>
                    </span>
                        <span class="menu-title">{{ __('Find Ap Info') }}</span>
                    </a>
                </div>
            @endif
            @if(!empty(auth()->user()->associate->quota_valid_until) && \Carbon\Carbon::parse(auth()->user()->associate->quota_valid_until)->gte(\Carbon\Carbon::today()) && auth()->user()->associate->category == \App\Models\Associate::CATEGORY_ASSOCIADO_EFETIVO)
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('declarations.index') ? "active" : "" }}" href="{{ route('declarations.index',['associate_id' =>auth()->user()->associate->id]) }}">
                    <span class="menu-icon justify-content-center me-4">
                        <i class="fas fa-file-import fa-lg"></i>
                    </span>
                        <span class="menu-title">{{ __('Declarations') }}</span>
                    </a>
                </div>
            @endif
            <div class="menu-item">
                <a class="menu-link {{ request()->routeIs('orders.index') ? "active" : "" }}" href="{{ route('orders.index',['associate_id' => auth()->user()->associate->id]) }}">
                <span class="menu-icon justify-content-center me-4">
                    <i class="fas fa-check-square fa-lg"></i>
                </span>
                    <span class="menu-title">{{ __('Orders') }}</span>
                </a>
            </div>
        @endif
        @can('adminFullApp')
            <div class="menu-item">
                <div class="menu-content pt-8 pb-2">
                    <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ __('Configurations') }}</span>
                </div>
            </div>
            <div class="menu-item">
                <a class="menu-link {{ request()->routeIs('settings.*') ? "active" : "" }}" href="{{ route('settings.index') }}">
                    <span class="menu-icon justify-content-center me-4">
                        <!--begin::Svg Icon | path: icons/duotone/general/gen019.svg-->
                        {!! theme()->getSvgIcon("icons/duotune/general/gen019.svg", "svg-icon-2") !!}
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-title">{{ __('Settings') }}</span>
                </a>
            </div>

            <div class="menu-item">
                <a class="menu-link {{ request()->routeIs('translations.*') ? "active" : "" }}" href="/translations">
                <span class="menu-icon justify-content-center me-4">
                    <!--begin::Svg Icon | path: icons/duotone/maps/map004.svg-->
                        {!! theme()->getSvgIcon("icons/duotune/maps/map004.svg", "svg-icon-2") !!}
                    <!--end::Svg Icon-->
                </span>
                    <span class="menu-title">{{ __('Translations') }}</span>
                </a>
            </div>
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('roles.*') ? "here show" : "" }}">
                <span class="menu-link">
                    <span class="menu-icon justify-content-center me-4">
                        <!--begin::Svg Icon | path: icons/duotone/Interface/Lock.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd" d="M3.11117 13.2288C3.27137 11.0124 5.01376 9.29156 7.2315 9.15059C8.55778 9.06629 10.1795 9 12 9C13.8205 9 15.4422 9.06629 16.7685 9.15059C18.9862 9.29156 20.7286 11.0124 20.8888 13.2288C20.9535 14.1234 21 15.085 21 16C21 16.915 20.9535 17.8766 20.8888 18.7712C20.7286 20.9876 18.9862 22.7084 16.7685 22.8494C15.4422 22.9337 13.8205 23 12 23C10.1795 23 8.55778 22.9337 7.23151 22.8494C5.01376 22.7084 3.27137 20.9876 3.11118 18.7712C3.04652 17.8766 3 16.915 3 16C3 15.085 3.04652 14.1234 3.11117 13.2288Z" fill="#12131A" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13 16.7324C13.5978 16.3866 14 15.7403 14 15C14 13.8954 13.1046 13 12 13C10.8954 13 10 13.8954 10 15C10 15.7403 10.4022 16.3866 11 16.7324V18C11 18.5523 11.4477 19 12 19C12.5523 19 13 18.5523 13 18V16.7324Z" fill="#12131A" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 6C7 3.23858 9.23858 1 12 1C14.7614 1 17 3.23858 17 6V10C17 10.5523 16.5523 11 16 11C15.4477 11 15 10.5523 15 10V6C15 4.34315 13.6569 3 12 3C10.3431 3 9 4.34315 9 6V10C9 10.5523 8.55228 11 8 11C7.44772 11 7 10.5523 7 10V6Z" fill="#12131A" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-title">{{ __('Roles') }}</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion menu-active-bg">
                    <div class="menu-item {{ request()->routeIs('roles.index') ? "active" : "" }}">
                        <a class="menu-link" href="{{ route('roles.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">{{ __('List roles') }}</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('permissions.index') ? "active" : "" }}" href="{{ route('permissions.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">{{ __('List permissions') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        @endcan
    </div>
    {{--end::Menu--}}
</div>
{{--end::Aside Menu--}}
