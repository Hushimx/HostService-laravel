<div class="student-info-panel p-3 py-3">
  <div class="title-info d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Profile</h3>
    <a href="#"
      class="btn-edit-profile d-flex justify-content-center align-items-center tt"
      data-bs-placement="bottom" title="Edit Your Profile !"
    >
      <i class="fa fa-edit"></i>
    </a>
  </div>
  {{-- avatar image --}}
  <img class="d-block mx-auto rounded-circle img-fluid shadow border mb-4"
    width="250px" src="{{ asset('front/imgs/logo/default-avatar.jpg') }}"
    alt="student personal photo">

  <h4 class="fw-bold text-center mx-auto">{{ auth()->user()->name }}</h4>
  <p class="text-capitalize text-center mb-4 mx-auto">{{ auth()->user()->grade->name }}</p>

  <a class="btn-logout" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <i class="fa fa-sign-out me-2"></i>
    <span>{{ trans('auth.logout') }}</span>
  </a>

  {{-- log out form --}}
  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
  </form>
</div>

