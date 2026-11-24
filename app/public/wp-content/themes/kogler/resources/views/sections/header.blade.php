@include('components.header-icons')

@php
  $socialLinks = [];

  if (function_exists('has_nav_menu') && has_nav_menu('social_navigation') && function_exists('wp_get_nav_menu_items') && function_exists('get_nav_menu_locations')) {
      $locations = get_nav_menu_locations();
      $menuId = (int) ($locations['social_navigation'] ?? 0);
      $items = $menuId ? wp_get_nav_menu_items($menuId) : [];
      $brandIcons = \App\helpers()->brandIcons();

      foreach ($items ?: [] as $item) {
          if ((int) ($item->menu_item_parent ?? 0) !== 0) {
              continue;
          }

          $url = (string) ($item->url ?? '');
          $icon = '';

          foreach ($brandIcons as $domain => $name) {
              if ($url !== '' && str_contains($url, (string) $domain) && \App\helpers()->hasSpriteIcon((string) $name)) {
                  $icon = (string) $name;
                  break;
              }
          }

          if ($icon === '') {
              continue;
          }

          $socialLinks[] = [
              'url' => $url,
              'label' => trim(wp_strip_all_tags((string) ($item->title ?? $icon))),
              'icon' => $icon,
          ];
      }
  }
@endphp

<div
  class="site-chrome-root"
  x-data="{ mobileOpen: false, searchOpen: false }"
  x-effect="document.body.classList.toggle('overflow-hidden', mobileOpen || searchOpen)"
  @keydown.escape.window="searchOpen = false"
>
  <div class="preheader px-clamp text-white">
    <div class="container flex flex-nowrap items-center justify-between gap-3 py-2.5 text-sm">
      <div class="flex min-w-0 items-center gap-4">
        <a class="preheader-phone inline-flex items-center gap-2 text-white no-underline transition-opacity hover:opacity-80 max-md:size-7 max-md:justify-center max-md:gap-0" href="tel:+18557026636" aria-label="{{ __('(855) 702 - 6636', 'sage') }}">
          <span class="shrink-0" aria-hidden="true">@svgIcon('phone'|16|16)</span>
          <span class="preheader-contact-text max-md:sr-only">(855) 702 - 6636</span>
        </a>
        <a class="preheader-email inline-flex items-center gap-2 text-white no-underline transition-opacity hover:opacity-80 max-md:size-7 max-md:justify-center max-md:gap-0" href="mailto:info@kogler-usa.com" aria-label="{{ __('info@kogler-usa.com', 'sage') }}">
          <span class="shrink-0" aria-hidden="true">@svgIcon('email'|16|16)</span>
          <span class="preheader-contact-text max-md:sr-only">info@kogler-usa.com</span>
        </a>
      </div>

      <div class="ml-auto flex items-center gap-1">
        <button
          type="button"
          class="preheader-icon"
          aria-label="{{ __('Search', 'sage') }}"
          aria-controls="header-search-dialog"
          :aria-expanded="searchOpen.toString()"
          @click="mobileOpen = false; searchOpen = true; $nextTick(() => $refs.headerSearch?.querySelector('.search-form__input')?.focus())"
        >
          @svgIcon('search'|16|16)
        </button>

        @if ($socialLinks)
          <ul class="m-0 flex list-none items-center gap-1 p-0">
            @foreach ($socialLinks as $social)
              <li>
                <a class="preheader-social" href="{{ esc_url($social['url']) }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $social['label'] }}">
                  <span aria-hidden="true">{!! \App\helpers()->getSvg(['icon' => $social['icon'], 'width' => 16, 'height' => 16, 'title' => '']) !!}</span>
                </a>
              </li>
            @endforeach
          </ul>
        @endif
      </div>
    </div>
  </div>

  <div class="site-chrome site-chrome--inner">
    <div class="header-bar-slot">
  <header
    id="main-header"
    class="banner header-bar z-30 border-b border-white/25 px-clamp"
  >
    <div class="container flex h-full items-center justify-between gap-8">
      <div class="brand shrink-0">
        @if (get_theme_mod('custom_logo_alt'))
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

      <div class="ml-auto flex items-center gap-6">
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

    <div
      x-show="mobileOpen"
      x-cloak
      x-transition.opacity
      class="fixed inset-0 z-40 bg-black/50 lg:hidden"
      @click="mobileOpen = false"
    ></div>

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
        class="offcanvas-nav fixed inset-0 z-50 flex flex-col overflow-y-auto px-clamp py-4 text-white lg:hidden"
      >
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

        <nav class="mt-8" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
          {!! wp_nav_menu([
            'theme_location' => 'primary_navigation',
            'menu_class' => 'flex flex-col divide-y divide-white/10 font-heading font-bold tracking-[1px]',
            'offcanvas' => true,
            'echo' => false,
          ]) !!}
        </nav>
      </div>
    @endif

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
  </div>
</div>
