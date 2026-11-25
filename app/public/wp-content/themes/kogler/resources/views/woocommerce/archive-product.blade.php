{{--
The Template for displaying product archives, including the main shop page which is a post type archive

@see https://docs.woocommerce.com/document/template-structure/
@package WooCommerce/Templates
@version 3.4.0
--}}

@extends('layouts.app-wide')

@section('content')
  @php
    do_action('get_header', 'shop');
    do_action('woocommerce_before_main_content');

    $isShop = function_exists('is_shop') && is_shop();
    $isTaxonomy = function_exists('is_product_taxonomy') && is_product_taxonomy();
    $activeBrand = $isShop ? \App\helpers()->getActiveShopBrand() : null;
    $brandOptions = $isShop ? \App\helpers()->getShopBrandOptions() : [];
    $shopConfig = $isShop ? \App\Shop\ShopCatalog::instance()->getClientConfig() : null;
    $shopUrl = function_exists('wc_get_page_permalink')
      ? (string) wc_get_page_permalink('shop')
      : home_url('/shop/');
  @endphp

  @if ($isShop && $shopConfig)
    <div
      class="mpx-shop"
      x-data="mpxShopFilters({!! \Illuminate\Support\Js::from($shopConfig) !!})"
      :class="{ 'is-filters-open': filtersOpen }"
      @popstate.window="onPopState()"
      @keydown.escape.window="closeFilters()"
    >
      <div
        class="mpx-shop__filters-backdrop"
        x-show="filtersOpen"
        x-cloak
        x-transition.opacity
        @click="closeFilters()"
      ></div>

      <aside
        id="mpx-shop-filters-panel"
        class="mpx-shop__sidebar"
        :class="{ 'is-open': filtersOpen }"
        aria-label="{{ __('Product filters', 'sage') }}"
        :aria-hidden="isDesktop ? 'false' : (filtersOpen ? 'false' : 'true')"
        :inert="! isDesktop && ! filtersOpen"
      >
        <div class="mpx-shop__filters-panel-header">
          <h2 class="mpx-shop__filters-panel-title">{{ __('Filters', 'sage') }}</h2>
          <button
            type="button"
            class="mpx-shop__filters-close"
            @click="closeFilters()"
            aria-label="{{ __('Close filters', 'sage') }}"
          >
            <span aria-hidden="true">@svgIcon('close'|20|20)</span>
          </button>
        </div>

        <div class="mpx-shop__filters-panel-body">
          @include('woocommerce.shop.filters', [
            'facets' => $shopConfig['facets'],
            'search' => $shopConfig['search'],
            'selectedCategories' => $shopConfig['categories'],
            'selectedAttributes' => $shopConfig['attributes'],
          ])
        </div>

        <div class="mpx-shop__filters-panel-footer">
          <button
            type="button"
            class="mpx-shop__filters-apply button"
            @click="closeFilters()"
          >
            {{ __('Show results', 'sage') }}
          </button>
        </div>
      </aside>

      <div class="mpx-shop__main">
        <header class="mpx-shop__header">
          <h1 class="mpx-shop__title" x-text="brandName">{{ kogler_title_case($activeBrand['name']) }}</h1>

          <div class="mpx-shop__header-actions">
            <button
              type="button"
              class="mpx-shop__filters-toggle"
              @click="openFilters()"
              :aria-expanded="filtersOpen.toString()"
              aria-controls="mpx-shop-filters-panel"
            >
              <span>{{ __('Filters', 'sage') }}</span>
              <span
                class="mpx-shop__filters-toggle-count"
                x-show="activeFilterCount() > 0"
                x-text="activeFilterCount()"
                x-cloak
              ></span>
            </button>

            <div class="mpx-shop__brand-toggle" role="group" aria-label="{{ __('Shop by brand', 'sage') }}">
              @foreach ($brandOptions as $brand)
                @php
                  $isActive = $brand['slug'] === $activeBrand['slug'];
                  $brandUrl = \App\helpers()->getShopBrandUrl($brand['slug']);
                @endphp
                <a
                  href="{{ esc_url($brandUrl) }}"
                  class="mpx-shop__brand-option{{ $isActive ? ' is-active' : '' }}"
                  @if ($isActive) aria-current="page" @endif
                >
                  <span class="mpx-shop__brand-name">{{ $brand['name'] }}</span>
                  <span class="mpx-shop__brand-subtitle">{{ $brand['subtitle'] }}</span>
                </a>
              @endforeach
            </div>
          </div>
        </header>

        @php
          do_action('woocommerce_archive_description');
        @endphp

        <div
          class="mpx-shop__results"
          :class="{ 'is-loading': loading }"
          aria-live="polite"
        >
          <div class="mpx-shop__products" x-ref="products">
            @if (woocommerce_product_loop())
              @php
                do_action('woocommerce_before_shop_loop');
                woocommerce_product_loop_start();
              @endphp

              @if (wc_get_loop_prop('total'))
                @while (have_posts())
                  @php
                    the_post();
                    do_action('woocommerce_shop_loop');
                    wc_get_template_part('content', 'product');
                  @endphp
                @endwhile
              @endif

              @php
                woocommerce_product_loop_end();
                do_action('woocommerce_after_shop_loop');
              @endphp
            @else
              @php
                do_action('woocommerce_no_products_found');
              @endphp
            @endif
          </div>

          <div
            class="mpx-shop__pagination"
            x-ref="pagination"
            @click="onPaginationClick($event)"
          >
            @php
              $shopQuery = $GLOBALS['wp_query'] ?? null;
              if ($shopQuery instanceof \WP_Query) {
                echo \App\Shop\ShopCatalog::instance()->renderPaginationHtml(
                  $shopQuery,
                  \App\Shop\ShopCatalog::instance()->parseRequest($_GET)
                );
              }
            @endphp
          </div>
        </div>
      </div>
    </div>
  @elseif ($isTaxonomy)
    <div class="mpx-tax-archive">
      <header class="mpx-tax-archive__header">
        @if (apply_filters('woocommerce_show_page_title', true))
          <h1 class="mpx-tax-archive__title">{{ kogler_title_case(woocommerce_page_title(false)) }}</h1>
        @endif

        <a class="mpx-tax-archive__back btn btn-primary" href="{{ esc_url($shopUrl) }}">
          {{ __('Back to shop', 'sage') }}
        </a>
      </header>

      @php
        do_action('woocommerce_archive_description');
      @endphp

      @if (have_posts())
        @php
          do_action('woocommerce_before_shop_loop');
          woocommerce_product_loop_start();
        @endphp

        @while (have_posts())
          @php
            the_post();
            do_action('woocommerce_shop_loop');
            wc_get_template_part('content', 'product');
          @endphp
        @endwhile

        @php
          woocommerce_product_loop_end();
          do_action('woocommerce_after_shop_loop');
        @endphp
      @else
        @php
          do_action('woocommerce_no_products_found');
        @endphp
      @endif
    </div>
  @else
    <header class="woocommerce-products-header">
      @if (apply_filters('woocommerce_show_page_title', true))
        <h1 class="woocommerce-products-header__title page-title">{{ kogler_title_case(woocommerce_page_title(false)) }}</h1>
      @endif

      @php
        do_action('woocommerce_archive_description');
      @endphp
    </header>

    @if (have_posts())
      @php
        do_action('woocommerce_before_shop_loop');
        woocommerce_product_loop_start();
      @endphp

      @while (have_posts())
        @php
          the_post();
          do_action('woocommerce_shop_loop');
          wc_get_template_part('content', 'product');
        @endphp
      @endwhile

      @php
        woocommerce_product_loop_end();
        do_action('woocommerce_after_shop_loop');
      @endphp
    @else
      @php
        do_action('woocommerce_no_products_found');
      @endphp
    @endif
  @endif

  @php
    do_action('woocommerce_after_main_content');
  @endphp
@endsection
