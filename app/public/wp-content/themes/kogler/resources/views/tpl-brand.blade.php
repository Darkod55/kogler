{{--
  Template Name: Brand
--}}

@extends('layouts.app-wide')

@section('content')
  {{--
    Brand — custom page scaffold.
    Header and footer come from layouts.app-wide.
    Build each section as a partial in resources/views/partials/brand/
    and @include it here.

    Hero jump targets, to put on the later brand sections:
    id="kogler", id="goliath-steel", id="kogler-outdoor".
    html already uses scroll-padding-top: var(--site-chrome-height, 7rem),
    so those sections only need the id. Adding scroll-mt-chrome as well
    stacks a second chrome offset.
  --}}

  @include('partials.brand.hero')
  @include('partials.brand.kogler')
  @include('partials.brand.goliath-steel')
  @include('partials.brand.kogler-outdoor')
  @include('partials.cta-work-together', [
      'ctaBackground' => 'bg-light',
      'ctaPadTop' => false,
  ])
@endsection
