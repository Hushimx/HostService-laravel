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
      {{ trans('products.manage') }} <small class="font-size-base font-w400 text-muted">{{ trans('products.products') }}</small>
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
        <!-- start add button -->
        <button type="button" class="btn btn-success btn-sm mr-1 mb-3" data-toggle="modal" data-target="#modal-add-product">
          <i class="fa fa-fw fa-plus mr-1"></i> {{ trans('products.add_product') }}
        </button>
        <!-- END add button -->
        <!-- start add modal Content -->
        <div class="modal fade" id="modal-add-product" tabindex="-1" role="dialog" aria-labelledby="modal-block-large" aria-hidden="true">
          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                  <h3 class="block-title">{{ trans('products.add_product') }}</h3>
                  <div class="block-options">
                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close" id="closeModal">
                      <i class="fa fa-fw fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="block-content font-size-sm py-0">
                  <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="row my-block p-3">
                        {{-- name --}}
                        <div class="col-xl-12">
                          <div class="form-group mb-3">
                            <label for="name">{{ trans('products.name') }}</label>
                            <input type="text" class="form-control form-control-alt" id="name"
                              name="name" placeholder="{{ trans('products.name') }}" value="{{ old('name') }}">
                          </div>
                        </div>
                        {{-- image --}}
                        <div class="col-xl-12 mb-3">
                            <div class="form-group mb-3">
                                <label>{{ trans('products.image') }}</label>
                                <div class="custom-file">
                                <input type="file" class="custom-file-input" data-toggle="custom-file-input" accept="image/*"
                                    name="image" id="product_image">
                                <label class="custom-file-label" for="product_image">{{ trans('courses.choose_image') }}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{ trans('products.img_prev') }}</label>
                                <div class="w-100">
                                    <img id="product_image_preview" class="d-block mx-auto img-fluid"
                                    src="{{ url('storage/no-image.png') }}" alt="image preview">
                                </div>
                            </div>
                        </div>
                        {{-- price --}}
                        <div class="col-xl-6">
                          <div class="form-group mb-3">
                            <label for="price">{{ trans('products.price') }}</label>
                            <input type="number" class="form-control form-control-alt" id="price" value="{{ old('price') }}"
                              name="price" placeholder="{{ trans('products.price') }}">
                          </div>
                        </div>
                        {{-- approve --}}
                        <div class="col-xl-6">
                          <div class="form-group mb-3">
                            <label>{{ trans('products.approve') }}</label>
                            <div class="custom-control custom-switch mb-1">
                              <input type="checkbox" class="custom-control-input" id="approve" name="approve" {{ old('approve') ? 'checked' : '' }}>
                              <label class="custom-control-label" for="approve">Approved</label>
                            </div>
                          </div>
                        </div>
                        {{-- product Categories --}}
                        <div class="col-lg-12 mb-3">
                            <label>{{ trans('products.categories') }}</label>
                            <select class="custom-select" id="categories" name="categoryId">
                              <option disabled selected>{{ trans('products.select_category') }}</option>
                              @foreach ($productCategories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                              @endforeach
                            </select>
                        </div>
                        {{-- vendor Stores --}}
                        <div class="col-lg-12 mb-3">
                            <label>{{ trans('products.stores') }}</label>
                            <select class="custom-select" id="storeId" name="storeId">
                              <option disabled selected>{{ trans('products.select_store') }}</option>
                              @foreach ($vendorStores as $store)
                                <option value="{{ $store->id }}">{{ $store->name }}</option>
                              @endforeach
                            </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="block-content text-left border-top">
                        <div class="form-group">
                          <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">{{ trans('grades.cancel') }}</button>
                          <button type="submit" class="btn btn-md btn-primary">
                            <i class="fa fa-check fa-fw mr-2"></i>{{ trans('grades.save') }}
                          </button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
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

