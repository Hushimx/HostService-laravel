@extends('admin.dashboard.includes.master')

@section('content')
<!-- Main Container -->
<main id="main-container">
  <!-- Hero -->
  <div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
        <h1 class="flex-sm-fill h3 my-2">
          {{ trans('main_trans.results') }} <small class="font-size-base font-w400 text-muted">{{ trans('main_trans.results_list') }}</small>
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
        <x-alert></x-alert>

        <a href="{{ back()->getTargetUrl() }}" class="btn btn-dark mb-3"><i class="fa fa-arrow-left me-2"></i> Back</a>
        <h2 class="text-center">{{ $quiz->title }}</h2>
        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
        <table class="table table-bordered table-hover table-vcenter js-dataTable-full shadow-sm">
          <thead>
            <tr>
              <th class="text-center" style="width: 60px;">ID</th>
              <th>Question</th>
              <th>Student answers</th>
              <th>correct or false</th>
              {{-- <th style="width: 15%;">{{ trans('grades.action') }}</th> --}}
            </tr>
          </thead>
          <tbody>
            @foreach ($questions as $question)
              <tr>
                <td class="text-center font-size-sm">{{ $loop->iteration }}</td>
                <td class="font-w600 font-size-sm">{{ $question->text }}</td>
                <td class="font-w600 font-size-sm">
                  @if(isset($user_answers_ids_array[$question->id][0]))
                    {{ $user_answers_ids_array[$question->id][0]->content }}
                  @endif
                </td>
                <td class="font-w600 font-size-sm">
                  @if(isset($user_answers_ids_array[$question->id][0]))
                    @if ($user_answers_ids_array[$question->id][0]->is_correct == 1)
                      <span class="h6 text-light p-2 rounded" style="background-color: rgb(9, 187, 9)"><i class="fa fa-check mr-2"></i>{{ 'Correct' }}</span>
                    @else
                      <span class="h6 text-light p-2 rounded" style="background-color: rgb(187, 45, 9)"><i class="fa fa-times mr-2"></i>{{ 'False' }}</span>
                    @endif
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

        {{-- result details --}}
        <div class="row">
          <div class="col-lg-6">
            <div class="my-3 border p-3 shadow-sm">
              <p class="m-0">All Question Count = {{ $questions->count() }}</p>
              <p class="m-0">Correct Answers  = {{ $correctCount }}</p>
              <p class="m-0">Wrong Answers  = {{ $questions->count() - $correctCount }}</p>
              <hr>
              <p class="m-0">Student Mark  = {{ $correctCount }} / {{ $questions->count() }} </p>
              <p class="m-0">Student Mark In Percent  = {{ round((100 * $correctCount) / $questions->count()) }}%</p>
              <hr>
              <p>Status  =
                @if ( ((100 * $correctCount) / $questions->count()) > 50 )
                  <span class="h6 text-light p-2 rounded" style="background-color: rgb(9, 187, 9)"><i class="fa fa-check mr-2"></i>Passed</span>
                @else
                  <span class="h6 text-light p-2 rounded" style="background-color: rgb(187, 45, 9)"><i class="fa fa-times mr-2"></i>Didn't Pass</span>
                @endif
              </p>
              <a class="btn btn-success btn-sm mb-2"
                href="{{ route('quiz.reset', ['quiz_id' => $quiz->id, 'student_id' => $student->id]) }}">
                <i class="si si-refresh mr-1"></i>
                @if (App::getLocale() == 'en') <span>Quiz Reset</span> @else <span>السماح بأعادة الامتحان</span> @endif
              </a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

</main>
@endsection
