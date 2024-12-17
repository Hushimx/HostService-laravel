@extends('front.student.includes.student_dashboard_layout')
@section('pageTitle', 'Student Dashboard | Mathematica')

@section('content')

<x-headTitle>
  <x-slot name="title">{{ trans('main_trans.Lets learn something') }}</x-slot>
</x-headTitle>


{{-- enrolled courses --}}
<h3 class="title mb-3 fw-bold" @if (App::getLocale() == 'ar') dir="rtl" @endif data-aos="zoom-in" data-aos-delay="500">{{ trans('main_trans.Enrolled Courses') }}</h3>

<div class="enrolled-courses mb-3">
  <div class="row">
    @forelse (auth()->user()->courses as $course)
    <div class="col-md-6 col-xl-4" data-aos="fade-right" data-aos-delay="500">
      <x-courseCard :course="$course"></x-courseCard>
    </div>
    @empty
    <p class="alert alert-info" @if (App::getLocale() == 'ar') dir="rtl" @endif data-aos="zoom-in" data-aos-delay="500">{{ trans('main_trans.noCoursesEnrolled') }}</p>
    @endforelse
  </div>
</div>

{{-- Last Posts --}}
<h3 class="title mb-3 fw-bold" @if (App::getLocale() == 'ar') dir="rtl" @endif data-aos="zoom-in" data-aos-delay="500">{{ trans('main_trans.Last posts') }}</h3>

<div class="last-posts mb-3">
  <div class="row">
    @forelse ($lastPosts as $post)
    <div class="col-md-6 col-xl-4 mb-5 mb-lg-3">
      <x-postCard :post="$post"></x-postCard>
    </div>
    @empty
    <p class="alert alert-info" @if (App::getLocale() == 'ar') dir="rtl" @endif>{{ trans('main_trans.nolastPosts') }}</p>
    @endforelse
  </div>
</div>

@endsection


