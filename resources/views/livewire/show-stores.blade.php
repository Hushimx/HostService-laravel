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
        <th class="text-center">{{ trans('main_trans.imageUrl') }}</th>
        <th class="text-center">{{ trans('main_trans.store_name') }}</th>
        <th class="text-center">{{ trans('main_trans.description') }}</th>
        <th class="text-center">{{ trans('main_trans.section') }}</th>
        <th class="text-center" style="width: 180px;">{{ trans('products.createdAt') }}</th>
        <th class="text-center" style="width: 180px;">{{ trans('grades.action') }}</th>
      </tr>
    </thead>
    <tbody id="tbody">
      @foreach ($stores as $store)
        <tr>
          <td class="text-center">{{ $loop->iteration }}</td>
          <td class="font-w600 font-size-sm text-center">
            @if ($store->imageUrl)
              @if (Storage::disk('store_images')->exists($store->imageUrl))
                <a href="{{ url('storage/store_images/'.$store->imageUrl) }}" class="img-link img-link-zoom-in d-block mx-auto mag-img">
                  <img class="img-thumb d-block mx-auto" src="{{ url('storage/store_images/'.$store->imageUrl) }}" alt="{{ $store->name }}" width="300px">
                </a>
              @else
                <a href="{{ url('storage/no-image.png') }}" class="img-link img-link-zoom-in d-block mx-auto mag-img">
                  <img class="img-thumb d-block mx-auto" src="{{ url('storage/no-image.png') }}" alt="{{ $store->name }}" width="300px">
                </a>
              @endif
            @else
              <a href="{{ url('storage/no-image.png') }}" class="img-link img-link-zoom-in d-block mx-auto mag-img">
                <img class="img-thumb d-block mx-auto" src="{{ url('storage/no-image.png') }}" alt="{{ $store->name }}" width="300px">
              </a>
            @endif
          </td>
          <td class="font-w600 font-size-sm text-center">{{ $store->name }}</td>
          <td class="font-w600 font-size-sm text-center">{{ $store->description ? $store->description : 'No description to show' }}</td>
          <td class="font-w600 font-size-sm text-center">{{ $store->section->name }}</td>
          <td class="font-w600 font-size-sm text-center">
            {{-- <span>{{ $product->createdAt }}</span> --}}
            <span class="d-block">{{ \Carbon\Carbon::parse($store->createdAt)->diffForHumans() }}</span>
            <span>{{ \Carbon\Carbon::parse($store->createdAt)->format('M d Y') }}</span>
          </td>
          <td class="font-w600 font-size-sm text-center">
            <a class="btn btn-alt-info mb-2 w-100" href="{{ route('products.store.index', $store->id) }}">
              <i class="fa fa-eye mr-1"></i>
              <span>Products</span>
            </a>
            <a class="btn btn-alt-primary w-100" href="{{ route('stores.edit', $store->id) }}">
              <i class="fa fa-edit mr-1"></i>
              <span>Edit</span>
            </a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  {{ $stores->links() }}
</div>
