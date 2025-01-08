<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>Mr Hashim</title>

        <meta name="description" content="Admin Mahmoud Yousry">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">

        <!-- Open Graph Meta -->
        {{-- <meta property="og:title" content="Admin Mr Mahmoud Yousry">
        <meta property="og:site_name" content="Admin Mr Mahmoud Yousry">
        <meta property="og:description" content="Admin Mr Mahmoud Yousry">
        <meta property="og:type" content="website">
        <meta property="og:url" content="">
        <meta property="og:image" content=""> --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="{{asset('dashboard/assets/media/favicons/favicon.png')}}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{asset('dashboard/assets/media/favicons/favicon-192x192.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{asset('dashboard/assets/media/favicons/apple-touch-icon-180x180.png')}}">

        <!-- Page JS Plugins CSS Like dataTables -->
        <link rel="stylesheet" href="{{ asset('dashboard/assets/js/plugins/magnific-popup/magnific-popup.css') }}">
        <link rel="stylesheet" href="{{ asset('dashboard/assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
        <link rel="stylesheet" href="{{ asset('dashboard/assets/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
        {{-- start Editor Plugn  --}}
        <link rel="stylesheet" href="{{ asset('dashboard/assets/js/plugins/summernote/summernote-bs4.css') }} ">
        <link rel="stylesheet" href="{{ asset('dashboard/assets/js/plugins/simplemde/simplemde.min.css') }} ">

        <!-- Stylesheets -->
        <!-- Fonts and OneUI framework -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
        <link rel="stylesheet" id="css-main" href="{{asset('dashboard/assets/css/oneui.min.css')}}">

        <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
        <link rel="stylesheet" id="css-theme" href="{{asset('dashboard/assets/css/themes/amethyst.min.css')}}">
        <!-- Custom Styles -->
        <link rel="stylesheet" href="{{asset('assests/css/customStyles.css')}}">

        @livewireStyles
        @yield('css_adds')
        <!-- END Stylesheets -->
    </head>
    <body>
        <!-- Page Container -->
        <!--
            Available classes for #page-container:

        GENERIC

            'enable-cookies'                            Remembers active color theme between pages (when set through color theme helper Template._uiHandleTheme())

        SIDEBAR & SIDE OVERLAY

            'sidebar-r'                                 Right Sidebar and left Side Overlay (default is left Sidebar and right Side Overlay)
            'sidebar-mini'                              Mini hoverable Sidebar (screen width > 991px)
            'sidebar-o'                                 Visible Sidebar by default (screen width > 991px)
            'sidebar-o-xs'                              Visible Sidebar by default (screen width < 992px)
            'sidebar-dark'                              Dark themed sidebar

            'side-overlay-hover'                        Hoverable Side Overlay (screen width > 991px)
            'side-overlay-o'                            Visible Side Overlay by default

            'enable-page-overlay'                       Enables a visible clickable Page Overlay (closes Side Overlay on click) when Side Overlay opens

            'side-scroll'                               Enables custom scrolling on Sidebar and Side Overlay instead of native scrolling (screen width > 991px)

        HEADER

            ''                                          Static Header if no class is added
            'page-header-fixed'                         Fixed Header

        HEADER STYLE

            ''                                          Light themed Header
            'page-header-dark'                          Dark themed Header

        MAIN CONTENT LAYOUT

            ''                                          Full width Main Content if no class is added
            'main-content-boxed'                        Full width Main Content with a specific maximum width (screen width > 1200px)
            'main-content-narrow'                       Full width Main Content with a percentage width (screen width > 1200px)
        -->

        @if (App::getLocale() == 'en')
            <?php $lang_theme = 'block-header-default'; ?>
        @else
            <?php $lang_theme = 'block-header-rtl text-right dir-rtl'; ?>
        @endif
