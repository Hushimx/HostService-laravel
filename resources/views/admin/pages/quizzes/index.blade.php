@extends('admin.dashboard.includes.master')

@section('css_adds')
  <link rel="stylesheet" href="{{ asset('dashboard/assets/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/assets/js/plugins/flatpickr/flatpickr.min.css') }}">
@endsection

@section('content')
<!-- Main Container -->
<main id="main-container">
  <!-- Hero -->
  <x-hero>
    <x-slot name="title">
      {{ trans('students.quizzes') }} <small class="font-size-base font-w400 text-muted">{{ trans('students.quizzes_list') }}</small>
    </x-slot>
    <li class="breadcrumb-item" aria-current="page">
      <a class="link-fx" href="/admin">{{ trans('main_trans.Dashboard_page') }}</a>
    </li>
    <li class="breadcrumb-item">{{ trans('students.quiz_list') }}</li>
  </x-hero>

  <!-- Page Content -->
  <div class="content">
    <div class="block block-rounded">
      <div class="block-content block-content-full">
        <!-- start add button -->
        <button type="button" class="btn btn-success btn-sm mr-1 mb-3" data-toggle="modal" data-target="#modal-add-quiz">
            <i class="fa fa-fw fa-plus mr-1"></i> {{ trans('students.new_Quiz') }}
        </button>

        <x-alert></x-alert>{{-- errors And Alerts --}}

        <!-- start add modal Content -->
        <div class="modal fade" id="modal-add-quiz" tabindex="-1" role="dialog" aria-labelledby="modal-block-large" aria-hidden="true">
          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                  <h3 class="block-title">{{ trans('students.new_Quiz') }}</h3>
                  <div class="block-options">
                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close" id="closeModal">
                      <i class="fa fa-fw fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="block-content font-size-sm">
                  <form action="{{ route('quizzes.store') }}" method="POST" id="quizForm">
                    @csrf
                    <div class="row">
                      {{-- quiz title --}}
                      <div class="col-xl-12 mb-3">
                        <label for="quiz_title">{{ trans('students.quiz_name') }}</label>
                        <input type="text" class="form-control form-control-alt" id="quiz_title" value="{{ old('title') }}"
                          name="title" placeholder="{{ trans('students.quiz_name') }}">
                      </div>
                      {{-- quiz description --}}
                      <div class="col-xl-12 mb-3">
                        <label for="description">{{ trans('students.quiz_text') }}</label>
                        <textarea class="form-control form-control-alt" id="description" name="description" value="{{ old('description') }}"
                        rows="4" placeholder="{{ trans('students.quiz_text') }}"></textarea>
                      </div>
                      {{-- quiz time --}}
                      <div class="col-xl-6 mb-3">
                        <label for="quiz_time">{{ trans('students.quiz_time') }}</label>
                        <input type="text" class="js-masked-time form-control mb-2" value="{{ old('time') }}"
                          id="quiz_time" name="time" placeholder="{{ trans('students.quiz_time') }}">
                        @error('time')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      {{-- approve --}}
                      <div class="col-xl-4 mb-3">
                        <label>{{ trans('posts.approve') }}</label>
                        <div class="custom-control custom-switch mb-1">
                          <input type="checkbox" class="custom-control-input" id="quiz_approve" name="approve" {{ old('approve', $post->approved ?? false) ? 'checked' : '' }}>
                          <label class="custom-control-label" for="quiz_approve">{{ trans('posts.approve') }}</label>
                        </div>
                      </div>
                      {{-- scheduled at --}}
                      <div class="col-xl-12 mb-3">
                        <label for="example-flatpickr-datetime">Calendar and time</label>
                        <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-datetime"
                          name="scheduled_at" data-enable-time="true" value="{{ old('scheduled_at') }}">
                      </div>
                      {{-- grades select grade_id --}}
                      <div class="col-lg-12 mb-3">
                        <label for="grades">{{ trans('courses.grades') }}</label>
                        <select class="custom-select" id="grades" name="grade_id">
                          <option value="0">{{ trans('courses.select_grade') }}</option>
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
                            <i class="fa fa-fw fa-check me-2"></i>{{ trans('grades.save') }}
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

        <div class="alertDiv"></div>
        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
        <table class="table table-responsive-xl table-bordered table-striped table-vcenter js-dataTable-full">
          <thead>
            <tr>
              <th class="text-center" style="width: 60px;">ID</th>
              <th>{{ trans('students.quiz_name_alt') }}</th>
              <th style="width: 30%">{{ trans('students.text') }}</th>
              <th class="d-none d-sm-table-cell">{{ trans('students.quiz_time') }}</th>
              <th class="text-center" style="width: 135px;">{{ trans('posts.approved') }}</th>
              <th>{{ trans('students.scheduled_at') }}</th>
              <th  class="d-none d-sm-table-cell">{{ trans('students.grade') }}</th>
              <th style="width: 15%">{{ trans('grades.action') }}</th>
            </tr>
          </thead>
          <tbody id="tbody">
          @foreach ($quizzes as $quiz)
            <tr>
              <td class="text-center font-size-sm">{{ $loop->iteration }}</td>
              <td class="font-w600 font-size-sm">{{ $quiz->title }}</td>
              <td class="font-w600 font-size-sm">{{ $quiz->description ?  $quiz->description : "No Description" }}</td>
              <td class="d-none d-sm-table-cell font-size-sm">{{ $quiz->time ? gmdate('i:s', $quiz->time) : 'Unlimited'}} </td>
              <td class="font-w600 font-size-sm text-white text-center">
                <span @if ($quiz->approved) class='bg-success p-1 rounded d-block' @else class='bg-danger p-1 rounded d-block' @endif>
                  @if ($quiz->approved) <i class="fa fa-check mr-1"></i> @else <i class="fa fa-times mr-1"></i> @endif
                  {{ $quiz->approved ? trans('posts.approved') : trans('posts.needApprove') }}
                </span>
              </td>
              <td class="font-w600 font-size-sm">{{ $quiz->scheduled_at }}</td>
              <td class="d-none d-sm-table-cell font-size-sm">{{ $quiz->grade->name }}</td>
              <td>
                <div class="d-flex flex-column justify-content-start">
                  <a class="btn btn-sm btn-secondary text-left mb-1" href="{{ route('quizzes.show', $quiz) }}"
                    data-toggle="tooltip" data-placement="left" title="Add or remove questions">
                    <i class="fa fa-fw fa-eye fa-fw mr-1"></i>
                    <span>{{ trans('students.manage') }}</span>
                  </a>
                  <a class="btn btn-sm btn-primary text-left mb-1" href="{{ route('quizzes.edit', $quiz->id) }}"
                    data-toggle="tooltip" data-placement="left" title="Edit Quiz Settings such as date time and content">
                    <i class="fa fa-fw fa-edit fa-fw mr-1"></i>
                    <span>{{ trans('students.edit') }}</span>
                  </a>
                  <button type="button" class="btn btn-sm btn-danger text-left" data-toggle="modal" data-target="#modal-delete-quiz{{$quiz->id}}">
                    <i class="fa fa-fw fa-times mr-1"></i> {{ trans('students.delete') }}
                  </button>
                </div>
              </td>
            </tr>
            <!-- start delete modal Content -->
            <div class="modal fade" id="modal-delete-quiz{{$quiz->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-block-large" aria-hidden="true">
              <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="block block-rounded block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                      <h3 class="block-title">{{ trans('students.quiz_delete') }}</h3>
                      <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                          <i class="fa fa-fw fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <div class="block-content font-size-sm">
                      {{-- start form --}}
                      <form action="{{ route('quizzes.destroy', $quiz->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="row">
                          <div class="col-lg-12 col-xl-12">
                            <div class="form-group text-center">
                              <p>{{ trans('grades.before_delete_alert') }}</p>
                              <p><strong>{{$quiz->name}}</strong></p>
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
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

</main>
@endsection

@section('scripts')
<script src="{{ asset('dashboard/assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('dashboard/assets/js/plugins/flatpickr/flatpickr.min.js') }}"></script>
@endsection
