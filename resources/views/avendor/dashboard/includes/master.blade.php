@include('avendor.dashboard.includes.head')
  <!-- Page Container -->
  @if (App::getLocale() == 'ar')
    <div id="page-container" class="sidebar-o sidebar-dark enable-page-overlay sidebar-r side-scroll page-header-fixed main-content-narrow">
  @else
    <div id="page-container" class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed main-content-narrow">
  @endif
    @include('avendor.dashboard.includes.sidebar-overlay')
    @include('avendor.dashboard.includes.sidebar')
    @include('avendor.dashboard.includes.header')

    @yield('content')

    @include('avendor.dashboard.includes.footer')
    @include('avendor.dashboard.includes.apps-modal')
  </div>
  <!-- END Page Container -->
@include('avendor.dashboard.includes.foot')
