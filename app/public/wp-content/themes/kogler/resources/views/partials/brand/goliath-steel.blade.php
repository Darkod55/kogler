{{--
  Brands page — Goliath Steel.
  This file is only included from the Brands page. The brand page has its own
  partial at partials/brand-page/goliath/intro.blade.php.
  No ACF. Categories and the parts slot are edited in the arrays below.
--}}
@php
    $logoUrl = '';
    $imageId = 0;
    $tileUrl = '';
    $goliathImage = '';

    if (class_exists(\Illuminate\Support\Facades\Vite::class)) {
        try {
            $tileUrl = \Illuminate\Support\Facades\Vite::asset('resources/images/brands/goliath-steel.webp');
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
        $goliathImage = is_string($goliathImage) ? $goliathImage : '';
    }

    $categories = [
        [
            'name' => 'Air System',
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

    $parts = [];
@endphp
<section id="goliath-steel" class="relative bg-goliath-900 p-clamp-xl text-white">
  <div class="container">
    <div class="flex flex-wrap items-center gap-16">
      <div class="min-w-[min(100%,460px)] shrink grow basis-[460px]">
        @if ($logoUrl !== '')
          <span class="inline-flex h-12 items-center rounded-xl bg-white/[0.08] px-5">
            <img src="{{ $logoUrl }}" alt="{{ __('Goliath Steel', 'sage') }}" class="h-6 w-auto" height="24">
          </span>
        @else
          <span class="inline-flex h-12 items-center rounded-xl bg-white/[0.08] px-5 text-xl font-extrabold tracking-[0.15em] text-goliath-chrome">GOLIATH STEEL</span>
        @endif

        <h2 class="mt-6 mb-0 font-fraunces text-white">
          Goliath Strength <em class="italic font-medium text-goliath-silver">Without the Goliath Price.</em>
        </h2>

        <p class="mt-6 mb-0 max-w-[560px] lead leading-[1.7] text-white/80">
          Goliath Steel is our commercial truck aftermarket parts brand. We offer high-quality parts at reasonable prices for fleets, repair shops and distribution partners.
        </p>
      </div>

      <div
        class="relative h-[280px] min-w-[min(100%,460px)] w-full shrink grow basis-[460px] overflow-hidden rounded-3xl bg-goliath-700 lg:order-first lg:h-[420px]"
        @unless ($goliathImage !== '' || $tileUrl !== '') aria-hidden="true" @endunless
      >
        @if ($goliathImage !== '')
          {!! $goliathImage !!}
        @elseif ($tileUrl !== '')
          <img src="{{ $tileUrl }}" alt="{{ __('Goliath Steel logo', 'sage') }}" width="270" height="270" class="absolute inset-0 h-full w-full object-cover object-center" loading="lazy" decoding="async">
        @endif
      </div>
    </div>

    <div class="mt-[72px]">
      <h3 class="mb-5 text-white">Product Categories</h3>

      <div class="flex flex-col gap-6">
        @foreach ($categories as $category)
          <div class="rounded-3xl bg-goliath-800 p-8">
            <div class="flex items-center gap-3.5 border-b border-white/12 pb-6">
              <svg class="size-7 shrink-0 text-goliath-silver" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="m12 14 4-4" />
                <path d="M3.34 19a10 10 0 1 1 17.32 0" />
              </svg>
              <h4 class="mb-0 font-fraunces text-white">{{ kogler_title_case($category['name']) }}</h4>
            </div>

            <ul class="m-0 mt-6 grid list-none grid-cols-1 gap-3 p-0 sm:grid-cols-2 lg:grid-cols-3">
              @foreach ($category['items'] as $item)
                @php
                    $thumb = '';
                    $thumbId = (int) ($item['image_id'] ?? 0);

                    if ($thumbId && function_exists('wp_attachment_is_image') && wp_attachment_is_image($thumbId)) {
                        $rendered = wp_get_attachment_image($thumbId, 'medium', false, [
                            'class' => 'h-full w-full object-cover',
                            'alt' => '',
                            'loading' => 'lazy',
                            'decoding' => 'async',
                        ]);
                        $thumb = is_string($rendered) ? $rendered : '';
                    }
                @endphp
                <li class="flex items-center gap-3.5 rounded-2xl bg-goliath-900 p-3">
                  <div class="flex size-16 shrink-0 items-center justify-center overflow-hidden rounded-[10px] {{ $thumb !== '' ? 'bg-white' : 'bg-goliath-700' }}" aria-hidden="true">
                    @if ($thumb !== '')
                      {!! $thumb !!}
                    @else
                      <svg class="size-6 text-goliath-silver" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z" />
                        <path d="M12 22V12" />
                        <polyline points="3.29 7 12 12 20.71 7" />
                        <path d="m7.5 4.27 9 5.15" />
                      </svg>
                    @endif
                  </div>
                  <span class="text-[length:var(--font-size-base)] font-bold leading-[1.35] text-white">{{ $item['name'] }}</span>
                </li>
              @endforeach
            </ul>
          </div>
        @endforeach
      </div>
    </div>

    @if ($parts)
      <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($parts as $part)
          <article class="rounded-3xl bg-goliath-800"></article>
        @endforeach
      </div>
    @endif
  </div>
</section>
