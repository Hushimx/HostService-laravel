@extends('front.includes.layout')

@section('pageTitle', 'Quizzes Level')

@section('content')
  <div class="border-bottom py-5">
    <div class="container">
      <h1 class="mb-5 text-center fw-bold">Select Test Level</h1>
      <div class="row">
        {{-- show all quiz levels --}}
        @foreach ($quiz_levels as $quiz_level)
          <div class="col-md-6 col-xl-4">
            <div class="mb-3">
              <div class="card mb-3 quiz-card-border">
                <div class="card-body quiz quiz-card-border">
                  <h5 class="card-title text-capitalize fs-4"> {{$quiz_level->name}}</h5>
                  <p class="card-text mb-4">{{ $quiz_level->description ? $quiz_level->description : 'There is No Description For This Level'}}</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <a href="/student/quiz_levels/{{ $quiz_level->id }}" class="btn btn-primary text-capitalize"><i class="fa-solid fa-circle-play fa-fw me-2"></i>Show Quizzes</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
        {{-- end show all quiz levels --}}
      </div>
    </div>
  </div>
@endsection
