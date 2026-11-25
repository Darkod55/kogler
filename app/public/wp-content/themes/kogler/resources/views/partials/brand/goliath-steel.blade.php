{{--
  Brand — Goliath Steel
  No ACF. Categories, items, and the parts slot are edited in the arrays below.
  An admin-editable catalogue would need ACF.
  No Goliath logo file is referenced in the theme. Set $logoUrl to swap the
  wordmark for an image. $tile fills the photo slot when $imageId is empty.
--}}
@php
    $logoUrl = '';
    $imageId = 0;
    $tileFile = 'goliath-steel.webp';
    $tileUrl = '';
    $goliathImage = '';

    if ($tileFile !== '' && class_exists(\Illuminate\Support\Facades\Vite::class)) {
        try {
            $tileUrl = \Illuminate\Support\Facades\Vite::asset('resources/images/brands/' . $tileFile);
        } catch (\Throwable $e) {
            $tileUrl = '';
        }
    }

    if ($imageId && function_exists('wp_attachment_is_image') && wp_attachment_is_image($imageId)) {
        $goliathImage = wp_get_attachment_image($imageId, 'full', false, [
            'class' => 'h-full w-full object-cover',
            'loading' => 'lazy',
            'decoding' => 'async',
            'alt' => __('Goliath Steel heavy-duty truck parts', 'sage'),
            'sizes' => '(min-width: 1024px) 640px, calc(100vw - 48px)',
        ]);
    }

    $categories = [
        [
            'name' => 'Air system',
            'icon' => 'gauge',
            'items' => [
                ['name' => '3-in-1 Electric Airline Sets', 'image_id' => 0],
                ['name' => 'ABS Power Cables', 'image_id' => 0],
                ['name' => 'ABS Air Brake Hose', 'image_id' => 0],
                ['name' => 'Gladhands & Seals', 'image_id' => 0],
                ['name' => 'Plugs & Receptacles', 'image_id' => 0],
                ['name' => 'Tender Springs & Clips', 'image_id' => 0],
            ],
        ],
    ];

    // Future parts guide. Empty means nothing is rendered.
    $parts = [];

    $itemClass = 'flex items-center gap-3.5 rounded-2xl bg-(--gs-bg) p-3 text-white';
    $itemLinkClass = $itemClass . ' no-underline transition hover:bg-white/[0.06] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white';
@endphp
<section
  id="goliath-steel"
  class="bg-(--gs-bg) p-clamp-xl text-white"
  style="--gs-bg: var(--color-goliath-900); --gs-panel: var(--color-goliath-800); --gs-tile: var(--color-goliath-700); --gs-accent: var(--color-goliath-silver); --gs-logo: var(--color-goliath-chrome);"
>
  <div class="container">
    <div class="flex flex-wrap items-center gap-16">
      <div class="min-w-[min(100%,460px)] shrink grow basis-[460px]">
        @if ($logoUrl)
          <span class="inline-flex h-12 items-center rounded-xl bg-white/[0.08] px-5">
            <img src="{{ $logoUrl }}" alt="{{ __('Goliath Steel', 'sage') }}" class="h-6 w-auto" height="24">
          </span>
        @else
          <span class="inline-flex h-12 items-center rounded-xl bg-white/[0.08] px-5 text-[20px] font-extrabold tracking-[0.15em] text-(--gs-logo)">GOLIATH STEEL</span>
        @endif

        <h2 class="mt-6 mb-0 font-fraunces text-white">
          Goliath Strength <em class="italic font-medium text-(--gs-accent)">Without the Goliath Price.</em>
        </h2>

        <p class="mt-6 mb-0 max-w-[560px] lead leading-[1.7] text-white/80">
          Goliath Steel is our commercial truck aftermarket parts brand. We offer high-quality parts at reasonable prices for fleets, repair shops and distribution partners.
        </p>
      </div>

      <div
        class="relative h-[280px] min-w-[min(100%,460px)] w-full shrink grow basis-[460px] overflow-hidden rounded-3xl bg-(--gs-tile) lg:order-first lg:h-[420px]"
        @unless ($goliathImage || $tileUrl) aria-hidden="true" @endunless
      >
        @if ($goliathImage)
          {!! $goliathImage !!}
        @elseif ($tileUrl)
          <img src="{{ $tileUrl }}" alt="{{ __('Goliath Steel logo', 'sage') }}" width="270" height="270" class="absolute inset-0 h-full w-full object-cover object-center" loading="lazy" decoding="async">
        @endif
      </div>
    </div>

    <div class="mt-[72px]">
      <h3 class="mb-5 text-white">Product Categories</h3>

      <div class="flex flex-col gap-6">
      @foreach ($categories as $category)
        <div class="rounded-3xl bg-(--gs-panel) p-8">
          <div class="flex items-center gap-3.5 border-b border-white/12 pb-6">
            <svg class="size-7 shrink-0 text-(--gs-accent)" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="m12 14 4-4" />
              <path d="M3.34 19a10 10 0 1 1 17.32 0" />
            </svg>
            <h4 class="mb-0 font-fraunces">{{ kogler_title_case($category['name']) }}</h4>
          </div>

          <ul class="m-0 mt-6 grid list-none grid-cols-1 gap-3 p-0 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($category['items'] as $item)
              @php
                  $thumb = '';
                  $thumbId = (int) ($item['image_id'] ?? 0);

                  if ($thumbId && function_exists('wp_attachment_is_image') && wp_attachment_is_image($thumbId)) {
                      $thumb = wp_get_attachment_image($thumbId, 'medium', false, [
                          'class' => 'h-full w-full object-cover',
                          'alt' => $item['name'],
                          'loading' => 'lazy',
                          'decoding' => 'async',
                      ]);
                  }
              @endphp
              <li>
                @if (! empty($item['url']))
                  <a href="{{ $item['url'] }}" class="{{ $itemLinkClass }}">
                @else
                  <div class="{{ $itemClass }}">
                @endif
                    <div
                      class="size-16 shrink-0 overflow-hidden rounded-[10px] bg-(--gs-tile)"
                      @unless ($thumb) aria-hidden="true" @endunless
                    >
                      @if ($thumb)
                        {!! $thumb !!}
                      @endif
                    </div>
                    <span class="text-[length:var(--font-size-base)] font-bold leading-[1.35] text-white">{{ $item['name'] }}</span>
                @if (! empty($item['url']))
                  </a>
                @else
                  </div>
                @endif
              </li>
            @endforeach
          </ul>
        </div>
      @endforeach
      </div>
    </div>

    {{--
      Parts guide slot. Render nothing while $parts is empty.
      When it has items: grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mt-6,
      each card bg-(--gs-panel) rounded-3xl.
    --}}
    @if ($parts)
      <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($parts as $part)
          <article class="rounded-3xl bg-(--gs-panel)"></article>
        @endforeach
      </div>
    @endif
  </div>
</section>
