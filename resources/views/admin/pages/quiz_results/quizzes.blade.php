@extends('admin.dashboard.includes.master')

@section('content')
<!-- Main Container -->
<main id="main-container">
  <!-- Hero -->
  <div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
        <h1 class="flex-sm-fill h3 my-2">
          {{ trans('main_trans.results') }} <small class="font-size-base font-w400 text-muted">{{ $student->name }}</small>
        </h1>
        <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item" aria-current="page">
              <a class="link-fx" href="/">{{ trans('main_trans.Dashboard_page') }}</a>
            </li>
            <li class="breadcrumb-item">{{ trans('main_trans.results') }}</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>

    <!-- Page Content -->
    <div class="content">
      <div class="block block-rounded">
        <div class="block-content block-content-full">

          {{-- back button --}}
          <a href="/admin/quiz_results" class="btn btn-dark mb-3">
            <i class="fa fa-arrow-left me-2"></i>
            <span>Back</span>
          </a>

          {{-- end errors And Alerts --}}
          <x-alert></x-alert>

          <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
          <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
            <thead>
              <tr>
                <th class="text-center" style="width: 60px;">ID</th>
                <th>{{ trans('main_trans.name') }}</th>
                <th style="width: 15%;">{{ trans('grades.action') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($student->quizzes as $quiz)
                <tr>
                  <td class="text-center font-size-sm">{{ $loop->iteration }}</td>
                  <td class="font-w600 font-size-sm">{{ $quiz->title }}</td>
                  <td>
                    @foreach ($student->quizzes as $studentQuiz)
                      @if ($studentQuiz->id == $quiz->id)
                        <a class="btn btn-success btn-sm mb-2 d-block text-left"
                          href="{{ route('quiz.reset', ['quiz_id' => $quiz->id, 'student_id' => $student->id]) }}">
                          <i class="si si-refresh mr-1"></i>
                          @if (App::getLocale() == 'en') <span>Quiz Reset</span> @else <span>السماح بأعادة الامتحان</span> @endif
                        </a>
                      @endif
                    @endforeach
                    <a class="btn btn-info btn-sm d-block text-left"
                      href="{{ route('quiz.questions', ['quiz_id' => $quiz->id, 'user_id' => $student->id]) }}">
                      <i class="fa fa-file-alt fa-fw mr-1"></i>
                      @if (App::getLocale() == 'en')
                        <span>Result Details</span>
                      @else
                        <span>نتيجة الطالب بالتفصيل</span>
                      @endif
                    </a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

        </div>
      </div>
    </div>

</main>
@endsection
