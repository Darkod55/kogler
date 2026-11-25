{{--
  Kögler Sleep — Sleeper Fitment Guide.
  Rows come from App\Sleep\MattressCatalog, the same trucks as the finder.
  Width-style wording is fixed so it stays the catalogue sentence.
--}}
@php
    $rows = \App\Sleep\MattressCatalog::fitmentRows();
    $tiles = [
        ['width' => '32"', 'text' => 'Innerspring cloth · Gel Foam cloth & wipeable'],
        ['width' => '36"', 'text' => 'All four styles'],
        ['width' => '38"', 'text' => 'Gel Foam cloth & wipeable'],
        ['width' => '39"', 'text' => 'Innerspring cloth & wipeable'],
        ['width' => '42"', 'text' => 'All four styles'],
    ];
@endphp
<section id="fitment-guide" class="relative scroll-mt-chrome bg-light px-clamp py-clamp-xl">
  <div class="container">
    <h2 class="mb-0 font-fraunces text-[clamp(34px,3.8vw,54px)] font-semibold leading-[1.08] tracking-tight text-dark-blue">
      Sleeper Fitment <em class="italic font-medium text-darker-blue">Guide</em>
    </h2>
    <p class="mt-[18px] mb-0 max-w-[680px] text-[length:var(--font-size-tagline)] leading-[1.7] text-(--site-ink)/80">
      Core Class 8 highway sleepers matched to Kogler mattress widths. All Kogler mattresses are 80" long and 7" deep.
    </p>

    <div
      class="relative mt-10 overflow-hidden rounded-3xl bg-white"
      x-data="{ canScroll: false }"
      x-init="
        const el = $refs.tableScroll;
        const update = () => { canScroll = el.scrollWidth > el.clientWidth + 2 && el.scrollLeft + el.clientWidth < el.scrollWidth - 2 };
        update();
        el.addEventListener('scroll', update, { passive: true });
        window.addEventListener('resize', update);
      "
    >
      <div x-ref="tableScroll" class="overflow-x-auto">
        <table class="w-full min-w-[760px] border-collapse text-[length:var(--font-size-btn)]">
          <caption class="sr-only">Kogler mattress width by truck make, model and bunk</caption>
          <thead class="bg-dark-blue text-white">
            <tr>
              <th class="sticky left-0 z-20 w-36 bg-dark-blue px-6 py-4 text-left text-[12px] font-bold tracking-widest uppercase" scope="col">OEM</th>
              <th class="sticky left-36 z-20 bg-dark-blue px-6 py-4 text-left text-[12px] font-bold tracking-widest uppercase" scope="col">Model</th>
              <th class="px-6 py-4 text-left text-[12px] font-bold tracking-widest uppercase" scope="col">Bunk</th>
              <th class="px-6 py-4 text-left text-[12px] font-bold tracking-widest uppercase" scope="col">Kogler width</th>
              <th class="px-6 py-4 text-left text-[12px] font-bold tracking-widest uppercase" scope="col">Note</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($rows as $row)
              <tr class="{{ $row['first'] ? 'border-t-2 border-(--site-ink)/18' : 'border-t border-(--site-ink)/8' }}">
                @if ($row['first'])
                  <th class="sticky left-0 z-10 w-36 bg-white px-6 py-3.5 align-top font-bold text-dark-blue" scope="rowgroup" rowspan="{{ $row['rowspan'] }}">
                    {{ $row['make'] }}@if ($row['makeMark'] !== '') {{ $row['makeMark'] }}@endif
                  </th>
                @endif
                <td class="sticky left-36 z-10 bg-white px-6 py-3.5">
                  <a
                    class="text-dark-blue underline-offset-2 hover:underline"
                    href="{{ '?' . http_build_query(['make' => $row['make'], 'model' => $row['modelIndex']]) }}#find-your-size"
                    @click.prevent="$dispatch('fitment:select', { make: '{{ $row['make'] }}', model: {{ (int) $row['modelIndex'] }} })"
                  >{{ $row['model'] }} <span aria-hidden="true">→</span><span class="sr-only"> SKUs</span></a>
                </td>
                <td class="px-6 py-3.5 text-(--site-ink)/75">{{ $row['bunk'] }}</td>
                <td class="px-6 py-3.5 font-fraunces text-[20px] font-semibold whitespace-nowrap text-dark-blue">{{ $row['width'] }}@if ($row['mark'] !== '') {{ $row['mark'] }}@endif</td>
                <td class="px-6 py-3.5 text-sm text-(--site-ink)/75">{{ $row['note'] }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div x-show="canScroll" x-cloak class="pointer-events-none absolute inset-y-0 right-0 w-10 bg-gradient-to-l from-white to-transparent" aria-hidden="true"></div>
    </div>

    <p class="mt-3.5 mb-0 text-sm leading-[1.6] text-(--site-ink)/75">
      * Width matches; OEM bunk is longer than 80". † Nearest fit; about 1" narrower than the OEM bunk.
      <br>
      <strong class="text-dark-blue">‡ Replacement reclining mattresses for Volvo sleepers are available on request.</strong>
    </p>

    <h3 class="mt-14 mb-[18px] text-[22px] font-bold text-dark-blue">Styles Available by Width</h3>
    <div class="grid grid-cols-1 gap-3.5 min-[380px]:grid-cols-2 min-[1000px]:grid-cols-[repeat(auto-fit,minmax(180px,1fr))]">
      @foreach ($tiles as $tile)
        <div class="rounded-t-[4px] rounded-b-[18px] border-t-[3px] border-dark-blue bg-white px-[22px] py-5">
          <p class="mb-0 font-fraunces text-[30px] leading-none font-semibold text-dark-blue">{{ $tile['width'] }}</p>
          <p class="mt-2.5 mb-0 text-sm leading-normal text-(--site-ink)/80">{{ $tile['text'] }}</p>
        </div>
      @endforeach
    </div>

    <div class="mt-6 flex items-start gap-3.5 rounded-[18px] border border-(--site-ink)/15 bg-white px-6 py-5" role="note">
      <svg class="mt-0.5 size-[22px] flex-none text-dark-blue" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
        <circle cx="12" cy="12" r="9" />
        <path d="M12 11v6" stroke-linecap="round" />
        <path d="M12 8h.01" stroke-linecap="round" />
      </svg>
      <p class="mb-0 text-[length:var(--font-size-btn)] leading-[1.6] text-(--site-ink)">
        <strong>Confirm before ordering.</strong> Bunk sizes vary by model year, sleeper length and spec, and newer cabs (2024+ Volvo VNL, latest Kenworth and Peterbilt) may differ. Measure the bunk (width × length) when in doubt. Truck not listed? Match the measured width on the <a class="font-semibold text-dark-blue underline-offset-2 hover:underline" href="#size-finder">Size Finder</a>; special sizes are quoted on request.
      </p>
    </div>
  </div>
</section>
