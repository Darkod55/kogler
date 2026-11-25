@extends('layouts.app-wide')

@section('content')
  @php
    $isAccountPage = function_exists('is_account_page') && is_account_page();
    $isWooPage = function_exists('is_woocommerce')
      && (
        (function_exists('is_cart') && is_cart())
        || (function_exists('is_checkout') && is_checkout())
        || $isAccountPage
      );

    $pageTitle = get_the_title();
    if ($isAccountPage && ! is_user_logged_in()) {
      if (function_exists('is_wc_endpoint_url') && is_wc_endpoint_url('lost-password')) {
        $pageTitle = __('Lost password', 'sage');
      } else {
        $pageTitle = __('Login', 'sage');
      }
    }
  @endphp

  @if ($isWooPage)
    <div class="woocommerce-site p-clamp">
      <div class="container">
        <header class="woocommerce-products-header">
          <h1 class="woocommerce-products-header__title page-title">{{ kogler_title_case($pageTitle) }}</h1>
        </header>
        @php(the_content())
      </div>
    </div>
  @else
    @php(the_content())
  @endif
@endsection
