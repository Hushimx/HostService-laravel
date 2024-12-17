@extends('front.student.includes.student_dashboard_layout')
@section('pageTitle', 'Student Dashboard | Mathematica')

@section('content')
  <x-headTitle>
    <x-slot name="title">{{ trans('students.This is where posts are shown!') }}</x-slot>
  </x-headTitle>

  {{-- all posts --}}
  <div class="all-posts p-0 bg-transparent">
    <h3 class="title mb-3 fw-bold" @if (App::getLocale() == 'ar') dir="rtl" data-aos="fade-right" @else data-aos="fade-left" @endif data-aos-delay="500">
      {{ trans('main_trans.posts') }}
    </h3>
    <div class="row" @if (App::getLocale() == 'ar') dir="rtl" @endif>
      @forelse ($posts as $post)
        <div class="col-md-6 col-xl-4 mb-3">
          <x-postCard :post="$post"></x-postCard>
        </div>
      @empty
        <p class="alert alert-info">There is posts to show right now !</p>
      @endforelse
    </div>

    {{-- Pagination --}}
    {{ $posts->links() }}

  </div>
@endsection
