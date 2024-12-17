@extends('front.student.includes.student_dashboard_layout')
@section('pageTitle', 'Quiz Started | Mathematica')

@section('content')
  <x-headTitle>
    <x-slot name="title">This is where Quiz Starts</x-slot>
  </x-headTitle>

  {{-- all posts --}}
  <div class="all-questions p-0 bg-transparent">
    <h3 class="title mb-3 fw-bold" @if (App::getLocale() == 'ar') dir="rtl" data-aos="fade-right" @else data-aos="fade-left" @endif data-aos-delay="500">
      {{ trans('main_trans.search_results') }}
    </h3>

    <div class="row mb-4">
      @forelse ($searchData as $search)
      <div class="col-md-6 col-xl-4">
        <x-courseCard :course="$search"></x-courseCard>
      </div>
      @empty
        <p class="alert alert-danger"><i class="fa-solid fa-triangle-exclamation"></i> No Results</p>
      @endforelse
    </div>

    {{-- pagination --}}
    {{ $searchData->links() }}

  </div>
@endsection
