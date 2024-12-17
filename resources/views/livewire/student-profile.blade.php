<div>
  <div class="container px-0">
    <form action="" wire:submit.prevent='updateProfile'>
      <div class="row">
        {{-- name --}}
        <div class="col-lg-6 mb-3">
          <label for="name">Name</label>
          <input id="name" class="form-control mt-2 py-2" type="text"
          wire:model.defer="name" placeholder="Your Name">
          @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        {{-- full name --}}
        <div class="col-lg-6 mb-3">
          <label for="fullName">Full Name</label>
          <input id="fullName" class="form-control mt-2 py-2" type="text"
          wire:model.defer="fullName" placeholder="Full Name">
          @error('fullName') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        {{-- email --}}
        <div class="col-lg-6 mb-3">
          <label for="email">Email</label>
          <input id="email" class="form-control mt-2 py-2" type="email"
          wire:model.defer="email" placeholder="Email">
          @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        {{-- phone --}}
        <div class="col-lg-6 mb-3">
          <label for="phone">Phone</label>
          <input id="phone" class="form-control mt-2 py-2" type="tel"
          wire:model.defer="phone" placeholder="Phone Number">
          @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        {{-- password --}}
        <div class="col-lg-6 mb-3">
          <label for="password">Password</label>
          <input id="password" class="form-control mt-2 py-2" type="password"
          wire:model.defer="password" placeholder="Change Your Password">
          @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        {{-- confirm password --}}
        <div class="col-lg-6 mb-3">
          <label for="confirmPassword">Confirm Password</label>
          <input id="confirmPassword" class="form-control mt-2 py-2" type="password"
          wire:model.defer="confirmPassword" placeholder="Confirm Your Password">
          @error('confirmPassword') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        {{-- grades --}}
        <div class="col-lg-6 mb-3">
          <label for="grade_id">Grade</label>
          <select id="grade_id" class="form-select mt-2 py-2" wire:model.defer='grade_id'>
            <option value="0">{{ trans('courses.select_grade') }}</option>
            @foreach ($grades as $grade)
              <option value="{{ $grade->id }}" @if (auth()->user()->grade_id == $grade->id) {{ 'selected' }} @endif>{{ $grade->name }}</option>
            @endforeach
            @error('grade_id') <span class="text-danger">{{ $message }}</span> @enderror
          </select>
        </div>
      </div>
      <div class="row">
        {{-- submit --}}
        <div class="col-lg-6 mb-3">
          <button class="btn btn-primary" type="submit" wire:loading.attr="disabled">
            <span wire:loading.remove><i class="fa fa-check me-2"></i>Save</span>
            <span wire:loading><i class="fa fa-spin me-2"></i>Submitting...</span>
          </button>
          <!-- Flash Message -->
          @if (session()->has('message'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)" class="alert alert-success mt-3">
              <i class="fa fa-check me-2"></i>{{ session('message') }}
            </div>
          @endif
        </div>
      </div>
    </form>
  </div>
</div>
