@extends('front.student.includes.student-master')

@section('mainContent')
  <div class="student-dashboard">
    {{-- left side navbar --}}
    <x-navPanel />
    {{-- middle content --}}
    <div class="content">
      @yield('content')
    </div>
    {{-- right side --}}
    <x-studentInfoRight />
  </div>
@endsection



@section('scripts')
  <script>
    // when click on bars show the left panel
    $(".btn-bars").click(function(){
      $(".nav-panel").animate({left: '0px'}, "fast");
    });

    // close the left panel
    $(".close-btn").click(function(){
      $(".nav-panel").animate({left: '-100%'}, "fast");
    });
  </script>
  @yield('js_scripts')
@endsection


