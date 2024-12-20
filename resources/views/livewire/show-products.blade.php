<div>
  <div class="d-flex justify-content-center align-items-center mb-2">
    <input type="text" class="form-control mr-2" placeholder="Search..." wire:model.defer="searchKey">
    <button type="submit" wire:click="search" class="btn btn-primary">Search</button>
  </div>
  <p class="mb-2">Current Search Key: {{ $searchKey }}</p>
  <table class="table table-responsive-xl table-bordered table-striped table-vcenter">
    <thead>
      <tr>
        <th class="text-center" style="width: 60px;">ID</th>
        <th class="text-center">{{ trans('products.name') }}</th>
        <th class="text-center">{{ trans('products.image') }}</th>
        <th class="text-center">{{ trans('products.price') }}</th>
        <th class="text-center" style="width: 155px;">{{ trans('products.approve') }}</th>
        <th class="text-center">{{ trans('products.category') }}</th>
        <th class="text-center" style="width: 180px;">{{ trans('products.createdAt') }}</th>
        <th class="text-center">{{ trans('grades.action') }}</th>
      </tr>
    </thead>
    <tbody id="tbody">
      @foreach ($products as $product)
        <tr>
          <td class="text-center">{{ $loop->iteration }}</td>
          <td class="font-w600 font-size-sm">{{ $product->name }}</td>
          <td class="font-w600 font-size-sm">
            @if ($product->image)
              <a href="{{ url('storage/'. $product->image)  }}" class="img-link img-link-zoom-in d-block mx-auto mag-img">
                <img class="img-thumb d-block mx-auto" src="{{ url('storage/'. $product->image)  }}" alt="{{ $product->text }}" width="300px">
              </a>
            @else
              <a href="{{ url('storage/no-image.png') }}" class="img-link img-link-zoom-in d-block mx-auto mag-img">
                <img class="img-thumb d-block mx-auto" src="{{ url('storage/no-image.png') }}" alt="{{ $product->name }}" width="300px">
              </a>
            @endif
          </td>
          <td class="font-w600 font-size-sm">{{ $product->price }}</td>
          <td class="font-w600 font-size-sm text-white text-center">
            <span @if ($product->aproved) class='bg-success p-1 rounded d-block' @else class='bg-danger p-1 rounded d-block' @endif>
              @if ($product->aproved) <i class="fa fa-fw fa-check-circle fa-fw mr-1"></i>
              @else <i class="fa fa-fw fa-times-circle fa-fw mr-1"></i> @endif
              {{ $product->aproved ? trans('products.approve') : trans('courses.needApprove') }}
            </span>
          </td>
          <td class="font-w600 font-size-sm text-center">
              @if ($product->category)
                  {{ $product->category->name }}
              @else
                  {{ trans('products.no-category') }}
              @endif
          </td>
          <td class="font-w600 font-size-sm text-center">
              {{-- <span>{{ $product->createdAt }}</span> --}}
              <span class="d-block">{{ \Carbon\Carbon::parse($product->created_at)->diffForHumans() }}</span>
              <span>{{ \Carbon\Carbon::parse($product->created_at)->format('M d Y') }}</span>
          </td>
          <td>
            <div class="d-flex flex-column justify-content-start align-items-stretch">
              <a class="btn btn-sm btn-primary d-flex align-items-baseline mb-1" href="{{ route('products.edit', $product) }}"
                data-toggle="tooltip" data-placement="left" title="Edit this product"
              >
                <i class="fa fa-edit fa-fw mr-1"></i>{{ trans('students.edit') }}
              </a>
              <button type="button" class="btn btn-sm btn-danger d-flex align-items-baseline"
                  data-toggle="modal" data-target="#modal-delete-product{{$product->id}}">
                <i class="fa fa-times fa-fw mr-1"></i>{{ trans('products.delete') }}
              </button>
            </div>
          </td>
        </tr>
        <!-- start delete modal Content -->
        <div class="modal fade" id="modal-delete-product{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-block-large" aria-hidden="true">
          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                  <h3 class="block-title">{{ trans('products.delete_product') }}</h3>
                  <div class="block-options">
                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                      <i class="fa fa-fw fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="block-content font-size-sm">
                  {{-- start form --}}
                  <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="page" value="{{ $products->currentPage() }}">
                    <div class="row">
                      <div class="col-lg-12 col-xl-12">
                        <div class="form-group text-center">
                          <p>{{ trans('grades.before_delete_alert') }}</p>
                          <p><strong>{{$product->name}}</strong></p>
                        </div>
                      </div>
                      <div class="block-content text-center border-top">
                        <div class="form-group">
                          <button type="submit" class="btn btn-md btn-danger">
                            <i class="fa fa-fw fa-times mr-1"></i> {{ trans('grades.yes') }}
                          </button>
                          <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">{{ trans('grades.no') }}</button>
                        </div>
                      </div>
                    </div>
                    </form>
                    {{-- End form --}}
                  </div>
              </div>
            </div>
          </div>
        </div>
        <!-- END delete modal Content -->
      @endforeach
    </tbody>
  </table>
  <!-- END Dynamic Table Full -->
  {{ $products->links() }}

</div>
