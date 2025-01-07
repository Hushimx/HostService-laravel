@extends('avendor.dashboard.includes.master')

@section('content')
<!-- Main Container -->
<main id="main-container">

  <!-- Hero Section -->
  <x-hero>
    <x-slot name="title">
      {{ trans('main_trans.view') }} <small class="font-size-base font-w400 text-muted">{{ trans('main_trans.delivery-orders-items') }}</small>
    </x-slot>
    <li class="breadcrumb-item" aria-current="page">
      <a class="link-fx" href="{{ route('vendor.dashboard') }}">{{ trans('main_trans.Dashboard_page') }}</a>
    </li>
    <li class="breadcrumb-item">{{ trans('main_trans.view') }} {{ trans('main_trans.delivery-orders-items') }}</li>
  </x-hero>

  <!-- Order Details Section -->
  <div class="content">
    <div class="block block-rounded">
      <div class="block-content block-content-full">
        <div class="bg-light p-3 rounded mb-4">
          <h3 class="font-w700 mb-3 text-center {{ App::getLocale() == 'ar' ? 'text-right' : '' }}">{{ trans('main_trans.delivery_order_info') }}</h3>
          <div class="row" {{ App::getLocale() == 'ar' ? 'dir=rtl' : '' }}>
            @foreach ([
              'clientName' => $deliveryOrdersItems->deliveryOrder->clientName,
              'clientNumber' => $deliveryOrdersItems->deliveryOrder->clientNumber,
              'hotelName' => $deliveryOrdersItems->deliveryOrder->hotelName,
              'paymentMethod' => $deliveryOrdersItems->deliveryOrder->paymentMethod,
              'notes' => $deliveryOrdersItems->deliveryOrder->notes,
              'status' => $deliveryOrdersItems->deliveryOrder->status,
              'total' => $deliveryOrdersItems->deliveryOrder->total
            ] as $key => $value)
              @if ($value || $key !== 'notes')
                <div class="col-lg-6 mb-2">
                  <p><strong>{{ trans("main_trans.$key") }}</strong>: <span class="text-secondary">{{ $value }}</span></p>
                </div>
              @endif
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Items Table Section -->
  <div class="content">
    <div class="block block-rounded">
      <div class="block-content block-content-full">
        <x-alert /> <!-- Display errors and alerts -->
        <h3 class="font-w700 mb-4 text-center">{{ trans('main_trans.order_items') }}</h3>
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-vcenter">
            <thead class="thead-dark">
              <tr>
                @foreach ([
                  'ID' => '60px',
                  'productTitle' => null,
                  'price' => null,
                  'quantity' => null,
                  'total' => null
                ] as $key => $width)
                  <th class="text-center" style="width: {{ $width }};">{{ trans("main_trans.$key") }}</th>
                @endforeach
              </tr>
            </thead>
            <tbody>
              <tr>
                @foreach ([
                  $deliveryOrdersItems->id,
                  $deliveryOrdersItems->productTitle,
                  $deliveryOrdersItems->price,
                  $deliveryOrdersItems->quantity ?: '',
                  $deliveryOrdersItems->price * $deliveryOrdersItems->quantity
                ] as $value)
                  <td class="text-center font-w600">{{ $value }}</td>
                @endforeach
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <style>
    .content {
      padding: 20px;
    }
    .bg-light {
      background-color: #f8f9fa;
    }
    .table th, .table td {
      vertical-align: middle;
    }
    .thead-dark th {
      background-color: #343a40;
      color: #fff;
    }
    .text-secondary {
      color: #6c757d;
    }
  </style>

</main>
@endsection
