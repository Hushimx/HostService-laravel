@extends('admin.dashboard.includes.master')

@section('css_adds')
  <style>
    .img-thumb {
      max-height: 155px;
      box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 1px 3px 1px;
      border-radius: 6px;
    }
  </style>
@endsection

@section('content')
<!-- Main Container -->
<main id="main-container">
  <!-- Hero -->
  <x-hero>
    <x-slot name="title">
      {{ trans('students.questions') }} <small class="font-size-base font-w400 text-muted">{{ trans('students.questions_list') }}</small>
    </x-slot>
    <li class="breadcrumb-item" aria-current="page">
      <a class="link-fx" href="/admin">{{ trans('main_trans.Dashboard_page') }}</a>
    </li>
    <li class="breadcrumb-item">{{ trans('main_trans.questions_bank') }}</li>
  </x-hero>


  <!-- Page Content -->
  <div class="content">
    <div class="block block-rounded">
      <div class="block-content block-content-full">

        <!-- start add button -->
        <button type="button" class="btn btn-success btn-sm mr-1 mb-3" data-toggle="modal" data-target="#modal-add-question">
          <i class="fa fa-fw fa-plus mr-1"></i> {{ trans('students.new_question') }}
        </button>

        <!-- start add modal Content -->
        <div class="modal fade" id="modal-add-question" tabindex="-1" role="dialog" aria-labelledby="modal-block-large" aria-hidden="true">
          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                  <h3 class="block-title">{{ trans('students.new_question') }}</h3>
                  <div class="block-options">
                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                      <i class="fa fa-fw fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="block-content font-size-sm">
                  <form action="{{ route('questions.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      {{-- question title --}}
                      <div class="col-xl-12 mb-3">
                        <label for="que_title">{{ trans('students.question_title') }}</label>
                        <textarea class="form-control form-control-alt" name="text" id="que_title"
                        id="" cols="30" rows="3" placeholder="{{ trans('students.question_title') }}">{{ old('text') }}</textarea>
                      </div>
                      {{-- Image Optional --}}
                      <div class="col-xl-12 mb-3">
                        <label>Image Optional</label>
                        <div class="custom-file">
                          <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                          <input type="file" class="custom-file-input" data-toggle="custom-file-input" id="question_image" name="question_image">
                          <label class="custom-file-label" for="v">Choose file</label>
                        </div>
                      </div>
                      {{-- Answer options --}}
                      <div class="col-lg-12 text-left border-top">
                        <div class="form-group answer-options mt-2">
                          <label>Answer options</label>
                          <div class="mb-3 d-flex">
                            <button type="button" class="btn btn-dark removeOption">
                             <span aria-hidden="true">&times;</span>
                            </button>
                            <input type="text" name="answer[]" class="form-control mx-2">
                          </div>
                          <div class="mb-3 d-flex">
                            <span class="btn btn-dark removeOption">
                             <span aria-hidden="true">&times;</span>
                            </span>
                            <input type="text" name="answer[]" class="form-control mx-2">
                          </div>
                        </div>
                      </div>
                      {{-- which Is Correct --}}
                      <div class="col-xl-12">
                        <div class="form-group">
                          <input type="text" name="whichIsCorrect" class="form-control" placeholder="Which one is correct ?">
                        </div>
                      </div>
                      {{-- grades select --}}
                      <div class="col-lg-12 border-top mb-3 pt-3">
                        <label for="grades">{{ trans('courses.grades') }}</label>
                        <select class="custom-select" id="grades" name="grade_id">
                          <option value="0">{{ trans('courses.select_grade') }}</option>
                          @foreach ($allGrades as $grade)
                            <option value="{{ $grade->id }}" {{ old('grade_id') == $grade->id ? 'selected' : '' }}>{{ $grade->name }}</option>
                          @endforeach
                        </select>
                      </div>
                      {{-- submit --}}
                      <div class="col-xl-12 text-left border-top py-3">
                        <button type="button" class="btn btn-alt-primary" data-dismiss="modal">{{ trans('grades.cancel') }}</button>
                        <button type="submit" class="btn btn-md btn-primary" id="insert_classes">
                          <i class="fa fa-fw fa-check"></i> {{ trans('grades.save') }}
                        </button>
                        <button type="button" class="btn btn-md btn-info add_option">
                          <i class="fa fa-fw fa-check"></i>
                          <span>Add One More</span>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

          <x-alert></x-alert>{{-- errors And Alerts --}}

          <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
          <table class="table table-responsive-xl table-bordered table-striped table-vcenter js-dataTable-full">
            <thead>
              <tr>
                <th class="text-center" style="width: 60px;">ID</th>
                <th>{{ trans('students.question_title') }}</th>
                <th style="width: 20%">{{ trans('students.question_image') }}</th>
                <th style="width: 15%">{{ trans('students.grade') }}</th>
                <th style="width: 20%">{{ trans('grades.action') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($questions as $question)
                <tr>
                  <td class="text-center font-size-sm">{{ $loop->iteration }}</td>
                  <td class="font-w600 font-size-sm">{{ $question->text }}</td>
                  <td class="font-w600 font-size-sm">
                    @if ($question->image)
                      <a href="{{ url('storage/'.$question->image) }}" class="img-link img-link-zoom-in d-block mx-auto mag-img">
                        <img class="img-thumb d-block mx-auto" src="{{ url('storage/'.$question->image) }}" alt="{{ $question->text }}">
                      </a>
                    @else
                      <a href="{{ url('storage/no-image.png') }}" class="img-link img-link-zoom-in d-block mx-auto mag-img">
                        <img class="img-thumb d-block mx-auto" src="{{ url('storage/no-image.png') }}" alt="{{ $question->text }}">
                      </a>
                    @endif
                  </td>
                  <td class="font-w600 font-size-sm">{{ $question->grade->name }}</td>
                  <td>
                    <div class="d-flex flex-xs-column flex-sm-column flex-xxl-row justify-content-start">
                      <a class="btn btn-sm btn-secondary m-1 text-left" href="{{ route('questions.show', $question->id) }}">
                        <i class="fa fa-fw fa-eye mr-1"></i>{{ trans('students.manage') }}
                      </a>
                      <button type="button" class="btn btn-sm btn-primary m-1 text-left" data-toggle="modal" data-target="#modal-edit-question{{ $question->id }}">
                        <i class="fa fa-fw fa-edit mr-1"></i> {{ trans('students.edit') }}
                      </button>
                      <button type="button" class="btn btn-sm btn-danger m-1 text-left" data-toggle="modal" data-target="#modal-delete-question{{ $question->id }}">
                        <i class="fa fa-fw fa-times mr-1"></i> {{ trans('students.delete') }}
                      </button>
                      @if ($question->image)
                      <a class="btn btn-sm btn-danger m-1 text-left" href="{{ route('questions.deleteImage', $question->id) }}">
                        <i class="fa fa-fw fa-times mr-1"></i>{{ trans('students.deleteImage') }}
                      </a>
                      @endif
                    </div>
                  </td>
                </tr>
                <!-- start edit modal -->
                <div class="modal fade" id="modal-edit-question{{ $question->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-block-large" aria-hidden="true">
                  <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="block block-rounded block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                          <h3 class="block-title">{{ trans('students.question_edit') }}</h3>
                          <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                              <i class="fa fa-fw fa-times"></i>
                            </button>
                          </div>
                        </div>
                        <div class="block-content font-size-sm">
                          {{-- start form --}}
                          <form action="{{ route('questions.update', $question->id) }}" method="POST"  enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                              {{-- question text --}}
                              <div class="col-lg-12 mb-3">
                                <label for="title">{{ trans('students.question_title') }}</label>
                                <textarea id="title" class="form-control" type="text" name="title">{{ $question->text }}</textarea>
                              </div>
                              {{-- question image --}}
                              <div class="col-lg-12 mb-3">
                                <label>Image (Optional)</label>
                                <div class="custom-file">
                                  <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                  <input name="question_image" type="file" class="custom-file-input" data-toggle="custom-file-input" id="question_image">
                                  <label class="custom-file-label" for="v">Choose file</label>
                                </div>
                              </div>
                              {{-- question Answer options --}}
                              <div class="col-xl-12 text-left border-top pt-3">
                                <div class="form-group answer-options">
                                  <label>Answer options</label>
                                  @foreach ($question->answers as $answer)
                                    <div class="mb-3 d-flex">
                                      <button type="button" class="btn btn-dark removeOption">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                      <input type="text" name="answer[]" value="{{ $answer->content }}" class="form-control mx-2">
                                    </div>
                                  @endforeach
                                </div>
                              </div>
                              {{-- some info --}}
                              <div class="col-xl-12">
                                @if (App::getLocale() == 'en')
                                  <div class="alert alert-info alert-dismissable text-capitalize" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                    <p class="mb-0">select the number of the right Answer not the value of it</p>
                                  </div>
                                @else
                                  <div class="alert alert-info alert-dismissable text-capitalize" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                    <p class="mb-0">اكتب رقم ترتيب الاجابة الصحيحه و ليس القيمة الخاصه بها</p>
                                  </div>
                                @endif

                                <div class="mb-3">
                                  @php
                                    $correctAnswerNum = '';
                                  @endphp
                                  @foreach ($question->answers as $answer)
                                    @if ($answer->is_correct)
                                      @php $correctAnswerNum = $loop->iteration @endphp
                                    @endif
                                  @endforeach
                                  <input type="text" name="whichIsCorrect" class="form-control"
                                    placeholder="Which one is correct ?" value="{{ $correctAnswerNum }}">
                                </div>
                              </div>
                              {{-- grades options --}}
                              <div class="col-lg-12 border-top py-3">
                                <label for="grades">{{ trans('courses.grades') }}</label>
                                <select class="custom-select" id="grades" name="grade_id">
                                  @foreach ($allGrades as $grade)
                                    <option value="{{ $grade->id }}"
                                      @if ($grade->id == $question->grade_id) selected @endif>
                                      {{ $grade->name }}
                                    </option>
                                  @endforeach
                                </select>
                              </div>
                              {{-- submit --}}
                              <div class="col-xl-12 text-left border-top py-3">
                                <button type="submit" class="btn btn-md btn-success">
                                  <i class="fa fa-fw fa-check mr-1"></i> {{ trans('students.save') }}
                                </button>
                                <button type="button" class="btn btn-alt-primary" data-dismiss="modal">{{ trans('grades.cancel') }}</button>
                                <button type="button" class="btn btn-md btn-info add_option">
                                  <i class="fa fa-fw fa-check"></i>
                                  <span>Add One More</span>
                                </button>
                              </div>
                            </div>
                          </form>
                          {{-- End form --}}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- start delete modal Content -->
                <div class="modal fade" id="modal-delete-question{{ $question->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-block-large" aria-hidden="true">
                  <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="block block-rounded block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                          <h3 class="block-title">{{ trans('students.question_delete') }}</h3>
                          <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                              <i class="fa fa-fw fa-times"></i>
                            </button>
                          </div>
                        </div>
                        <div class="block-content font-size-sm">
                          {{-- start form --}}
                          <form action="{{ route('questions.destroy', $question->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="row">
                              <div class="col-lg-12 col-xl-12">
                                <div class="form-group text-center">
                                  <p>{{ trans('grades.before_delete_alert') }}</p>
                                  <p><strong>{{ $question->text }}</strong></p>
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
    const myOption = `
      <div class="mb-3 d-flex">
        <span class="btn btn-dark removeOption">
          <span aria-hidden="true">&times;</span>
        </span>
        <input type="text" name="answer[]" class="form-control mx-2" value="">
      </div>
    `;

    let addOptions = document.querySelectorAll('.add_option'); // all buttons

    let removeOption = document.querySelector('.removeOption');

    document.addEventListener('click', function(event) {
      // Start with the clicked element
      let targetElement = event.target;

      // Traverse the DOM upwards from the clicked element to see if it or any of its parents have the 'removeOption' class
      while (targetElement && !targetElement.classList.contains('removeOption')) {
        targetElement = targetElement.parentNode;
      }

      // If a parent element with the 'removeOption' class was found
      if (targetElement && targetElement.classList.contains('removeOption')) {
        // Get the parent div of the found element
        const parentDiv = targetElement.parentNode;

        // Perform your action on the parent div
        if (parentDiv) {
          parentDiv.remove();
        }
      }
    });

    addOptions.forEach(element => {
      element.addEventListener('click', function () {
        // find the .answer-options in the same line of elements then add one more option
        $(this).parent().siblings().eq(2).children('.answer-options').append(myOption);
      });
    });

  </script>

  <script>
    $(document).ready(function() {
      $('.mag-img').magnificPopup({type:'image'});
    });
  </script>

@endsection
