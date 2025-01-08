<div>
  <x-alert></x-alert>
  <form wire:submit.prevent="updateDesc">
    <div class="form-group mb-3">
      <label for="descInput">{{ trans('main_trans.description') }}</label>
      <textarea
        class="form-control form-control-alt js-summernote"
        id="descInput"
        name="desc"
        cols="30"
        rows="4"
        wire:model.defer="description"
        wire:ignore
      ></textarea>

      @error('description') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <div class="text-center mb-3">
      <button type="submit" class="btn btn-primary">
        <i class="fa fa-fw fa-check"></i> {{ trans('grades.update') }}
      </button>
      <button type="button" class="btn btn-secondary" wire:click="$emit('modal-hide')">Cancel</button>
    </div>
  </form>
</div>
