{{--
  Who We Are — We are
  No facility photo yet. Set $weAreImageId when the attachment exists.
  The bg-light-blue box stays aria-hidden until that image renders.
  Icons are inline Lucide paths: the sprite has icon-user and icon-warranty, not users / shield-check.
--}}
@php
    $weAreImageId = 0;
    $weAreImage = '';

    if ($weAreImageId && function_exists('wp_attachment_is_image') && wp_attachment_is_image($weAreImageId)) {
        $weAreAttrs = [
            'class' => 'h-full w-full rounded-3xl object-cover',
            'loading' => 'lazy',
            'decoding' => 'async',
            'sizes' => '(min-width: 768px) 400px, calc(100vw - 48px)',
        ];

        $weAreAlt = trim(wp_strip_all_tags((string) get_post_meta($weAreImageId, '_wp_attachment_image_alt', true)));

        if ($weAreAlt === '') {
            $weAreAttrs['alt'] = __('Mattress production at Kogler\'s facility in Cleveland, Tennessee', 'sage');
        }

        $weAreImage = wp_get_attachment_image($weAreImageId, 'full', false, $weAreAttrs);
    }
@endphp
<section class="relative bg-white px-clamp py-clamp-xl">
  <div class="container">
    <div class="flex flex-wrap gap-16">
      <div class="min-w-0 max-w-[400px] shrink grow basis-[320px]">
        <h2 class="mb-0 font-fraunces text-[clamp(32px,3.4vw,48px)] font-semibold leading-[1.1] text-dark-blue">
          We are
        </h2>

        <div
          class="mt-10 h-[300px] w-full overflow-hidden rounded-3xl bg-light-blue"
          @unless ($weAreImage) aria-hidden="true" @endunless
        >
          @if ($weAreImage)
            {!! $weAreImage !!}
          @endif
        </div>
      </div>

      <div class="min-w-0 shrink basis-[560px] grow-[999]">
        <div class="grid gap-5 [grid-template-columns:repeat(auto-fit,minmax(min(100%,320px),1fr))]">
          <article class="flex flex-col gap-4 rounded-3xl bg-light p-9">
            <div class="flex size-[52px] items-center justify-center rounded-[14px] bg-primary text-white">
              <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                <circle cx="9" cy="7" r="4" />
              </svg>
            </div>
            <h3 class="mb-0 text-[22px] font-bold text-dark-blue">Partners</h3>
            <p class="mb-0 text-[length:var(--font-size-base)] leading-[1.65] text-dark-blue/75">
              We learn your business and build programs around how you buy, stock and sell.
            </p>
          </article>

          <article class="flex flex-col gap-4 rounded-3xl bg-light p-9">
            <div class="flex size-[52px] items-center justify-center rounded-[14px] bg-primary text-white">
              <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                <path d="m9 12 2 2 4-4" />
              </svg>
            </div>
            <h3 class="mb-0 text-[22px] font-bold text-dark-blue">Quality</h3>
            <p class="mb-0 text-[length:var(--font-size-base)] leading-[1.65] text-dark-blue/75">
              From the foam that goes into a mattress to the cable that connects a trailer, everything is tested against the realities of life on the road.
            </p>
          </article>

          <article class="flex flex-col gap-4 rounded-3xl bg-dark-blue p-9 text-white">
            <div class="flex flex-wrap items-baseline gap-3">
              <span class="font-fraunces text-[72px] font-semibold leading-none text-secondary">50+</span>
              <span class="whitespace-nowrap text-sm text-white/80">years in heavy-duty</span>
            </div>
            <h3 class="mb-0 text-[22px] font-bold text-white">Industry Backed</h3>
            <p class="mb-0 text-[length:var(--font-size-base)] leading-[1.65] text-white/85">
              With over 50 years in heavy-duty, our leaders understand the industry and are aligned with your needs.
            </p>
          </article>

          <article class="flex flex-col gap-4 rounded-3xl bg-dark-blue p-9 text-white">
            <div class="flex flex-wrap items-baseline gap-3">
              <span class="font-fraunces text-[72px] font-semibold leading-none text-secondary">150+</span>
              <span class="whitespace-nowrap text-sm text-white/80">mattresses each day</span>
            </div>
            <h3 class="mb-0 text-[22px] font-bold text-white">Made in the USA</h3>
            <p class="mb-0 text-[length:var(--font-size-base)] leading-[1.65] text-white/85">
              Our manufacturing facility in Cleveland, TN produces over 150 quality mattresses each day.
            </p>
          </article>
        </div>
      </div>
    </div>
  </div>
</section>
