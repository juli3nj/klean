<div class="relative">
  <img class="parallaxTriangleLeft absolute bottom-0 left-0 object-cover object-center z-10 max-w-[112px] md:max-w-fit " src="@asset('images/triangle-left.png')" alt="Background image" />

  <div data-aos="fade-up" class="max-w-[1400px] mx-auto pt-24 px-4">
    @if($title)
      <h2 class="text-4xl font-afacad font-medium my-4 text-center [&>span]:font-bold lg:text-5xl">
        {!! $title !!}
      </h2>
    @endif
    @if($subtitle)
      <div class="text-center text-xl font-medium">
        {!! $subtitle !!}
      </div>
    @endif
    @if($shortcode)
      <div class="my-8">
        {!! do_shortcode($shortcode) !!}
      </div>
    @endif
  </div>
</div>
