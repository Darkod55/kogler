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

  {{--
    Section placeholder.
    Add the next section as resources/views/partials/who-we-are/{name}.blade.php
    and @include it here.
  --}}
  <section>
    <!-- Who We Are — section placeholder -->
  </section>
@endsection
