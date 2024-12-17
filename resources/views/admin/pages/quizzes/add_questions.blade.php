@extends('admin.dashboard.includes.master')

@section('css_adds')
  <style>
    .box1 {
      width: 20px;
      height: 20px;
    }

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
      {{ trans('students.add_question_to_quiz') }} <small class="font-size-base font-w400 text-muted">{{ trans('students.quizzes_list') }}</small>
    </x-slot>
    <li class="breadcrumb-item" aria-current="page">
      <a class="link-fx" href="/admin">{{ trans('main_trans.Dashboard_page') }}</a>
    </li>
    <li class="breadcrumb-item">{{ trans('students.quiz_list') }}</li>
  </x-hero>

  <!-- Page Full Content -->
  <x-page-full-content>

    <!-- go Back Button -->
    <a class="btn btn-success btn-sm mr-1 mb-3" href="/quizzes" id="goBackButton">
      <i class="fa fa-fw fa-arrow-right mr-1"></i>{{ trans('students.back') }}
    </a>

    <!-- start add button -->
    <button type="button" class="btn btn-success btn-sm mr-1 mb-3" id="btn_add_all">
      <i class="fa fa-fw fa-plus mr-1"></i>
      <span>{{ trans('students.add_selected_questions') }}</span>
    </button>

    <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
    <table id="datatable" class="table table-responsive-xl table-bordered table-striped table-vcenter js-dataTable-full">
      <thead>
        <tr>
          <th class="text-center" style="width: 80px;">
            <input class="d-block mx-auto box1" name="select_all" id="example-select-all" type="checkbox" onclick="CheckAll('box1', this)" />
          </th>
          <th class="text-center" style="width: 60px;">ID</th>
          <th>{{ trans('students.quiz_text') }}</th>
          <th class="d-none d-sm-table-cell">{{ trans('students.quiz_image') }}</th>
          <th class="d-none d-sm-table-cell">{{ trans('students.grade') }}</th>
          <th style="width: 15%">{{ trans('grades.action') }}</th>
        </tr>
      </thead>
      <tbody id="tbody">
      @foreach ($questions as $question)
        <tr>
          <td class="text-center"><input type="checkbox" value="{{ $question->id }}" class="box1"></td>
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
          <td class="d-none d-sm-table-cell font-size-sm">
            <span class="btn btn-dark btn-sm d-block">{{ $question->grade->name }}</span>
          </td>
          <td>
            <div class="d-flex flex-column justify-content-start">
              @if($quiz->questions->contains($question->id))
                <a class="btn btn-sm btn-danger text-left" href="{{ route('questions.removeOneQuestion', ['questionId' => $question->id, 'quizId'=> $quiz->id]) }}" data-toggle="click-ripple">
                  <i class="fa fa-times fa-fw mr-1"></i>
                  <span>{{ trans('students.remove_question') }}</span>
                </a>
              @else
                <a class="btn btn-sm btn-success text-left" href="{{ route('questions.storeOneQuestionToQuiz', ['questionId' => $question->id, 'quizId'=> $quiz->id]) }}" data-toggle="click-ripple">
                  <i class="fa fa-check fa-fw mr-1"></i>
                  <span>{{ trans('students.add_question') }}</span>
                </a>
              @endif
            </div>
          </td>
        </tr>
      @endforeach
      <!-- start select_all modal -->
      <div class="modal fade" id="select_all_questions" tabindex="-1" role="dialog" aria-labelledby="modal-block-large" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
          <div class="modal-content">
              <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                  <h3 class="block-title">{{ trans('students.add_selected_questions') }}</h3>
                  <div class="block-options">
                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                      <i class="fa fa-fw fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="block-content font-size-sm">
                  {{-- start form --}}
                  <form action="{{ route('questions.add_all_questions') }}" method="POST">
                    @csrf
                    <div class="row">
                      <div class="col-lg-12 col-xl-12">
                        <div class="form-group text-center text-capitalize">
                          <p>{{ trans('students.confirm_add_selected_questions') }}</p>
                        </div>
                        <input id="select_all_id" type="hidden" name="select_all_id" value="">
                        <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
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
      </tbody>
    </table>
  </x-page-full-content>

</main>
@endsection

@section('scripts')
  <script>
    $(document).ready(function() {
      $('.mag-img').magnificPopup({type:'image'});
    });
  </script>
  <script>
    // Selects all Items
    function CheckAll(className, elem) {
      var elements = document.getElementsByClassName(className);

      if (elem.checked) {
        for (var i = 0; i < elements.length; i++) {
          elements[i].checked = true;
        }
      } else {
        // $('#btn_add_all').hide();
        for (var i=0; i < elements.length; i++) {
          elements[i].checked = false;
        }
      }

    }

    // Delete Seleceted Button btn_add_all
    $('#btn_add_all').on('click', function () {
      var selected = new Array();
      $('#datatable input[type=checkbox]:checked').each(function () {
        selected.push(this.value);
      });

      // if user selected one row or more show the modal then
      if (selected.length > 0) {
        $('#select_all_questions').modal('show');
        $('input[id="select_all_id"]').val(selected);
      }
    });
  </script>
@endsection
