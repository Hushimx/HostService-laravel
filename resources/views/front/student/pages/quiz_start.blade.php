@extends('front.student.includes.student_dashboard_layout')
@section('pageTitle', 'Quiz Started | Mathematica')

@section('content')
  <x-headTitle>
    <x-slot name="title">{{ trans('students.This is where Quiz Starts') }}</x-slot>
  </x-headTitle>

  @php
    $correctAnswersCount = 0;
    $wrongAnswersCount = 0;
    $totalAnswers = 0;
  @endphp

  @if (!$thisQuizIsEntredBefore)
  {{-- time counter --}}
  <h3 class="counterTime shadow"><i class="fa-solid fa-hourglass-end me-2"></i>{{ $quiz->time ? gmdate('i:s', $quiz->time) : "Unlimited" }}</h3>
  @else
    {{-- entered it before --}}
    @if (App::getLocale() == 'en')
      <div class="alert alert-primary alert-dismissable mb-3" role="alert">
        <p class="mb-2 text-capitalize fw-bold">You have participated in This Quiz Before</p>
        <p class="mb-0 text-capitalize ">If You Wish to participated again ask your teacher to allow you</p>
      </div>
    @else
      <div class="alert alert-primary alert-dismissable mb-3" role="alert" dir="rtl">
        <p class="mb-2 text-capitalize fw-bold">لقد قمت بالفعل بالدخول على هذا الامتحان من قبل</p>
        <p class="mb-0 text-capitalize ">اذا اردت اعاده الامتحان مره اخرى ارجوا التواصل مع المعلم الخاص بك</p>
      </div>
    @endif
  @endif
  {{-- all posts --}}
  <div class="all-questions p-0 bg-transparent">
    <h3 class="title mb-5 fw-bold" @if (App::getLocale() == 'ar') dir="rtl" data-aos="fade-right" @else data-aos="fade-left" @endif data-aos-delay="500">
      {{ trans('main_trans.questions') }}
    </h3>
    <form id="quizForm" class="pb-5">

      <div class="row" @if (App::getLocale() == 'ar') dir="rtl" @endif>
        {{-- hidden inputs --}}
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
        <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">

        {{-- questions --}}
        @foreach ($quiz->questions as $question)
        @php $totalAnswers++; @endphp
          {{-- loop on every question to get the id of it --}}
          <input type="hidden" name="answers[{{ $loop->index }}][question_id]" value="{{ $question->id }}">

          <div class="col-sm-12 mb-3">
            <div class="question-card p-3 mb-5 position-relative rounded border shadow">
              <span class="question-number position-absolute translate-middle text-light rounded-circle bg-primary">{{ $loop->iteration }}</span>

              <h3 class="my-4 text-center">{{ $question->text }}</h3>

              @if ($question->image)
              <img class="img-thumbnail d-block m-auto mb-3" src="{{ asset('storage/' . $question->image) }}" alt="{{ $question->text }}">
              @endif

              {{-- answers --}}
              @foreach ($question->answers as $answer)
              <div class="form-check px-0">
                <input class="form-check-input answer-input
                @if ($thisQuizIsEntredBefore)
                  {{-- check student answer in loop is found in the other array of anwers --}}
                  @if ($user_answers->contains('answer_id', $answer->id))
                    {{-- check first if this is the selected answer user did if so then show it wrong or right --}}
                    @if ($answer->is_correct)
                      {{ 'correct-answer' }}
                      @php $correctAnswersCount++; @endphp
                    @else
                      {{ 'wrong-answer' }}
                      @php $wrongAnswersCount++; @endphp
                    @endif
                  @else
                    @if ($answer->is_correct)
                      {{ 'correct-answer' }}
                    @else
                      {{ 'wrong-answer' }}
                    @endif
                  @endif
                @endif
                " type="radio"
                  @if ($thisQuizIsEntredBefore)
                    @foreach ($user_answers as $user_answer)
                      {{-- check student answer if this is it --}}
                      @if ($answer->id == $user_answer->answer_id) {{ 'checked' }}  @endif
                    @endforeach
                  @endif
                  name="answers[{{ $loop->parent->index }}][answer_id]" id="Radio{{ $answer->id }}"
                  value="{{ $answer->id }}">
                <label class="form-check-label answer-choice fs-3" for="Radio{{ $answer->id }}">{{ $answer->content }}</label>
              </div>
              @endforeach
            </div>
          </div>
        @endforeach
      </div>

      {{-- if student entered this exam before dont show the quiz  --}}
      @if (!$thisQuizIsEntredBefore)
        <div>
          <button class="btn btn-primary text-capitalize d-block mx-auto p-3" type="submit" id="submitBtn">
            <i class="fa-solid fa-thumbs-up me-1"></i>
            <span>{{ trans('students.Submit Your Answers') }}</span>
          </button>
          <a class="d-none student-quizzes-btn" href="{{ route('student.quizzes') }}">Quizzess</a>
        </div>
      @endif

    </form>

    {{-- show results --}}
    @if ($thisQuizIsEntredBefore)
    <div class="mb-5">
      @if (App::getLocale() == 'en')
        <div class="alert alert-primary alert-dismissable mb-0 py-4" role="alert">
          @if (isset($correctAnswersCount) && isset($wrongAnswersCount) && isset($totalAnswers))
            <h3 class="mb-4"><i class="fa fa-clock fa-fw"></i> {{ trans('students.Total Answers') }}: <span class="mb-0 fw-bold">{{ $totalAnswers }}</span></h3>
            <h3 class="mb-4"><i class="fa fa-check fa-fw"></i> {{ trans('students.Total Correct Answers') }}: <span class="mb-2 fw-bold">{{ $correctAnswersCount }}</span></h3>
            <h3 class="mb-4"><i class="fa fa-times fa-fw"></i> {{ trans('students.Total Wrong Answers') }}: <span class="mb-0 fw-bold">{{ $wrongAnswersCount }}</span></h3>
            <h3 class="mb-0">
              <i class="fa fa-file fa-fw"></i>
              <span class="mr-2">{{ trans('students.result') }} : </span>
              @if ($correctAnswersCount > ($totalAnswers / 2))
                <span class="bg-success text-white rounded px-3 fw-bold">{{ trans('students.passed') }}</span>
              @else
                <span class="bg-danger text-white rounded px-3 fw-bold">{{ trans('students.failed') }}</span>
              @endif
            </h3>
          @endif
        </div>
      @else
        <div class="alert alert-primary alert-dismissable mb-0" role="alert" dir="rtl">
          @if (isset($correctAnswersCount) && isset($wrongAnswersCount) && isset($totalAnswers))
            <h3 class="mb-4"><i class="fa fa-clock fa-fw"></i> {{ trans('students.Total Answers') }} : <span class="mb-0 fw-bold">{{ $totalAnswers }}</span></h3>
            <h3 class="mb-4"><i class="fa fa-check fa-fw"></i> {{ trans('students.Total Correct Answers') }} : <span class="mb-2 fw-bold">{{ $correctAnswersCount }}</span></h3>
            <h3 class="mb-4"><i class="fa fa-times fa-fw"></i> {{ trans('students.Total Wrong Answers') }} : <span class="mb-0 fw-bold">{{ $wrongAnswersCount }}</span></h3>
            <h3 class="mb-4">
              <i class="fa fa-file fa-fw"></i>
              <span class="mr-2">{{ trans('students.result') }} : </span>
              @if ($correctAnswersCount > ($totalAnswers / 2 ))
                <span class="bg-success text-white rounded px-3 fw-bold">{{ trans('students.passed') }}</span>
              @else
                <span class="bg-danger text-white rounded px-3 fw-bold">{{ trans('students.failed') }}</span>
              @endif
            </h3>
          @endif
        </div>
      @endif
    </div>
    @endif

  </div>
@endsection


@section('js_scripts')

  {{-- if student entered this exam before dont show the quiz  --}}
  @if (!$thisQuizIsEntredBefore)
  {{-- didn't entered it before --}}
  <script>
    // script responsible for sending answers
    $(document).ready(function() {
      let submitBtn = document.querySelector('#submitBtn');
      // let modalResult = document.querySelector('#modalResult');

      $('#quizForm').on('submit', function (e) {
        e.preventDefault();

        // Serialize the form data
        const formData = $(this).serialize();

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        // Submit the form data via AJAX
        $.ajax({
          url: '{{ url("student-dashboard/submit-answers") }}',
          type: 'POST',
          data: formData,
          beforeSend: function() {
            submitBtn.innerHTML = `<i class="fa-solid fa-thumbs-up me-2"></i> Sending ...`;
          },
          success: function(data) {
            console.log('data: ', data);
            if (data && data.message == "enteredBefore") {
              window.alert('You have Enetered this Quiz Before');
              document.querySelector('.student-quizzes-btn').click();
              return ;
            }
            submitBtn.innerHTML = `<i class="fa-solid fa-thumbs-up me-2"></i>Submit Your Answers`;
            // window.location.reload();
            window.alert('Your answers submited Successfully');
            document.querySelector('.student-quizzes-btn').click();
          },
          error: function(error) {
            // An error occurred
            alert('An error occurred while submitting your answers.');
            console.log(error);
          },
        });

      });
    });

    // start quiz time counter code

    // Set the initial number
    let quizTime = {{ $quiz->time ? $quiz->time : 0 }};

    if (quizTime > 0) { // if there is number in quizTime do count

      let dateDiff = {{ $quiz->time ? $quiz->time * 1000   : 0 }};

      let counter = setInterval(() => {
        dateDiff -= 1000;

        let hours = Math.floor(dateDiff % (1000 * 60 * 60 * 24) / (1000 * 60 * 60) );
        let minutes = Math.floor(dateDiff % (1000 * 60 * 60 ) / (1000 * 60));
        let seconds = Math.floor(dateDiff % (1000 * 60 ) / 1000);

        // console.log('seconds = ', seconds, 'minutes = ', minutes, 'hours = ', hours);

        // Update the display or do something with the number
        document.querySelector('.counterTime').innerHTML = `<i class="fa-solid fa-hourglass-end me-2"></i> ${hours < 10 ? '0'+hours : hours } : ${minutes < 10 ? '0'+minutes : minutes } : ${seconds < 10 ? '0'+seconds : seconds }`;

        if (dateDiff === 0) {
          clearInterval(counter);
          document.querySelector('#submitBtn').click();
          document.querySelector('.counterTime').style.backgroundColor = 'red';
        }

        $('#submitBtn').on('click', function () {
          clearInterval(counter);
        });

        $("#hours").html(hours);
        $("#mins").html(minutes);
        $("#secs").html(seconds);

      }, 1000);

    }

  </script>
  @endif
@endsection
