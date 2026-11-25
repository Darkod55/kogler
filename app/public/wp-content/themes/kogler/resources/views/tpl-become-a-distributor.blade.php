{{--
  Template Name: Become a Distributor
--}}

@extends('layouts.app-wide')

@section('content')
  {{--
    Become a Distributor.
    Header and footer come from layouts.app-wide.
    Section partials live in resources/views/partials/become-a-distributor/.
  --}}

  @include('partials.become-a-distributor.hero')
  @include('partials.become-a-distributor.application')
@endsection
