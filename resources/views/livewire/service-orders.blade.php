<div>
  {{-- search --}}
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
  {{-- table --}}
  <table class="table table-responsive-xl table-bordered table-striped table-vcenter">
    <thead>
      <tr>
        <th class="text-center" style="width: 60px;">ID</th>
        <th class="text-center">{{ trans('main_trans.roomNumber') }}</th>
        <th class="text-center">{{ trans('main_trans.hotelName') }}</th>
        <th class="text-center">{{ trans('main_trans.status') }}</th>
        <th class="text-center">{{ trans('main_trans.notes') }}</th>
        <th class="text-center">{{ trans('main_trans.total') }}</th>
        <th class="text-center" style="width: 180px;">{{ trans('products.createdAt') }}</th>
      </tr>
    </thead>
    <tbody id="tbody">
      @foreach ($vendorServiceOrders as $serviceOrders)
        <tr>
          <td class="text-center">{{ $loop->iteration }}</td>
          <td class="font-w600 font-size-sm text-center">{{ $serviceOrders->room->roomNumber }}</td>
          <td class="font-w600 font-size-sm text-center">{{ $serviceOrders->room->hotel->name }}</td>
          <td class="font-w600 font-size-sm text-white text-center">
            <span @if ($serviceOrders->status) class='bg-success p-1 rounded d-block' @else class='bg-danger p-1 rounded d-block' @endif>
              @if ($serviceOrders->status) <i class="fa fa-fw fa-check-circle fa-fw mr-1"></i>
              @else <i class="fa fa-fw fa-times-circle fa-fw mr-1"></i> @endif
              {{ $serviceOrders->status ? trans('products.approve') : trans('courses.needApprove') }}
            </span>
          </td>
          <td class="font-w600 font-size-sm text-center">{{ $serviceOrders->notes ? $serviceOrders->notes : 'No Notes to show' }}</td>
          <td class="font-w600 font-size-sm text-center">{{ $serviceOrders->total }}</td>
          <td class="font-w600 font-size-sm text-center">
            {{-- <span>{{ $product->createdAt }}</span> --}}
            <span class="d-block">{{ \Carbon\Carbon::parse($serviceOrders->createdAt)->diffForHumans() }}</span>
            <span>{{ \Carbon\Carbon::parse($serviceOrders->createdAt)->format('M d Y') }}</span>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  <!-- END Dynamic Table Full -->
  {{ $vendorServiceOrders->links() }}

</div>
