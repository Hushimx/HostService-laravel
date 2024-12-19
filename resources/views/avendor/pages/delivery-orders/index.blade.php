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
      {{ trans('main_trans.view') }} <small class="font-size-base font-w400 text-muted">{{ trans('main_trans.delivery-orders') }}</small>
    </x-slot>
    <li class="breadcrumb-item" aria-current="page">
      <a class="link-fx" href="{{ route('vendor.dashboard') }}">{{ trans('main_trans.Dashboard_page') }}</a>
    </li>
    <li class="breadcrumb-item">{{ trans('products.manage') }} {{ trans('products.products') }}</li>
  </x-hero>

  <!-- Page Content -->
  <div class="content">
    <div class="block block-rounded">
      <div class="block-content block-content-full">

        {{-- errors And Alerts --}}
        <x-alert />
        <!--
            DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js
            which was auto compiled from _js/pages/be_tables_datatables.js
        -->
        <table class="table table-responsive-xl table-bordered table-striped table-vcenter js-dataTable-full">
          <thead>
            <tr>
              <th class="text-center" style="width: 60px;">ID</th>
              <th class="text-center">{{ trans('main_trans.clientName') }}</th>
              <th class="text-center">{{ trans('main_trans.city') }}</th>
              <th class="text-center">{{ trans('main_trans.hotelName') }}</th>
              <th class="text-center">{{ trans('main_trans.storeSlug') }}</th>
              <th class="text-center">{{ trans('main_trans.notes') }}</th>
              <th class="text-center">{{ trans('main_trans.status') }}</th>
              <th class="text-center">{{ trans('products.createdAt') }}</th>
              <th class="text-center" style="width: 180px;">{{ trans('grades.action') }}</th>
            </tr>
          </thead>
          <tbody id="tbody">
            @foreach ($deliveryOrders as $order)
              @if ($order->deliveryOrder)
              <tr>
                <td class="text-center">{{ $order->deliveryOrder->id }}</td>
                <td class="font-w600 font-size-sm">{{ $order->deliveryOrder->clientName }}</td>
                <td class="font-w600 font-size-sm">{{ $order->city->name }}</td>
                <td class="font-w600 font-size-sm">{{ $order->deliveryOrder->hotelName }}</td>
                <td class="font-w600 font-size-sm">{{ $order->deliveryOrder->storeSlug }}</td>
                <td class="font-w600 font-size-sm">{{ $order->deliveryOrder->notes ? $order->deliveryOrder->notes : 'no notes' }}</td>
                <td class="font-w600 font-size-sm text-white text-center">
                <span @if ($order->deliveryOrder->status) class='bg-success p-1 rounded d-block' @else class='bg-danger p-1 rounded d-block' @endif>
                  @if ($order->deliveryOrder->status)
                    {{ $order->deliveryOrder->status }}
                  @else
                    {{ 'No Status Available' }}
                  @endif
                </span>
                </td>
                <td class="font-w600 font-size-sm text-center">
                  {{-- <span>{{ $product->createdAt }}</span> --}}
                  <span class="d-block">{{ \Carbon\Carbon::parse($order->deliveryOrder->createdAt)->diffForHumans() }}</span>
                  <span>{{ \Carbon\Carbon::parse($order->deliveryOrder->updatedAt)->format('M d Y') }}</span>
                </td>
                <td class="font-w600 font-size-sm">
                  <a class="btn btn-primary d-block m-auto" href="{{ route('deliveryOrders.deliveryOrderItems', $order->orderId) }}">
                    {{ trans('main_trans.delivery-orders-items') }}
                  </a>
                </td>
              </tr>
              @endif
            @endforeach
          </tbody>
        </table>
        <!-- END Dynamic Table Full -->
        {{ $deliveryOrders->links() }}
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

