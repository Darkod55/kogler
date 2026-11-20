{{--
  Who We Are — Our brands
  URLs and image IDs are placeholders. Set url and image_id per brand when they exist.
  Images render only when image_id is a real attachment. Otherwise the card keeps bg-dark-gray.
--}}
@php
    $brands = [
        [
            'name' => 'Kogler',
            'description' => 'High-quality sleep products for the commercial truck cab.',
            'link_label' => 'Visit Kogler',
            'url' => '#',
            'image_id' => 0,
            'alt' => __('Kogler mattress in a truck sleeper cab', 'sage'),
            'strip' => 'color-mix(in srgb, var(--color-dark-blue) 88%, transparent)',
            'link' => 'var(--color-secondary)',
        ],
        [
            'name' => 'Goliath Steel',
            'description' => 'Heavy-duty commercial truck aftermarket parts, high quality at reasonable prices.',
            'link_label' => 'Visit Goliath Steel',
            'url' => '#',
            'image_id' => 0,
            'alt' => __('Goliath Steel heavy-duty truck parts', 'sage'),
            'strip' => 'color-mix(in srgb, #181B1E 90%, transparent)',
            'link' => '#D6DBDF',
        ],
        [
            'name' => 'Kogler Outdoor',
            'description' => 'Adventure sleep products for life on the road and on the water.',
            'link_label' => 'Visit Kogler Outdoor',
            'url' => '#',
            'image_id' => 0,
            'alt' => __('RV parked by a lake', 'sage'),
            'strip' => 'color-mix(in srgb, #203228 90%, transparent)',
            'link' => '#F2C88F',
        ],
    ];
@endphp
<section class="relative bg-white px-clamp pt-0 pb-clamp-block-xl">
  <div class="container">
    <h2 class="mb-8 font-heading text-[clamp(30px,3.2vw,44px)] font-bold tracking-tight text-dark-blue">
      Our brands
    </h2>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
      @foreach ($brands as $brand)
        @php
            $brandImage = '';
            $brandImageId = (int) $brand['image_id'];

            if ($brandImageId && function_exists('wp_attachment_is_image') && wp_attachment_is_image($brandImageId)) {
                $brandAttrs = [
                    'class' => 'absolute inset-0 h-full w-full object-cover motion-safe:transition-transform motion-safe:group-hover:scale-[1.03]',
                    'loading' => 'lazy',
                    'decoding' => 'async',
                    'sizes' => '(min-width: 1348px) 422px, (min-width: 768px) calc((100vw - 80px) / 3), calc(100vw - 48px)',
                ];

                $brandAlt = trim(wp_strip_all_tags((string) get_post_meta($brandImageId, '_wp_attachment_image_alt', true)));

                if ($brandAlt === '') {
                    $brandAttrs['alt'] = $brand['alt'];
                }

                $brandImage = wp_get_attachment_image($brandImageId, 'full', false, $brandAttrs);
            }
        @endphp
        <a
          href="{{ $brand['url'] }}"
          class="group relative flex min-h-[440px] flex-col justify-end overflow-hidden rounded-xl bg-dark-gray no-underline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary md:min-h-[560px]"
          style="--brand-strip: {{ $brand['strip'] }}; --brand-link: {{ $brand['link'] }};"
        >
          @if ($brandImage)
            {!! $brandImage !!}
          @endif

          <div class="relative z-10 bg-[var(--brand-strip)] p-8">
            <h3 class="mb-0 text-[30px] font-extrabold tracking-tight text-white">
              {{ $brand['name'] }}
            </h3>
            <p class="mt-2.5 mb-[18px] text-[length:var(--font-size-base)] leading-relaxed text-white/85">
              {{ $brand['description'] }}
            </p>
            <span class="text-[length:var(--font-size-btn)] font-semibold text-[color:var(--brand-link)] group-hover:underline">
              {{ $brand['link_label'] }} →
            </span>
          </div>
        </a>
      @endforeach
    </div>
  </div>
</section>
