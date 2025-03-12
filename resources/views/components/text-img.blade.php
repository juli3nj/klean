<div class="relative">
  <img class="absolute parallaxTriangle max-w-[112px] -top-[300px] right-0 object-cover object-center z-0 lg:max-w-fit md:-top-[150px]" src="@asset('images/triangle.png')" alt="Background image" />
  <div class="px-4 max-w-[1400px] my-12 mx-auto flex flex-col justify-center items-center gap-12 lg:gap-28 lg:flex-row">
    <div class="max-w-[500px] mx-auto w-full lg:w-1/3"  data-aos="fade-right">
      @if($image)
        <div class="relative aspect-square overflow-hidden">
          <img class="w-full h-full object-cover object-center rounded-full" src="{{ $image['url'] }}" title="{{ $image['title'] }}" alt="{{ $image['alt'] }}" />
          <div class="customGradient absolute rounded-full flex items-center justify-center p-8 top-0 right-0 w-40 h-40"><p class="text-center text-xl font-medium [&>span]:font-bold">{!! $img_text !!}</p></div>
        </div>
      @endif
    </div>
    <div class="w-full lg:w-2/3" data-aos="fade-left">
      <h1 class="text-4xl font-medium my-4 text-center [&>span]:font-bold lg:text-5xl lg:text-left">{!! $title !!}</h1>
      <div class="contentText text-center lg:text-left">
        {!! $text !!}
      </div>
    </div>
  </div>
  <img class="parallaxTriangleLeft absolute max-w-[113px] -bottom-[450px] max-w- left-0 object-cover object-center z-10 md:max-w-fit lg:-bottom-[900px]" src="@asset('images/triangle-left.png')" alt="Background image" />

</div>
