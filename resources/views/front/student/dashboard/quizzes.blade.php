@extends('front.student.includes.student_dashboard_layout')
@section('pageTitle', 'Quizzes | Mathematica')

@section('content')
  <x-headTitle>
    <x-slot name="title">{{ trans('students.All your quizzes will be here !') }}</x-slot>
  </x-headTitle>

  {{-- all posts --}}
  <div class="all-quizzes p-0 bg-transparent">
    <h3 class="title mb-4 fw-bold" @if (App::getLocale() == 'ar') dir="rtl" data-aos="fade-right" @else data-aos="fade-left" @endif data-aos-delay="500">
      {{ trans('main_trans.quizzes') }}
    </h3>
    <div class="row" @if (App::getLocale() == 'ar') dir="rtl" @endif>
      @forelse ($quizzes as $quiz)
        {{-- show only quizzes that has questions only --}}
        @if ($quiz->questions()->first())
          <div class="col-md-6 col-xl-4 mb-3">
            <x-quizCard :quiz="$quiz" :quizpresent="$quiz_present"></x-quizCard>
          </div>
        @endif
      @empty
        {{-- welcome alert --}}
        <div class="alert alert-info alert-dismissible fade show" role="alert">
          <h4 class="alert-heading">
            <i class="fa fa-info-circle"></i>
            <span>Good! you are here</span>
          </h4>
          <p>At this moment there is no quiz for you to see, in this quiz every question has time limit you should answer before the time goes to 0</p>
          <p>Time now is ...</p>
          <hr>
          <p class="mb-0">Your teacher will add many quizzes in this section make sure to check it out everyday.</p>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endforelse
    </div>
  </div>
@endsection
