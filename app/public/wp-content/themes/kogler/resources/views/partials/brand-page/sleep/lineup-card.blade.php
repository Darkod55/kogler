{{--
  Kögler Sleep lineup card.
  $cardId, $title, $intro, $features, $parts, $imageLast,
  $clothImage, $wipeableImage (url, alt), $caption (gel only).
--}}
@php
    $cardId = $cardId ?? 'lineup';
    $imageLast = $imageLast ?? false;
    $caption = $caption ?? false;
    $clothImage = $clothImage ?? ['url' => '', 'alt' => ''];
    $wipeableImage = $wipeableImage ?? ['url' => '', 'alt' => ''];
    $parts = $parts ?? ['cloth' => [], 'wipeable' => []];
    $features = $features ?? [];
    $partsJson = function_exists('wp_json_encode')
        ? wp_json_encode($parts)
        : json_encode($parts, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE);
    $imageColumn = 'mx-auto w-full max-w-[360px] shrink grow basis-full min-[1000px]:mx-0 min-[1000px]:max-w-[460px] min-[1000px]:basis-[360px]';
    if ($imageLast) {
        $imageColumn .= ' min-[1000px]:order-last';
    }
@endphp
<article
  class="{{ $cardClass ?? '' }} flex flex-wrap gap-12 rounded-[28px] bg-white p-7 min-[1000px]:p-12"
  x-data="{ cover: 'cloth', parts: { cloth: [], wipeable: [] } }"
  data-parts="{{ $partsJson }}"
  x-init="parts = JSON.parse($el.dataset.parts)"
>
  <div class="{{ $imageColumn }}">
    <figure class="m-0">
      @if ($clothImage['url'] !== '')
        <img
          src="{{ $clothImage['url'] }}"
          alt="{{ $clothImage['alt'] }}"
          width="800"
          height="800"
          class="aspect-square w-full rounded-[20px] bg-white object-contain"
          loading="lazy"
          decoding="async"
          @if ($wipeableImage['url'] !== '') x-show="cover === 'cloth'" @endif
        >
      @endif
      @if ($wipeableImage['url'] !== '')
        <img
          src="{{ $wipeableImage['url'] }}"
          alt="{{ $wipeableImage['alt'] }}"
          width="800"
          height="800"
          class="aspect-square w-full rounded-[20px] bg-white object-contain"
          loading="lazy"
          decoding="async"
          x-show="cover === 'wipeable'"
          x-cloak
        >
      @endif
      @if ($caption)
        <figcaption class="mt-2.5 text-center text-[12px] font-bold tracking-widest text-(--site-ink)/70 uppercase" x-text="cover === 'cloth' ? 'Cloth cover' : 'Wipeable navy nylon cover'">Cloth cover</figcaption>
      @endif
    </figure>
  </div>

  <div class="min-w-0 w-full shrink grow-[999] basis-full min-[1000px]:basis-[520px]">
    <h3 class="mb-0 font-fraunces text-[clamp(30px,3vw,38px)] font-semibold leading-[1.1] text-dark-blue">{{ $title }}</h3>
    <p class="mt-3 mb-0 text-[17px] leading-[1.65] text-(--site-ink)/80">{{ $intro }}</p>

    <table class="mt-7 w-full border-collapse text-[length:var(--font-size-btn)]">
      <thead>
        <tr class="border-b-2 border-dark-blue">
          <th class="w-[38%] pr-4 pb-3 text-left text-[12px] font-bold tracking-widest text-dark-blue uppercase" scope="col">Feature</th>
          <th class="pb-3 text-left text-[12px] font-bold tracking-widest text-dark-blue uppercase" scope="col">Benefit to the driver &amp; fleet</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($features as $feature)
          <tr class="border-b border-(--site-ink)/10">
            <th class="py-3.5 pr-4 text-left font-bold text-dark-blue" scope="row">{{ $feature['feature'] }}</th>
            <td class="py-3.5 leading-normal text-(--site-ink)/80">{{ $feature['benefit'] }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="mt-9 flex flex-wrap items-center justify-between gap-4">
      <h4 class="mb-0 text-[length:var(--font-size-tagline)] font-bold text-dark-blue">Part Numbers</h4>
      <div
        class="inline-flex rounded-full bg-light p-1"
        role="tablist"
        aria-label="{{ $tabLabel }}"
        @keydown.right.prevent="cover = 'wipeable'; $refs.wipeable.focus()"
        @keydown.left.prevent="cover = 'cloth'; $refs.cloth.focus()"
      >
        <button
          type="button"
          role="tab"
          id="{{ $cardId }}-tab-cloth"
          x-ref="cloth"
          :aria-selected="cover === 'cloth'"
          :tabindex="cover === 'cloth' ? 0 : -1"
          aria-controls="{{ $cardId }}-parts"
          class="cursor-pointer rounded-full px-[18px] py-2.5 text-sm font-bold"
          :class="cover === 'cloth' ? 'bg-dark-blue text-white' : 'bg-transparent text-dark-blue hover:bg-white'"
          @click="cover = 'cloth'"
        >Cloth cover</button>
        <button
          type="button"
          role="tab"
          id="{{ $cardId }}-tab-wipeable"
          x-ref="wipeable"
          :aria-selected="cover === 'wipeable'"
          :tabindex="cover === 'wipeable' ? 0 : -1"
          aria-controls="{{ $cardId }}-parts"
          class="cursor-pointer rounded-full px-[18px] py-2.5 text-sm font-bold"
          :class="cover === 'wipeable' ? 'bg-dark-blue text-white' : 'bg-transparent text-dark-blue hover:bg-white'"
          @click="cover = 'wipeable'"
        >Wipeable cover</button>
      </div>
    </div>

    <div
      id="{{ $cardId }}-parts"
      role="tabpanel"
      :aria-labelledby="cover === 'cloth' ? '{{ $cardId }}-tab-cloth' : '{{ $cardId }}-tab-wipeable'"
      class="mt-4 overflow-x-auto rounded-[18px] border border-(--site-ink)/12"
      x-cloak
    >
      <table class="w-full min-w-[520px] border-collapse text-[length:var(--font-size-btn)]">
        <thead class="bg-dark-blue text-white">
          <tr>
            <th class="px-5 py-3.5 text-left text-[12px] font-bold tracking-widest uppercase" scope="col">Part no.</th>
            <th class="px-5 py-3.5 text-left text-[12px] font-bold tracking-widest uppercase" scope="col">Description</th>
            <th class="px-5 py-3.5 text-left text-[12px] font-bold tracking-widest uppercase" scope="col">Size (W × L × D)</th>
          </tr>
        </thead>
        <tbody>
          <template x-for="row in parts[cover]" :key="row.sku">
            <tr class="border-t border-(--site-ink)/10">
              <th class="px-5 py-3.5 text-left font-bold text-dark-blue tabular-nums" scope="row" x-text="row.sku"></th>
              <td class="px-5 py-3.5" x-text="row.description"></td>
              <td class="px-5 py-3.5 tabular-nums" x-text="row.size"></td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>

    <noscript>
      @foreach (['cloth' => 'Cloth cover', 'wipeable' => 'Wipeable cover'] as $coverKey => $coverLabel)
        <p class="mt-4 mb-2 text-sm font-bold text-dark-blue">{{ $coverLabel }}</p>
        <div class="overflow-x-auto rounded-[18px] border border-(--site-ink)/12">
          <table class="w-full min-w-[520px] border-collapse text-[length:var(--font-size-btn)]">
            <thead class="bg-dark-blue text-white">
              <tr>
                <th class="px-5 py-3.5 text-left text-[12px] font-bold tracking-widest uppercase" scope="col">Part no.</th>
                <th class="px-5 py-3.5 text-left text-[12px] font-bold tracking-widest uppercase" scope="col">Description</th>
                <th class="px-5 py-3.5 text-left text-[12px] font-bold tracking-widest uppercase" scope="col">Size (W × L × D)</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($parts[$coverKey] as $row)
                <tr class="border-t border-(--site-ink)/10">
                  <th class="px-5 py-3.5 text-left font-bold text-dark-blue tabular-nums" scope="row">{{ $row['sku'] }}</th>
                  <td class="px-5 py-3.5">{{ $row['description'] }}</td>
                  <td class="px-5 py-3.5 tabular-nums">{{ $row['size'] }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endforeach
    </noscript>

    <p class="mt-3.5 mb-0 text-sm text-(--site-ink)/70">Skid = 30 mattresses · ½ Skid = 15 · Special order / made-to-order sizes quoted on request.</p>
  </div>
</article>
