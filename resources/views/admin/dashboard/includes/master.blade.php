@include('admin.dashboard.includes.head')
    <!-- Page Container -->
    @if (App::getLocale() == 'ar')
        <div id="page-container" class="sidebar-o sidebar-dark enable-page-overlay sidebar-r side-scroll page-header-fixed main-content-narrow">
    @else
        <div id="page-container" class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed main-content-narrow">
    @endif
        @include('admin.dashboard.includes.sidebar-overlay')
        @include('admin.dashboard.includes.sidebar')
        @include('admin.dashboard.includes.header')

        @yield('content')

        @include('admin.dashboard.includes.footer')
        @include('admin.dashboard.includes.apps-modal')
    </div>
    <!-- END Page Container -->
@include('admin.dashboard.includes.foot')
