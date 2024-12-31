@extends('admin.dashboard.includes.layout')

@section('content')

<!-- Page Content -->
<div class="hero-static bg-light-purple py-5">
  <div class="content">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6 col-xl-5">
        <!-- Sign In Block -->
        <div class="block block-rounded shadow-lg border border-yellow">
          <div class="block-header bg-purple text-white text-center">
            <h3 class="block-title">{{ trans('login_trans.vendor_sign_in') }}</h3>
          </div>
          <div class="block-content bg-white rounded-bottom">
            <div class="p-4">
              <div class="text-center mb-4">
                <img src="{{ asset('images/vendor-icon.png') }}" alt="Vendor Login" style="width: 100px;">
              </div>
              <h1 class="h4 mb-2 text-center text-purple font-weight-bold">{{ trans('login_trans.welcome_back') }}</h1>
              <p class="text-muted text-center mb-4">
                {{ trans('login_trans.vendor_welcome_message') }}
              </p>

              <!-- Sign In Form -->
              <form class="js-validation-signin" action="{{ route('vendor.login') }}" method="POST">
                @csrf
                <div class="form-group">
                  <label for="login-email" class="font-weight-bold text-purple">{{ trans('login_trans.email') }}</label>
                  <input type="text" class="form-control form-control-lg border-yellow @error('email') is-invalid @enderror"
                    id="login-email" name="email" value="{{ old('email') }}" placeholder="{{ trans('login_trans.email_placeholder') }}">
                  @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="login-password" class="font-weight-bold text-purple">{{ trans('login_trans.password') }}</label>
                  <input type="password" class="form-control form-control-lg border-yellow @error('password') is-invalid @enderror"
                    id="login-password" name="password" placeholder="{{ trans('login_trans.password_placeholder') }}">
                  @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group text-center">
                  <button type="submit" class="btn btn-purple btn-lg px-5 text-white">
                    <i class="fa fa-sign-in-alt mr-2"></i>{{ trans('login_trans.sign_in') }}
                  </button>
                </div>
                <div class="form-group text-center">
                  @if (Route::has('password.request'))
                  <a class="text-purple" href="{{ route('password.request') }}">
                    {{ trans('login_trans.forgot_password') }}
                  </a>
                  @endif
                </div>
              </form>
              <!-- END Sign In Form -->


            </div>
          </div>
        </div>
        <!-- END Sign In Block -->
      </div>
    </div>
  </div>

</div>
<!-- END Page Content -->

@endsection
