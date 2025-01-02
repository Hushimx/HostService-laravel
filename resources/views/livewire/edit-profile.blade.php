<div>
  <x-alert></x-alert>
  <!-- User Profile -->
  <div class="block block-rounded">
    <div class="block-header">
      <h3 class="block-title">Vendor Profile</h3>
    </div>

    <div class="block-content">
      <form wire:submit.prevent='editProfile'>
        <div class="row push">
          <div class="col-lg-4">
            <p class="font-size-sm text-muted">
              Your account’s vital info. Your name will be publicly visible.
            </p>
          </div>
          <div class="col-lg-8 col-xl-5">
            <div class="form-group">
              <label for="edit-name">{{ trans('main_trans.Name') }}</label>
              <input type="text" class="form-control" id="edit-name" name="edit-name"
                placeholder="Enter your name.." wire:model.defer='name'>
              @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
              <label for="phoneNo">{{ trans('main_trans.Phone Number') }}</label>
              <input type="text" class="form-control" id="phoneNo" name="phoneNo"
                placeholder="Enter your phone Number.." wire:model.defer='phoneNo'>
              @error('phoneNo') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
              <label for="address">{{ trans('main_trans.Address') }}</label>
              <input type="text" class="form-control" id="address" name="address"
                placeholder="Enter your phone Number.." wire:model.defer='address'>
              @error('address') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
              <label for="locationUrl">{{ trans('main_trans.Location Url') }}</label>
              <input type="text" class="form-control" id="locationUrl" name="locationUrl"
                placeholder="Enter your phone Number.." wire:model.defer='locationUrl'>
              @error('locationUrl') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-alt-primary">
                <div class="spinner-border spinner-border-sm text-primary mr-1" role="status" wire:loading wire:target='editProfile'>
                  <span class="sr-only">{{ trans('main_trans.Saving...') }}</span>
                </div>
                <span wire:loading wire:target='editProfile'>{{ trans('main_trans.Saving...') }}</span>
                <div wire:loading.remove wire:target='editProfile'>
                  <i class="fa fa-check fa-fw mr-1"></i>
                  <span>{{ trans('main_trans.Update') }}</span>
                </div>
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Change Password -->
  <div class="block block-rounded">
    <div class="block-header">
      <h3 class="block-title">Change Password</h3>
    </div>
    <x-alert></x-alert>
    @if(session('passwordSuccess'))
    <div class="alert alert-success d-flex align-items-center ANIMATED FADEINDOWN" role="alert">
      <div class="flex-00-auto">
        <i class="fa fa-fw fa-check"></i>
      </div>
      <div class="flex-fill ml-3">
        <p class="mb-0 text-capitalize">{{ session('passwordSuccess') }}</p>
      </div>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
    @endif
    <div class="block-content">
      <form wire:submit.prevent="updatePassword">
        <div class="row push">
          <div class="col-lg-4">
            <p class="font-size-sm text-muted">
              Changing your sign in password is an easy way to keep your account secure.
            </p>
          </div>
          <div class="col-lg-8 col-xl-5">
            <div class="form-group">
              <label for="currentPassword">Current Password</label>
              <input type="password" class="form-control" id="currentPassword" name="currentPassword" wire:model.defer="currentPassword">
              @error('currentPassword') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group row">
              <div class="col-12">
                <label for="newPassword">New Password</label>
                <input type="password" class="form-control" id="newPassword" name="newPassword" wire:model.defer="newPassword">
                @error('newPassword') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="form-group row">
              <div class="col-12">
                <label for="confirmPassword">Confirm New Password</label>
                <input type="password" class="form-control" id="confirmPassword" wire:model.defer="newPassword_confirmation">
              </div>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-alt-primary">
                <div class="spinner-border spinner-border-sm text-primary" role="status" wire:loading wire:target='updatePassword'>
                  <span class="sr-only">{{ trans('main_trans.Saving...') }}</span>
                </div>
                <span wire:loading wire:target='updatePassword'>{{ trans('main_trans.Saving...') }}</span>
                <div wire:loading.remove wire:target='updatePassword'>
                  <i class="fa fa-check fa-fw mr-1"></i>
                  <span>{{ trans('main_trans.Update') }}</span>
                </div>
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
