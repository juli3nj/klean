<div id="hero" class="w-screen h-screen">
  <div class="w-full h-full relative">
    @if($image)
      <img class="absolute top-0 left-0 w-full h-full -z-10 object-cover object-center" src="{{ $image['url'] }}" title="{{ $image['title'] }}" alt="{{ $image['alt'] }}" />
      <div class="absolute top-0 left-0 w-full h-full bg-black opacity-60"></div>
      <img src="{{asset('images/vector-1.svg')}}" class="absolute top-0 left-0 z-0" alt="">
      <img src="{{asset('images/sep-bottom.png')}}" class="max-h-[95px] w-full absolute bottom-0 left-0 z-0" alt="">
    @endif
    <div data-aos="fade-up" class="relative w-full h-full flex items-center justify-center flex-col z-10">
      <div class="mb-16">
        <img src="{{asset('images/logo.svg')}}" alt="" class="w-[250px] shadowLogo bg-transparent">
      </div>
      @if($title)
        <h2 class="text-5xl text-center font-afacad my-8 md:text-6xl">
          {{ $title }}
        </h2>
      @endif
      @if($subtitle)
        <div class="text-2xl text-center">
          {!! $subtitle !!}
        </div>
      @endif
      <div class="flex items-center justify-center mt-16">
        <div class="hidden h-0.5 w-20 bg-secondary-800 mr-16 sm:block"></div>
        <a href="#contact" class="buttonGradient customGradientHover font-medium text-lg tracking-wider py-4 px-6">Nous contacter</a>
        <div class="hidden h-0.5 w-20 bg-secondary-800 ml-16 sm:block"></div>
      </div>
    </div>
  </div>
</div>