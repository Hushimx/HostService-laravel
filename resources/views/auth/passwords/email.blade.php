@extends('admin.dashboard.includes.layout')

@section('content')
<div id="page-container">

  <!-- Main Container -->
  <main id="main-container">

    <!-- Page Content -->
    <div class="hero-static">
      <div class="content">
        <div class="row justify-content-center">
          <div class="col-md-8 col-lg-6 col-xl-4">
            <!-- Reminder Block -->
            <div class="block block-rounded block-themed mb-0">
              <div class="block-header bg-primary-dark">
                <h3 class="block-title">{{ __('Reset Password') }}</h3>
                <div class="block-options">
                  <a class="btn-block-option" href="{{ route('register') }}" data-toggle="tooltip" data-placement="left"
                    title="Sign In">
                    <i class="fa fa-sign-in-alt"></i>
                  </a>
                </div>
              </div>
              <div class="block-content">
                <div class="p-sm-3 px-lg-4 py-lg-5">
                  <h1 class="h2 mb-1">Mr Mathematica</h1>
                  <p class="text-muted">
                    Please provide your account’s email and we will send you your password reset link.
                  </p>

                  @if (session('status'))
                  <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                  </div>
                  @endif

                  <!-- Reminder Form -->
                  <!-- jQuery Validation (.js-validation-reminder class is initialized in js/pages/op_auth_reminder.min.js which was auto compiled from _js/pages/op_auth_reminder.js) -->
                  <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                  <form class="js-validation-reminder" action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <div class="form-group py-3">
                      <label for="email" class="col-form-label text-md-end">{{ __('Email Address') }}</label>
                      <input id="email" type="email" class="form-control @error('email') is-invalid @enderror form-control-lg form-control-alt" id="reminder-credential"
                        name="email" placeholder="Username or Email" value="{{ old('email') }}" required autofocus autocomplete="email">
                      @error('email')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                    <div class="form-group row">
                      <div class="col-md-6 col-xl-8">
                        <button type="submit" class="btn btn-block btn-alt-primary">
                          <i class="fa fa-fw fa-envelope mr-1"></i><span>{{ __('Send Password Reset Link') }}</span>
                        </button>
                      </div>
                    </div>
                  </form>
                  <!-- END Reminder Form -->
                </div>
              </div>
            </div>
            <!-- END Reminder Block -->
          </div>
        </div>
      </div>
    </div>
    <!-- END Page Content -->
  </main>
  <!-- END Main Container -->
</div>
@endsection
