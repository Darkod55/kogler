{{--
  Who We Are — We serve
  Homepage filenames (kogler-distributor-img, kogler-repair-shop-img,
  kogler-fleet-manager-img, kogler-rv-owner-img) are not in the theme, and
  Dealerships / Retailers are new. Every image_id stays 0 until attached.
  The sprite has no Lucide package, warehouse, shopping-bag, wrench, truck,
  or caravan symbols, so the tiles use inline Lucide paths.
--}}
@php
    $serveIcons = [
        'package' => '<path d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z" /><path d="M12 22V12" /><polyline points="3.29 7 12 12 20.71 7" /><path d="m7.5 4.27 9 5.15" />',
        'warehouse' => '<path d="M18 21V10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v11" /><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8a2 2 0 0 1 1.132-1.803l7.95-3.974a2 2 0 0 1 1.837 0l7.948 3.974A2 2 0 0 1 22 8z" /><path d="M6 13h12" /><path d="M6 17h12" />',
        'shopping-bag' => '<path d="M16 10a4 4 0 0 1-8 0" /><path d="M3.103 6.034h17.794" /><path d="M3.4 5.467a2 2 0 0 0-.4 1.2V20a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6.667a2 2 0 0 0-.4-1.2l-2-2.667A2 2 0 0 0 17 2H7a2 2 0 0 0-1.6.8z" />',
        'wrench' => '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.106-3.105c.32-.322.863-.22.983.218a6 6 0 0 1-8.259 7.057l-7.91 7.91a1 1 0 0 1-2.999-3l7.91-7.91a6 6 0 0 1 7.057-8.259c.438.12.54.662.219.984z" />',
        'truck' => '<path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2" /><path d="M15 18H9" /><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14" /><circle cx="17" cy="18" r="2" /><circle cx="7" cy="18" r="2" />',
        'caravan' => '<path d="M18 19V9a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v8a2 2 0 0 0 2 2h2" /><path d="M2 9h3a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2" /><path d="M22 17v1a1 1 0 0 1-1 1H10v-9a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v9" /><circle cx="8" cy="19" r="2" />',
    ];

    $audiences = [
        [
            'title' => 'Distributors',
            'text' => 'A reliable supplier partner with programs built for resale.',
            'icon' => 'package',
            'image_id' => 0,
            'alt' => __('Kogler products prepared for a distributor partner', 'sage'),
        ],
        [
            'title' => 'Dealerships',
            'text' => 'Products that fit the trucks you sell and service.',
            'icon' => 'warehouse',
            'image_id' => 0,
            'alt' => __('Truck dealership lot lined with commercial trucks', 'sage'),
        ],
        [
            'title' => 'Retailers',
            'text' => 'Brands ready for shelf and online.',
            'icon' => 'shopping-bag',
            'image_id' => 0,
            'alt' => __('Retail shelf stocked for in-store and online sale', 'sage'),
        ],
        [
            'title' => 'Repair Shops',
            'text' => 'Dependable parts on hand so you can get trucks back on the road.',
            'icon' => 'wrench',
            'image_id' => 0,
            'alt' => __('Technician working in a truck repair bay', 'sage'),
        ],
        [
            'title' => 'Fleets',
            'text' => 'Standardized products, consistent supply and one point of contact.',
            'icon' => 'truck',
            'image_id' => 0,
            'alt' => __('Fleet of commercial trucks ready for the road', 'sage'),
        ],
        [
            'title' => 'RV & Boat Owners',
            'text' => 'Quality products for your home away from home.',
            'icon' => 'caravan',
            'image_id' => 0,
            'alt' => __('RV parked by a lake', 'sage'),
        ],
    ];
@endphp
<section class="relative bg-dark-blue p-clamp-xl">
  <div class="container">
    <h2 class="mb-0 font-fraunces text-white">
      We Serve
    </h2>

    <div class="mt-14 grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">
      @foreach ($audiences as $audience)
        @php
            $audienceImage = '';
            $audienceImageId = (int) $audience['image_id'];

            if ($audienceImageId && function_exists('wp_attachment_is_image') && wp_attachment_is_image($audienceImageId)) {
                $audienceAttrs = [
                    'class' => 'h-full w-full object-cover',
                    'loading' => 'lazy',
                    'decoding' => 'async',
                    'sizes' => '(min-width: 1348px) 420px, (min-width: 1024px) calc((100vw - 88px) / 3), (min-width: 768px) calc((100vw - 68px) / 2), calc(100vw - 48px)',
                ];

                $audienceAlt = trim(wp_strip_all_tags((string) get_post_meta($audienceImageId, '_wp_attachment_image_alt', true)));

                if ($audienceAlt === '') {
                    $audienceAttrs['alt'] = $audience['alt'];
                }

                $audienceImage = wp_get_attachment_image($audienceImageId, 'full', false, $audienceAttrs);
            }
        @endphp
        <article class="overflow-hidden rounded-3xl bg-white">
          <div
            class="h-[170px] w-full bg-light-blue"
            @unless ($audienceImage) aria-hidden="true" @endunless
          >
            @if ($audienceImage)
              {!! $audienceImage !!}
            @endif
          </div>

          <div class="flex items-start gap-4 p-7">
            <div class="flex size-[44px] flex-none items-center justify-center rounded-xl bg-light-blue text-primary">
              <svg class="size-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                {!! $serveIcons[$audience['icon']] !!}
              </svg>
            </div>

            <div class="min-w-0">
              <h3 class="mb-1.5 text-dark-blue">
                {{ kogler_title_case($audience['title']) }}
              </h3>
              <p class="mb-0 text-[length:var(--font-size-btn)] leading-[1.6] text-dark-blue/75">
                {{ $audience['text'] }}
              </p>
            </div>
          </div>
        </article>
      @endforeach
    </div>
  </div>
</section>
