{{--
  Goliath Steel — hero.
  Set $logoId to the Media Library attachment of logo-goliath-steel-full-colour.svg
  (PNG is fine too). A theme file of that name is used when the ID is 0.
  The artwork is not recoloured.
--}}
@php
    $logoId = 0;
    $goliathLogo = '';

    $logoFromAttachment = function (int $id): string {
        if ($id < 1 || ! function_exists('wp_get_attachment_url')) {
            return '';
        }

        $mime = function_exists('get_post_mime_type') ? (string) get_post_mime_type($id) : '';
        $isImage = function_exists('wp_attachment_is_image') && wp_attachment_is_image($id);

        if (! $isImage && $mime !== 'image/svg+xml') {
            return '';
        }

        $image = wp_get_attachment_image($id, 'full', false, [
            'class' => 'h-auto w-full',
            'alt' => 'Goliath Steel',
            'loading' => 'eager',
            'decoding' => 'async',
        ]);

        return is_string($image) ? $image : '';
    };

    $goliathLogo = $logoFromAttachment((int) $logoId);

    if ($goliathLogo === '' && class_exists(\Illuminate\Support\Facades\Vite::class)) {
        foreach ([
            'resources/images/brands/logo-goliath-steel-full-colour.svg',
            'resources/images/brands/logo-goliath-steel-full-colour.png',
        ] as $relative) {
            $absolute = function_exists('get_theme_file_path') ? get_theme_file_path($relative) : '';

            if (! is_string($absolute) || ! is_readable($absolute)) {
                continue;
            }

            try {
                $url = \Illuminate\Support\Facades\Vite::asset($relative);
            } catch (\Throwable $e) {
                $url = '';
            }

            if ($url === '') {
                continue;
            }

            $size = @getimagesize($absolute);
            $width = is_array($size) ? (int) $size[0] : 420;
            $height = is_array($size) ? (int) $size[1] : 180;

            $goliathLogo = sprintf(
                '<img src="%s" alt="Goliath Steel" class="h-auto w-full" width="%d" height="%d" loading="eager" decoding="async">',
                esc_url($url),
                max(1, $width),
                max(1, $height)
            );
            break;
        }
    }

    $koglerMark = '';
    $koglerLogoId = function_exists('get_theme_mod') ? (int) get_theme_mod('custom_logo') : 0;

    if ($koglerLogoId && function_exists('wp_attachment_is_image') && wp_attachment_is_image($koglerLogoId)) {
        $mark = wp_get_attachment_image($koglerLogoId, 'full', false, [
            'class' => 'h-3.5 w-auto',
            'alt' => 'Kögler',
            'loading' => 'eager',
            'decoding' => 'async',
        ]);
        $koglerMark = is_string($mark) ? $mark : '';
    }

    $distributorUrl = \App\helpers()->pageUrlBySlug('find-a-distributor');
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
            'title' => '3-in-1 ABS Assemblies',
            'line' => 'Standard & Full Assembly',
            'href' => '#abs-3-in-1',
            'rule' => 'border-goliath-green',
        ],
        [
            'title' => '7-Way Electrical Cables',
            'line' => 'Straight & Coiled',
            'href' => '#seven-way',
            'rule' => 'border-goliath-green',
        ],
        [
            'title' => 'Air Brake Hoses',
            'line' => 'Service & Emergency',
            'href' => '#air-brake-hoses',
            'rule' => 'border-goliath-green',
        ],
        [
            'title' => 'Diamond-Grip Nitrile Gloves',
            'line' => 'Sizes S – XXL · Sold by the case',
            'href' => '#gloves',
            'rule' => 'border-goliath-orange',
        ],
    ];
@endphp
<section class="relative bg-goliath-950 p-clamp-x pt-clamp-xl pb-20 text-white">
  <div class="container">
    <nav class="text-sm font-semibold text-goliath-silver" aria-label="{{ __('Breadcrumb', 'sage') }}">
      <a class="underline-offset-[3px] hover:underline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-goliath-green" href="{{ $brandsUrl }}">Our brands</a>
      <span aria-hidden="true">/</span>
      Goliath Steel
    </nav>

    <div class="mt-9 flex flex-wrap items-center justify-between gap-12">
      <div class="min-w-[min(100%,520px)] shrink grow basis-[520px]">
        <h1 class="mb-0 font-fraunces text-white">
          Trusted Products. <em class="italic font-medium text-goliath-silver">Unbeatable Value.</em>
        </h1>

        <p class="mt-6 mb-0 inline-flex items-center gap-2.5 text-sm font-bold tracking-widest text-white/80 uppercase">
          <span class="inline-flex h-7 items-center rounded bg-primary px-2 text-xs font-bold tracking-normal text-white normal-case">
            @if ($koglerMark)
              {!! $koglerMark !!}
            @else
              Kögler
            @endif
          </span>
          A Kogler USA brand
        </p>

        <div class="mt-9 flex flex-wrap gap-3.5">
          <a class="btn btn-primary" href="#products">View products</a>
          <a class="btn btn-brand-outline" href="{{ $distributorUrl }}">Find a Distributor</a>
        </div>
      </div>

      @if ($goliathLogo !== '')
        <div class="w-full max-w-[300px] shrink-0 min-[1000px]:ml-auto min-[1000px]:max-w-[420px] min-[1000px]:basis-[420px] min-[1000px]:grow-0">
          {!! $goliathLogo !!}
        </div>
      @endif
    </div>

    <ul class="mt-20 grid list-none grid-cols-1 gap-6 p-0 sm:grid-cols-2 lg:grid-cols-4">
      @foreach ($facts as $fact)
        <li class="border-t-2 {{ $fact['rule'] }} pt-[18px]">
          <a class="group block no-underline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-goliath-green" href="{{ $fact['href'] }}">
            <p class="mb-0 text-[length:var(--font-size-tagline)] font-bold text-white group-hover:underline">{{ $fact['title'] }}</p>
            <p class="mt-1 mb-0 text-[length:var(--font-size-btn)] text-white/75">{{ $fact['line'] }}</p>
          </a>
        </li>
      @endforeach
    </ul>
  </div>
</section>
