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
        {{-- show services component --}}
        <livewire:show-services />
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

  {{-- @if ($service)

    @php
      $servicesData = json_decode($service->ServicesData); // Decode JSON to array
    @endphp

    @if ($servicesData)
      <label for="serviceData">{{ $servicesData }}</label>
      <input id="serviceData" class="form-control" type="text" placeholder="price">
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

  @endif --}}


@endsection

