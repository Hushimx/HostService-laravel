{{-- start navbar --}}

{{-- contact us message --}}
@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show w-75 m-auto position-fixed top-50 start-50 translate-middle z-2" role="alert">
      <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif
@if($errors->any())
  @foreach ($errors->all() as $error)
    <div class="alert alert-danger alert-dismissible fade show m-0 top-50 start-50 translate-middle" role="alert">
        <i class="fa-solid fa-circle-xmark me-2"></i>{{ $error }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endforeach
@endif
{{-- end contact us message --}}

<nav class="navbar navbar-expand-lg shadow sticky" id="navbar">
  <div class="container-fluid px-lg-5">
    <a class="navbar-brand fw-bold mx-0" href="#">
      <img class="pe-2" src="{{ asset('front/imgs/icons/logo.webp') }}" alt="">
      <span>Mr Mathematica</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon">
          <i class="fa fa-chevron-down"></i>
        </span>
    </button>
    <div class="collapse navbar-collapse mt-3 mt-lg-0" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active text-sm-center p-lg-2 p-3 link" aria-current="page" href="/">
            <i class="fa-solid fa-house me-2 fa-fw"></i>{{ trans('main_trans.home') }}
          </a>
        </li>

        @auth
          @if (auth()->user()->role == 'admin')
            <li class="nav-item">
              <a class="nav-link active text-sm-center p-lg-2 p-3 link" aria-current="page" href="/admin">
                <i class="fa-solid fa-users-gear me-2 fa-fw"></i> {{ trans('main_trans.admin') }}
              </a>
            </li>
          @endif
          <li class="nav-item">
            <a class="nav-link text-sm-center p-lg-2 p-3" href="{{ route('student.overview') }}">
              <i class="fa-solid fa-user fa-fw me-2"></i>{{ trans('main_trans.studentDashboard') }}
            </a>
          </li>
        @endauth
        <li class="nav-item">
          <a class="nav-link text-sm-center p-lg-2 p-3 link" href="/#videos">
            <i class="fa-solid fa-play me-2 fa-fw"></i>{{ trans('main_trans.Videos') }}
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-sm-center p-lg-2 p-3 link" href="{{ route('courses') }}">
            <i class="fa-solid fa-atom me-2 fa-fw"></i>{{ trans('main_trans.courses') }}
          </a>
        </li>
        @guest
        {{-- <li class="nav-item">
          <a class="nav-link text-sm-center p-lg-2 p-3 link" href="/#whyToLearnOnline">
            <i class="fa-solid fa-users me-2 fa-fw"></i>{{ trans('main_trans.aboutus') }}
          </a>
        </li> --}}

        <li class="nav-item">
          <a class="nav-link text-sm-center p-lg-2 p-3 link" href="/#join-us">
            <i class="fa-solid fa-phone me-2 fa-fw"></i>{{ trans('main_trans.contactus') }}
          </a>
        </li>
        @endguest
      </ul>
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 px-0">
        @auth
        <li class="nav-item dropdown ms-1 my-2 my-lg-0">
          <a class="nav-link dropdown-toggle text-sm-center p-lg-2 p-3" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            @if (App::getLocale() == 'en')
              Welcome {{ explode(' ', Auth::user()->name)[0] }}
            @else
            {{ explode(' ', Auth::user()->name)[0] }} {{ 'مرحبا' }}
            @endif
          </a>
          <ul class="dropdown-menu">
            <li>
              <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-door-open me-2"></i>
                <span>{{ trans('auth.logout') }}</span>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                </form>
              </a>
            </li>
          </ul>
        </li>
        @endauth

        @guest
        <li class="nav-item">
          <a class="nav-link text-sm-center p-lg-2 p-3" href="{{ route('login') }}"><i class="fa-solid fa-key me-2"></i>{{ trans('main_trans.login') }}</a>
        </li>
        @endauth
        <li class="nav-item dropdown ms-1 my-2 my-lg-0">
          <a class="nav-link dropdown-toggle text-sm-center p-lg-2 p-3" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            @if (App::getLocale() == 'en')
              <img class="px-1 py-1" width="30px" height="auto" src="https://upload.wikimedia.org/wikipedia/en/thumb/a/a4/Flag_of_the_United_States.svg/1200px-Flag_of_the_United_States.svg.png" alt="">
              {{ LaravelLocalization::getCurrentLocaleNative() }}
            @else
              <img class="px-1 py-1" width="30px" height="auto" src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fe/Flag_of_Egypt.svg/255px-Flag_of_Egypt.svg.png" alt="">
              {{ LaravelLocalization::getCurrentLocaleNative() }}
            @endif
          </a>
          <ul class="dropdown-menu py-0 overflow-hidden">
            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
              <a class="dropdown-item d-flex align-items-center justify-content-between py-2" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                <span class="font-size-sm font-w500">{{ $properties['native'] }}</span>
              </a>
            @endforeach
          </ul>
        </li>

      </ul>
    </div>
  </div>
</nav>
{{-- end navbar --}}
