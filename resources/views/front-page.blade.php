@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    <x-hero-scene />
    <x-text-img />
    <x-partenaires />
    <x-services />
    <x-gallery />
    <x-reviews />
    <x-contact />
  @endwhile
@endsection
