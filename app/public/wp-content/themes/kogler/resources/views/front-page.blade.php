@extends('layouts.app-wide')

@section('content')
  @include('partials.home.hero')
  @include('partials.home.capabilities')
  @include('partials.home.brands')
  {!! the_content() !!}
@endsection
