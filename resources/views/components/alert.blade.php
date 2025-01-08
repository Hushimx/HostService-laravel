@if(session('success'))
  <div class="alert alert-success d-flex align-items-center ANIMATED FADEINDOWN" role="alert">
    <div class="flex-00-auto">
      <i class="fa fa-fw fa-check"></i>
    </div>
    <div class="flex-fill ml-3">
      <p class="mb-0 text-capitalize">{{ session('success') }}</p>
    </div>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
  </div>
@endif

@if(session('error'))
  <div class="alert alert-danger d-flex align-items-center animated fadeInDown" role="alert">
    <div class="flex-00-auto">
      <i class="far fa-sad-tear fa-fw"></i>
    </div>
    <div class="flex-fill ml-3">
      <p class="mb-0 text-capitalize">{{ session('error') }}</p>
    </div>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
  </div>
@endif

@if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
