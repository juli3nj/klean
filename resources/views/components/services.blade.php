<div class="relative py-28">
  <img class="absolute top-32 right-0 object-cover object-center z-0 max-w-[112px] md:max-w-fit" src="@asset('images/triangle.png')" alt="Background image" />
  <div class="max-w-[1400px] mx-auto px-4">
    <div data-aos="fade-up" class="mb-24">
      @if($title)
        <h2 class="text-4xl font-afacad font-medium my-4 text-center [&>span]:font-bold lg:text-5xl">{!! $title !!}</h2>
      @endif
      @if($description)
        <div class="text-center text-xl font-medium">{!! $description !!}</div>
      @endif
    </div>
    @if($services)
      <div class="grid grid-cols-1 gap-y-12 gap-x-32 lg:grid-cols-2">
        @foreach($services as $service)
          <div
              @if($loop->even)
                data-aos="fade-left"
              @else
                data-aos="fade-right"
              @endif
              class="flex flex-col items-center gap-10 mt-0 lg:even:mt-32 lg:items-start lg:flex-row">
            @if(array_key_exists('icon', $service))
                <img class="max-w-[90px] w-full" src="{{ $service['icon']['url'] }}" alt="{{ $service['icon']['title'] }}" />
            @endif
            <div class="">
              @if(array_key_exists('title', $service))
                <h3 class="text-3xl text-center lg:text-left [&>span]:font-bold">{!! $service['title'] !!}</h3>
              @endif
              @if(array_key_exists('description', $service))
                <div class="contentText text-center lg:text-left">{!! $service['description'] !!}</div>
              @endif
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
  <div data-aos="fade-bottom" class="flex items-center justify-center mt-16">
    <div class="hidden h-0.5 w-20 bg-secondary-800 mr-16 sm:block"></div>
    <a href="#contact" class="buttonGradient customGradientHover font-medium text-lg tracking-wider py-4 px-6">Nous contacter</a>
    <div class="hidden h-0.5 w-20 bg-secondary-800 ml-16 sm:block"></div>
  </div>
</div>