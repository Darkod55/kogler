{{--
  Template Name: Brand Page

  Reusable brand page. In wp-admin: Pages → the page → Template → Brand Page,
  then Brand in the sidebar (post meta kogler_brand).
  That meta sets data-brand and the body class brand-{slug}.
  Goliath Steel and Kögler Outdoor use the same template and the Brand sidebar field.
  Anchors use the theme's scroll-padding-top (--site-chrome-height), which
  is already the sticky header height. scroll-mt-chrome is not added on top,
  because the two offsets stack.
--}}

@extends('layouts.app-wide')

@section('content')
  @php($brandPage = \App\helpers()->brandTheme())

  @if ($brandPage === 'kogler-sleep')
    @include('partials.brand-page.sleep.hero')
    @include('partials.brand-page.sleep.intro')
    @include('partials.brand-page.sleep.lineup')
    @include('partials.brand-page.sleep.quick-selector')
    @include('partials.brand-page.sleep.fitment-guide')
    @include('partials.brand-page.sleep.size-finder')
    @include('partials.brand-page.sleep.measure')
    @include('partials.brand-page.sleep.ordering')
    @include('partials.brand-page.sleep.cta')
  @elseif ($brandPage === 'goliath-steel')
    @include('partials.brand-page.goliath.hero')
    @include('partials.brand-page.goliath.intro')
    @include('partials.brand-page.goliath.products')
    @include('partials.brand-page.goliath.private-label')
    @include('partials.brand-page.goliath.gloves')
    @include('partials.brand-page.goliath.quick-reference')
    @include('partials.brand-page.goliath.cta')
  @elseif ($brandPage === 'kogler-outdoor')
    @include('partials.brand-page.outdoor.hero')
    @include('partials.brand-page.outdoor.intro')
    @include('partials.brand-page.outdoor.home-away')
    @include('partials.brand-page.outdoor.brands')
    @include('partials.brand-page.outdoor.cta')
  @else
    {{-- Choose Kögler Sleep, Goliath Steel, or Kögler Outdoor in the Brand sidebar field. --}}
  @endif
@endsection
