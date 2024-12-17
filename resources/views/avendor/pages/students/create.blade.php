@extends('admin.dashboard.includes.master')

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
    <li class="breadcrumb-item">{{ trans('students.add_new_student') }}</li>
  </x-hero>

  <!-- Page Content -->
  <div class="content">
    <div class="block block-rounded">
      <div class="block-content block-content-full">
        {{-- errors And Alerts --}}
        <div class="alertDiv">
          <x-alert />
        </div>

        <!-- start add button -->
        <a class="btn btn-success btn-sm mr-1" href="{{ url()->previous() }}">
          <i class="fa fa-fw fa-arrow-right mr-1"></i>
          <span>{{ trans('students.back') }}</span>
        </a>

        <form action="{{ route('students.store') }}" method="POST">
          @csrf
          <h2 class="content-heading mb-3">{{ trans('students.student_information') }}</h2>
          <div class="row">
            {{-- name --}}
            <div class="col-lg-6 mb-3">
              <label for="name_en">{{trans('students.name')}}</label>
              <input id="name_en" type="text" name="name" class="form-control">
              @error('name')
                <div class="alert alert-danger my-2">{{ $message }}</div>
              @enderror
            </div>
            {{-- email --}}
            <div class="col-lg-6 mb-3">
              <label for="email">{{trans('students.email')}}</label>
              <input id="email" type="email" name="email"  class="form-control">
              @error('Email')
                  <div class="alert alert-danger my-2">{{ $message }}</div>
              @enderror
            </div>
            {{-- password --}}
            <div class="col-lg-6 mb-3">
                <label for="password">{{trans('students.password')}}</label>
                <input id="password" type="password" name="password" class="form-control">
                @error('Password')
                <div class="alert alert-danger my-2">{{ $message }}</div>
                @enderror
            </div>
            {{-- confirm password --}}
            <div class="col-lg-6 mb-3">
                <label for="password_confirmation">{{ trans('students.confirm_password') }}</label>
                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control">
            </div>
            {{-- phone --}}
            <div class="col-lg-6 mb-3">
              <label for="phone">{{trans('students.phone')}}</label>
              <input id="phone" type="text" name="phone"  class="form-control">
              @error('phone')
                <div class="alert alert-danger my-2">{{ $message }}</div>
              @enderror
            </div>
            {{-- grades --}}
            <div class="col-lg-6 mb-3">
              <label for="grades">{{ trans('courses.grades') }}</label>
              <select class="custom-select" id="grades" name="grade_id">
                <option value="0">{{ trans('courses.select_grade') }}</option>
                @foreach ($allGrades as $grade)
                  <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row">
            {{-- submit --}}
            <div class="col-lg-6">
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
