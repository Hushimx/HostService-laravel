@extends('avendor.dashboard.includes.master')

@section('content')
<!-- Main Container -->
<main id="main-container">
  <!-- Hero -->
  <x-hero>
    <x-slot name="title">
      {{ trans('products.manage') }} <small class="font-size-base font-w400 text-muted">{{ trans('products.products') }}</small>
    </x-slot>
    <li class="breadcrumb-item" aria-current="page">
      <a class="link-fx" href="/">{{ trans('main_trans.Dashboard_page') }}</a>
    </li>
    <li class="breadcrumb-item">{{ trans('products.manage') }} {{ trans('products.products') }}</li>
  </x-hero>

  <!-- Page Content -->
  <div class="content">
    <div class="block block-rounded">
      <div class="block-content block-content-full">
        <!-- start add button -->
        <button type="button" class="btn btn-success btn-sm mr-1 mb-3" data-toggle="modal" data-target="#modal-add-level">
          <i class="fa fa-fw fa-plus mr-1"></i> {{ trans('courses.addNewCourse') }}
        </button>
        <!-- END add button -->
        <!-- start add modal Content -->
        <div class="modal fade" id="modal-add-level" tabindex="-1" role="dialog" aria-labelledby="modal-block-large" aria-hidden="true">
          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                  <h3 class="block-title">New Course</h3>
                  <div class="block-options">
                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close" id="closeModal">
                      <i class="fa fa-fw fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="block-content font-size-sm py-0">
                  <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row classes_add_form" id="jsAddAnotherData">
                      <div class="row my-block p-3">
                        {{-- course name --}}
                        <div class="col-xl-12">
                          <div class="form-group mb-3">
                            <label for="course_name">{{ trans('products.product_name') }}</label>
                            <input type="text" class="form-control form-control-alt" id="course_name"
                              name="name" placeholder="{{ trans('products.course_name') }}" value="{{ old('name') }}">
                          </div>
                        </div>
                        {{-- course desc --}}
                        <div class="col-xl-12">
                          <div class="form-group mb-3">
                            <label for="course_desc">{{ trans('products.course_desc') }}</label>
                            <textarea class="form-control form-control-alt" id="course_desc" name="description"
                              rows="4" placeholder="{{ trans('products.course_desc') }}" value="{{ old('description') }}"></textarea>
                          </div>
                        </div>
                        {{-- course image --}}
                        <div class="col-xl-12 mb-3">
                          <div class="form-group">
                            <label>{{ trans('products.course_image') }}</label>
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" data-toggle="custom-file-input" accept="image/*"
                                name="image" id="course_image">
                              <label class="custom-file-label" for="course_image">{{ trans('products.choose_image') }}</label>
                            </div>
                          </div>
                        </div>
                        {{-- course price --}}
                        <div class="col-xl-6">
                          <div class="form-group mb-3">
                            <label for="course_price">{{ trans('products.course_price') }}</label>
                            <input type="number" class="form-control form-control-alt" id="course_price" value="{{ old('price') }}"
                              name="price" placeholder="{{ trans('products.course_price') }}">
                          </div>
                        </div>
                        {{-- course approve --}}
                        <div class="col-xl-6">
                          <div class="form-group mb-3">
                            <label>{{ trans('products.course_approve') }}</label>
                            <div class="custom-control custom-switch mb-1">
                              <input type="checkbox" class="custom-control-input" id="course_approve" name="approve" {{ old('approve') ? 'checked' : '' }}>
                              <label class="custom-control-label" for="course_approve">Approved</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="block-content text-left border-top">
                        <div class="form-group">
                          <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">{{ trans('grades.cancel') }}</button>
                          <button type="submit" class="btn btn-md btn-primary">
                            <i class="fa fa-check fa-fw mr-2"></i>{{ trans('grades.save') }}
                          </button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- END add modal Content -->
        {{-- errors And Alerts --}}
        <div class="alertDiv">
          <x-alert />
        </div>
        {{-- end errors And Alerts --}}
        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
        <table class="table table-responsive-xl table-bordered table-striped table-vcenter js-dataTable-full">
          <thead>
            <tr>
              <th class="text-center" style="width: 60px;">ID</th>
              <th class="text-center">{{ trans('products.name') }}</th>
              <th class="text-center">{{ trans('products.image') }}</th>
              <th class="text-center">{{ trans('products.price') }}</th>
              <th class="text-center" style="width: 155px;">{{ trans('products.approve') }}</th>
              <th class="text-center">{{ trans('products.category') }}</th>
              <th class="text-center" style="width: 180px;">{{ trans('products.createdAt') }}</th>
              <th class="text-center">{{ trans('grades.action') }}</th>
            </tr>
          </thead>
          <tbody id="tbody">
            @foreach ($products as $product)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="font-w600 font-size-sm">{{ $product->name }}</td>
                <td class="font-w600 font-size-sm">
                  @if ($product->image)
                    <a href="{{ $product->image }}" class="img-link img-link-zoom-in d-block mx-auto mag-img">
                      <img class="img-thumb d-block mx-auto" src="{{ $product->image }}" alt="{{ $product->text }}" width="300px">
                    </a>
                  @else
                    <a href="{{ url('storage/no-image.png') }}" class="img-link img-link-zoom-in d-block mx-auto mag-img">
                      <img class="img-thumb d-block mx-auto" src="{{ url('storage/no-image.png') }}" alt="{{ $product->name }}" width="300px">
                    </a>
                  @endif
                </td>
                <td class="font-w600 font-size-sm">{{ $product->price }}</td>
                <td class="font-w600 font-size-sm text-white text-center">
                  <span @if ($product->approve) class='bg-success p-1 rounded d-block' @else class='bg-danger p-1 rounded d-block' @endif>
                    @if ($product->approve) <i class="fa fa-fw fa-check-circle fa-fw mr-1"></i>
                    @else <i class="fa fa-fw fa-times-circle fa-fw mr-1"></i> @endif
                    {{ $product->approve ? trans('products.approve') : trans('courses.needApprove') }}
                  </span>
                </td>
                <td class="font-w600 font-size-sm text-center">
                    @if ($product->category)
                        {{ $product->category->name }}
                    @else
                        {{ trans('products.no-category') }}
                    @endif
                </td>
                <td class="font-w600 font-size-sm text-center">
                    {{-- <span>{{ $product->createdAt }}</span> --}}
                    <span class="d-block">{{ \Carbon\Carbon::parse($product->created_at)->diffForHumans() }}</span>
                    <span>{{ \Carbon\Carbon::parse($product->created_at)->format('M d Y') }}</span>
                </td>
                <td>
                  <div class="d-flex flex-column justify-content-start align-items-stretch">
                    <a class="btn btn-sm btn-secondary d-flex align-items-baseline mb-1" href="{{ route('products.show', $product->id) }}"
                      data-toggle="tooltip" data-placement="left" title="Give Permisions allow students to enroll in the course"
                    >
                      <i class="fa fa-eye fa-fw mr-1"></i>{{ trans('students.permissions') }}
                    </a>
                    <a class="btn btn-sm btn-primary d-flex align-items-baseline mb-1" href="{{ route('products.edit', $product) }}"
                      data-toggle="tooltip" data-placement="left" title="Edit the course"
                    >
                      <i class="fa fa-edit fa-fw mr-1"></i>{{ trans('students.edit') }}
                    </a>
                    <button type="button" class="btn btn-sm btn-danger d-flex align-items-baseline"
                        data-toggle="modal" data-target="#modal-delete-product{{$product->id}}">
                      <i class="fa fa-times fa-fw mr-1"></i>{{ trans('products.delete') }}
                    </button>
                  </div>
                </td>
              </tr>
              <!-- start delete modal Content -->
              <div class="modal fade" id="modal-delete-product{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-block-large" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="block block-rounded block-themed block-transparent mb-0">
                      <div class="block-header bg-primary-dark">
                        <h3 class="block-title">{{ trans('product.delete_product') }}</h3>
                        <div class="block-options">
                          <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                          </button>
                        </div>
                      </div>
                      <div class="block-content font-size-sm">
                        {{-- start form --}}
                        <form action="{{ route('products.destroy', $product) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <div class="row">
                            <div class="col-lg-12 col-xl-12">
                              <div class="form-group text-center">
                                <p>{{ trans('grades.before_delete_alert') }}</p>
                                <p><strong>{{$product->name}}</strong></p>
                              </div>
                            </div>
                            <div class="block-content text-center border-top">
                              <div class="form-group">
                                <button type="submit" class="btn btn-md btn-danger">
                                  <i class="fa fa-fw fa-times mr-1"></i> {{ trans('grades.yes') }}
                                </button>
                                <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">{{ trans('grades.no') }}</button>
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
              <!-- END delete modal Content -->
            @endforeach
          </tbody>
        </table>
        <!-- END Dynamic Table Full -->
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
@endsection

