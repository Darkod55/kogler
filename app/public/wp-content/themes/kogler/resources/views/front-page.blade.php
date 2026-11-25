@extends('layouts.app-wide')

@section('content')
  @include('partials.home.hero')
  @include('partials.home.capabilities')
  {!! the_content() !!}
@endsection
