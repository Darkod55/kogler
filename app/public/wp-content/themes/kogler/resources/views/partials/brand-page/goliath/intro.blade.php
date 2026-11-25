{{--
  Goliath Steel brand page — intro and Air System tiles.
  This partial is only included from the Brand Page template.
  Photos are Media Library attachment IDs. Set $imageId for the assembly
  photo and each item image_id. 0 keeps the icon box. Add a category to
  $categories to stack another panel.
--}}
@php
    $chipLogoId = 0;
    $imageId = 405;
    $chipLogo = '';
    $photoHtml = '';

    if ($chipLogoId && function_exists('wp_attachment_is_image') && wp_attachment_is_image($chipLogoId)) {
        $renderedChip = wp_get_attachment_image($chipLogoId, 'full', false, [
            'class' => 'h-[22px] w-auto',
            'alt' => 'Goliath Steel',
            'loading' => 'lazy',
            'decoding' => 'async',
        ]);
        $chipLogo = is_string($renderedChip) ? $renderedChip : '';
    }

    if ($imageId && function_exists('wp_attachment_is_image') && wp_attachment_is_image($imageId)) {
        $rendered = wp_get_attachment_image($imageId, 'full', false, [
            'class' => 'absolute inset-0 h-full w-full object-cover',
            'alt' => 'Goliath Steel 3-in-1 full assembly with gladhands and seals',
            'loading' => 'lazy',
            'decoding' => 'async',
            'sizes' => '(min-width: 1000px) 640px, calc(100vw - 48px)',
        ]);
        $photoHtml = is_string($rendered) ? $rendered : '';
    }

    $categories = [
        [
            'name' => 'Air System',
            'items' => [
                ['name' => '3-in-1 Electric Airline Sets', 'image_id' => 404],
                ['name' => 'ABS Power Cables', 'image_id' => 407],
                ['name' => 'ABS Air Brake Hose', 'image_id' => 411],
                ['name' => 'Gladhands & Seals', 'image_id' => 405],
                ['name' => 'Plugs & Receptacles', 'image_id' => 409],
                ['name' => 'Tender Springs & Clips', 'image_id' => 0],
            ],
        ],
    ];
@endphp
<section id="goliath-steel" class="relative bg-goliath-900 p-clamp-xl text-white">
  <div class="container">
    <div class="flex flex-wrap items-center gap-16">
      <div class="min-w-[min(100%,460px)] shrink grow basis-[460px]">
        @if ($chipLogo !== '')
          <span class="inline-flex h-12 items-center rounded-xl bg-white/[0.08] px-5">
            {!! $chipLogo !!}
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
        class="relative h-[280px] min-w-[min(100%,460px)] w-full shrink grow basis-[460px] overflow-hidden rounded-3xl bg-goliath-700 min-[1000px]:order-first min-[1000px]:h-[420px]"
        @unless ($photoHtml !== '') aria-hidden="true" @endunless
      >
        @if ($photoHtml !== '')
          {!! $photoHtml !!}
        @endif
      </div>
    </div>

    <div class="mt-[72px]">
      <h3 class="mb-5 text-white">Product Categories</h3>

      <div class="flex flex-col gap-4">
        @foreach ($categories as $category)
          <div class="rounded-3xl bg-goliath-800 p-6 min-[1000px]:p-8">
            <div class="flex items-center gap-3.5 border-b border-white/12 pb-6">
              <svg class="size-7 shrink-0 text-goliath-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
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
  </div>
</section>
