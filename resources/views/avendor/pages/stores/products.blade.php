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
        @livewire('show-store-products', ['storeId' => $storeId])
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

    if (imageInput) {
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
    }

  </script>
@endsection

