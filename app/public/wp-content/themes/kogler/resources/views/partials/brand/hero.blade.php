{{--
  Brand — hero
  Jump targets #kogler, #goliath-steel, and #kogler-outdoor are later sections.
  Fraunces italic is synthesized; the theme only loads the roman face.
  Badge files live in resources/images/brands/ and are omitted when empty.
--}}
@php
    $brandJumps = [
        ['name' => 'Kogler', 'subtitle' => __('Sleeper mattresses', 'sage'), 'href' => '#kogler', 'badge' => 'kogler.webp'],
        ['name' => 'Goliath Steel', 'subtitle' => __('Product categories', 'sage'), 'href' => '#goliath-steel', 'badge' => 'goliath-steel.webp'],
        ['name' => 'Kogler Outdoor', 'subtitle' => __('Products', 'sage'), 'href' => '#kogler-outdoor', 'badge' => 'kogler-outdoor.webp'],
    ];
@endphp
<section class="relative bg-dark-blue px-clamp pt-clamp-block-xl pb-clamp-block-xl text-left text-white">
  <div class="container">
    <h1 class="mb-0 font-fraunces text-[clamp(44px,6vw,84px)] font-semibold leading-[1.02] tracking-tight text-white">
      Our <em class="italic font-medium text-secondary">brands</em>
    </h1>

    <p class="mt-8 mb-0 max-w-[620px] text-[length:var(--font-size-lead)] leading-[1.65] text-white/85">
      At Kogler-USA we supply thousands of customers across the commercial truck, RV and marine markets through three brands: Kogler, Goliath Steel and Kogler Outdoor.
    </p>

    <nav class="mt-14" aria-label="{{ __('Brands on this page', 'sage') }}">
      <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        @foreach ($brandJumps as $jump)
          @php
              $badgeUrl = '';
              $badgeFile = trim((string) ($jump['badge'] ?? ''));

              if ($badgeFile !== '' && class_exists(\Illuminate\Support\Facades\Vite::class)) {
                  try {
                      $badgeUrl = \Illuminate\Support\Facades\Vite::asset('resources/images/brands/' . $badgeFile);
                  } catch (\Throwable $e) {
                      $badgeUrl = '';
                  }
              }
          @endphp
          <a class="group flex items-center justify-between gap-4 rounded-3xl border border-white/15 bg-white/[0.07] px-7 py-6 text-white no-underline transition hover:bg-white/[0.14] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-secondary motion-reduce:transform-none" href="{{ $jump['href'] }}">
            <span class="flex min-w-0 items-center gap-4">
              @if ($badgeUrl)
                <span class="inline-flex size-11 shrink-0 overflow-hidden rounded-xl">
                  <img src="{{ $badgeUrl }}" alt="" width="44" height="44" class="h-full w-full object-cover" loading="lazy" decoding="async">
                </span>
              @endif
              <span class="flex flex-col gap-1">
                <span class="text-[22px] font-extrabold tracking-tight">{{ $jump['name'] }}</span>
                <span class="text-sm text-white/75">{{ $jump['subtitle'] }}</span>
              </span>
            </span>
            <span class="text-[22px] text-secondary transition motion-safe:group-hover:translate-y-0.5 motion-reduce:transform-none" aria-hidden="true">↓</span>
          </a>
        @endforeach
      </div>
    </nav>
  </div>
</section>
