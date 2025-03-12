<div class="customGradient relative">
  <img src="{{asset('images/sep-bottom.png')}}" class="rotate-180 max-h-[95px] w-full absolute top-[-1px] left-0 z-0" alt="">
  <div data-aos="fade-up" class="py-24 px-4 mx-auto max-w-[800px] md:py-36">
    @if($title)
      <h2 class="text-4xl font-afacad font-medium my-4 text-center [&>span]:font-bold lg:text-5xl">
        {!! $title !!}
      </h2>
    @endif
    @if($text)
      <div class="contentText text-center">
        {!! $text !!}
      </div>
    @endif
    @if($gallery)
      <div class="grid grid-cols-2 items-center gap-8 justify-center my-12 sm:grid-cols-4">
        @foreach($gallery as $partenaire)
          <img class="w-full" src="{{$partenaire['url']}}" alt="{{$partenaire['alt']}}" title="{{ $partenaire['title'] }}" />
        @endforeach
      </div>
    @endif
  </div>
  <img src="{{asset('images/sep-bottom.png')}}" class="max-h-[95px] w-full absolute bottom-0 left-0 z-0" alt="">
</div>