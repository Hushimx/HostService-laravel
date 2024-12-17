<div class="nav-panel" data-aos="fade-right">
  <div class="d-flex justify-content-around align-items-center">
    <a class="mathematica-logo" href="/" data-aos="fade-right" data-aos-delay="400">
      <img class="img-fluid d-block mx-auto" src="{{ asset('front/imgs/logo/math_logo_dash_1080.webp') }}" alt="logo app">
    </a>
    <button class="close-btn fs-4 shadow-0 d-block d-lg-none">
      <i class="fa fa-times"></i>
    </button>
  </div>

  <ul class="list-unstyled mb-0 px-0" data-aos="fade-right" data-aos-delay="500">
    <a href="{{ route('student.overview') }}">
      <li class="{{ Route::is('student.overview') ? 'active' : '' }}">
        <i class="fa fa-eye me-2"></i>
        <span>{{ trans('main_trans.overview') }}</span>
      </li>
    </a>
    <a href="{{ route('student.courses') }}">
      <li class="{{ Route::is('student.courses') ? 'active' : '' }}">
        <i class="fa fa-sticky-note me-2"></i>
        <span>{{ trans('main_trans.my-courses') }}</span>
      </li>
    </a>
    <a href="{{ route('student.quizzes') }}">
      <li class="{{ Route::is('student.quizzes') || Route::is('quiz.start') ? 'active' : '' }}">
        <i class="fa fa-sticky-note me-2"></i>
        <span>{{ trans('main_trans.quizzes') }}</span>
      </li>
    </a>
    <a href="{{ route('student.posts') }}">
      <li class="{{ Route::is('student.posts') || Route::is('student.showpost') ? 'active' : '' }}">
        <i class="fa fa-file-text me-2"></i>
        <span>{{ trans('main_trans.posts') }}</span>
      </li>
    </a>
    <a href="#">
      <li class="">
        <i class="fa fa-heart me-2"></i>
        <span>{{ trans('main_trans.favourites') }}</span>
      </li>
    </a>
    <a href="{{ route('attachments.show', auth()->user()->grade_id) }}">
      <li class="{{ Route::is('attachments.show') ? 'active' : '' }}">
        <i class="fa fa-file-pdf me-2"></i>
        <span>{{ trans('main_trans.files') }}</span>
      </li>
    </a>
    <a href="#">
      <li class="">
        <i class="fa fa-comments me-2"></i>
        <span>{{ trans('main_trans.messages') }}</span>
      </li>
    </a>
  </ul>

  <ul class="list-unstyled mb-0 px-0" data-aos="fade-right" data-aos-delay="750">
    <a href="{{ route('student.settings') }}">
      <li class="{{ Route::is('student.settings') ? 'active' : '' }}">
        <i class="fa fa-cog me-2"></i>
        <span>{{ trans('main_trans.Settings') }}</span>
      </li>
    </a>
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
      <li class="logout">
        <i class="fa fa-sign-out me-2"></i>
        <span>{{ trans('auth.logout') }}</span>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
      </li>
    </a>
  </ul>
</div>
