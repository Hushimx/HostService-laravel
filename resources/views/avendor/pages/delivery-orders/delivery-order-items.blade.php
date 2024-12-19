@extends('avendor.dashboard.includes.master')

@section('css_adds')
    <style>
        #product_image_preview {
            max-height: 200px;
        }
    </style>
@endsection

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
            <p><span>{{ trans('main_trans.clientName') }}</span>: {{ $deliveryOrdersItems->clientName }}</p>
          </div>
          <div class="col-lg-6">
            <p><span>{{ trans('main_trans.clientNumber') }}</span>: {{ $deliveryOrdersItems->clientNumber }}</p>
          </div>
          <div class="col-lg-6">
            <p><span>{{ trans('main_trans.hotelName') }}</span>: {{ $deliveryOrdersItems->hotelName }}</p>
          </div>
          <div class="col-lg-6">
            <p><span>{{ trans('main_trans.paymentMethod') }}</span>: {{ $deliveryOrdersItems->paymentMethod }}</p>
          </div>
          @if ($deliveryOrdersItems->notes)
            <div class="col-lg-6">
              <p><span>{{ trans('main_trans.notes') }}</span>: {{ $deliveryOrdersItems->notes }}</p>
            </div>
          @endif
          <div class="col-lg-6">
            <p><span>{{ trans('main_trans.status') }}</span>: {{ $deliveryOrdersItems->status }}</p>
          </div>
          <div class="col-lg-6">
            <p><span>{{ trans('main_trans.total') }}</span>: {{ $deliveryOrdersItems->total }}</p>
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
            @foreach ($deliveryOrdersItems->deliveryOrderItemsVendor as $deliveryOrdersItem)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="font-w600 font-size-sm">{{ $deliveryOrdersItem->productTitle }}</td>
                <td class="font-w600 font-size-sm">{{ $deliveryOrdersItem->price }}</td>
                <td class="font-w600 font-size-sm">{{ $deliveryOrdersItem->quantity ? $deliveryOrdersItem->quantity : '' }}</td>
                <td class="font-w600 font-size-sm">{{ $deliveryOrdersItem->price * $deliveryOrdersItem->quantity }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

</main>
@endsection

@section('scripts')
  <script>
    $(document).ready(function() {
      $('.mag-img').magnificPopup({type:'image'});
    });
  </script>
  <script>
    // this script is responsible for previwing the image after user select it
    // Select the file input and the image preview element
    const imageInput = document.getElementById('product_image');
    const preview = document.getElementById('product_image_preview');

    // Add an event listener to handle when a file is selected
    imageInput.addEventListener('change', function () {
        // Check if a file is selected
        if (this.files && this.files[0]) {
            // Create a new FileReader instance
            const reader = new FileReader();

            // Define the onload function that will execute once the file is read
            reader.onload = function (e) {
                // Set the src of the image preview element to the file data
                preview.src = e.target.result;
                // Display the image element
                preview.style.display = 'block';
            };

            // Read the file as a data URL (base64 encoded string)
            reader.readAsDataURL(this.files[0]);
        } else {
            // If no file is selected, hide the image preview
            preview.style.display = 'none';
            preview.src = ''; // Clear the src attribute
        }
    });
  </script>
@endsection
