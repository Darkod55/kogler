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

  {{--
    Later sections go here.
    Next: company info plus the contact form, on bg-light.
  --}}
@endsection
