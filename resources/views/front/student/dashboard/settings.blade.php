@extends('front.student.includes.student_dashboard_layout')
@section('pageTitle', 'Student Dashboard | Mathematica')

@section('content')
  <x-headTitle>
    <x-slot name="title">{{ trans('students.profile-edit') }}</x-slot>
  </x-headTitle>

  {{-- all posts --}}
  <div class="all-posts p-0 bg-transparent">
    <h3 class="title mb-4 fw-bold" @if (App::getLocale() == 'ar') dir="rtl" data-aos="fade-right" @else data-aos="fade-left" @endif data-aos-delay="500">
      {{ trans('main_trans.profile') }}
    </h3>
    <livewire:student-profile />
  </div>
@endsection
