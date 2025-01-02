@extends('avendor.dashboard.includes.master')

@section('content')
  <!-- Main Container -->
  <main id="main-container">

    <!-- Hero -->
    <div class="bg-image" style="background-image: url('{{ asset('dashboard/assets/media/photos/photo8@2x.jpg') }}');">
      <div class="bg-black-75">
        <div class="content content-full text-center">
          <div class="my-3">
            <img class="img-avatar img-avatar-thumb" src="{{ asset('dashboard/assets/media/avatars/avatar13.jpg') }}" alt="">
          </div>
          <h1 class="h2 text-white mb-0">{{ trans('main_trans.edit-profile') }}</h1>
          <h2 class="h4 font-w400 text-white-75">
            {{ Auth::guard('vendors')->user()->name }}
          </h2>
          <a class="btn btn-light" href="be_pages_generic_profile.html">
            <i class="fa fa-fw fa-arrow-left text-danger"></i> <span>{{ trans('main_trans.Back to Dashboard') }}</span>
          </a>
        </div>
      </div>
    </div>

    <!-- Page Content -->
    <div class="content content-boxed">
      <livewire:edit-profile></livewire:edit-profile>
    </div>
  </main>
@endsection
