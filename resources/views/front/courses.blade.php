@extends('front.includes.layout')

@section('pageTitle', 'Courses | Mathematica')

@section('content')
  {{-- start navbar  --}}
  @include('front.includes.navbar')

  <div class="block-navbar"></div>

  {{-- start courses layout --}}
  <div class="courses-layout">
    <div class="container h-100 z-2 d-flex align-items-center">
      <h2>Our Courses</h2>
    </div>
  </div>

  {{-- start courses cards --}}
  <div class="all-courses py-5 overflow-hidden">
    <div class="container">
      <div class="row">
        @forelse ($courses as $course)
        <div class="col-md-6 col-xl-4">
          <x-courseCard :course="$course"></x-courseCard>
        </div>
        @empty
        <p class="alert alert-info" @if (App::getLocale() == 'ar') {{ "dir=rtl" }} @endif>
          <i class="fa fa-warning me-2"></i>
          <span>{{ trans('courses.no-courses') }}</span>
        </p>
        @endforelse
      </div>
    </div>
  </div>


  <!-- start footer -->
  <x-footer />
@endsection

@section('scripts')
  <script>
    let currentTime = new Date();

    let year = currentTime.getFullYear();
    let navbar = document.querySelector('.navbar');

    // Function to toggle the visibility of the backToTopButton
    // and toggle background of navbar
    function toggleBackToTopButtonVisibility() {
      // if scrolle value is less than 900
      if (window.scrollY > 400) {
        navbar.classList.add('navbar-blue'); // color navbar
      } else {
        navbar.classList.remove('navbar-blue'); // remove navbar color
      }
    }

    // Add a scroll event listener to toggle the visibility of the button
    window.addEventListener('scroll', toggleBackToTopButtonVisibility);

    document.querySelector('#thisYear').innerHTML = year;
  </script>
@endsection
