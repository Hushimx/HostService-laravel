

<!-- start bootstrap 5 carousel -->
<div class="slider">
  <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active" data-bs-interval="5000">
        <div class="overlay"></div>
        <img src="{{ asset('/front/imgs/sliders/cover1.jpg') }}" class="d-block w-100 100vh" alt="first cover in carousel">
        <div class="carousel-caption d-block d-md-block">
          <h5 data-aos="fade-up" data-aos-duration="1500">{{ trans('main_trans.welcome to mr mathematica') }}</h5>
          <p data-aos="fade-down" data-aos-duration="1500" class="mb-0">{{ trans('main_trans.Lets share your Maths works with us') }}</p>
        </div>
      </div>
      <div class="carousel-item" data-bs-interval="5000">
        <div class="overlay"></div>
        <img src="{{ asset('/front/imgs/sliders/cover2.jpg') }}" class="d-block w-100 100vh" alt="second cover in carousel">
        <div class="carousel-caption d-block d-md-block">
          <h5 data-aos="fade-up" data-aos-duration="1500">{{ trans('main_trans.High and calm sessions for you with') }}</h5>
          <p data-aos="fade-down" data-aos-duration="1500" class="mb-0">{{ trans('main_trans.the ability to do your own notes') }}</p>
        </div>
      </div>
      <div class="carousel-item" data-bs-interval="5000">
        <div class="overlay"></div>
        <img src="{{ asset('/front/imgs/sliders/cover3.png') }}" class="d-block w-100 100vh" alt="third cover in carousel">
        <div class="carousel-caption d-block d-md-block">
          <h5 data-aos="fade-up" data-aos-duration="1500" class="mb-0">{{ trans('main_trans.Act as classwork') }}</h5>
        </div>
      </div>
      <div class="carousel-item" data-bs-interval="5000">
        <div class="overlay"></div>
        <img src="{{ asset('/front/imgs/sliders/cover4.png') }}" class="d-block w-100 100vh" alt="forth cover in carousel">
        <div class="carousel-caption d-block d-md-block">
          <h5 data-aos="fade-up" data-aos-duration="1500" class="mb-0">{{ trans('main_trans.Have many helpful') }}</h5>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</div>

{{--end carousel --}}
