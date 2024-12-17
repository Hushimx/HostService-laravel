<!DOCTYPE html>
<html lang="en">
  <head>
    {{-- meta tags --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- needed for ajax codes  --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('front/imgs/icons/logo.webp') }}">
    <!-- Google Fonts Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Google English Font Tag -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300&display=swap" rel="stylesheet">
    <!-- Google Arabic Font Tag -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic&display=swap" rel="stylesheet">
    {{-- title --}}
    <title>@yield('pageTitle')</title>
    {{-- <meta name="description" content="In ArabicU Institute we help you to profoundly learn and understand allah's message through our professional handpicked online arabic and quran tutors" />
    <meta property="og:title" content="ArabicU Institute" /> --}}
    {{-- css adds --}}
    <link rel="stylesheet" href="{{ asset('front/css/bootstrap.min.css') }}" async />
    <link rel="stylesheet" href="{{ asset('front/css/all.min.css') }}" async />
    <link rel="stylesheet" href="{{ asset('front/css/aos.css') }}" async />
    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}" async />

    @yield('css_adds')
    @livewireStyles
  </head>
  <body>




