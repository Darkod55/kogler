{{--
  Template Name: Contact
--}}

@extends('layouts.app-wide')

@section('content')
  {{--
    Contact.
    Header and footer come from layouts.app-wide.
    Section partials live in resources/views/partials/contact/.
  --}}

  @include('partials.contact.hero')
  @include('partials.contact.info-form')

  {{--
    Later sections go here, as partials in resources/views/partials/contact/.
  --}}
@endsection
