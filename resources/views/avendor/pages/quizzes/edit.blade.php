@extends('admin.dashboard.includes.master')

@section('css_adds')
  <link rel="stylesheet" href="{{ asset('dashboard/assets/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/assets/js/plugins/flatpickr/flatpickr.min.css') }}">
@endsection

@section('content')
<!-- Main Container -->
<main id="main-container">
  <!-- Hero -->
  <x-hero>
    <x-slot name="title">
      {{ trans('main_trans.students') }} <small class="font-size-base font-w400 text-muted">{{ trans('main_trans.students_list') }}</small>
    </x-slot>
    <li class="breadcrumb-item" aria-current="page">
      <a class="link-fx" href="/admin">{{ trans('main_trans.Dashboard_page') }}</a>
    </li>
    <li class="breadcrumb-item">{{ trans('main_trans.editQuiz') }}</li>
  </x-hero>

  <!-- Page Content -->
  <div class="content">
    <div class="block block-rounded">
      <div class="block-content block-content-full">
        <!-- start add button -->
        <a class="btn btn-success btn-sm mr-1 mb-3" href="{{ route('quizzes.index') }}">
          <i class="fa fa-fw fa-arrow-right mr-1"></i>
          {{ trans('students.back') }}
        </a>

        <x-alert></x-alert>

        <form action="{{ route('quizzes.update', $quiz) }}" method="POST">
            @csrf
            @method('PUT')
            <h2 class="content-heading mb-4">{{ trans('students.quiz_info') }}</h2>
            <div class="row">
              {{-- quiz title --}}
              <div class="col-xl-4 mb-3">
                <label for="name">{{trans('students.quiz_name')}}</label>
                <input id="name" type="text" name="title" class="form-control" value="{{ old('time') ?? $quiz->title }}">
                @error('name')
                  <div class="alert alert-danger my-2">{{ $message }}</div>
                @enderror
              </div>
              {{-- quiz time --}}
              <div class="col-xl-4 mb-2">
                <label for="time">{{ trans('students.quiz_time') }}</label>
                <input type="text" class="js-masked-time form-control mb-2"
                  id="time" name="time" placeholder="{{ trans('students.quiz_time') }}">
                <span>Time Counter is {{ gmdate('i:s', $quiz->time) }}</span>
                @error('time')
                  <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
              {{-- scheduled at --}}
              <div class="col-xl-4 mb-3">
                <label for="example-flatpickr-datetime">Calendar and time</label>
                <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-datetime"
                  name="scheduled_at" data-enable-time="true" value="{{ old('scheduled_at') ?? $quiz->scheduled_at }}">
              </div>
              {{-- quiz description --}}
              <div class="col-xl-12 mb-3">
                <label for="description">{{trans('students.quiz_text')}}</label>
                <textarea class="form-control" name="description" id="description" cols="30" rows="4"
                  value="{{ old('description') ?? $quiz->description }}">{{ $quiz->description }}</textarea>
                @error('description')
                  <div class="alert alert-danger my-2">{{ $message }}</div>
                @enderror
              </div>

              {{-- quiz grade --}}
              <div class="col-xl-6 mb-3">
                <label>{{ trans('courses.grades') }}</label>
                <select class="custom-select" id="grades" name="grade_id">
                  <option value="0">{{ trans('courses.select_grade') }}</option>
                  @foreach ($allGrades as $grade)
                    <option value="{{ $grade->id }}"
                      @if ($grade->id == $quiz->grade_id) selected @endif>
                      {{ $grade->name }}
                    </option>
                  @endforeach
                </select>
              </div>

              {{-- quiz approve --}}
              <div class="col-xl-6 mb-3">
                <label>{{ trans('posts.approve') }}</label>
                <div class="custom-control custom-switch mb-1">
                  <input type="checkbox" class="custom-control-input" id="quiz_approve" name="approve" @if ($quiz->approved) checked @endif>
                  <label class="custom-control-label" for="quiz_approve">{{ trans('posts.approve') }}</label>
                </div>
              </div>

            </div>
            <div class="row">
              <div class="col-lg-12">
                <button class="btn btn-primary btn-md" type="submit">
                  <i class="fa fa-check fa-fw mr-1"></i>
                  <span>{{ trans('students.submit') }}</span>
                </button>
              </div>
            </div>
        </form>
      </div>
    </div>
  </div>

</main>
@endsection

@section('scripts')
<script src="{{ asset('dashboard/assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('dashboard/assets/js/plugins/flatpickr/flatpickr.min.js') }}"></script>
@endsection
