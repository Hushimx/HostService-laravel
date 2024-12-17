@extends('front.includes.layout')

@section('pageTitle', 'Quizzes')

@section('content')
<div class="border-bottom py-5">
  <div class="container">
    <h1 class="mb-5 text-center fw-bold">Select Your Quiz</h1>
    <div class="row">

      {{-- get quizzes --}}
      @foreach ($quizzes as $quiz)
        {{-- then get quiz_level from it --}}
        @if ($quiz->questions()->first())
          {{-- check if there is questions inside the quiz first --}}
          <div class="col-lg-6 col-xl-4">
            <div class="mb-3">
              <div class="card mb-3 quiz-card-border">
                <div class="card-body quiz quiz-card-border">
                  <h5 class="card-title text-capitalize fs-4">{{ $quiz->name }}</h5>
                  <p class="card-text mb-4">
                    {{ $quiz->description ? $quiz->description : 'There is No Description For This Quiz' }}
                  </p>
                  <div class="d-flex justify-content-between align-items-center">
                    <a href="/student/quiz/{{ $quiz->id }}" class="btn btn-primary text-capitalize"><i
                        class="fa-solid fa-circle-play fa-fw me-2"></i>start quiz</a>
                    <span class="fw-bold">{{ $quiz->time ? $quiz->time . ' Minutes' : 'Unlimited Time' }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @else
          <div class="col-lg-6 col-xl-4">
            <div class="mb-3">
              <div class="card mb-3 quiz-card-border">
                <div class="card-body quiz quiz-card-border">
                  <h5 class="card-title text-capitalize fs-4">{{ $quiz->name }}</h5>
                  <p class="card-text mb-4">
                    {{ $quiz->description ? $quiz->description : 'There is No Description For This Quiz' }}
                  </p>
                  <div class="d-flex justify-content-between align-items-center">
                    <p class="alert alert-warning text-capitalize">
                      <i class="fa-solid fa-triangle-exclamation me-2"></i>
                      <span>no Questions and answers added to start</span>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endif
      @endforeach

    </div>
  </div>
</div>
@endsection


