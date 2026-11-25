{{--
  Brand — Kogler Outdoor
  No ACF. Products and the parts slot are edited in the arrays below.
  An admin-editable catalogue would need ACF.
  No Kogler Outdoor logo file is referenced in the theme. Set $logoUrl to
  swap the wordmark for an image. $tile fills the photo slot when $imageId is empty.
  $amazonUrl is empty until the Amazon URL is confirmed. The button is
  omitted while it is empty.
--}}
@php
    $logoUrl = '';
    $amazonUrl = '';
    $imageId = 0;
    $tileFile = 'kogler-outdoor.webp';
    $tileUrl = '';
    $outdoorImage = '';

    if ($tileFile !== '' && class_exists(\Illuminate\Support\Facades\Vite::class)) {
        try {
            $tileUrl = \Illuminate\Support\Facades\Vite::asset('resources/images/brands/' . $tileFile);
        } catch (\Throwable $e) {
            $tileUrl = '';
        }
    }

    if ($imageId && function_exists('wp_attachment_is_image') && wp_attachment_is_image($imageId)) {
        $outdoorImage = wp_get_attachment_image($imageId, 'full', false, [
            'class' => 'h-full w-full object-cover',
            'loading' => 'lazy',
            'decoding' => 'async',
            'alt' => __('RV parked beside a lake at a campsite', 'sage'),
            'sizes' => '(min-width: 1024px) 640px, calc(100vw - 48px)',
        ]);
    }

    $warrantyUrl = function_exists('home_url') ? home_url('/warranty/') : '#';

    if (function_exists('get_page_by_path') && function_exists('get_permalink')) {
        $warrantyPage = get_page_by_path('warranty');

        if ($warrantyPage instanceof \WP_Post && $warrantyPage->post_status === 'publish') {
            $warrantyUrl = get_permalink($warrantyPage);
        }
    }

    $products = [
        ['title' => 'RV mattresses', 'image_id' => 0, 'note' => '', 'url' => ''],
        ['title' => 'Marine sleep products', 'image_id' => 0, 'note' => '', 'url' => ''],
    ];

    // Future parts guide. Empty means nothing is rendered.
    $parts = [];

    $cardClass = 'flex items-center gap-5 rounded-3xl bg-white p-4';
    $cardLinkClass = $cardClass . ' no-underline transition hover:shadow-lg focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-(--ko-green)';
@endphp
<section
  id="kogler-outdoor"
  class="bg-light p-clamp-xl"
  style="--ko-green: var(--color-outdoor-900); --ko-ink: var(--color-outdoor-ink); --ko-amber: var(--color-outdoor-amber); --ko-amber-ink: var(--color-outdoor-amber-ink); --ko-tint: var(--color-outdoor-tint);"
>
  <div class="container">
    <div class="flex flex-wrap items-center gap-16">
      <div class="min-w-[min(100%,460px)] shrink grow basis-[460px]">
        @if ($logoUrl)
          <span class="inline-flex h-12 items-center gap-2.5 rounded-xl bg-(--ko-green) px-5">
            <img src="{{ $logoUrl }}" alt="{{ __('Kogler Outdoor', 'sage') }}" class="h-6 w-auto" height="24">
          </span>
        @else
          <span class="inline-flex h-12 items-center gap-2.5 rounded-xl bg-(--ko-green) px-5" role="img" aria-label="{{ __('Kogler Outdoor', 'sage') }}">
            <span class="text-[22px] font-bold text-white" aria-hidden="true">Kögler</span>
            <span class="text-[13px] font-bold tracking-[0.2em] text-(--ko-amber)" aria-hidden="true">OUTDOOR</span>
          </span>
        @endif

        <h2 class="mt-6 mb-0 font-fraunces text-(--ko-green)">
          Sleep Like Home, <em class="italic font-medium text-(--ko-amber-ink)">Wherever You Roam!</em>
        </h2>

        <p class="mt-6 mb-0 max-w-[560px] lead leading-[1.7] text-(--ko-ink)/80">
          Kogler Outdoor brings our sleep expertise to the RV and marine markets, with comfort products made for RVs, campers and boats.
        </p>

        <div class="mt-8 flex flex-wrap gap-3.5">
          @if ($amazonUrl)
            <a class="btn btn-primary" href="{{ $amazonUrl }}" target="_blank" rel="noopener">
              {{ __('Shop on Amazon', 'sage') }}<span class="sr-only"> {{ __('(opens in a new tab)', 'sage') }}</span>
            </a>
          @endif
          <a class="btn btn-secondary" href="{{ $warrantyUrl }}">
            {{ __('Warranty', 'sage') }}
          </a>
        </div>
      </div>

      <div
        class="relative h-[280px] min-w-[min(100%,460px)] w-full shrink grow basis-[460px] overflow-hidden rounded-3xl bg-(--ko-tint) lg:h-[420px]"
        @unless ($outdoorImage || $tileUrl) aria-hidden="true" @endunless
      >
        @if ($outdoorImage)
          {!! $outdoorImage !!}
        @elseif ($tileUrl)
          <img src="{{ $tileUrl }}" alt="{{ __('Kogler Outdoor logo', 'sage') }}" width="270" height="270" class="absolute inset-0 h-full w-full object-cover object-center" loading="lazy" decoding="async">
        @endif
      </div>
    </div>

    <div class="mt-[72px]">
      <h3 class="mb-5 text-(--ko-green)">Products</h3>

      <ul class="m-0 grid list-none grid-cols-1 gap-5 p-0 md:grid-cols-2">
        @foreach ($products as $product)
          @php
              $thumb = '';
              $thumbId = (int) ($product['image_id'] ?? 0);

              if ($thumbId && function_exists('wp_attachment_is_image') && wp_attachment_is_image($thumbId)) {
                  $thumb = wp_get_attachment_image($thumbId, 'medium', false, [
                      'class' => 'h-full w-full object-cover',
                      'alt' => $product['title'],
                      'loading' => 'lazy',
                      'decoding' => 'async',
                  ]);
              }

              $note = trim((string) ($product['note'] ?? ''));
          @endphp
          <li>
            @if (! empty($product['url']))
              <a href="{{ $product['url'] }}" class="{{ $cardLinkClass }}">
            @else
              <div class="{{ $cardClass }}">
            @endif
                <div
                  class="h-[120px] w-[140px] flex-none overflow-hidden rounded-2xl bg-(--ko-tint) max-[400px]:h-[96px] max-[400px]:w-[112px]"
                  @unless ($thumb) aria-hidden="true" @endunless
                >
                  @if ($thumb)
                    {!! $thumb !!}
                  @endif
                </div>
                <div>
                  <h4 class="mb-0 font-fraunces text-(--ko-green)">{{ kogler_title_case($product['title']) }}</h4>
                  @if ($note !== '')
                    <p class="mt-1.5 mb-0 text-[14px] text-(--ko-amber-ink)">{{ $note }}</p>
                  @endif
                </div>
            @if (! empty($product['url']))
              </a>
            @else
              </div>
            @endif
          </li>
        @endforeach
      </ul>
    </div>

    {{--
      Parts guide slot. Render nothing while $parts is empty.
      When it has items: grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mt-6,
      each card bg-white rounded-3xl.
    --}}
    @if ($parts)
      <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($parts as $part)
          <article class="rounded-3xl bg-white"></article>
        @endforeach
      </div>
    @endif
  </div>
</section>
