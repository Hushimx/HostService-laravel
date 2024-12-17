@extends('front.includes.layout')
@section('pageTitle', 'Mathematica')

@section('content')
  @include('front.includes.navbar')
  @include('front.includes.carousel')
  {{-- start our courses --}}
  <x-ourCourses :courses="$courses" />

  {{-- start videos --}}
  <x-videosSection :videos="$videos" />

  {{-- start join-us --}}
  <section class="join-us section-padding" id="join-us">
    <div class="container">
      <h2 class="mb-4 text-center fw-bold m-auto" data-aos="fade-up" data-aos-duration="1500">
        {{ trans('main_trans.thousand_miles') }}</h2>
      <p class="lh-lg text-center w-75 m-auto mb-5 fs-3" data-aos="zoom-in" data-aos-duration="1500">
        {{ trans('main_trans.never_too_late') }}</p>
      <div class="row">
        <div class="offset-lg-1 col-lg-10">
          <form action="{{ route('contact.store') }}" method="POST" class="form-control shadow">
            @csrf
            <div class="row p-2">
              <div class="col-lg-6">
                <div class="mb-3" data-aos="zoom-in-right" data-aos-duration="1500">
                  <label for="Name" class="form-label fw-bold">{{ trans('main_trans.name') }}</label>
                  <input type="text" class="form-control" name="name" id="Name"
                    placeholder="{{ trans('main_trans.enter_your_name') }}">
                </div>
                <div class="mb-3" data-aos="zoom-in-right" data-aos-duration="1500" data-aos-delay="400">
                  <label for="Email" class="form-label fw-bold">{{ trans('main_trans.email') }}</label>
                  <input type="email" class="form-control" name="email" id="Email" placeholder="name@example.com">
                </div>
                <div class="mb-3" data-aos="zoom-in-right" data-aos-duration="1500" data-aos-delay="800">
                  <label for="phone" class="form-label fw-bold">{{ trans('main_trans.phone') }}</label>
                  <input type="text" class="form-control" name="phone" id="phone">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3" data-aos="zoom-in-left" data-aos-duration="1500">
                  <label for="genderSelect" class="form-label fw-bold">{{ trans('main_trans.gender') }}</label>
                  <select class="form-select" id="genderSelect" name="gender">
                    <option value="Male">{{ trans('main_trans.male') }}</option>
                    <option value="Female">{{ trans('main_trans.female') }}</option>
                  </select>
                </div>
                <div class="mb-3" data-aos="zoom-in-left" data-aos-duration="1500" data-aos-delay="400">
                  <label for="age" class="form-label fw-bold">{{ trans('main_trans.age') }}</label>
                  <input type="number" class="form-control" name="age" id="age">
                </div>
                <div class="mb-3" data-aos="zoom-in-left" data-aos-duration="1500" data-aos-delay="800">
                  <label for="nationalitySelect" class="form-label fw-bold">{{ trans('main_trans.nationality') }}</label>
                  <select class="form-select" id="nationalitySelect" name="nationality_id">
                    <option selected>{{ trans('main_trans.select_nationality') }} ...</option>
                    @foreach ($nationalities as $nationality)
                    <option value="{{ $nationality->id }}">{{ $nationality->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="mb-3" data-aos="fade-up" data-aos-duration="1500">
                  <label for="message" class="form-label fw-bold">{{ trans('main_trans.message') }}</label>
                  <textarea class="form-control" name="message" id="message" cols="30" rows="10"
                    placeholder="{{ trans('main_trans.message_content') }}"></textarea>
                </div>
                <button data-aos="zoom-in" data-aos-duration="1500" class="btn btn-primary fw-bold"><i
                    class="fa-regular fa-paper-plane me-2"></i>{{ trans('main_trans.send') }}</button>
              </div>

            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- start footer -->
  <x-footer />

  {{-- back to top button --}}
  <x-backtotop />

@endsection

@section('scripts')
  <script>
    let currentTime = new Date();
    let year = currentTime.getFullYear();
    let navbar = document.querySelector('.navbar');
    let backToTop = document.querySelector('#backToTop');

    // Function to toggle the visibility of the backToTopButton
    // and toggle background of navbar
    function toggleBackToTopButtonVisibility() {
      // if scrolle value is less than 900
      if (window.scrollY > 900) {
        backToTop.classList.remove('d-none'); // show backToTop button
        navbar.classList.add('navbar-blue'); // color navbar
      } else {
        backToTop.classList.add('d-none'); // hide backToTop button
        navbar.classList.remove('navbar-blue'); // remove navbar color
      }
    }

    // Add a scroll event listener to toggle the visibility of the button
    window.addEventListener('scroll', toggleBackToTopButtonVisibility);

    // go to top of the page
    function scrollToTop() {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    }

    backToTop.addEventListener('click', scrollToTop);
    document.querySelector('#thisYear').innerHTML = year;
  </script>
@endsection
