@props(['courses'])

<div class="our-courses py-5">
  <div class="container">
    <h1 class="text-center mb-5 display-4"  data-aos="fade-up" data-aos-duration="1500" class="aos-init aos-animate">Our Courses</h1>
    <div class="row gx-5">
    {{-- course card --}}
    @foreach ($courses as $course)
      <div class="col-md-6 col-lg-4">
        <x-courseCard :course="$course"></x-courseCard>
      </div>
    @endforeach
    </div>
  </div>
</div>
