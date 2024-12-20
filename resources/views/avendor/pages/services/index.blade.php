@extends('avendor.dashboard.includes.master')

@section('css_adds')
    <style>
        #product_image_preview {
            max-height: 200px;
        }
    </style>
@endsection

@section('content')
<!-- Main Container -->
<main id="main-container">
  <!-- Hero -->
  <x-hero>
    <x-slot name="title">
      {{ trans('main_trans.manage') }} <small class="font-size-base font-w400 text-muted">{{ trans('main_trans.services') }}</small>
    </x-slot>
    <li class="breadcrumb-item" aria-current="page">
      <a class="link-fx" href="{{ route('vendor.dashboard') }}">{{ trans('main_trans.Dashboard_page') }}</a>
    </li>
    <li class="breadcrumb-item">{{ trans('main_trans.manage') }} {{ trans('main_trans.services') }}</li>
  </x-hero>

  <!-- Page Content -->
  <div class="content">
    <div class="block block-rounded">
      <div class="block-content block-content-full">
        <x-alert /> {{-- errors And Alerts --}}
        <!--
            DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js
            which was auto compiled from _js/pages/be_tables_datatables.js
        -->
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
    </div>
  </div>

</main>
@endsection

@section('scripts')
  <script>
    $(document).ready(function() {
      $('.mag-img').magnificPopup({type:'image'});
    });
  </script>
  <script>
    // this script is responsible for previwing the image after user select it
    // Select the file input and the image preview element
    const imageInput = document.getElementById('product_image');
    const preview = document.getElementById('product_image_preview');
    if (imageInput) {
      // Add an event listener to handle when a file is selected
      imageInput.addEventListener('change', function () {
          // Check if a file is selected
          if (this.files && this.files[0]) {
              // Create a new FileReader instance
              const reader = new FileReader();

              // Define the onload function that will execute once the file is read
              reader.onload = function (e) {
                  // Set the src of the image preview element to the file data
                  preview.src = e.target.result;
                  // Display the image element
                  preview.style.display = 'block';
              };

              // Read the file as a data URL (base64 encoded string)
              reader.readAsDataURL(this.files[0]);
          } else {
              // If no file is selected, hide the image preview
              preview.style.display = 'none';
              preview.src = ''; // Clear the src attribute
          }
      });
    }

  </script>
  @php
    $servicesData = json_decode($service->ServicesData); // Decode JSON to array
  @endphp

  @if ($servicesData)
    <label for="">{{ $servicesData }}</label>
    <input id="" class="form-control" type="text" value="" placeholder="price">
  @endif
  <script>
    // Select all forms with the class 'form-edit-price'
    let forms = document.querySelectorAll('.form-edit-price');

    // Pass PHP data as JSON
    let codedData = @json($servicesData);
    let data = JSON.parse(codedData);

    // Check if forms and data are valid
    if (forms.length > 0 && Array.isArray(data)) {
        // Loop through each form
        forms.forEach((form) => {
            // Clear the form content before adding new inputs
            form.innerHTML = '';

            // Loop through the data and dynamically add inputs
            data.forEach((item, index) => {
                // Create a label and input for each item
                let label = document.createElement('label');
                label.textContent = `${item.title}`;
                label.setAttribute('for', `price-${index}`);
                label.setAttribute('class', 'text-left d-block'); // Margin for spacing

                let input = document.createElement('input');
                input.setAttribute('id', `price-${index}`);
                input.setAttribute('class', 'form-control mb-3');
                input.setAttribute('type', 'text');
                input.setAttribute('value', item.price);
                input.setAttribute('placeholder', 'Enter price');

                // Append the label and input to the current form
                form.appendChild(label);
                form.appendChild(input);
            });
        });
    } else {
        console.error('No forms found or data is invalid.');
    }
</script>

@endsection

