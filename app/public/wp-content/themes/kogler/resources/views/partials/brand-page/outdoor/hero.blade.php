{{--
  Kögler Outdoor — hero.
  Set $logoId to the white logo attachment. The SVG fallback is
  resources/images/brands/logo-kogler-outdoor-white.svg when that file is in the build.
  Shop on Amazon is always shown. It opens the Kögler Outdoor Customizer URL
  when that setting is filled in.
  Fact-strip lines are new website copy. Edit them here and confirm with the client.
  In-page offset is html scroll-padding-top (--site-chrome-height).
--}}
@php
    $logoId = 0;
    $logo = '';

    if ($logoId > 0 && function_exists('wp_get_attachment_image')) {
        $mime = function_exists('get_post_mime_type') ? (string) get_post_mime_type($logoId) : '';
        $isImage = function_exists('wp_attachment_is_image') && wp_attachment_is_image($logoId);

        if ($isImage || $mime === 'image/svg+xml') {
            $rendered = wp_get_attachment_image($logoId, 'full', false, [
                'class' => 'h-auto w-full',
                'alt' => 'Kögler Outdoor',
                'loading' => 'eager',
                'decoding' => 'async',
            ]);
            $logo = is_string($rendered) ? $rendered : '';
        }
    }

    if ($logo === '' && class_exists(\Illuminate\Support\Facades\Vite::class)) {
        try {
            $logoUrl = \Illuminate\Support\Facades\Vite::asset('resources/images/brands/logo-kogler-outdoor-white.svg');
            $logo = '<img src="' . esc_url($logoUrl) . '" alt="Kögler Outdoor" class="h-auto w-full" width="420" height="140" loading="eager" decoding="async">';
        } catch (\Throwable $e) {
            $logo = '';
        }
    }

    $amazonUrl = \App\helpers()->outdoorAmazonUrl();
    $brandsUrl = function_exists('home_url') ? home_url('/our-brands/') : '#';

    if (function_exists('get_posts') && function_exists('get_permalink')) {
        $brandPages = get_posts([
            'post_type' => 'page',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'meta_key' => '_wp_page_template',
            'meta_value' => 'tpl-brand.blade.php',
            'orderby' => 'date',
            'order' => 'ASC',
        ]);

        if ($brandPages && $brandPages[0] instanceof \WP_Post) {
            $permalink = get_permalink($brandPages[0]);

            if (is_string($permalink) && $permalink !== '') {
                $brandsUrl = $permalink;
            }
        }
    }

    $facts = [
        [
            'icon' => 'caravan',
            'title' => 'RVs',
            'line' => 'Life on the road',
            'paths' => '<path d="M18 19V9a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v8a2 2 0 0 0 2 2h2" /><path d="M2 9h3a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2" /><path d="M22 17v1a1 1 0 0 1-1 1H10v-9a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v9" /><circle cx="8" cy="19" r="2" />',
        ],
        [
            'icon' => 'tent',
            'title' => 'Campers',
            'line' => 'Wherever you roam',
            'paths' => '<path d="M3.5 21 14 3" /><path d="M20.5 21 10 3" /><path d="M15.5 21 12 15l-3.5 6" /><path d="M2 21h20" />',
        ],
        [
            'icon' => 'sailboat',
            'title' => 'Boats',
            'line' => 'Life on the water',
            'paths' => '<path d="M22 18H2a4 4 0 0 0 4 4h12a4 4 0 0 0 4-4Z" /><path d="M21 14 10 2 3 14h18Z" /><path d="M10 2v16" />',
        ],
    ];
@endphp
<section class="relative bg-outdoor-950 px-clamp pt-clamp-xl pb-20 text-white">
  <div class="container">
    <div class="flex flex-wrap items-center justify-between gap-14">
      <div class="min-w-[min(100%,520px)] shrink grow basis-full min-[1000px]:basis-[520px]">
        <nav class="text-sm font-semibold text-outdoor-amber" aria-label="{{ __('Breadcrumb', 'sage') }}">
          <a class="underline-offset-[3px] hover:underline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-outdoor-amber" href="{{ $brandsUrl }}">Our brands</a>
          <span aria-hidden="true">/</span>
          Kögler Outdoor
        </nav>

        <h1 class="mt-7 mb-0 font-fraunces tracking-tight text-white">
          Adventure Sleep Products for Life on the Road <em class="italic font-medium text-outdoor-amber">and on the Water</em>
        </h1>

        <div class="mt-10 flex flex-wrap gap-3.5">
          <a
            class="btn btn-primary"
            href="{{ $amazonUrl !== '' ? $amazonUrl : '#' }}"
            @if ($amazonUrl !== '') target="_blank" rel="noopener" @endif
          >
            Shop on Amazon
            @if ($amazonUrl !== '')
              <span class="sr-only"> (opens in a new tab)</span>
            @endif
          </a>
          <a class="btn btn-brand-outline" href="#products">View products</a>
        </div>
      </div>

      <div class="w-full max-w-[300px] shrink-0 min-[1000px]:ml-auto min-[1000px]:max-w-[420px] min-[1000px]:basis-[420px] min-[1000px]:grow-0">
        @if ($logo !== '')
          {!! $logo !!}
        @else
          <p class="m-0 font-fraunces text-[2.75rem] leading-none text-white" role="img" aria-label="Kögler Outdoor">Kögler Outdoor</p>
        @endif
      </div>
    </div>

    <ul class="mt-[72px] grid list-none grid-cols-1 gap-6 p-0 sm:grid-cols-3">
      @foreach ($facts as $fact)
        <li class="flex items-start gap-3.5 border-t-2 border-outdoor-amber pt-[18px]">
          <svg class="mt-0.5 size-[26px] shrink-0 text-outdoor-amber" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            {!! $fact['paths'] !!}
          </svg>
          <div class="min-w-0">
            <p class="mb-0 text-[length:var(--font-size-tagline)] font-bold text-white">{{ $fact['title'] }}</p>
            <p class="mt-1 mb-0 text-[length:var(--font-size-btn)] text-white/75">{{ $fact['line'] }}</p>
          </div>
        </li>
      @endforeach
    </ul>
  </div>
</section>
