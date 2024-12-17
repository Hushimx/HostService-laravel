@extends('front.student.includes.student_dashboard_layout')
@section('pageTitle', 'My Courses | Mathematica')

@section('content')
  <x-headTitle>
    <x-slot name="title">{{ trans('students.This is where all your courses that you enrolled in') }}</x-slot>
  </x-headTitle>

  {{-- all posts --}}
  <div class="all-posts p-0 bg-transparent">
    <h3 class="title mb-3 fw-bold" @if (App::getLocale() == 'ar') dir="rtl" data-aos="fade-right" @else data-aos="fade-left" @endif data-aos-delay="500">
      {{ trans('main_trans.my-courses') }}
    </h3>
    <div class="row" @if (App::getLocale() == 'ar') dir="rtl" @endif>
      @forelse ($studentInfo->courses as $course)
        <div class="col-md-6 col-xl-4 mb-3">
          <x-courseCard :course="$course"></x-courseCard>
        </div>
      @empty
        <p class="alert alert-info"><i class="fa-solid fa-circle-exclamation me-2"></i><span>You do not have any course</span></p>
      @endforelse
    </div>
  </div>
@endsection
