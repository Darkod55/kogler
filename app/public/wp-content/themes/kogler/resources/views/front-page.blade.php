@extends('layouts.app-wide')

@section('content')
  @include('partials.home.hero')
  {!! the_content() !!}
@endsection
