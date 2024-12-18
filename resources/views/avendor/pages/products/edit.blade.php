@extends('avendor.dashboard.includes.master')

@section('css_adds')
  <style>
    .img-thumb {
      width: auto;
      height: auto;
      max-height: 600px;
      box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 1px 3px 1px;
      border-radius: 6px;
    }

    .img-thumb img {
        max-width: 100%;
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
    <li class="breadcrumb-item">{{ trans('products.edit') }} {{ trans('products.product') }}</li>
  </x-hero>

  <!-- Page Content -->
  <x-page-full-content>
    <!-- start back button -->
    <a class="btn btn-success btn-sm mr-1 mb-3" href="#" id="goBackButton">
      <i class="fa fa-fw fa-arrow-right mr-1"></i>{{ trans('students.back') }}
    </a>

    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <h2 class="content-heading mb-4">{{ trans('products.products_info') }}</h2>

      <div class="row">
        {{-- left side of form --}}
        <div class="col-xl-8">
          {{-- name --}}
          <div class="form-group mb-3">
            <label for="name">{{ trans('products.name') }}</label>
            <input id="name" type="text" name="name" class="form-control form-control-alt" value="{{ $product->name }}">
            @error('name')
              <div class="alert alert-danger my-2">{{ $message }}</div>
            @enderror
          </div>
          {{-- price --}}
          <div class="form-group mb-3">
            <label for="price">{{ trans('products.price') }}</label>
            <input type="number" class="form-control form-control-alt" id="price" name="price"
              placeholder="{{ trans('courses.price') }}" value="{{ $product->price }}">
          </div>
          {{-- approve --}}
          <div class="form-group mb-3">
            <label>{{ trans('products.approve') }}</label>
            <div class="custom-control custom-switch mb-1">
              <input type="checkbox" class="custom-control-input" id="approve" name="approve"  @if ($product->aprove) checked @endif>
              <label class="custom-control-label" for="approve">{{ trans('products.approve') }}</label>
            </div>
          </div>
          {{-- product Categories --}}
          <div class="form-group mb-3">
            <label>{{ trans('products.categories') }}</label>
            <select class="custom-select" id="categories" name="categoryId">
              <option disabled selected>{{ trans('products.select_category') }}</option>
              @foreach ($productCategories as $category)
                <option value="{{ $category->id }}"
                    @if ($category->id == $product->categoryId) selected @endif>
                    {{ $category->name }}
                </option>
              @endforeach
            </select>
          </div>
          {{-- vendor Stores --}}
          <div class="form-group mb-3">
            <label>{{ trans('products.stores') }}</label>
            <select class="custom-select" id="storeId" name="storeId">
              <option disabled selected>{{ trans('products.select_store') }}</option>
              @foreach ($vendorStores as $store)
                <option value="{{ $store->id }}"
                    @if ($store->id == $product->storeId) selected @endif>
                    {{ $store->name }}
                </option>
              @endforeach
            </select>
            </div>
        </div>
        {{-- right side  --}}
        <div class="col-xl-4 mb-3">
          {{-- image --}}
          <div class="form-group">
            <label>{{ trans('products.image') }}</label>
            <div class="custom-file mb-3">
              <input type="file" class="custom-file-input" data-toggle="custom-file-input" accept="image/*" name="image" id="product_image">
              <label class="custom-file-label" for="product_image">{{ trans('courses.choose_image') }}</label>
            </div>
            <label>{{ trans('products.img_prev') }}</label>
            @if ($product->image)
              <div class="img-thumb">
                @if(Storage::disk('products_images')->exists($product->image))
                  <img id="product_image_preview" class="d-block mx-auto"
                  src="{{ url('storage/' . $product->image) }}" alt="{{ $product->name }}">
                @else
                  <img id="product_image_preview" class="d-block mx-auto"
                  src="{{ url('storage/no-image.png') }}" alt="{{ $product->name }}">
                @endif
              </div>
            @endif
          </div>
        </div>
      </div>

      <div class="form-group">
        <button class="btn btn-primary btn-md" type="submit"><i class="fa fa-check fa-fw mr-1"></i>{{ trans('students.update') }}</button>
      </div>
    </form>
  </x-page-full-content>

</main>
@endsection

@section('scripts')
  <script>
    document.getElementById("goBackButton").addEventListener("click", function() {
      history.back();
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
