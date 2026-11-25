@extends('layouts.app-wide')

@section('content')
  @include('partials.home.hero')
  @include('partials.home.capabilities')
  @include('partials.home.brands')
  @include('partials.home.audiences')
  @include('partials.home.inside')
  @include('partials.home.benefits')
  @include('partials.home.services')
  @include('partials.home.testimonials')
  @include('partials.home.contact')
  {!! the_content() !!}
@endsection
