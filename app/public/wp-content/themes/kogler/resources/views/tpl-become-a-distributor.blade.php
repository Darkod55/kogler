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

  {{--
    Next: application form on bg-light.
    Add it under resources/views/partials/become-a-distributor/ and @include it here.
  --}}
@endsection
