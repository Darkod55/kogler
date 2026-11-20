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

  {{--
    Next section: add a partial under resources/views/partials/who-we-are/
    and @include it here.
  --}}
@endsection
