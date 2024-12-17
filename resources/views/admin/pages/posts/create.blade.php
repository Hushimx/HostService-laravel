@extends('admin.dashboard.includes.master')

@section('css_adds')
  {{-- start Editor Plugn  --}}
  <link rel="stylesheet" href="{{ asset('dashboard/assets/js/plugins/summernote/summernote-bs4.css') }} ">
  <style>
    .img-thumb {
      width: auto;
      height: auto;
      max-height: 600px;
      box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 1px 3px 1px;
      border-radius: 6px;
    }

    .img-thumb img {
      max-height: 580px;
    }
  </style>
@endsection

@section('content')
<!-- Main Container -->
<main id="main-container">
  <!-- Hero -->
  <x-hero>
    <x-slot name="title">
      {{ trans('posts.create') }} <small class="font-size-base font-w400 text-muted">{{ trans('posts.post') }}</small>
    </x-slot>
    <li class="breadcrumb-item" aria-current="page">
      <a class="link-fx" href="/admin/dashboard">{{ trans('main_trans.Dashboard_page') }}</a>
    </li>
    <li class="breadcrumb-item" aria-current="page">
      <a class="link-fx" href="{{ route('posts.index') }}">{{ trans('posts.posts') }}</a>
    </li>
    <li class="breadcrumb-item">{{ trans('posts.create') }} {{ trans('posts.post') }}</li>
  </x-hero>

  <!-- Page Content -->
  <x-page-full-content>
    <!-- start back button -->
    <a class="btn btn-success btn-sm mr-1 mb-3" href="{{ route('posts.index') }}" id="goBackButton">
      <i class="fa fa-fw fa-arrow-right mr-1"></i>{{ trans('students.back') }}
    </a>

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <h2 class="content-heading mb-4">{{ trans('posts.post_info') }}</h2>

      <div class="row">
        {{-- left side of form --}}
        <div class="col-xl-8">
          {{-- title --}}
          <div class="form-group mb-3">
            <label for="post_title">{{ trans('posts.title') }}</label>
            <input id="post_title" type="text" name="title" class="form-control" value="{{ old('title') }}">
            @error('title')
              <div class="alert alert-danger my-2">{{ $message }}</div>
            @enderror
          </div>
          {{-- content --}}
          <div class="form-group mb-3">
            <label for="content">{{ trans('posts.content') }}</label>
            <textarea class="form-control form-control-alt js-summernote" name="content" id="content" cols="30" rows="4">{{ old('content') }}</textarea>
            @error('content')
              <div class="alert alert-danger my-2">{{ $message }}</div>
            @enderror
          </div>

        </div>
        {{-- right side --}}
        <div class="col-xl-4 mb-3">
          {{-- blog image --}}
          <div class="form-group">
            <label>{{ trans('posts.thumbnail') }}</label>
            <div class="custom-file">
              <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
              <input type="file" class="custom-file-input" data-toggle="custom-file-input" id="thumbnail" name="thumbnail" accept="image/*">
              <label class="custom-file-label" for="thumbnail">{{ trans('blog.choose_image') }}</label>
              <span class="font-size-sm muted">Thumbnail recommended dimension is 388 × 259 px</span>
            </div>
          </div>

          {{-- thumbnail preview --}}
          <div class="form-group">
            <label>{{ trans('posts.post_img_prev') }}</label>
            <div class="img-thumb">
              <img id="post_image_preview" class="d-block mx-auto" src="{{ url('storage/no-image.png') }}" alt="post preview">
            </div>
          </div>

          {{-- approve --}}
          <div class="form-group mb-3">
            <label>{{ trans('posts.approve') }}</label>
            <div class="custom-control custom-switch mb-1">
              <input type="checkbox" class="custom-control-input" id="post_approve" name="approve" {{ old('approve', $post->approved ?? false) ? 'checked' : '' }}>
              <label class="custom-control-label" for="post_approve">{{ trans('posts.approve') }}</label>
            </div>
          </div>

          {{-- all grades --}}
          <div class="form-group">
            <label>{{ trans('courses.grades') }}</label>
            <select class="custom-select" id="grades" name="grade_id">
              <option disabled selected>{{ trans('courses.select_grade') }}</option>
              @foreach ($allGrades as $grade)
                <option value="{{ $grade->id }}" {{ old('grade_id') == $grade->id ? 'selected' : '' }}>{{ $grade->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>

      <div class="form-group">
        <button class="btn btn-success btn-md" type="submit">
          <i class="fa fa-check fa-fw mr-1"></i>{{ trans('posts.create') }}
        </button>
      </div>
    </form>
  </x-page-full-content>

</main>
@endsection

@section('scripts')
  <script src="{{ asset('dashboard/assets/js/plugins/summernote/summernote-bs4.min.js') }}"></script>
  <script>
    document.getElementById("goBackButton").addEventListener("click", function() {
      history.back();
    });

    // this script is responsible for previwing the image after user select it
    // Select the file input and the image preview element
    const imageInput = document.getElementById('thumbnail');
    const preview = document.getElementById('post_image_preview');

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
