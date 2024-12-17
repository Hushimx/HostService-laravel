@props(['course'])

<div class="course-card mb-5 mb-lg-3 aos-init aos-animate" data-aos="zoom-in-left" data-aos-duration="1000">
  <a href="{{ route('course.play', [$course, 0]) }}">
    <div class="img-container">
      @if ($course->image)
        <img class="img-fluid w-100" src="{{ url('storage/'.$course->image) }}" alt="{{$course->name}}">
      @else
        <img class="img-fluid w-100" src="{{ url('storage/posts_images/photo22.jpg') }}" alt="{{$course->name}}">
      @endif
    </div>
  </a>
  <div class="course-content">
    <a class="mb-3" href="{{ route('course.play', [$course, 0]) }}"><h5>{{ $course->name }}</h5></a>
    <p class="mb-0">{{ $course->description }}</p>
  </div>
  <div class="course-info d-flex justify-content-between align-items-center border-top p-2">
    <span class="author">{{ $course->author ?? 'Mr Ibrahim'}}</span>
    <span class="price">{{ $course->price }} EGP</span>
  </div>
</div>
