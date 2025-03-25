@extends('layouts.app')

@section('content')
    @while(have_posts()) @php(the_post())
      <div class="relative bg-secondary-800 text-center pt-20 pb-32">
        <a href="{{ home_url('/') }}">
          <img src="{{ asset('images/logo.svg') }}" alt="{{ get_bloginfo('name') }}" class="w-full h-full max-w-[250px] mx-auto shadowLogo" />
        </a>
        <img src="{{asset('images/sep-bottom.png')}}" class="max-h-[95px] w-full absolute bottom-0 left-0 z-0" alt="">
      </div>
      <div class="max-w-[1440px] mx-auto px-4">
        <h1 class="text-4xl font-bold text-center my-8">{{ get_the_title() }}</h1>
        <div class="prose max-w-none">
          @php(the_content())
        </div>
      </div>
    @endwhile
@endsection
