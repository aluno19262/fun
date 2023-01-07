@if ( /*theme()->getOption('layout', 'page-title/breadcrumb') === true &&*/ !empty($breadcrumbs))
    @if (theme()->getOption('layout', 'page-title/direction') === 'row' && !empty($pageTitle) && (!isset($hideSubHeader) || $hideSubHeader != true))
        <!--begin::Separator-->
        <span class="h-20px border-gray-200 border-start mx-4"></span>
        <!--end::Separator-->
    @endif
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-line fw-bold fs-7 my-1">

        @foreach ($breadcrumbs as $breadcrumb)
            @if(!empty($breadcrumb->isHome))
                <li class="breadcrumb-item text-muted text-hover-primary"><a href="{{ $breadcrumb->url }}">{!! theme()->getSvgIcon("icons/duotune/general/gen001.svg", "svg-icon-1 text-hover-primary") !!}</a></li>
            @else
                @if ($breadcrumb->url && !$loop->last)
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ $breadcrumb->url }}" class="text-muted text-hover-primary">
                            {{ $breadcrumb->title }}
                        </a>
                    </li>
                @else
                    <li class="breadcrumb-item text-dark">
                        {{ $breadcrumb->title }}
                    </li>
                @endif
            @endif
        @endforeach
    </ul>
    <!--end::Breadcrumb-->
@endif
