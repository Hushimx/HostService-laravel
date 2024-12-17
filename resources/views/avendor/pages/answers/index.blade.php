@extends('admin.dashboard.includes.master')

@section('content')
<!-- Main Container -->
<main id="main-container">
  <!-- Hero -->
  <div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
        <h1 class="flex-sm-fill h3 my-2">
          {{ trans('students.answers') }} <small class="font-size-base font-w400 text-muted">{{ trans('students.answers_list') }}</small>
        </h1>
        <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item" aria-current="page">
              <a class="link-fx" href="/admin">{{ trans('main_trans.Dashboard_page') }}</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
              <a class="link-fx" href="/questions">{{ trans('main_trans.questions_bank') }}</a>
            </li>
            <li class="breadcrumb-item">{{ trans('students.answers_list') }}</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>

  <!-- Page Content -->
  <div class="content">
    <div class="block block-rounded">
      <div class="block-content block-content-full">
          <h2 class="text-center">{{ $question->text }} - ( {{ $question->grade->name }} )</h2>
          <a class="btn btn-success btn-sm mb-3" href="/questions"><i class="fa fa-fw fa-arrow-left mr-1"></i>Back</a>
          <!-- start add button -->
          <button type="button" class="btn btn-success btn-sm mr-1 mb-3" data-toggle="modal" data-target="#modal-add-answer">
              <i class="fa fa-fw fa-plus mr-1"></i> {{ trans('students.new_answer') }}
          </button>
          <!-- END add button -->
          <!-- start add modal Content -->
          <div class="modal fade" id="modal-add-answer" tabindex="-1" role="dialog" aria-labelledby="modal-block-large" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="block block-rounded block-themed block-transparent mb-0">
                  <div class="block-header bg-primary-dark">
                    <h3 class="block-title">{{ trans('students.new_answer') }}</h3>
                    <div class="block-options">
                      <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-fw fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <div class="block-content font-size-sm">
                    <form action="{{ route('answers.store') }}" method="POST">
                        @csrf
                        <div class="row">
                          <div class="col-xl-12">
                            <div class="form-group">
                              <input type="hidden" value="{{ $question->id }}" name="question_id">

                              <label for="answer">{{ trans('students.answer_content') }}</label>
                              <textarea class="form-control form-control-alt" name="content" id="answer"
                              id="" cols="30" rows="4" placeholder="{{ trans('students.answer_content') }}"></textarea>
                            </div>
                            <div class="form-group custom-control custom-checkbox mb-4">
                              <input id="isCorrect" type="checkbox" class="custom-control-input" name="isCorrect" value="yes">
                              <label for="isCorrect" class="custom-control-label">{{ trans('students.answer_correct') }}</label>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                            <div class="block-content text-left border-top">
                                <div class="form-group">
                                    <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">{{ trans('grades.cancel') }}</button>
                                    <button type="submit" class="btn btn-md btn-primary" id="insert_classes">
                                        <i class="fa fa-fw fa-check"></i> {{ trans('grades.save') }}
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

          <x-alert></x-alert>{{-- errors And Alerts --}}

          <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
          <table class="table table-responsive-xl table-bordered table-striped table-vcenter js-dataTable-full">
            <thead>
              <tr>
                <th class="text-center" style="width: 60px;">ID</th>
                <th>{{ trans('students.answer_content') }}</th>
                <th>{{ trans('students.answer_correct') }}</th>
                <th style="width: 15%;">{{ trans('grades.action') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($question->answers as $answer)
              <tr>
                <td class="text-center font-size-sm">{{ $loop->iteration }}</td>
                <td class="font-w600 font-size-sm">{{ $answer->content }}</td>
                <td class="font-w600 font-size-sm">{{ $answer->is_correct == 1 ? trans('students.yes') : trans('students.no') }}</td>
                <td>
                  <div class="d-flex flex-xs-column flex-sm-column flex-md-row justify-content-start">
                    <button type="button" class="btn btn-sm btn-primary m-1"
                      data-toggle="modal" data-target="#modal-edit-answer{{ $answer->id }}">
                      <i class="fa fa-fw fa-edit mr-1"></i> {{ trans('students.edit') }}
                    </button>
                    <button type="button" class="btn btn-sm btn-danger m-1"
                      data-toggle="modal" data-target="#modal-delete-answer{{ $answer->id }}">
                      <i class="fa fa-fw fa-times mr-1"></i> {{ trans('students.delete') }}
                    </button>
                  </div>
                </td>
              </tr>
                <!-- start edit modal -->
                <div class="modal fade" id="modal-edit-answer{{ $answer->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-block-large" aria-hidden="true">
                  <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="block block-rounded block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                          <h3 class="block-title">{{ trans('students.answer_edit') }}</h3>
                          <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                              <i class="fa fa-fw fa-times"></i>
                            </button>
                          </div>
                        </div>
                        <div class="block-content font-size-sm">
                          {{-- start form --}}
                          <form action="{{ route('answers.update', $answer->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                              <div class="col-lg-12 col-xl-12">
                                <div class="form-group">
                                  <input type="hidden" value="{{ $question->id }}" name="question_id">
                                  <label for="title">{{ trans('students.answer_content') }}</label>
                                  <textarea id="title" class="form-control" type="text" name="content">{{ $answer->content }}</textarea>
                                </div>
                                <div class="form-group custom-control custom-checkbox mb-4">
                                  <input id="isCorrectEdit{{ $answer->id }}" type="checkbox" class="custom-control-input" name="isCorrect" value="yes" @if ($answer->is_correct) {{ 'checked' }} @endif>
                                  <label for="isCorrectEdit{{ $answer->id }}" class="custom-control-label">{{ trans('students.answer_correct') }}</label>
                                </div>
                              </div>
                              <div class="block-content text-center border-top">
                                <div class="form-group">
                                  <button type="submit" class="btn btn-md btn-success">
                                    <i class="fa fa-fw fa-check mr-1"></i> {{ trans('students.update') }}
                                  </button>
                                  <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">{{ trans('grades.cancel') }}</button>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- END edit modal -->
                <!-- start delete modal Content -->
                <div class="modal fade" id="modal-delete-answer{{ $answer->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-block-large" aria-hidden="true">
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
                          <form action="{{ route('answers.destroy', $answer) }}" method="POST">
                              @csrf
                              @method('DELETE')
                              <div class="row">
                                <div class="col-lg-12 col-xl-12">
                                  <div class="form-group text-center">
                                    <p>{{ trans('grades.before_delete_alert') }}</p>
                                    <p><strong>{{ $answer->content }}</strong></p>
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
