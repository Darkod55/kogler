{{--
  Kögler Outdoor brand page — intro and product cards.
  This partial is only included from the Brand Page template.
  The Our Brands page keeps partials/brand/kogler-outdoor.blade.php.
  Set $imageId for the lakeside RV photo. 0 keeps the green placeholder.
  Product cards come from the outdoor_products repeater when ACF has rows.
  Detail lines stay hidden until a size list or marine list is supplied.
  In-page offset is html scroll-padding-top (--site-chrome-height).
--}}
@php
    $chipLogoId = 0;
    $imageId = 0;
    $chipLogo = '';
    $photoHtml = '';

    if ($chipLogoId && function_exists('wp_get_attachment_image')) {
        $mime = function_exists('get_post_mime_type') ? (string) get_post_mime_type($chipLogoId) : '';
        $isImage = function_exists('wp_attachment_is_image') && wp_attachment_is_image($chipLogoId);

        if ($isImage || $mime === 'image/svg+xml') {
            $renderedChip = wp_get_attachment_image($chipLogoId, 'full', false, [
                'class' => 'h-6 w-auto',
                'alt' => 'Kögler Outdoor',
                'loading' => 'lazy',
                'decoding' => 'async',
            ]);
            $chipLogo = is_string($renderedChip) ? $renderedChip : '';
        }
    }

    if ($imageId && function_exists('wp_attachment_is_image') && wp_attachment_is_image($imageId)) {
        $rendered = wp_get_attachment_image($imageId, 'full', false, [
            'class' => 'absolute inset-0 h-full w-full object-cover',
            'alt' => 'RV parked at a lakeside campsite',
            'loading' => 'lazy',
            'decoding' => 'async',
            'sizes' => '(min-width: 1000px) 640px, calc(100vw - 48px)',
        ]);
        $photoHtml = is_string($rendered) ? $rendered : '';
    }

    $amazonUrl = \App\helpers()->outdoorAmazonUrl();
    $warrantyUrl = function_exists('home_url') ? home_url('/warranty/') : '#';

    if (function_exists('get_page_by_path') && function_exists('get_permalink')) {
        $warrantyPage = get_page_by_path('warranty');

        if ($warrantyPage instanceof \WP_Post && $warrantyPage->post_status === 'publish') {
            $permalink = get_permalink($warrantyPage);

            if (is_string($permalink) && $permalink !== '') {
                $warrantyUrl = $permalink;
            }
        }
    }

    $products = [
        [
            'title' => 'RV Mattresses',
            'image_id' => 0,
            'detail' => '',
            'alt' => 'Kögler mattress in an RV bedroom',
            'placeholder' => 'bg-outdoor-600',
        ],
        [
            'title' => 'Marine Sleep Products',
            'image_id' => 0,
            'detail' => '',
            'alt' => 'Kögler mattress in a boat cabin berth',
            'placeholder' => 'bg-outdoor-water',
        ],
    ];

    if (function_exists('get_field')) {
        $saved = get_field('outdoor_products');
        $cards = [];

        if (is_array($saved)) {
            foreach ($saved as $index => $card) {
                if (! is_array($card)) {
                    continue;
                }

                $title = trim((string) ($card['title'] ?? ''));
                $detail = trim((string) ($card['detail'] ?? ''));
                $image = $card['image'] ?? 0;
                $imageIdCard = is_array($image) ? (int) ($image['ID'] ?? $image['id'] ?? 0) : (int) $image;

                if ($title === '' && $detail === '' && $imageIdCard < 1) {
                    continue;
                }

                $placeholders = ['bg-outdoor-600', 'bg-outdoor-water', 'bg-outdoor-700'];
                $cards[] = [
                    'title' => $title !== '' ? $title : 'Product',
                    'image_id' => $imageIdCard,
                    'detail' => $detail,
                    'alt' => $title !== '' ? $title : 'Kögler Outdoor product',
                    'placeholder' => $placeholders[$index] ?? 'bg-outdoor-700',
                ];
            }
        }

        if ($cards !== []) {
            $products = $cards;
        }
    }

    $productGrid = 'm-0 mt-0 grid list-none grid-cols-1 gap-6 p-0 md:grid-cols-2';

    if (count($products) >= 3) {
        $productGrid .= ' lg:grid-cols-3';
    }
@endphp
<section id="products" class="relative bg-outdoor-900 px-clamp py-clamp-xl text-white">
  <div class="container">
    <div class="flex flex-wrap items-center gap-16">
      <div class="min-w-[min(100%,460px)] shrink grow basis-[460px]">
        @if ($chipLogo !== '')
          <span class="inline-flex h-12 items-center rounded-xl bg-white/10 px-5">
            {!! $chipLogo !!}
          </span>
        @else
          <span class="inline-flex h-12 items-center gap-2.5 rounded-xl bg-white/10 px-5" role="img" aria-label="Kögler Outdoor">
            <span class="text-[22px] font-bold tracking-tight text-white" aria-hidden="true">Kögler</span>
            <span class="text-[13px] font-bold tracking-[0.2em] text-outdoor-amber" aria-hidden="true">OUTDOOR</span>
          </span>
        @endif

        <h2 class="mt-6 mb-0 font-fraunces tracking-tight text-white">
          Sleep Like Home, <em class="italic font-medium text-outdoor-amber">Wherever You Roam!</em>
        </h2>

        <p class="mt-6 mb-0 max-w-[560px] lead leading-[1.7] text-white/85">
          Kogler Outdoor brings our sleep expertise to the RV and marine markets, with comfort products made for RVs, campers and boats.
        </p>

        <div class="mt-8 flex flex-wrap gap-3.5">
          @if ($amazonUrl !== '')
            <a class="btn btn-primary" href="{{ $amazonUrl }}" target="_blank" rel="noopener">
              Shop on Amazon<span class="sr-only"> (opens in a new tab)</span>
            </a>
          @endif
          <a class="btn btn-brand-outline" href="{{ $warrantyUrl }}">Warranty</a>
        </div>
      </div>

      <div
        class="relative h-[280px] min-w-[min(100%,460px)] w-full shrink grow basis-[460px] overflow-hidden rounded-3xl bg-outdoor-700 min-[1000px]:h-[420px]"
        @unless ($photoHtml !== '') aria-hidden="true" @endunless
      >
        @if ($photoHtml !== '')
          {!! $photoHtml !!}
        @endif
      </div>
    </div>

    <div class="mt-[72px]">
      <h3 class="mb-5 text-white">Products</h3>

      <ul class="{{ $productGrid }}">
        @foreach ($products as $product)
          @php
              $thumb = '';
              $thumbId = (int) ($product['image_id'] ?? 0);
              $detail = trim((string) ($product['detail'] ?? ''));

              if ($thumbId && function_exists('wp_attachment_is_image') && wp_attachment_is_image($thumbId)) {
                  $thumb = wp_get_attachment_image($thumbId, 'large', false, [
                      'class' => 'absolute inset-0 h-full w-full object-cover',
                      'alt' => (string) ($product['alt'] ?? $product['title']),
                      'loading' => 'lazy',
                      'decoding' => 'async',
                      'sizes' => '(min-width: 1000px) 50vw, calc(100vw - 48px)',
                  ]);
              }
          @endphp
          <li class="relative flex min-h-[360px] flex-col justify-end overflow-hidden rounded-3xl md:min-h-[460px] {{ $product['placeholder'] }}">
            @if (is_string($thumb) && $thumb !== '')
              {!! $thumb !!}
            @endif
            <div class="relative bg-outdoor-950 px-8 py-7">
              <h4 class="mb-0 font-fraunces text-white">{{ $product['title'] }}</h4>
              @if ($detail !== '')
                <p class="mt-1.5 mb-0 text-sm text-outdoor-amber">{{ $detail }}</p>
              @endif
            </div>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
</section>
