{{--
  Goliath Steel — Quick Reference and Ordering Information.
  Part numbers come from App\Goliath\AbsCatalog::quickReference() (ABS only).
  Ordering cards are the catalog copy until the goliath_ordering ACF
  repeater on this page has rows.
  In-page offset is html scroll-padding-top (--site-chrome-height).
--}}
@php
    $reference = \App\Goliath\AbsCatalog::quickReference();
    $lengths = $reference['lengths'];
    $rows = $reference['rows'];

    $orderingCards = [
        [
            'label' => 'Packaging',
            'headline' => 'Poly bag standard',
            'detail' => 'Boxed on request. Boxed 3-in-1 part numbers end in “B.”',
        ],
        [
            'label' => 'Quantities',
            'headline' => 'Skid = 72 · ½ Skid = 36',
            'detail' => 'Units per skid, all ABS products.',
        ],
        [
            'label' => 'Private label',
            'headline' => 'Programs available',
            'detail' => 'Your brand on Goliath Steel products. Ask your sales rep.',
        ],
    ];

    if (function_exists('get_field')) {
        $saved = get_field('goliath_ordering');
        $cards = [];

        if (is_array($saved)) {
            foreach ($saved as $card) {
                if (! is_array($card)) {
                    continue;
                }

                $label = trim((string) ($card['label'] ?? ''));
                $headline = trim((string) ($card['headline'] ?? ''));
                $detail = trim((string) ($card['detail'] ?? ''));

                if ($label === '' && $headline === '' && $detail === '') {
                    continue;
                }

                $cards[] = [
                    'label' => $label,
                    'headline' => $headline,
                    'detail' => $detail,
                ];
            }
        }

        if ($cards !== []) {
            $orderingCards = $cards;
        }
    }
@endphp
<section id="quick-reference" class="relative bg-goliath-900 px-clamp py-clamp-xl text-white" x-data="goliathQuickReference()">
  <div class="container">
    <h2 class="mb-0 font-fraunces tracking-tight text-white">
      Quick <em class="italic font-medium text-goliath-silver">Reference</em>
    </h2>
    <p class="mt-[18px] mb-0 max-w-[640px] lead leading-[1.7] text-white/80">
      Every Goliath Steel ABS part number by product and length.
    </p>

    <div
      class="relative mt-10 overflow-hidden rounded-3xl border border-white/10"
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
        <table class="w-full min-w-[720px] border-collapse text-[length:var(--font-size-btn)]">
          <caption class="sr-only">Goliath Steel ABS part numbers by product and length</caption>
          <thead class="bg-goliath-800">
            <tr>
              <th class="sticky left-0 z-20 w-[34%] border-r border-white/[0.08] bg-goliath-800 px-6 py-4 text-left fs-xs font-bold tracking-widest uppercase" scope="col">Product</th>
              @foreach ($lengths as $index => $length)
                <th @class([
                  'px-6 py-4 text-left fs-xs font-bold tracking-widest uppercase',
                  'border-l border-white/[0.08]' => $index > 0,
                ]) scope="col">{{ $length }}</th>
              @endforeach
            </tr>
          </thead>
          <tbody>
            @foreach ($rows as $row)
              <tr class="border-t border-white/[0.08]">
                <th class="sticky left-0 z-10 border-r border-white/[0.08] bg-goliath-900 px-6 py-4 text-left align-top font-bold" scope="row">
                  <a class="underline-offset-2 hover:underline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-goliath-green" href="#{{ $row['id'] }}">{{ $row['name'] }}</a>
                  @if ($row['variant'] !== '')
                    <span class="block text-sm font-medium text-white/65">{{ $row['variant'] }}</span>
                  @endif
                </th>
                @foreach ($lengths as $index => $length)
                  <td @class([
                    'px-6 py-4 align-top',
                    'border-l border-white/[0.08]' => $index > 0,
                  ])>
                    @forelse ($row['cells'][$length] as $part)
                      <div class="flex items-baseline justify-between gap-4 py-0.5">
                        <span class="inline-flex min-w-0 items-baseline gap-2">
                          <button
                            type="button"
                            class="cursor-pointer font-bold tabular-nums underline-offset-2 hover:underline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-goliath-green"
                            @click='copySku({{ \Illuminate\Support\Js::from($part['sku']) }}, $event)'
                          >{{ $part['sku'] }}</button>
                          <span x-show='copied === {{ \Illuminate\Support\Js::from($part['sku']) }}' x-cloak class="text-sm font-semibold text-goliath-green">Copied</span>
                        </span>
                        <span class="shrink-0 text-[13px] text-white/60">{{ $part['packaging'] }}</span>
                      </div>
                    @empty
                      <span aria-hidden="true" class="text-white/35">—</span>
                      <span class="sr-only">Not available</span>
                    @endforelse
                  </td>
                @endforeach
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div x-show="canScroll" x-cloak class="pointer-events-none absolute inset-y-0 right-0 w-10 bg-gradient-to-l from-goliath-900 to-transparent" aria-hidden="true"></div>
    </div>
    <p class="sr-only" aria-live="polite" x-text="copied ? copied + ' copied' : ''"></p>

    <h2 class="mt-[88px] mb-0 font-fraunces text-white">
      Ordering <em class="italic font-medium text-goliath-silver">Information</em>
    </h2>

    <dl class="mt-8 mb-0 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
      @foreach ($orderingCards as $card)
        <div class="rounded-t-[4px] rounded-b-[20px] border-t-[3px] border-goliath-green bg-goliath-800 px-7 py-6">
          <dt class="fs-xs font-bold tracking-widest text-white/65 uppercase">{{ $card['label'] }}</dt>
          <dd class="mt-2 mb-0">
            <span class="block text-[19px] font-bold">{{ $card['headline'] }}</span>
            @if ($card['detail'] !== '')
              <span class="mt-1.5 block text-sm leading-[1.55] text-white/75">{{ $card['detail'] }}</span>
            @endif
          </dd>
        </div>
      @endforeach
    </dl>
  </div>
</section>
