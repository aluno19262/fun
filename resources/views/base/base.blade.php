<!DOCTYPE html>
{{--
Product Name: {{ theme()->getOption('product', 'description') }}
Author: Noop
Purchase: {{ theme()->getOption('product', 'purchase') }}
Website: https://noop.pt
Contact: dev@noop.pt
License: {{ theme()->getOption('product', 'license') }}
--}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    {!! theme()->printHtmlAttributes('html') !!} {{ theme()->printHtmlClasses('html') }}>
    {{-- begin::Head --}}
    <head>
        <meta charset="utf-8"/>
        @if (!empty($pageTitle))
            <title>{{ $pageTitle }}</title>
        @else
            <title>@yield('title', config('app.name', 'Laravel'))</title>
        @endif
        <meta name="description" content="@yield('page_description', $pageDescription ?? '')"/>
        <meta name="keywords" content="{{ theme()->getOption('meta', 'keywords') }}"/>
        <link rel="canonical" href="{{ ucfirst(theme()->getOption('meta', 'canonical')) }}"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link rel="shortcut icon" href="{{ asset(theme()->getDemo() . '/' .theme()->getOption('assets', 'favicon')) }}"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- begin::Fonts --}}
        {{ theme()->includeFonts() }}
        {{-- end::Fonts --}}

        @stack('firstStyles')

        @if (theme()->hasOption('page', 'assets/vendors/css'))
            {{-- begin::Page Vendor Stylesheets(used by this page) --}}
            @foreach (theme()->getOption('page', 'assets/vendors/css') as $file)
                <link href="{{ assetCustom($file) }}" rel="stylesheet" type="text/css"/>
            @endforeach
            {{-- end::Page Vendor Stylesheets --}}
        @endif

        @if (theme()->hasOption('page', 'assets/custom/css'))
            {{-- begin::Page Custom Stylesheets(used by this page) --}}
            @foreach (theme()->getOption('page', 'assets/custom/css') as $file)
                <link href="{{ assetCustom($file) }}" rel="stylesheet" type="text/css"/>
            @endforeach
            {{-- end::Page Custom Stylesheets --}}
        @endif

        @if (theme()->hasOption('assets', 'css'))
            {{-- begin::Global Stylesheets Bundle(used by all pages) --}}
            @foreach (theme()->getOption('assets', 'css') as $file)
                <link href="{{ assetCustom($file) }}" rel="stylesheet" type="text/css"/>
            @endforeach
            {{-- end::Global Stylesheets Bundle --}}
        @endif
        <link href="{{ asset('custom-css/app.css') }}?v=1" rel="stylesheet" type="text/css" >

        @stack('styles')

    </head>
    {{-- end::Head --}}

    {{-- begin::Body --}}
    <body {!! theme()->printHtmlAttributes('body') !!} {!! !empty(auth()->user()) && auth()->user()->can('accessAsUser') && !auth()->user()->canAny(['accessAsCAC','manageApp']) ? str_replace('aside-enabled aside-fixed','',theme()->printHtmlClasses('body'))  : theme()->printHtmlClasses('body')!!} {!! theme()->printCssVariables('body') !!}>

        @if (theme()->getOption('layout', 'loader/display') === true)
            {{ theme()->getView('layout/_loader') }}
        @endif

        @yield('content')

        {{-- begin::Javascript --}}
        @if (theme()->hasOption('assets', 'js'))
            {{-- begin::Global Javascript Bundle(used by all pages) --}}
            @foreach (theme()->getOption('assets', 'js') as $file)
                <script src="{{ asset(theme()->getDemo() . '/' .$file) }}"></script>
            @endforeach
            {{-- end::Global Javascript Bundle --}}
        @endif

        @if (theme()->hasOption('page', 'assets/vendors/js'))
            {{-- begin::Page Vendors Javascript(used by this page) --}}
            @foreach (theme()->getOption('page', 'assets/vendors/js') as $file)
                <script src="{{ asset(theme()->getDemo() . '/' .$file) }}"></script>
            @endforeach
            {{-- end::Page Vendors Javascript --}}
        @endif

        @if (theme()->hasOption('page', 'assets/custom/js'))
            {{-- begin::Page Custom Javascript(used by this page) --}}
            @foreach (theme()->getOption('page', 'assets/custom/js') as $file)
                <script src="{{ asset(theme()->getDemo() . '/' .$file) }}"></script>
            @endforeach
            {{-- end::Page Custom Javascript --}}
        @endif
        {{-- end::Javascript --}}
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-206097757-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-206097757-1');
        </script>

        @stack('scripts')
    </body>
    {{-- end::Body --}}
</html>
