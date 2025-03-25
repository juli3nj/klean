<section id="contact" class="relative">
  <div data-aos="fade-up" class="max-w-[1020px] mx-auto py-24 px-4">
    @if($title)
      <h2 class="text-4xl font-afacad font-medium my-4 text-center [&>span]:font-bold lg:text-5xl">
        {!! $title !!}
      </h2>
    @endif
    @if($description)
      <div class="contentText  text-center mx-auto">
        {!! $description !!}
      </div>
    @endif
    @if($shortcode)

        {!! do_shortcode($shortcode) !!}

    @endif
  </div>
</section>