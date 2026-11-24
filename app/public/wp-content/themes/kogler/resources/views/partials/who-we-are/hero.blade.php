{{--
  Who We Are — Hero
  Media is attachment 97. The bg-primary wrapper shows through while it loads,
  and stays empty if that attachment is missing.
--}}
@php
    $heroImageId = 97;
    $heroImage = '';

    if (function_exists('wp_attachment_is_image') && wp_attachment_is_image($heroImageId)) {
        $heroAttrs = [
            'class' => 'h-full w-full rounded-t-3xl object-cover',
            'loading' => 'eager',
            'fetchpriority' => 'high',
            'decoding' => 'async',
            // Container max is 1300px inside px-clamp (24px each side).
            'sizes' => '(min-width: 1348px) 1300px, calc(100vw - 48px)',
        ];

        $heroAlt = trim(wp_strip_all_tags((string) get_post_meta($heroImageId, '_wp_attachment_image_alt', true)));

        if ($heroAlt === '') {
            $heroAttrs['alt'] = __('Wide road / truck shot', 'sage');
        }

        $heroImage = wp_get_attachment_image($heroImageId, 'full', false, $heroAttrs);
    }
@endphp
<section class="relative overflow-hidden bg-dark-blue px-clamp pt-clamp-block-xl pb-0 text-left">
  <div class="container">
    <h1 class="mb-0 max-w-[1100px] font-fraunces text-[clamp(44px,6.2vw,88px)] font-semibold leading-[1.02] tracking-tight text-white">
      One Company. Three Brands.
      <em class="font-medium italic text-secondary">Built for the People Who Keep America Moving.</em>
    </h1>

    <p class="mt-12 mb-0 max-w-[620px] text-lg leading-relaxed text-white/85 lg:text-[length:var(--font-size-lead)]">
      At Kogler-USA we supply thousands of customers across the commercial truck, RV and marine markets through three brands: Kogler, Goliath Steel and Kogler Outdoor.
    </p>

    <div
      class="mt-16 h-[280px] w-full overflow-hidden rounded-t-3xl bg-primary lg:h-[460px]"
      @unless ($heroImage) aria-hidden="true" @endunless
    >
      @if ($heroImage)
        {!! $heroImage !!}
      @endif
    </div>
  </div>
</section>
