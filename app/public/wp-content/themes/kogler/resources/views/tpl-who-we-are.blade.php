{{--
  Template Name: Who We Are
--}}

@extends('layouts.app-wide')

@section('content')
  {{--
    Who We Are — custom page scaffold.
    Header and footer come from layouts.app-wide.
    Build each section as a partial in resources/views/partials/who-we-are/ and @include it here.
  --}}

  @include('partials.who-we-are.hero')
  @include('partials.who-we-are.quality-price')
  @include('partials.who-we-are.our-brands')
  @include('partials.who-we-are.we-are')
  @include('partials.who-we-are.we-serve')
  @include('partials.who-we-are.hours')
  @include('partials.who-we-are.leadership')
  @include('partials.cta-work-together', [
      'ctaIntro' => \App\helpers()->pageField('wwa_cta_intro', 'Tell us how you buy, stock and sell, and we\'ll build the right program around it.'),
  ])
@endsection
