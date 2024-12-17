@extends('admin.dashboard.includes.master')
@section('content')
  <!-- Main Container -->
  <main id="main-container">
    <!-- Hero -->
    <div class="bg-body-light">
      <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
          <h1 class="flex-sm-fill h3 my-2">
            {{ trans('videos.edit') }} <small class="font-size-base font-w400 text-muted">{{ $video->name }}</small>
          </h1>
          <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-alt">
              <li class="breadcrumb-item" aria-current="page">
                <a class="link-fx" href="/admin/dashboard">{{ trans('main_trans.Dashboard_page') }}</a>
              </li>
              <li class="breadcrumb-item" aria-current="page">
                <a class="link-fx" href="/course/{{ $course->id }}/videos">{{ $course->name }}</a>
              </li>
              <li class="breadcrumb-item"> {{ $video->name }}</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
      <div class="block block-rounded">
        <div class="block-content block-content-full">
          {{-- errors And Alerts --}}
          <div class="alertDiv">
            <x-alert />
          </div>

          <!-- start back button -->
          <a class="btn btn-success btn-sm mr-1 mb-0" href="/course/{{ $course->id }}/videos" id="goBackButton"
            data-toggle="tooltip" data-placement="top" title="Go Back"
          >
            <i class="fa fa-fw fa-arrow-right mr-1"></i>{{ trans('students.back') }}
          </a>

          <form action="{{ route('courses.videos.update', [$course->id, $video->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h2 class="content-heading mb-3">{{ trans('videos.video_info') }}</h2>

            <div class="row mb-3">
              {{-- left side of form --}}
              <div class="col-xl-12">
                {{-- name --}}
                <div class="form-group mb-3">
                  <label for="course_name">{{ trans('videos.name') }}</label>
                  <input id="course_name" type="text" name="name" class="form-control" value="{{ old('name') ?? $video->name }}">
                  @error('name')
                    <div class="alert alert-danger my-2">{{ $message }}</div>
                  @enderror
                </div>
                {{-- link --}}
                <div class="form-group mb-3">
                  <label for="link">{{ trans('videos.link') }}</label>
                  <input id="link" type="text" name="link" class="form-control" value="{{ old('link') ?? $video->link }}">
                  @error('description')
                    <div class="alert alert-danger my-2">{{ $message }}</div>
                  @enderror
                </div>
                {{-- time --}}
                <div class="form-group mb-2">
                  <label for="time">{{ trans('videos.time') }}</label>
                  <input type="text" class="js-masked-time form-control mb-2" value="{{ old('time') ?? $video->time }}"
                    id="time" name="time" placeholder="{{ trans('videos.time') }}">
                  <span>Time Counter is {{ $video->time }} Seconds</span>
                  @error('time')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-xl-12">
                <button class="btn btn-primary btn-md" type="submit">
                  <i class="fa fa-check fa-fw mr-1"></i>{{ trans('students.update') }}
                </button>
              </div>
            </div>

          </form>

        </div>
      </div>
    </div>

  </main>
@endsection
