<div class="head-content pb-4" @if (App::getLocale() == 'ar') dir="rtl" @endif>
  {{-- bars of navbar button --}}
  <div class="row py-2 d-block d-lg-none">
    <div class="col-12">
      <button class="btn btn-bars px-0">
        <i class="fa fa-bars fa-2x"></i>
      </button>
    </div>
  </div>
  {{-- head title --}}
  <div class="row mt-0 mt-lg-4">
    <div class="col-lg-6">
      <h4 class="fw-bold mb-2">{{ trans('main_trans.hello') }} <span>{{ auth()->user()->name }}</span> !</h4>
      <p>{{ $title }}</p>
    </div>
    <div class="col-lg-6">
      <div class="position-relative">
        <form action="{{ route('student.search') }}" method="POST">
          @csrf
          <input class="form-control px-3 pe-5" type="text" name="search">
          <button class="btn-search" type="submit"><i class="fa fa-search"></i></button>
        </form>
      </div>
    </div>
  </div>
</div>
