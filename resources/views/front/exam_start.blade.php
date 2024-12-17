@extends('front.includes.layout')

@section('pageTitle', 'Quizzes Area')

@section('content')
<div class="border-bottom py-5">
  <div class="container">
    <div class="row">
      @if ($quiz->questions()->first())

      <h1 class="mb-5 text-center fw-bold">Select Your Answer</h1>

      {{-- time counter --}}
      <h3 class="counterTime shadow">
        <i class="fa-solid fa-hourglass-end me-2"></i>{{ $quiz->time ? $quiz->time : 'Unlimited' }}
      </h3>

      <form id="quizForm" class="p-3 py-4" action="{{ url('student/submit-answers') }}" method="POST"
        style="font-family: sans-serif;">
        @csrf

        {{-- if there is desc for the quiz show it --}}
        @if ($quiz->text)
        <p class="fs-4 shadow rounded-4 p-3 mb-5 text-center">{{ $quiz->text }}</p>
        @endif

        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
        <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">

        <div class="row">
          @foreach ($questions as $question)
          <div class="col-xl-12">
            <div class="px-4 pb-3 text-end shadow p-3 rounded-4 mb-5 position-relative pt-5">

              <span class="question-number position-absolute translate-middle text-light rounded-circle bg-primary">{{ $loop->iteration }}</span>

              <h2 class="text-capitalize mb-3 text-center">{{ $question->title }}</h2>

              <input type="hidden" name="answers[{{ $loop->index }}][question_id]" value="{{ $question->id }}">

              @if ($question->image)
              <div class="form-check my-3">
                <img class="img-thumbnail d-block m-auto" src="{{ asset('storage/' . $question->image) }}" alt="">
              </div>
              @endif

              @foreach ($question->answers as $answer)
              <div class="form-check">
                <input class="form-check-input answer-input" type="radio"
                  name="answers[{{ $loop->parent->index }}][answer_id]" id="Radio{{ $answer->id }}"
                  value="{{ $answer->id }}">
                <label class="form-check-label answer-choice fs-3" for="Radio{{ $answer->id }}">
                  {{ $answer->content }}
                </label>
              </div>
              @endforeach
            </div>
          </div>
          @endforeach
        </div>

        <div>
          <button id="submitBtn" class="btn btn-primary text-capitalize" type="submit">
            <i class="fa-solid fa-thumbs-up me-2"></i>
            <span>{{ trans('students.Submit Your Answers') }}</span>
          </button>
        </div>

      </form>
      @else
      <p class="text-center alert alert-danger">
        <i class="fa-solid fa-triangle-exclamation me-2"></i>
        <span>There is No Questions Added To this Quiz</span>
      </p>
      @endif

      {{-- start results --}}
      <!-- Button trigger modal -->
      <button id="modalResult" type="button" class="btn btn-primary d-none" data-bs-toggle="modal"
        data-bs-target="#exampleModal">
        Launch demo modal
      </button>

      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Your Results</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p class="text-center">You Got <span class="correct"></span> Out <span class="questions"></span></p>
              <p class="text-center result-info"></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      {{-- End results --}}

    </div>
  </div>
</div>
@endsection

@section('scripts')

<script>
  $(document).ready(function() {
            let submitBtn = document.querySelector('#submitBtn');
            let modalResult = document.querySelector('#modalResult');
            $('#submitBtn').click(function(e) {
                e.preventDefault();

                // Serialize the form data
                const formData = $('#quizForm').serialize();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // Submit the form data via AJAX
                $.ajax({
                    url: '{{ url('student/submit-answers') }}',
                    type: 'POST',
                    data: formData,
                    beforeSend: function() {
                        submitBtn.innerHTML =
                            `<i class="fa-solid fa-thumbs-up me-2"></i> Sending ...`;
                    },
                    success: function(data) {
                        submitBtn.innerHTML =
                            `<i class="fa-solid fa-thumbs-up me-2"></i>Submit Your Answers`;
                        modalResult.click();

                        console.log(data);

                        document.querySelector('.modal-body .correct').innerHTML = data
                            .correctAnswers;
                        document.querySelector('.modal-body .questions').innerHTML = data
                            .totalQuestions;

                        if (data.correctAnswers > (data.totalQuestions / 2)) {
                            document.querySelector('.result-info').innerHTML = 'success';
                        } else {
                            document.querySelector('.result-info').innerHTML = 'fail';
                        }
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

            let dateDiff = {{ $quiz->time ? $quiz->time * 60 * 1000 : 0 }};

            let counter = setInterval(() => {
                dateDiff -= 1000;

                let hours = Math.floor(dateDiff % (1000 * 60 * 60 * 24) / (1000 * 60 * 60));
                let minutes = Math.floor(dateDiff % (1000 * 60 * 60) / (1000 * 60));
                let seconds = Math.floor(dateDiff % (1000 * 60) / 1000);

                // console.log('seconds = ', seconds, 'minutes = ', minutes, 'hours = ', hours);

                // Update the display or do something with the number
                document.querySelector('.counterTime').innerHTML =
                    `<i class="fa-solid fa-hourglass-end me-2"></i> ${hours < 10 ? '0'+hours : hours } : ${minutes < 10 ? '0'+minutes : minutes } : ${seconds < 10 ? '0'+seconds : seconds }`;

                if (dateDiff === 0) {
                    clearInterval(counter);
                    document.querySelector('#submitBtn').click();
                    document.querySelector('.counterTime').style.backgroundColor = 'red';
                }

                $('#submitBtn').on('click', function() {
                    clearInterval(counter);
                });

                $("#hours").html(hours);
                $("#mins").html(minutes);
                $("#secs").html(seconds);
            }, 1000);
        }
</script>


@endsection
