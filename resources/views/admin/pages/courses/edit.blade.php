@extends('admin.dashboard.includes.master')

@section('css_adds')
  <style>
    .img-thumb {
      width: auto;
      height: auto;
      max-height: 600px;
      box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 1px 3px 1px;
      border-radius: 6px;
    }
  </style>
@endsection

@section('content')
<!-- Main Container -->
<main id="main-container">
  <!-- Hero -->
  <x-hero>
    <x-slot name="title">
      {{ trans('courses.edit') }} <small class="font-size-base font-w400 text-muted">{{ trans('courses.course') }}</small>
    </x-slot>
    <li class="breadcrumb-item" aria-current="page">
      <a class="link-fx" href="/courses">{{ trans('courses.course') }}</a>
    </li>
    <li class="breadcrumb-item">{{ trans('courses.edit') }} {{ trans('courses.course') }}</li>
  </x-hero>

  <!-- Page Content -->
  <x-page-full-content>
    <!-- start back button -->
    <a class="btn btn-success btn-sm mr-1 mb-3" href="#" id="goBackButton">
      <i class="fa fa-fw fa-arrow-right mr-1"></i>{{ trans('students.back') }}
    </a>

    <form action="{{ route('courses.update', $course) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <h2 class="content-heading mb-4">{{ trans('courses.course_info') }}</h2>

      <div class="row">
        {{-- left side of form --}}
        <div class="col-xl-8">
          {{-- name --}}
          <div class="form-group mb-3">
            <label for="course_name">{{ trans('courses.course_name') }}</label>
            <input id="course_name" type="text" name="name" class="form-control form-control-alt" value="{{ $course->name }}">
            @error('name')
              <div class="alert alert-danger my-2">{{ $message }}</div>
            @enderror
          </div>
          {{-- description --}}
          <div class="form-group mb-3">
            <label for="text">{{ trans('courses.course_desc') }}</label>
            <textarea class="form-control form-control-alt" name="description" id="text" cols="30" rows="4">{{ $course->description }}</textarea>
            @error('description')
              <div class="alert alert-danger my-2">{{ $message }}</div>
            @enderror
          </div>
          {{-- course price --}}
          <div class="form-group mb-3">
            <label for="course_price">{{ trans('courses.course_price') }}</label>
            <input type="number" class="form-control form-control-alt" id="course_price" name="price"
              placeholder="{{ trans('courses.course_price') }}" value="{{ $course->price }}">
          </div>
          {{-- course approve --}}
          <div class="form-group mb-3">
            <label>{{ trans('courses.course_approve') }}</label>
            <div class="custom-control custom-switch mb-1">
              <input type="checkbox" class="custom-control-input" id="course_approve" name="approve"  @if ($course->approve) checked @endif>
              <label class="custom-control-label" for="course_approve">{{ trans('courses.course_approve') }}</label>
            </div>
          </div>
          {{-- course grades --}}
          <div class="form-group">
            <label>{{ trans('courses.grades') }}</label>
            <select class="custom-select" id="grades" name="grade_id">
              <option disabled selected>{{ trans('courses.select_grade') }}</option>
              @foreach ($allGrades as $grade)
                  <option value="{{ $grade->id }}"
                    @if ($grade->id == $course->grade_id) selected @endif>
                    {{ $grade->name }}
                </option>
              @endforeach
            </select>
          </div>
        </div>
        {{-- right side  --}}
        <div class="col-xl-4 mb-3">
          {{-- course image --}}
          <div class="form-group">
            <label>{{ trans('courses.course_image') }}</label>
            <div class="custom-file mb-3">
              <input type="file" class="custom-file-input" data-toggle="custom-file-input" accept="image/*" name="image" id="course_image">
              <label class="custom-file-label" for="course_image">{{ trans('courses.choose_image') }}</label>
            </div>
            <label>{{ trans('courses.course_img_prev') }}</label>
            @if ($course->image)
              <div class="img-thumb">
                @if(Storage::disk('public')->exists($course->image))
                  <img id="course_image_preview" class="d-block mx-auto"
                  src="{{ url('storage/' . $course->image) }}" alt="{{ $course->name }}">
                @else
                  <img id="course_image_preview" class="d-block mx-auto"
                  src="{{ url('storage/no-image.png') }}" alt="{{ $course->name }}">
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
    const imageInput = document.getElementById('course_image');
    const preview = document.getElementById('course_image_preview');

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
