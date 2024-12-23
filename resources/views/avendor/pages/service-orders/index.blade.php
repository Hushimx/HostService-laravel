@extends('avendor.dashboard.includes.master')

@section('content')
<!-- Main Container -->
<main id="main-container">
  <!-- Hero -->
  <x-hero>
    <x-slot name="title">
      {{ trans('main_trans.view') }} <small class="font-size-base font-w400 text-muted">{{ trans('main_trans.service-orders') }}</small>
    </x-slot>
    <li class="breadcrumb-item" aria-current="page">
      <a class="link-fx" href="{{ route('vendor.dashboard') }}">{{ trans('main_trans.Dashboard_page') }}</a>
    </li>
    <li class="breadcrumb-item">{{ trans('products.manage') }} {{ trans('main_trans.service-orders') }}</li>
  </x-hero>

  <!-- Page Content -->
  <div class="content">
    <div class="block block-rounded">
      <div class="block-content block-content-full">
        {{-- errors And Alerts --}}
        <x-alert />
        @livewire('service-orders')
      </div>
    </div>
  </div>

</main>
@endsection

