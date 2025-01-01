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
      {{ trans('main_trans.edit') }} <small class="font-size-base font-w400 text-muted">{{ trans('main_trans.store') }}</small>
    </x-slot>
    <li class="breadcrumb-item" aria-current="page">
      <a class="link-fx" href="{{ route('vendor.dashboard') }}">{{ trans('main_trans.Dashboard_page') }}</a>
    </li>
    <li class="breadcrumb-item">{{ trans('main_trans.edit') }} {{ trans('main_trans.store') }}</li>
  </x-hero>

  <!-- Page Content -->
  <x-page-full-content>
    <!-- start back button -->
    <a class="btn btn-success btn-sm mr-1 mb-3" href="#" id="goBackButton">
      <i class="fa fa-fw fa-arrow-right mr-1"></i>{{ trans('students.back') }}
    </a>

    <form action="{{ route('stores.update', $store) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <h2 class="content-heading mb-4">{{ trans('products.products_info') }}</h2>

      <div class="row">
        {{-- left side of form --}}
        <div class="col-xl-8">
          {{-- name --}}
          <div class="form-group mb-3">
            <label for="name">{{ trans('main_trans.name') }}</label>
            <input id="name" type="text" name="name" class="form-control form-control-alt" value="{{ $store->name }}">
            @error('name')
              <div class="alert alert-danger my-2">{{ $message }}</div>
            @enderror
          </div>
          {{-- description --}}
          <div class="form-group mb-3">
            <label for="description">{{ trans('main_trans.description') }}</label>
            <textarea class="form-control form-control-alt" name="description" id="description" cols="30" rows="10">{{ $store->description }}</textarea>
            @error('description')
              <div class="alert alert-danger my-2">{{ $message }}</div>
            @enderror
          </div>
          {{-- store sections --}}
          <div class="form-group mb-3">
            <label for="sections">{{ trans('main_trans.sections') }}</label>
            <select class="custom-select" id="sections" name="sectionId">
              <option disabled selected>{{ trans('main_trans.select_section') }}</option>
              @foreach ($storeSections as $section)
                <option value="{{ $section->id }}"
                  @if ($section->id == $store->sectionId) selected @endif>
                  {{ $section->name }}
                </option>
              @endforeach
            </select>
          </div>
        </div>
        {{-- right side  --}}
        <div class="col-xl-4 mb-3">
          {{-- imageUrl --}}
          <div class="form-group">
            <label>{{ trans('main_trans.imageUrl') }}</label>
            <div class="custom-file mb-3">
              <input type="file" class="custom-file-input" data-toggle="custom-file-input" accept="image/*" name="imageUrl" id="imageUrl">
              <label class="custom-file-label" for="imageUrl">{{ trans('courses.choose_image') }}</label>
            </div>
            <label>{{ trans('main_trans.imageUrl') }}</label>
            @if ($store->imageUrl)
              <div class="img-thumb">
                @if(Storage::disk('store_images')->exists($store->imageUrl))
                  <img id="store_image_preview" class="d-block mx-auto"
                  src="{{ url('storage/store_images/' . $store->imageUrl) }}" alt="{{ $store->name }}">
                @else
                  <img id="store_image_preview" class="d-block mx-auto"
                  src="{{ url('storage/no-image.png') }}" alt="{{ $store->name }}">
                @endif
              </div>
            @endif
          </div>
          {{-- bannerUrl --}}
          <div class="form-group">
            <label>{{ trans('main_trans.bannerUrl') }}</label>
            <div class="custom-file mb-3">
              <input type="file" class="custom-file-input" data-toggle="custom-file-input" accept="image/*" name="bannerUrl" id="bannerUrl">
              <label class="custom-file-label" for="bannerUrl">{{ trans('courses.choose_image') }}</label>
            </div>
            <label>{{ trans('main_trans.bannerUrl') }}</label>
            @if ($store->bannerUrl)
              <div class="img-thumb">
                @if(Storage::disk('store_images')->exists($store->bannerUrl))
                  <img id="store_banner_preview" class="d-block mx-auto"
                  src="{{ url('storage/store_images/' . $store->bannerUrl) }}" alt="{{ $store->name }}">
                @else
                  <img id="store_banner_preview" class="d-block mx-auto"
                  src="{{ url('storage/no-image.png') }}" alt="{{ $store->name }}">
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
    const imageUrl = document.getElementById('imageUrl');
    const previewImage = document.getElementById('store_image_preview');

    const bannerUrl = document.getElementById('bannerUrl');
    const previewBanner = document.getElementById('store_banner_preview');

    if (imageUrl) {
      // Add an event listener to handle when a file is selected
      imageUrl.addEventListener('change', function () {
        // Check if a file is selected
        if (this.files && this.files[0]) {
          // Create a new FileReader instance
          const reader = new FileReader();

          // Define the onload function that will execute once the file is read
          reader.onload = function (e) {
            // Set the src of the image preview element to the file data
            previewImage.src = e.target.result;
            // Display the image element
            previewImage.style.display = 'block';
          };

          // Read the file as a data URL (base64 encoded string)
          reader.readAsDataURL(this.files[0]);
        } else {
          // If no file is selected, hide the image preview
          previewImage.style.display = 'none';
          previewImage.src = ''; // Clear the src attribute
        }
      });
    }

    if (bannerUrl) {
      // Add an event listener to handle when a file is selected
      bannerUrl.addEventListener('change', function () {
        // Check if a file is selected
        if (this.files && this.files[0]) {
          // Create a new FileReader instance
          const reader = new FileReader();

          // Define the onload function that will execute once the file is read
          reader.onload = function (e) {
            // Set the src of the image preview element to the file data
            previewBanner.src = e.target.result;
            // Display the image element
            previewBanner.style.display = 'block';
          };

          // Read the file as a data URL (base64 encoded string)
          reader.readAsDataURL(this.files[0]);
        } else {
          // If no file is selected, hide the image preview
          previewBanner.style.display = 'none';
          previewBanner.src = ''; // Clear the src attribute
        }
      });
    }
  </script>
@endsection
