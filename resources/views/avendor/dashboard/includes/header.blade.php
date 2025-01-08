<!-- Header -->
<header id="page-header">
    <!-- Header Content -->
    <div class="content-header">
        <!-- Left Section -->
        <div class="d-flex align-items-center">
            <!-- Toggle Sidebar -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
            <button type="button" class="btn btn-sm btn-dual mr-2 d-lg-none" data-toggle="layout" data-action="sidebar_toggle">
                <i class="fa fa-fw fa-bars"></i>
            </button>
            <!-- END Toggle Sidebar -->

            <!-- Toggle Mini Sidebar -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
            <button type="button" class="btn btn-sm btn-dual mr-2 d-none d-lg-inline-block" data-toggle="layout" data-action="sidebar_mini_toggle">
                <i class="fa fa-fw fa-ellipsis-v"></i>
            </button>
            <!-- END Toggle Mini Sidebar -->
        </div>
        <!-- END Left Section -->

        <!-- Right Section -->
        <div class="d-flex align-items-center">
          <div class="dropdown d-inline-block ml-2">
            <button type="button" class="btn btn-sm btn-dual d-flex align-items-center" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              @if (App::getLocale() == 'en')
                <img class="px-1 py-1" width="30px" height="auto" src="{{ asset('dashboard/assets/media/flags/en_flag.webp') }}" alt="">
                {{ LaravelLocalization::getCurrentLocaleNative() }}
              @else
                <img class="px-1 py-1" width="30px" height="auto" src="{{ asset('dashboard/assets/media/flags/egypt_flag.png') }}" alt="">
                {{ LaravelLocalization::getCurrentLocaleNative() }}
              @endif

              <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block ml-1 mt-1"></i>
            </button>

            <div class="dropdown-menu dropdown-menu-md dropdown-menu-right p-0 border-0" aria-labelledby="page-header-user-dropdown">
              <div class="p-2">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                  <li>
                    <a class="dropdown-item d-flex align-items-center justify-content-between" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                      <span class="font-size-sm font-w500">{{ $properties['native'] }}</span>
                    </a>
                  </li>
                @endforeach
              </div>
            </div>
          </div>

          <!-- User Dropdown -->
          <div class="dropdown d-inline-block ml-2">
            <button type="button" class="btn btn-sm btn-dual d-flex align-items-center" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img class="rounded-circle" src="{{asset('dashboard/assets/media/avatars/avatar10.jpg')}}" alt="Header Avatar" style="width: 21px;">
              <span class="d-none d-sm-inline-block ml-2">{{ Str::before(Auth::guard('vendors')->user()->name, ' ') }}</span>
              <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block ml-1 mt-1"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-md dropdown-menu-right p-0 border-0" aria-labelledby="page-header-user-dropdown">
              <div class="p-3 text-center bg-primary-dark rounded-top">
                <img class="img-avatar img-avatar48 img-avatar-thumb" src="{{asset('dashboard/assets/media/avatars/avatar10.jpg')}}" alt="">
                <p class="mt-2 mb-0 text-white font-w500">{{  Auth::guard('vendors')->user()->name }}</p>
                <p class="mb-0 text-white-50 font-size-sm">Web Developer</p>
              </div>
              <div class="p-2">
                <a class="dropdown-item d-flex align-items-center justify-content-between" href="{{ route('vendor.logout') }}"
                  onclick="event.preventDefault(); document.getElementById('vendor-logout-form').submit();">
                  <span class="font-size-sm font-w500">{{ __('Logout') }}</span>
                  <form id="vendor-logout-form" action="{{ route('vendor.logout') }}" method="POST" class="d-none">
                      @csrf
                  </form>
                </a>
              </div>
            </div>
          </div>
          <!-- END User Dropdown -->
        </div>
        <!-- END Right Section -->
    </div>
    <!-- END Header Content -->
</header>
<!-- END Header -->
