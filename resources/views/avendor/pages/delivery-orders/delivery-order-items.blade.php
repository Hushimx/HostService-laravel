@extends('avendor.dashboard.includes.master')

@section('content')
<!-- Main Container -->
<main id="main-container">
  <!-- Hero -->
  <x-hero>
    <x-slot name="title">
      {{ trans('main_trans.view') }} <small class="font-size-base font-w400 text-muted">{{ trans('main_trans.delivery-orders-items') }}</small>
    </x-slot>
    <li class="breadcrumb-item" aria-current="page">
      <a class="link-fx" href="{{ route('vendor.dashboard') }}">{{ trans('main_trans.Dashboard_page') }}</a>
    </li>
    <li class="breadcrumb-item">{{ trans('main_trans.view') }} {{ trans('main_trans.delivery-orders-items') }}</li>
  </x-hero>

  <!-- Page Content -->
  <div class="content">
    <div class="block block-rounded">
      <div class="block-content block-content-full">
        <h2 class="content-heading mb-4 @if (App::getLocale() == 'ar') text-right @endif">{{ trans('main_trans.delivery_order_info') }}</h2>
        <div class="row" @if (App::getLocale() == 'ar') dir="rtl" @endif>
          <div class="col-lg-6">
            <p><span>{{ trans('main_trans.clientName') }}</span>: {{ $deliveryOrdersItems->deliveryOrder->clientName }}</p>
          </div>
          <div class="col-lg-6">
            <p><span>{{ trans('main_trans.clientNumber') }}</span>: {{ $deliveryOrdersItems->deliveryOrder->clientNumber }}</p>
          </div>
          <div class="col-lg-6">
            <p><span>{{ trans('main_trans.hotelName') }}</span>: {{ $deliveryOrdersItems->deliveryOrder->hotelName }}</p>
          </div>
          <div class="col-lg-6">
            <p><span>{{ trans('main_trans.paymentMethod') }}</span>: {{ $deliveryOrdersItems->deliveryOrder->paymentMethod }}</p>
          </div>
          @if ($deliveryOrdersItems->notes)
            <div class="col-lg-6">
              <p><span>{{ trans('main_trans.notes') }}</span>: {{ $deliveryOrdersItems->deliveryOrder->notes }}</p>
            </div>
          @endif
          <div class="col-lg-6">
            <p><span>{{ trans('main_trans.status') }}</span>: {{ $deliveryOrdersItems->deliveryOrder->status }}</p>
          </div>
          <div class="col-lg-6">
            <p><span>{{ trans('main_trans.total') }}</span>: {{ $deliveryOrdersItems->deliveryOrder->total }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Page Content -->
  <div class="content">
    <div class="block block-rounded">
      <div class="block-content block-content-full">
        <x-alert /> {{-- errors And Alerts --}}
        <!--
            DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js
            which was auto compiled from _js/pages/be_tables_datatables.js
        -->
        <table class="table table-responsive-xl table-bordered table-striped table-vcenter js-dataTable-full">
          <thead>
            <tr>
              <th class="text-center" style="width: 60px;">ID</th>
              <th class="text-center">{{ trans('main_trans.productTitle') }}</th>
              <th class="text-center">{{ trans('main_trans.price') }}</th>
              <th class="text-center">{{ trans('main_trans.quantity') }}</th>
              <th class="text-center">{{ trans('main_trans.total') }}</th>
            </tr>
          </thead>
          <tbody id="tbody">
            <tr>
              <td class="text-center">{{ $deliveryOrdersItems->id }}</td>
              <td class="font-w600 font-size-sm">{{ $deliveryOrdersItems->productTitle }}</td>
              <td class="font-w600 font-size-sm">{{ $deliveryOrdersItems->price }}</td>
              <td class="font-w600 font-size-sm">{{ $deliveryOrdersItems->quantity ? $deliveryOrdersItems->quantity : '' }}</td>
              <td class="font-w600 font-size-sm">{{ $deliveryOrdersItems->price * $deliveryOrdersItems->quantity }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</main>
@endsection

