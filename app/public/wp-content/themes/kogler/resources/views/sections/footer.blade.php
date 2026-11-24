<footer class="site-footer">
  <div class="px-clamp py-clamp">
    {{--
      Logo + social | Information | Services | Contact
      Mobile: stacked.
      Tablet (md): brand full-width centered; three nav cols in a row.
      Desktop (lg): 4 columns.
    --}}
    <div class="container grid grid-cols-1 gap-10 md:grid-cols-3 lg:grid-cols-4 lg:gap-8">
      <div class="footer-brand flex flex-col items-start gap-6 md:col-span-3 md:items-center lg:col-span-1 lg:items-start">
        <div class="brand shrink-0">
          {!! \App\helpers()->getSiteLogo([
            'link_classes' => 'inline-flex items-start',
            'custom_logo_class' => 'site-logo',
          ]) !!}
        </div>

        @if (has_nav_menu('social_navigation'))
          <nav class="footer-social-nav" aria-label="{{ wp_get_nav_menu_name('social_navigation') }}">
            {!! wp_nav_menu([
              'theme_location' => 'social_navigation',
              'menu_class' => 'footer-social flex flex-wrap items-center justify-start gap-3 md:justify-center lg:justify-start',
              'container' => false,
              'depth' => 1,
              'echo' => false,
            ]) !!}
          </nav>
        @endif
      </div>

      @if (has_nav_menu('footer_navigation'))
        <nav class="footer-nav" aria-label="{{ wp_get_nav_menu_name('footer_navigation') }}">
          <h3 class="footer-nav__title">{{ __('Information', 'sage') }}</h3>
          {!! wp_nav_menu([
            'theme_location' => 'footer_navigation',
            'menu_class' => 'footer-links flex flex-col gap-2.5',
            'container' => false,
            'depth' => 1,
            'echo' => false,
          ]) !!}
        </nav>
      @endif

      @if (has_nav_menu('services_navigation'))
        <nav class="footer-nav" aria-label="{{ wp_get_nav_menu_name('services_navigation') }}">
          <h3 class="footer-nav__title">{{ __('Services', 'sage') }}</h3>
          {!! wp_nav_menu([
            'theme_location' => 'services_navigation',
            'menu_class' => 'footer-links flex flex-col gap-2.5',
            'container' => false,
            'depth' => 1,
            'echo' => false,
          ]) !!}
        </nav>
      @endif

      <div class="footer-nav footer-contact">
        <h3 class="footer-nav__title">{{ __('Contact', 'sage') }}</h3>
        <ul class="footer-contact__list m-0 flex list-none flex-col gap-2.5 p-0">
          <li>
            <a class="footer-contact__link" href="mailto:info@kogler-usa.com">
              {{ __('Email: info@kogler-usa.com', 'sage') }}
            </a>
          </li>
          <li>
            <a class="footer-contact__link" href="tel:+18557026636">
              {{ __('Phone: +1 (855) 702-6636', 'sage') }}
            </a>
          </li>
          <li>
            <span class="footer-contact__text">{{ __('Location: 939 W North Ave. Suite 880. Chicago, IL 60642', 'sage') }}</span>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div class="footer-bar border-t border-white/12 px-clamp py-4 text-sm">
    <div class="container flex flex-col items-center gap-3 text-center lg:flex-row lg:items-center lg:justify-between lg:gap-6 lg:text-left">
      @if (has_nav_menu('legal_navigation'))
        <nav class="footer-legal-nav" aria-label="{{ wp_get_nav_menu_name('legal_navigation') }}">
          {!! wp_nav_menu([
            'theme_location' => 'legal_navigation',
            'menu_class' => 'footer-legal-links m-0 flex list-none flex-wrap items-center justify-center gap-x-5 gap-y-2 p-0 lg:justify-start',
            'container' => false,
            'depth' => 1,
            'echo' => false,
          ]) !!}
        </nav>
      @endif

      <p class="footer-bar__copy m-0 lg:text-right">
        {{ sprintf(
          __('Copyright © %s - Kögler. All Rights Reserved.', 'sage'),
          date('Y')
        ) }}
        {!! sprintf(
          __('Developed by %s', 'sage'),
          '<a href="https://metapixels.co.uk/" class="text-white underline transition-colors hover:text-white/80" target="_blank" rel="noopener noreferrer">' . esc_html__('MetaPixels', 'sage') . '</a>'
        ) !!}
      </p>
    </div>
  </div>
</footer>
