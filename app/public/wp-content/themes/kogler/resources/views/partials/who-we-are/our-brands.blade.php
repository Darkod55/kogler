{{--
  Who We Are — Our brands
  Each card uses that brand’s colour and logo attachment.
  Sleep 395, Goliath 397, Outdoor 396.
--}}
@php
    $brandLogo = function (int $id, string $alt): string {
        if ($id < 1 || ! function_exists('wp_get_attachment_image')) {
            return '';
        }

        $mime = function_exists('get_post_mime_type') ? (string) get_post_mime_type($id) : '';
        $isImage = function_exists('wp_attachment_is_image') && wp_attachment_is_image($id);

        if (! $isImage && $mime !== 'image/svg+xml') {
            return '';
        }

        $image = wp_get_attachment_image($id, 'full', false, [
            'class' => 'block h-auto w-full max-w-[240px] object-contain',
            'alt' => $alt,
            'loading' => 'lazy',
            'decoding' => 'async',
        ]);

        return is_string($image) ? $image : '';
    };

    $brands = [
        [
            'name' => 'Kogler',
            'description' => 'High-quality sleep products for the commercial truck cab.',
            'link_label' => 'Visit Kogler',
            'url' => \App\helpers()->brandPageUrl('kogler-sleep'),
            'logo' => $brandLogo(395, 'Kögler Sleep'),
            'panel' => 'bg-primary',
            'strip' => 'bg-dark-blue',
            'link' => 'text-secondary',
        ],
        [
            'name' => 'Goliath Steel',
            'description' => 'Heavy-duty commercial truck aftermarket parts, high quality at reasonable prices.',
            'link_label' => 'Visit Goliath Steel',
            'url' => \App\helpers()->brandPageUrl('goliath-steel'),
            'logo' => $brandLogo(397, 'Goliath Steel'),
            'panel' => 'bg-goliath-900',
            'strip' => 'bg-goliath-950',
            'link' => 'text-goliath-chrome',
        ],
        [
            'name' => 'Kogler Outdoor',
            'description' => 'Adventure sleep products for life on the road and on the water.',
            'link_label' => 'Visit Kogler Outdoor',
            'url' => \App\helpers()->brandPageUrl('kogler-outdoor'),
            'logo' => $brandLogo(396, 'Kögler Outdoor'),
            'panel' => 'bg-outdoor-900',
            'strip' => 'bg-outdoor-950',
            'link' => 'text-outdoor-amber',
        ],
    ];
@endphp
<section class="relative bg-white p-clamp-x pt-0 pb-clamp-xl">
  <div class="container">
    <h2 class="mb-0 font-heading text-dark-blue">
      {{ \App\helpers()->pageField('wwa_brands_title', 'Three Brands, One Standard.') }}
    </h2>
    <p class="mt-4 mb-0 max-w-[620px] text-[length:var(--font-size-lead)] leading-[1.7] text-dark-blue/75">
      {{ \App\helpers()->pageField('wwa_brands_intro', 'Three specialist brands, each built for a different part of life on the road and on the water.') }}
    </p>

    <div class="mt-8 grid grid-cols-1 gap-4 md:grid-cols-3">
      @foreach ($brands as $brand)
        <a
          href="{{ $brand['url'] }}"
          class="group relative flex min-h-[440px] flex-col justify-end overflow-hidden rounded-xl no-underline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary md:min-h-[560px]"
        >
          <div class="flex min-h-0 w-full flex-1 items-center justify-center p-8 {{ $brand['panel'] }}">
            @if ($brand['logo'] !== '')
              {!! $brand['logo'] !!}
            @endif
          </div>

          <div class="relative z-10 p-8 {{ $brand['strip'] }}">
            <h3 class="mb-0 text-white">
              {{ $brand['name'] }}
            </h3>
            <p class="mt-2.5 mb-[18px] text-[length:var(--font-size-base)] leading-relaxed text-white/85">
              {{ $brand['description'] }}
            </p>
            <span class="text-[length:var(--font-size-btn)] font-semibold group-hover:underline {{ $brand['link'] }}">
              {{ $brand['link_label'] }} →
            </span>
          </div>
        </a>
      @endforeach
    </div>
  </div>
</section>
