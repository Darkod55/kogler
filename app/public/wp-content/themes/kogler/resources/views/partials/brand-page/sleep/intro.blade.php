{{--
  Kögler Sleep — brand intro, spec table, and mattress finder.
  Catalog: App\Sleep\MattressCatalog (also used by later fitment sections).
  Set $photoId to the Media Library attachment of the night truck photo.
  resources/images/brands/kogler-sleep-truck-night.webp is used when that file is in the build.
--}}
@php
    $catalog = \App\Sleep\MattressCatalog::catalog();
    $specs = \App\Sleep\MattressCatalog::specRows();
    $fitmentJson = function_exists('wp_json_encode')
        ? wp_json_encode($catalog)
        : json_encode($catalog, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE);

    $photoId = 398;
    $photo = '';

    if ($photoId && function_exists('wp_attachment_is_image') && wp_attachment_is_image($photoId)) {
        $photo = wp_get_attachment_image($photoId, 'full', false, [
            'class' => 'absolute inset-0 h-full w-full object-cover',
            'alt' => 'Semi truck driving at night',
            'loading' => 'lazy',
            'decoding' => 'async',
            'sizes' => '(min-width: 1000px) 640px, calc(100vw - 48px)',
        ]);
    } elseif (class_exists(\Illuminate\Support\Facades\Vite::class)) {
        try {
            $photoUrl = \Illuminate\Support\Facades\Vite::asset('resources/images/brands/kogler-sleep-truck-night.webp');
            $photo = '<img src="' . esc_url($photoUrl) . '" alt="Semi truck driving at night" width="1200" height="800" class="absolute inset-0 h-full w-full object-cover" loading="lazy" decoding="async">';
        } catch (\Throwable $e) {
            $photo = '';
        }
    }

    $koglerLogo = function_exists('content_url')
        ? content_url('uploads/2026/08/kogler-logo-white.webp')
        : '';

    $selectClass = 'h-[50px] w-full cursor-pointer appearance-none rounded-xl bg-white pr-10 pl-3.5 text-[length:var(--font-size-btn)] text-dark-blue focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-light-blue disabled:cursor-not-allowed disabled:opacity-[0.55]';
@endphp
<section id="kogler" class="relative scroll-mt-chrome bg-white px-clamp py-clamp-xl">
  <div class="container">
    <div class="flex flex-wrap items-center gap-16">
      <div class="min-w-0 w-full shrink grow basis-full min-[1000px]:basis-[460px]">
        <!--
        @if ($koglerLogo)
          <span class="inline-flex h-12 items-center rounded-xl bg-dark-blue px-5">
            <img src="{{ $koglerLogo }}" alt="Kögler" class="h-6 w-auto" height="24">
          </span>
        @endif
      -->
        <h2 class="mt-6 mb-0 font-fraunces text-[clamp(34px,3.8vw,54px)] font-semibold leading-[1.08] tracking-tight text-dark-blue">
          Driving a Truck Is Hard, <em class="italic font-medium text-darker-blue">Sleeping in One Shouldn’t Be.</em>
        </h2>

        <p class="mt-6 mb-0 max-w-[560px] text-[length:var(--font-size-tagline)] leading-[1.7] text-(--site-ink)/80">
          Kogler makes high-quality sleep products for the commercial trucking industry. Our sleeper mattresses are built for drivers who spend their nights in the cab and for the fleets that depend on them being rested.
        </p>
      </div>

      <div class="relative h-[280px] min-w-0 w-full shrink grow basis-full overflow-hidden rounded-3xl bg-light-blue min-[1000px]:h-[420px] min-[1000px]:basis-[460px]" @unless ($photo) aria-hidden="true" @endunless>
        @if ($photo)
          {!! $photo !!}
        @endif
      </div>
    </div>

    <script type="application/json" id="kogler-sleep-fitment">{!! $fitmentJson !!}</script>

    <div
      x-data="fitmentFinder(JSON.parse(document.getElementById('kogler-sleep-fitment').textContent))"
      @fitment:select.window="selectTruck($event.detail)"
    >
      <div class="mt-[72px] flex flex-wrap items-stretch gap-6">
        <div class="min-w-0 w-full shrink grow-[3] basis-full min-[1000px]:basis-[520px]">
          <h3 class="mb-5 text-[24px] font-bold text-dark-blue">Sleeper Mattresses</h3>

          <div class="overflow-hidden rounded-3xl border border-(--site-ink)/12">
            <div class="overflow-x-auto">
              <table class="w-full border-collapse text-left text-base text-(--site-ink)">
                <thead class="bg-light">
                  <tr>
                    <th class="w-[34%] px-6 py-4 text-[12px] font-bold tracking-widest text-dark-blue uppercase" scope="col">Spec</th>
                    <th class="px-6 py-4 text-[12px] font-bold tracking-widest text-dark-blue uppercase" scope="col">Options</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($specs as $spec)
                    <tr class="border-t border-(--site-ink)/10">
                      <th class="px-6 py-[18px] text-left font-bold text-dark-blue" scope="row">{{ $spec['label'] }}</th>
                      <td class="px-6 py-[18px]">
                        @if ($spec['type'] === 'chips')
                          <div class="flex flex-wrap gap-1.5">
                            @foreach ($spec['chips'] as $chip)
                              <span class="rounded-lg bg-light-blue px-3 py-1.5 text-sm font-bold text-darker-blue">{{ $chip }}</span>
                            @endforeach
                          </div>
                        @elseif ($spec['type'] === 'length')
                          {{ $spec['value'] }} <span class="text-(--site-ink)/70">{{ $spec['note'] }}</span>
                        @else
                          {{ $spec['value'] }}
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div id="find-your-size" class="flex min-w-0 w-full shrink grow-[2] basis-full scroll-mt-chrome flex-col justify-between gap-7 rounded-3xl bg-dark-blue p-9 text-white min-[1000px]:basis-[340px]">
          <div>
            <p class="mb-0 text-[13px] font-semibold text-light-blue">Manufacturer’s Fitment Guide</p>
            <h3 class="mt-2.5 mb-0 font-fraunces text-[34px] font-semibold leading-[1.1]">Find Your Mattress</h3>
          </div>

          <form class="flex flex-col gap-3" @submit.prevent>
            <label class="flex flex-col gap-1.5 text-[13px] font-semibold text-white/90">
              Truck make
              <span class="relative">
                <select
                  x-model="make"
                  @change="onMakeChange()"
                  class="{{ $selectClass }}"
                >
                  <option value="">Select make</option>
                  <template x-for="name in makes" :key="name">
                    <option :value="name" x-text="name"></option>
                  </template>
                </select>
                <svg class="pointer-events-none absolute inset-y-0 right-3.5 my-auto size-4 text-dark-blue" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                  <path d="M5 7.5 10 12.5 15 7.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
            </label>

            <label class="flex flex-col gap-1.5 text-[13px] font-semibold text-white/90">
              Model
              <span class="relative">
                <select
                  :disabled="make === ''"
                  :value="model === null ? '' : String(model)"
                  @change="onModelChange($event)"
                  class="{{ $selectClass }}"
                >
                  <option value="">Select model</option>
                  <template x-for="(item, index) in models" :key="item.name">
                    <option :value="index" x-text="item.name"></option>
                  </template>
                </select>
                <svg class="pointer-events-none absolute inset-y-0 right-3.5 my-auto size-4 text-dark-blue" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                  <path d="M5 7.5 10 12.5 15 7.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
            </label>
          </form>

          <noscript>
            <a class="font-semibold text-white underline underline-offset-2" href="#fitment-guide">See the full fitment guide</a>
          </noscript>
        </div>
      </div>

      <div class="mt-6" aria-live="polite">
        <p
          x-show="make === '' || model === null"
          x-cloak
          class="mb-0 rounded-3xl border-[1.5px] border-dashed border-(--site-ink)/25 px-8 py-7 text-[length:var(--font-size-base)] text-(--site-ink)/75"
          x-text="emptyMessage"
        >Choose your truck make to see which Kögler mattress fits.</p>

        <div x-show="make !== '' && model !== null" x-cloak class="rounded-3xl bg-light-blue p-9">
          <div class="flex flex-wrap items-baseline gap-x-4 gap-y-1.5">
            <p class="mb-0 text-[13px] font-bold tracking-widest text-darker-blue uppercase">Your Kögler size</p>
            <p class="mb-0 font-fraunces text-[28px] font-semibold text-dark-blue" x-text="truckName"></p>
          </div>

          <div class="mt-6 grid grid-cols-1 gap-4 min-[1000px]:grid-cols-[repeat(auto-fit,minmax(340px,1fr))]">
            <template x-for="bunk in bunks" :key="bunk.position">
              <article class="rounded-[20px] bg-white p-7">
                <p class="mb-0 text-[12px] font-bold tracking-widest text-(--site-ink)/70 uppercase" x-text="bunk.position"></p>
                <p class="mt-2 mb-0 font-fraunces text-[44px] leading-none font-semibold text-dark-blue">
                  <span x-text="bunk.widthsLabel"></span>
                  <span class="text-[length:var(--font-size-base)] font-semibold text-(--site-ink)/60">wide</span>
                </p>
                <p x-show="bunk.note" x-cloak class="mt-2.5 mb-0 text-sm leading-[1.55] text-(--site-ink)/80" x-text="bunk.note"></p>
                <ul class="mt-[18px] mb-0 list-none p-0">
                  <template x-for="option in bunk.options" :key="option.sku + option.size">
                    <li class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-1 border-t border-(--site-ink)/10 py-2.5 text-sm">
                      <span><strong x-text="option.type"></strong> · <span x-text="option.size"></span></span>
                      <span class="font-bold text-dark-blue tabular-nums" x-text="option.sku"></span>
                    </li>
                  </template>
                </ul>
              </article>
            </template>
          </div>

          <p x-show="makeNote" x-cloak class="mt-4 mb-0 text-sm text-(--site-ink)/80" x-text="makeNote"></p>

          <p class="mt-5 mb-0 text-sm text-(--site-ink)/80">
            Measure your bunk to confirm before ordering.
            <a class="font-semibold text-dark-blue underline-offset-2 hover:underline" href="#fitment-guide">See the full fitment guide</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</section>
