{{--
  Template Name: Legal
--}}
@extends('layouts.app-wide')

@section('content')
  <section class="p-clamp-xl bg-dark-blue text-white bs-block">
    <div class="container">
      <h1 class="font-fraunces font-semibold">{{ kogler_title_case(get_the_title()) }}</h1>
    </div>
  </section>
  <section class="p-clamp-xl">
    <div class="container">
      <div class="mw-1000">
        {!! the_content() !!}
      </div>
    </div>
  </section>
@endsection

