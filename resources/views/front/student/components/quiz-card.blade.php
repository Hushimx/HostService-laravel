@props(['quiz', 'quizpresent'])

<div class="quiz_card p-3 @if ($quizpresent->contains('quiz_id', $quiz->id)) registered @else not-registered @endif ">
  {{-- if quiz is entered --}}
  @if ($quizpresent->contains('quiz_id', $quiz->id))
    <p class="mb-2"><i class="fa fa-check"></i><span class="mx-2">Already Ended</span></p>
  @else {{-- if quiz not entered --}}
    <p class="mb-2"><i class="fa fa-times"></i><span class="mx-2">Not started yet</span></p>
  @endif
  <h2 class="mb-0">{{ $quiz->title }}</h2>
  <p class="mb-3">{{ $quiz->description }}</p>
  {{-- if quiz not entered show enter button--}}

  <a class="mb-3 p-1 px-2 d-inline-block tt" href="{{ route('quiz.start', $quiz) }}">
    @if ($quizpresent->contains('quiz_id', $quiz->id))
      {{ trans('students.showResults') }}
    @else
      {{ trans('students.quiz_start') }}
    @endif
  </a>

  <h6 class="mb-0" dir="ltr">{{ date('Y-m-d h:i A', strtotime($quiz->scheduled_at)) }}</h6>
</div>
