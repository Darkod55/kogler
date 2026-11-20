{{--
  Who We Are — Quality and price
  No mattress image yet. Set $qualityImageId to the media library attachment ID.
  The bg-secondary/60 box stays as the fallback until that image renders.
  Do not wire /wp-content/uploads/2026/08/kogler-video-mattress.mp4.
--}}
@php
    $qualityImageId = 0;
    $qualityImage = '';

    if ($qualityImageId && function_exists('wp_attachment_is_image') && wp_attachment_is_image($qualityImageId)) {
        $qualityAttrs = [
            'class' => 'h-full w-full rounded-xl object-cover',
            'loading' => 'lazy',
            'decoding' => 'async',
            // Half of the 1300px container after the 64px desktop gap, inside px-clamp.
            'sizes' => '(min-width: 1348px) 618px, (min-width: 1024px) calc((100vw - 112px) / 2), calc(100vw - 48px)',
        ];

        $qualityAlt = trim(wp_strip_all_tags((string) get_post_meta($qualityImageId, '_wp_attachment_image_alt', true)));

        if ($qualityAlt === '') {
            $qualityAttrs['alt'] = __('Cross-section of a Kogler mattress showing its foam layers', 'sage');
        }

        $qualityImage = wp_get_attachment_image($qualityImageId, 'full', false, $qualityAttrs);
    }
@endphp
<section class="relative bg-white px-clamp py-clamp-xl">
  <div class="container">
    <div class="flex flex-wrap items-center gap-10 lg:gap-16">
      <div class="min-w-0 shrink grow basis-[420px]">
        <h2 class="mb-0 font-heading text-[clamp(30px,3.2vw,44px)] font-bold leading-[1.2] tracking-tight text-dark-blue">
          We don't believe you should have to choose between quality and price.
        </h2>

        <p class="mt-6 mb-0 max-w-[520px] text-[length:var(--font-size-tagline)] leading-[1.7] text-dark-blue/75">
          Our products are built to hold up mile after mile, and priced so you don't pay a premium for it.
        </p>
      </div>

      <div
        class="h-[280px] min-w-0 shrink grow basis-[420px] overflow-hidden rounded-xl bg-secondary/60 lg:h-[440px]"
        @unless ($qualityImage) aria-hidden="true" @endunless
      >
        @if ($qualityImage)
          {!! $qualityImage !!}
        @endif
      </div>
    </div>
  </div>
</section>
