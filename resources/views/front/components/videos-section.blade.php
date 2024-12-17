@props(['videos'])

<div class="videos bg-shaped-white py-5" id="videos">
  <div class="container">
    <h1 class="text-center py-5 display-4" data-aos="fade-up" data-aos-duration="1500" class="aos-init aos-animate">Videos Mr.Mathematica</h1>

      <div class="row">
        <div class="col-lg-12 mb-3">
          <iframe data-aos="fade-right" data-aos-duration="1500"
            class="main-video rounded aos-init aos-animate d-block mx-auto"
            height="auto" style=""
            src="https://www.youtube.com/embed/{{ $videos[0]->url }}"
            title="منظومة شرح مادة الفيزياء للصف الثالث الثانوي 🧲"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
          </iframe>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 mb-3">
          <iframe data-aos="fade-right" data-aos-duration="1500"
            class="rounded aos-init aos-animate"
            width="100%" height="auto"
            src="https://www.youtube.com/embed/{{ $videos[1]->url }}"
            title="Mr Mathematica" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin"allowfullscreen>
          </iframe>
        </div>
        <div class="col-lg-6 mb-3">
          <iframe data-aos="fade-left" data-aos-duration="1500"
            class="rounded aos-init aos-animate"
            width="100%" height="auto"
            src="https://www.youtube.com/embed/{{ $videos[2]->url }}"
            title="Mr Mathematica" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
          </iframe>
        </div>
      </div>
  </div>
</div>
