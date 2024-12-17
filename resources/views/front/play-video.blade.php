@extends('front.includes.layout')
@section('pageTitle', $video->name)

@section('css_adds')
  <style>
    .sticky {
      position: static;
    }

    .navbar {
      background-color: var(--nav-bg-blue) !important;
    }
  </style>
@endsection

@section('content')
  @include('front.includes.navbar')

  <div class="play-course-video py-4">
    <div class="container-fluid">
      {{-- video controls --}}
      <div class="row px-0 px-lg-5">
        @if ($video)
        <div class="mb-3">
          <div class="d-flex justify-content-between align-items-center gap-3">
            {{-- prev btn --}}
            <a class="btn btn-primary rounded-1 text-uppercase text-white @if ($video->id === $course->videos->first()->id) disabled @endif"
              href="{{ route('course.play', [$course, $videoOrder - 2]) }}">
              <i class="fa fa-chevron-left"></i> <span>{{ trans('main_trans.prev-lesson') }}</span>
            </a>
            {{-- time counter --}}
            <p class="alert alert-info mb-0">
              <i class="fa-solid fa-circle-exclamation me-2"></i><span>Time remaining to unlock the question <strong><span id="timeCounter"></span></strong> !</span>
            </p>
            {{-- next btn --}}
            @if ($isVideoUnlocked)
              <a class="btn btn-next btn-primary rounded-1 text-uppercase text-white disabled @if ($video->id === $course->videos->last()->id) disabled @endif">
                <span>{{ trans('main_trans.next-lesson') }}</span> <i class="fa fa-chevron-right"></i>
              </a>
            @endif
            <a class="d-none next-video-btn" href="{{ route('course.play', [$course, $videoOrder]) }}"></a>
          </div>
        </div>
        @endif
      </div>

      {{-- video player container --}}
      <div class="row px-0 px-lg-5">
        <div class="col-lg-8 mb-4" id="video-player-cont">
          @if ($video && $isVideoUnlocked)
            {{-- Video name --}}
            <div class="playlist mb-3 pb-3">
              <h4 class="mb-0">{{ $video->name }}</h4>
            </div>
            {{-- Video player --}}
            <div class="playlist mb-3 pb-3" id="video-area">
              <div class="video-card">
                <iframe src="https://www.youtube.com/embed/{{ $video->link }}" title="Motorcycle - As The Rush Comes (OFFICIAL VIDEO)"
                  frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                  referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
              </div>
            </div>

            {{-- Video Question --}}
            <div class="bg-body-tertiary p-3 rounded shadow-sm mb-3" id="video-question">
              <p class="alert alert-primary text-center text-capitalize"><i class="fa-solid fa-circle-exclamation me-2"></i>you need to answer the question to unlock the next video</p>
              <h2 class="mb-3 text-center">{{ $videoQuestion->text }}</h2>
              @if ( $videoQuestion->image )
                <img class="w-50 border shadow mb-3 d-block mx-auto" src="{{ asset('storage/'. $videoQuestion->image) }}" alt="{{ $videoQuestion->text }}">
              @endif
              <form id="videoQuestionForm" action="{{ route('videoQuestion.submit') }}" method="POST">
                @csrf
                <input type="hidden" name="questionId" value="{{ $video->questions[0]->id }}">
                <input type="hidden" name="videoOrder" value="{{ $videoOrder + 1 }}">
                <input type="hidden" name="courseId" value="{{ $course->id }}">
                <input type="hidden" name="videoId" value="{{ $video->id }}">
                @foreach ($video->questions[0]->answers as $answer)
                <div class="form-check">
                  <input class="form-check-input answer-input" type="radio" name="answers[]" id="Radio{{ $answer->id }}" value="{{ $answer->id }}">
                  <label class="form-check-label answer-choice fs-3"
                    for="Radio{{ $answer->id }}">{{ $answer->content }}</label>
                </div>
                @endforeach
                <div class="form-check mt-3 d-flex justify-content-center gap-3">
                  <button id="returnBackToPlayer" class="btn btn-primary d-block mx-auto" type="button"><i class="fa fa-arrow-up"></i> Back To Video</button>
                  <button id="submitBtn" class="btn btn-primary text-capitalize d-block mx-auto" type="submit">
                    <i class="fa-solid fa-thumbs-up me-1"></i>
                    <span>{{ trans('students.Submit Your Answer') }}</span>
                  </button>
                </div>
              </form>
            </div>
          @endif
        </div>
        {{-- right playlist --}}
        @if ($isVideoUnlocked)
          <div class="col-lg-4">
            <div class="playlist mb-3 pb-3">
              <h4 class="mb-0">{{ $course->name }}</h4>
            </div>
            <div class="playlist">
              <table class="table table-borderless table-vcenter">
                <tbody>
                  <tr class="table-active">
                    <th style="width: 50px;"></th>
                    <th>PLaylist</th>
                  </tr>
                  @foreach ($course->videos as $courseVideo)
                    @if ($videosUnlocked->contains("video_id", $courseVideo->id))
                      <tr>
                        <td class="table-success text-center">
                          <i class="fa fa-fw fa-unlock text-success"></i>
                        </td>
                        <td>
                          <a href="{{ route('course.play', [$course, $loop->iteration]) }}">{{ $courseVideo->name }}</a>
                        </td>
                      </tr>
                    @else
                      <tr class="table-active">
                        <td class="table-danger text-center">
                          <i class="fa fa-fw fa-lock text-danger"></i>
                        </td>
                        <td class="bg-gray">
                          <a href="{{ route('course.play', [$course,  $loop->iteration]) }}">{{ $courseVideo->name }}</a>
                        </td>
                      </tr>
                    @endif
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        @else
          {{-- video is locked alert message --}}
          <div class="col-lg-12 mb-4 py-3">
            <div class="alert alert-danger" @if (App::getLocale() == 'ar') dir="rtl" @endif>
              <i class="fa fa-fw fa-lock text-danger"></i>
              <span>{{ trans('students.video_not_unlocked') }}</span>
            </div>
          </div>
        @endif

        {{-- course done alert message --}}
        <div class="course-done-alert alert alert-success d-none" role="alert">
          <h4 class="alert-heading">Well done!</h4>
          <p>Aww Congratiolations this is your last video in this course</p>
          <hr>
          <p class="mb-0">Now all your videos are <strong>unlocked</strong> for you so you can watch at any time</p>
        </div>
      </div>

    </div>
  </div>

  <!-- start footer -->
  <x-footer />
@endsection

@section('scripts')
  <script>
    let currentTime = new Date();
    let year = currentTime.getFullYear();
    document.querySelector('#thisYear').innerHTML = year;
  </script>

  @php
    $lastVideoId = $course->videos()->latest()->value('id');
  @endphp

  {{-- show modal after video duration goes 0 --}}
  {{-- if this video is not the last video --}}

  <script>
    let videoDuration   = {{ $video->time }} * 1000; // per minute if 1 then 1 minute
    let nextVideoBtn    = document.querySelector('.btn-next'); // to show question
    let nextVideoButton = document.querySelector('.next-video-btn'); // to go to next video
    let submitBtn       = document.querySelector('#submitBtn'); // to go to next video
    let returnBackPlayerButton = document.querySelector('#returnBackToPlayer');

    $('#video-area').slideDown();
    $('#video-question').slideUp();

    returnBackPlayerButton.addEventListener('click', function () {
      $('#video-area').slideDown();
      $('#video-question').slideUp();
    });

    // counter for showing the button that will show the question
    startCountdown({{ $video->time }}, '#timeCounter');

    function showQuestion() {
      $('#video-area').slideUp();
      $('#video-question').slideDown();
    }

    $('#videoQuestionForm').on('submit', function (e) {
        e.preventDefault();

        // Get form data
        const formData = $(this).serialize();

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
          type: "POST",
          url: $(this).attr("action"),
          data: formData,
          beforeSend: function() {
            // setting a timeout
            submitBtn.innerHTML = "<i class='fa fa-spin fa-spinner'></i> Sending...";
          },
          success: function (response) {
            console.log('response: ', response);

            if (response.message == "success") {
              submitBtn.innerHTML = `<i class='fa fa-check me-2'></i>${response.message}`;
              nextVideoButton.click();
              submitBtn.setAttribute('disabled', true);
            } else if (response.message == "lastVideo") {
              submitBtn.innerHTML = `<i class='fa fa-check me-2'></i> Send`;
              document.querySelector('.course-done-alert').classList.remove('d-none');
              $('#video-player-cont').slideUp();
              $('.playlist').slideUp();
              submitBtn.setAttribute('disabled', true);
            } else {
              submitBtn.innerHTML = `<i class='fa fa-check me-2'></i> Send`;
              // window.location.reload();
            }
          },
          error: function (xhr) {
            console.log('xhr: ', xhr);
            // Handle error response
            const errors = xhr.responseJSON?.errors || "Something went wrong!";
            submitBtn.innerHTML = `<i class='fa fa-check me-2'></i> Send`;
          }
        });

      });

    function startCountdown(durationInSeconds, displayElementIdOrClass) {
      // Calculate initial minutes and seconds
      let time = durationInSeconds;

      // Reference the display element
      const displayElement = document.querySelector(displayElementIdOrClass);

      // Update the display
      function updateDisplay() {
          const minutes = Math.floor(time / 60);
          const seconds = time % 60;

          displayElement.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
      }

      // Initialize the first display
      updateDisplay();

      // Start the interval
      const interval = setInterval(() => {
          if (time > 0) {
              time--; // Decrement time
              updateDisplay();
          } else {
              clearInterval(interval); // Stop the timer when it reaches 0
              console.log('Countdown finished!');
              if (nextVideoBtn.classList.contains('d-none') || nextVideoBtn.classList.contains('disabled')) {
                nextVideoBtn.classList.remove('disabled'); // to be able to click on it
                nextVideoBtn.classList.add('btn-unlocked'); // for animation when button show
                nextVideoBtn.addEventListener('click', showQuestion);
              }
          }
      }, 1000); // Run every second
    }
  </script>

@endsection
