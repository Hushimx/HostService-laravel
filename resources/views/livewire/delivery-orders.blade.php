<div>
  <div class="d-flex justify-content-center align-items-center mb-2">
    <input type="text" class="form-control mr-2" placeholder="Search..." wire:model.defer="searchKey" wire:keydown.enter="search">
    <button type="submit" wire:click="search" class="btn btn-primary d-flex align-items-center" wire:loading.class='btn-success' wire:loading.attr='disabled'>
      <span>Search</span>
      <div class="spinner-border spinner-border-sm text-light ml-2" role="status" wire:loading wire:target='search'>
        <span class="sr-only">Loading...</span>
      </div>
    </button>
  </div>
  <p class="mb-2">Current Search Key: {{ $searchKey }}</p>
  <table class="table table-responsive-xl table-bordered table-striped table-vcenter">
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
