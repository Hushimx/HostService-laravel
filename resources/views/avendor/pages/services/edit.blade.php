@extends('avendor.dashboard.includes.master')

@section('css_adds')
  {{-- start Editor Plugn  --}}
  <link rel="stylesheet" href="{{ asset('dashboard/assets/js/plugins/summernote/summernote-bs4.css') }} ">
  <link rel="stylesheet" href="{{ asset('dashboard/assets/js/plugins/simplemde/simplemde.min.css') }} ">
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
      {{ trans('main_trans.edit-desc') }} <small class="font-size-base font-w400 text-muted">{{ trans('main_trans.services') }}</small>
    </x-slot>
    <li class="breadcrumb-item" aria-current="page">
      <a class="link-fx" href="{{ route('vendor.dashboard') }}">{{ trans('main_trans.Dashboard_page') }}</a>
    </li>
    <li class="breadcrumb-item">{{ trans('main_trans.edit-desc') }} {{ trans('main_trans.services') }}</li>
  </x-hero>

  <!-- Page Content -->
  <div class="content">
    <div class="block block-rounded">
      <div class="block-content block-content-full">
        <x-alert /> {{-- errors And Alerts --}}

        <!-- start back button -->
        <a class="btn btn-success btn-sm mr-1 mb-3" href="{{ route('services.index') }}" id="goBackButton">
          <i class="fa fa-fw fa-arrow-right mr-1"></i>{{ trans('students.back') }}
        </a>

        <form action="{{ route('service.update.description', $service) }}" method="POST">
          @csrf
          @method('PUT')

          <h2 class="content-heading mb-4">{{ $service->name }}</h2>

          <div class="row">
            {{-- address --}}
            <div class="col-xl-6 mb-3">
              <label for="address">{{ trans('main_trans.Address') }}</label>
              <input id="address" type="text" name="address" class="form-control" value="{{ $service->address }}">
              @error('address')
                <div class="alert alert-danger my-2">{{ $message }}</div>
              @enderror
            </div>

            {{-- locationUrl --}}
            <div class="col-xl-6 mb-3">
              <label for="locationUrl">{{ trans('main_trans.Location Url') }}</label>
              <input id="locationUrl" type="text" name="locationUrl" class="form-control" value="{{ $service->locationUrl }}">
              @error('locationUrl')
                <div class="alert alert-danger my-2">{{ $message }}</div>
              @enderror
            </div>

            {{-- description --}}
            <div class="col-lg-6 mb-4">
              <label for="desc">{{ trans('main_trans.description') }}</label>
              <textarea class="form-control form-control-alt js-summernote"
                name="description" id="desc" cols="30" rows="4">{{ $service->description }}</textarea>
              @error('description')
                <div class="alert alert-danger my-2">{{ $message }}</div>
              @enderror
            </div>

            {{-- description_ar --}}
            <div class="col-lg-6 mb-4">
              <label for="description_ar">{{ trans('main_trans.description_ar') }}</label>
              <textarea class="form-control form-control-alt js-summernote"
                name="description_ar" id="description_ar" cols="30" rows="4">{{ $service->description_ar }}</textarea>
              @error('description_ar')
                <div class="alert alert-danger my-2">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="form-group">
            <button class="btn btn-primary btn-md" type="submit"><i class="fa fa-check fa-fw mr-1"></i>{{ trans('students.update') }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</main>
@endsection

@section('scripts')
<script src="{{ asset('dashboard/assets/js/plugins/summernote/summernote-bs4.min.js') }}"></script>
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

