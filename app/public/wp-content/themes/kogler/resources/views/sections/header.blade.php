@include('components.header-icons')

@php
  $is_front = is_front_page();
  $cart_count = 0;
  $cart_total = '$0.00';
  $cart_url = home_url('/cart/');
  $account_url = wp_login_url();

  if (function_exists('WC')) {
    $cart_url = wc_get_cart_url();
    $account_url = wc_get_page_permalink('myaccount') ?: wp_login_url();

    if (WC()->cart) {
      $cart_count = (int) WC()->cart->get_cart_contents_count();
      $cart_total = html_entity_decode(
        wp_strip_all_tags(wc_price(WC()->cart->get_displayed_subtotal())),
        ENT_QUOTES,
        'UTF-8'
      );
    }
  }
@endphp

<div class="site-chrome {{ $is_front ? 'site-chrome--front' : 'site-chrome--inner' }}">
  <div class="preheader hidden md:block px-clamp {{ $is_front ? 'text-white' : 'text-dark-blue' }}">
    <div class="container flex items-center justify-between gap-4 py-2.5 text-sm lg:gap-6">
      <ul class="preheader-pros m-0 flex list-none items-center gap-4 p-0 lg:gap-6">
        <li class="inline-flex items-center gap-2">
          <span class="shrink-0 opacity-90" aria-hidden="true">@svgIcon('car'|16|16)</span>
          <span>{{ __('Free shipping over $XXX', 'sage') }}</span>
        </li>
        <li class="inline-flex items-center gap-2">
          <span class="shrink-0 opacity-90" aria-hidden="true">@svgIcon('star'|16|16)</span>
          <span>{{ __('Save up to 40% on bulk purchases', 'sage') }}</span>
        </li>
        <li class="inline-flex items-center gap-2">
          <span class="shrink-0 opacity-90" aria-hidden="true">@svgIcon('warranty'|16|16)</span>
          <span>{{ __('Warranty', 'sage') }}</span>
        </li>
      </ul>

      @if (has_nav_menu('preheader_navigation'))
        <nav class="preheader-nav shrink-0" aria-label="{{ wp_get_nav_menu_name('preheader_navigation') }}">
          {!! wp_nav_menu([
            'theme_location' => 'preheader_navigation',
            'menu_class' => 'flex items-center gap-5',
            'container' => false,
            'depth' => 1,
            'echo' => false,
          ]) !!}
        </nav>
      @else
        <a class="preheader-phone inline-flex shrink-0 items-center gap-2 no-underline transition-opacity hover:opacity-80 {{ $is_front ? 'text-white' : 'text-dark-blue' }}" href="tel:+18557026636">
          <span class="shrink-0" aria-hidden="true">@svgIcon('phone'|14|14)</span>
          <span>(855) 702 - 6636</span>
        </a>
      @endif
    </div>
  </div>

  <header
    id="main-header"
    class="banner header-bar z-30 border-b px-clamp transition-all duration-300 {{ $is_front ? 'border-transparent' : 'border-white/25' }}"
    x-data="{ mobileOpen: false, searchOpen: false }"
    x-effect="document.body.classList.toggle('overflow-hidden', mobileOpen || searchOpen)"
    @keydown.escape.window="searchOpen = false"
  >
    <div class="container flex items-center gap-8 py-6">
      <div class="header-leading flex min-w-0 flex-1 items-center gap-8">
        <div class="brand shrink-0">
          @if ($is_front && get_theme_mod('custom_logo_alt'))
            <a class="brand-logo-link inline-grid items-center" href="{{ esc_url(home_url('/')) }}" rel="home">
              {!! \App\helpers()->getSiteLogo([
                'wrap_link' => false,
                'custom_logo_class' => 'site-logo site-logo--main',
              ]) !!}
              {!! \App\helpers()->getSiteLogo([
                'wrap_link' => false,
                'logo_variant' => 'alt',
                'custom_logo_class' => 'site-logo site-logo--alt',
              ]) !!}
              <span class="sr-only">{{ get_bloginfo('name', 'display') }}</span>
            </a>
          @elseif (! $is_front && get_theme_mod('custom_logo_alt'))
            {{-- Inner pages match homepage scrolled chrome: white (alt) logo. --}}
            {!! \App\helpers()->getSiteLogo([
              'link_classes' => 'inline-flex items-center',
              'custom_logo_class' => 'site-logo',
              'logo_variant' => 'alt',
            ]) !!}
          @else
            {!! \App\helpers()->getSiteLogo([
              'link_classes' => 'inline-flex items-center',
              'custom_logo_class' => 'site-logo',
            ]) !!}
          @endif
        </div>

        @if (has_nav_menu('primary_navigation'))
          <nav class="primary-nav hidden min-w-0 items-center lg:flex" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
            {!! wp_nav_menu([
              'theme_location' => 'primary_navigation',
              'menu_class' => 'flex items-center gap-6',
              'container' => false,
              'echo' => false,
            ]) !!}
          </nav>
        @endif
      </div>

      <div class="header-actions flex shrink-0 items-center">
        <button
          type="button"
          class="header-icon-btn"
          aria-label="{{ __('Search', 'sage') }}"
          aria-controls="header-search-dialog"
          :aria-expanded="searchOpen.toString()"
          @click="mobileOpen = false; searchOpen = true; $nextTick(() => $refs.headerSearch?.querySelector('.search-form__input')?.focus())"
        >
          @svgIcon('search'|24|24)
        </button>

        <a
          class="header-icon-btn"
          href="{{ esc_url($account_url) }}"
          aria-label="{{ __('Account', 'sage') }}"
        >
          @svgIcon('user'|24|24)
        </a>

        <a
          class="header-cart"
          href="{{ esc_url($cart_url) }}"
          aria-label="{{ sprintf(__('Cart, %s, %d items', 'sage'), $cart_total, $cart_count) }}"
        >
          <span class="header-cart__total">{{ $cart_total }}</span>
          <span class="header-cart__icon">
            @svgIcon('cart'|24|24)
            <span class="header-cart__count" aria-hidden="true" @if ($cart_count === 0) hidden @endif>{{ $cart_count }}</span>
          </span>
        </a>

        {{--
          Off-canvas menu toggle - a single button that swaps its icon based
          on `mobileOpen` rather than two separate open/close buttons, so
          the click target is always the exact same element/position
          whether the menu is opening or closing. Needs a higher z-index
          than the off-canvas backdrop/panel below (z-40/z-50) so it stays
          on top of them (and clickable) once the panel is open - <header>
          itself only goes up to z-30, precisely so it stays underneath.
        --}}
        <button
          type="button"
          class="header-menu-toggle relative z-[60] lg:hidden"
          @click="mobileOpen = ! mobileOpen"
          :aria-expanded="mobileOpen"
          :aria-label="mobileOpen ? '{{ __('Close menu', 'sage') }}' : '{{ __('Open menu', 'sage') }}'"
        >
          <span x-show="! mobileOpen">@svgIcon('menu'|25|25)</span>
          <span class="text-white" x-show="mobileOpen" x-cloak>@svgIcon('close'|25|25)</span>
        </button>
      </div>
    </div>

    {{-- Off-canvas backdrop --}}
    <div
      x-show="mobileOpen"
      x-cloak
      x-transition.opacity
      class="fixed inset-0 z-40 bg-black/50 lg:hidden"
      @click="mobileOpen = false"
    ></div>

    {{-- Off-canvas menu panel, slides in from the right, covering the full viewport --}}
    @if (has_nav_menu('primary_navigation'))
      <div
        x-show="mobileOpen"
        x-cloak
        x-transition:enter="duration-300 ease-out"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="duration-200 ease-in"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="offcanvas-nav fixed inset-0 z-50 flex flex-col overflow-y-auto bg-dark-blue px-clamp py-4 text-white lg:hidden"
      >
        {{--
          Logo + spacer row: matches the main bar's py-6 / toggle height so the
          header close button (z-60) stays aligned top-right over the spacer.
        --}}
        <div class="flex shrink-0 items-center justify-between gap-6">
          <div class="brand shrink-0">
            {!! \App\helpers()->getSiteLogo([
              'link_classes' => 'inline-flex items-center text-white',
              'custom_logo_class' => 'site-logo transition-all duration-300',
              'logo_variant' => 'alt',
            ]) !!}
          </div>
          <div class="size-7 shrink-0" aria-hidden="true"></div>
        </div>

        @if (has_nav_menu('primary_navigation'))
          <nav class="mt-8" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
            {!! wp_nav_menu([
              'theme_location' => 'primary_navigation',
              'menu_class' => 'flex flex-col divide-y divide-white/10 font-heading font-bold tracking-[1px]',
              'offcanvas' => true,
              'echo' => false,
            ]) !!}
          </nav>
        @endif
      </div>
    @endif

    {{-- Header search dialog --}}
    <div
      id="header-search-dialog"
      class="header-search"
      x-show="searchOpen"
      x-cloak
      x-transition.opacity.duration.200ms
      role="dialog"
      aria-modal="true"
      aria-labelledby="header-search-heading"
      @click.self="searchOpen = false"
    >
      <button
        type="button"
        class="header-search__close"
        @click="searchOpen = false"
        aria-label="{{ __('Close search', 'sage') }}"
      >
        <span aria-hidden="true">@svgIcon('close'|22|22)</span>
      </button>

      <div
        class="header-search__panel"
        x-ref="headerSearch"
        x-show="searchOpen"
        x-transition:enter="duration-250 ease-out"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="duration-150 ease-in"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        @click.stop
      >
        <h2 id="header-search-heading" class="header-search__title">
          {{ __('Search', 'sage') }}
        </h2>

        {!! get_search_form(false) !!}
      </div>
    </div>
  </header>
</div>
