<div>
  <div class="d-flex justify-content-center align-items-center mb-2">
    <input type="text" class="form-control mr-2" placeholder="Search..." wire:model.defer="searchKey" wire:keydown.enter="search">
    <button type="submit" wire:click="search" class="btn btn-primary d-flex align-items-center" wire:loading.class='btn-success' wire:loading.attr='disabled'>
      <span>Search</span>
      <div class="spinner-border spinner-border-sm text-light ml-2" role="status" wire:loading wire:target='search'>
        <span class="sr-only">Loading...</span>
      </div>
    </button>
  </div>
  <p class="mb-2">Current Search Key: {{ $searchKey }}</p>
  <table class="table table-responsive-xl table-bordered table-striped table-vcenter">
    <thead>
      <tr>
        <th class="text-center" style="width: 60px;">ID</th>
        <th class="text-center">{{ trans('main_trans.city') }}</th>
        <th class="text-center">{{ trans('main_trans.serviceName') }}</th>
        <th class="text-center">{{ trans('main_trans.serviceDesc') }}</th>
        <th class="text-center">{{ trans('grades.action') }}</th>
      </tr>
    </thead>
    <tbody id="tbody">

      @foreach ($vendorServices as $service)
        <tr>
          <td class="text-center">{{ $loop->iteration }}</td>
          <td class="font-w600 font-size-sm text-center">{{ $service->city->name }}</td>
          <td class="font-w600 font-size-sm text-center">{{ $service->service->name }}</td>
          <td class="font-w600 font-size-sm text-center">{{ $service->service->description }}</td>
          <td>
            <div class="d-flex flex-column justify-content-start align-items-stretch">
              <button type="button" class="btn btn-sm btn-primary d-flex align-items-baseline" data-toggle="modal" data-target="#modal-edit-price{{$service->service->id}}">
                <i class="fa fa-edit fa-fw mr-1"></i>{{ trans('students.edit') }}
              </button>
            </div>
          </td>
        </tr>
        <!-- start edit modal -->
        <div class="modal fade" id="modal-edit-price{{$service->service->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-block-large" aria-hidden="true">
          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                  <h3 class="block-title">{{ trans('main_trans.edit-price') }}</h3>
                  <div class="block-options">
                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                      <i class="fa fa-fw fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="block-content font-size-sm">
                  {{-- start form --}}
                  <form action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="row">
                      <div class="col-lg-12 col-xl-12">
                        <div class="form-group text-center form-edit-price">

                        </div>
                      </div>
                      <div class="block-content text-center border-top">
                        <div class="form-group">
                          <button type="submit" class="btn btn-md btn-primary">
                            <i class="fa fa-fw fa-check mr-1"></i> {{ trans('grades.save') }}
                          </button>
                          <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">{{ trans('grades.cancel') }}</button>
                        </div>
                      </div>
                    </div>
                    </form>
                    {{-- End form --}}
                  </div>
              </div>
            </div>
          </div>
        </div>
        <!-- END edit price modal -->
      @endforeach
    </tbody>
  </table>
  <!-- END Dynamic Table Full -->
  {{ $vendorServices->links() }}
</div>
