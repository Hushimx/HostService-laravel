@extends('admin.dashboard.includes.master')

@section('content')
<!-- Main Container -->
<main id="main-container">
  <!-- Hero -->
  <x-hero>
    <x-slot name="title">
      {{ trans('main_trans.attachments') }} <small class="font-size-base font-w400 text-muted">{{ trans('main_trans.manage') }}</small>
    </x-slot>
    <li class="breadcrumb-item" aria-current="page">
      <a class="link-fx" href="/admin/dashboard">{{ trans('main_trans.Dashboard_page') }}</a>
    </li>
    <li class="breadcrumb-item">{{ trans('posts.manage') }} {{ trans('posts.posts') }}</li>
  </x-hero>

  <!-- Page Content -->
  <div class="content">
    <div class="block block-rounded">
      <div class="block-content block-content-full">
        <!-- start create post button -->

        {{-- <a class="btn btn-success btn-sm mr-1 mb-3" href="#">
          <i class="fa fa-fw fa-plus mr-1"></i>{{ trans('main_trans.uploadFile') }}
        </a> --}}

        <button type="button" class="btn btn-success btn-sm mr-1 mb-3" data-toggle="modal" data-target="#modal-upload-file">
          <i class="fa fa-fw fa-plus mr-1"></i>{{ trans('main_trans.uploadFile') }}
        </button>

        <!-- start upload file Content -->
        <div class="modal fade" id="modal-upload-file" tabindex="-1" role="dialog" aria-labelledby="modal-block-large" aria-hidden="true">
          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                  <h3 class="block-title">Upload Attachment File</h3>
                  <div class="block-options">
                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close" id="closeModal">
                      <i class="fa fa-fw fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="block-content font-size-sm py-0">
                  <form action="{{ route('attachments.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                      <div class="row py-3">
                        {{-- attachment file --}}
                        <div class="col-xl-12 mb-3">
                          <label>{{ trans('main_trans.uploadFile') }}</label>
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" data-toggle="custom-file-input" name="file" id="attachment">
                            <label class="custom-file-label" for="attachment">{{ trans('main_trans.choose_file') }}</label>
                          </div>
                        </div>
                        {{-- all grades --}}
                        <div class="col-xl-12">
                          <label>{{ trans('courses.grades') }}</label>
                          <select class="custom-select" id="grades" name="grade_id">
                            <option disabled selected>{{ trans('courses.select_grade') }}</option>
                            @foreach ($allGrades as $grade)
                              <option value="{{ $grade->id }}" {{ old('grade_id') == $grade->id ? 'selected' : '' }}>{{ $grade->name }}</option>
                            @endforeach
                          </select>
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
        <x-alert /> {{-- errors And Alerts --}}

        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
        <table class="table table-responsive-xl table-bordered table-striped table-vcenter js-dataTable-full">
          <thead>
            <tr>
              <th class="text-center" style="width: 60px;">ID</th>
              <th class="text-center">{{ trans('main_trans.file_name') }}</th>
              <th class="text-center" style="width: 180px;">{{ trans('posts.grade') }}</th>
              <th class="text-center" style="width: 280px;">{{ trans('posts.created_at') }}</th>
              <th class="text-center" style="width: 160px;">{{ trans('posts.action') }}</th>
            </tr>
          </thead>
          <tbody id="tbody">
            @foreach ($gradeAttachments as $attachment)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="font-w600 font-size-sm">{{ $attachment->file_name }}</td>
                <td class="font-w600 font-size-sm">{{ $attachment->grade->name }}</td>
                <td class="font-w600 font-size-sm">
                  <span class="d-block">{{ $attachment->created_at->format('d/m/Y h:i A') }}</span>
                  <span>{{ $attachment->created_at->diffForHumans() }}</span>
                </td>
                <td>
                  <div class="d-flex flex-column justify-content-start align-items-stretch">
                    <button type="button" class="btn btn-sm btn-danger d-flex align-items-baseline"
                      data-toggle="modal" data-target="#modal-upload-file{{$attachment->id}}">
                      <i class="fa fa-times fa-fw mr-1"></i>{{ trans('main_trans.deleteFile') }}
                    </button>
                  </div>
                </td>
              </tr>
              <!-- start delete modal Content -->
              <div class="modal fade" id="modal-upload-file{{$attachment->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-block-large" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="block block-rounded block-themed block-transparent mb-0">
                      <div class="block-header bg-primary-dark">
                        <h3 class="block-title">{{ trans('attachments.delete') }}</h3>
                        <div class="block-options">
                          <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                          </button>
                        </div>
                      </div>
                      <div class="block-content font-size-sm">
                        {{-- start form --}}
                        <form action="{{ route('attachments.destroy', $attachment) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <div class="row">
                            <div class="col-lg-12 col-xl-12">
                              <div class="form-group text-center">
                                <p>{{ trans('grades.before_delete_alert') }}</p>
                                <p><strong>{{$attachment->name}}</strong></p>
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

