<div class="customGradientAlt relative overflow-x-hidden">
  <img src="{{asset('images/sep-bottom.png')}}" class="rotate-180 max-h-[95px] w-full absolute top-[-1px] left-0 z-0" alt="">
  <div data-aos="fade-up" class="py-24 px-4 mx-auto max-w-[1920px] md:py-36">
    @if($title)
      <h2 class="text-4xl font-afacad font-medium my-4 text-center [&>span]:font-bold lg:text-5xl">
        {!! $title !!}
      </h2>
    @endif
    @if($description)
      <div class="contentText text-center mx-auto">
        {!! $description !!}
      </div>
   @endif
      <div class="swiper-container swiperGallery my-12">
        <div class="swiper-wrapper">
          @foreach($gallery as $image)
            <div class="swiper-slide">
              <a href="{{$image['url']}}" data-lightbox="gallery" data-title="{{$image['title']}}">
                <img src="{{$image['sizes']['square']}}" alt="{{$image['alt']}}" title="{{$image['title']}}" class="w-full h-full object-cover" />
              </a>
            </div>
          @endforeach
        </div>
      </div>
  </div>
  <img src="{{asset('images/sep-bottom.png')}}" class="max-h-[95px] w-full absolute bottom-0 left-0 z-0" alt="">
</div>