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
              <a class="btn btn-sm btn-primary d-flex align-items-baseline" href="{{ route('service.edit.description', $service->id) }}"><i class="fa fa-edit fa-fw mr-1"></i>{{ trans('students.edit') }}</a>
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  {{ $vendorServices->links() }}
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const addServiceBtn = document.getElementById('add-service-btn');
    const servicesInputs = document.getElementById('services-inputs');

    // Add new service input fields dynamically
    addServiceBtn.addEventListener('click', function () {
      const index = servicesInputs.children.length;

      const serviceDiv = document.createElement('div');
      serviceDiv.classList.add('p-3', 'mb-3', 'border', 'rounded');

      const titleLabel = document.createElement('label');
      titleLabel.setAttribute('for', `title-${index}`);
      titleLabel.textContent = '{{ trans('main_trans.service_title') }}';
      serviceDiv.appendChild(titleLabel);

      const titleInput = document.createElement('input');
      titleInput.setAttribute('type', 'text');
      titleInput.setAttribute('name', `services[${index}][title]`);
      titleInput.setAttribute('id', `title-${index}`);
      titleInput.setAttribute('class', 'form-control mb-2');
      titleInput.setAttribute('placeholder', '{{ trans('main_trans.enter_title') }}');
      serviceDiv.appendChild(titleInput);

      const priceLabel = document.createElement('label');
      priceLabel.setAttribute('for', `price-${index}`);
      priceLabel.textContent = '{{ trans('main_trans.service_price') }}';
      serviceDiv.appendChild(priceLabel);

      const priceInput = document.createElement('input');
      priceInput.setAttribute('type', 'number');
      priceInput.setAttribute('name', `services[${index}][price]`);
      priceInput.setAttribute('id', `price-${index}`);
      priceInput.setAttribute('class', 'form-control');
      priceInput.setAttribute('placeholder', '{{ trans('main_trans.enter_price') }}');
      serviceDiv.appendChild(priceInput);

      servicesInputs.appendChild(serviceDiv);
    });
  });
</script>
