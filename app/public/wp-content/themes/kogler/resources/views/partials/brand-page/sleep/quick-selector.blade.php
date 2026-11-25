{{--
  Kögler Sleep — Quick Selector.
  Intro and rows are edited in the arrays below. The theme has no ACF.
--}}
@php
    $quickIntro = 'Not sure which mattress to choose? Start with how the truck is used and who sleeps in it. These pointers match the most common needs to the right construction and cover.';
    $quickNote = 'Every option is 7" deep, roll-packed and made in Cleveland, TN. Once you know the style, ';

    $quickRows = [
        [
            'condition' => 'Wants a traditional, springy feel at the best price',
            'recommendation' => 'Innerspring',
            'href' => '#lineup-innerspring',
        ],
        [
            'condition' => 'Wants cooler sleep and even, consistent support',
            'recommendation' => 'Gel-Infused Foam',
            'href' => '#lineup-gel-foam',
        ],
        [
            'condition' => 'Slip-seats, runs team drivers or turns trucks over often',
            'recommendation' => 'Wipeable cover',
            'href' => '#lineup',
            'cover' => 'wipeable',
        ],
        [
            'condition' => 'Has a dedicated driver who puts comfort first',
            'recommendation' => 'Cloth cover',
            'href' => '#lineup',
            'cover' => 'cloth',
        ],
        [
            'condition' => 'Needs a 28" or a 29" × 79" bunk',
            'recommendation' => '28": Gel Foam, cloth · 29": Innerspring, cloth',
            'href' => '#size-finder',
        ],
    ];

    $pill = 'inline-block rounded-full bg-light-blue px-4 py-2 text-[length:var(--font-size-btn)] font-bold text-darker-blue no-underline hover:bg-white hover:ring-1 hover:ring-darker-blue/30 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-darker-blue';
@endphp
<section id="quick-selector" class="relative scroll-mt-chrome bg-white px-clamp py-clamp-xl">
  <div class="container">
    <div class="flex flex-wrap gap-14">
      <div class="min-w-0 w-full shrink grow basis-full min-[1000px]:max-w-[420px] min-[1000px]:basis-[320px]">
        <h2 class="mb-0 font-fraunces text-[clamp(34px,3.8vw,54px)] font-semibold leading-[1.08] tracking-tight text-dark-blue">
          Quick <em class="italic font-medium text-darker-blue">Selector</em>
        </h2>
        <p class="mt-5 mb-0 text-[length:var(--font-size-tagline)] leading-[1.7] text-(--site-ink)/80">{{ $quickIntro }}</p>
        <p class="mt-4 mb-0 text-[length:var(--font-size-btn)] leading-[1.6] text-(--site-ink)/70">
          {{ $quickNote }}<a class="font-semibold text-dark-blue underline-offset-2 hover:underline" href="#find-your-size">find your size</a>.
        </p>
      </div>

      <div class="min-w-0 w-full shrink grow-[999] basis-full min-[1000px]:basis-[560px]">
        <div class="hidden items-center justify-between gap-6 border-b-2 border-dark-blue pb-3.5 text-[12px] font-bold tracking-widest text-dark-blue uppercase sm:flex" aria-hidden="true">
          <span>If the customer…</span>
          <span>Recommend</span>
        </div>

        <dl class="m-0">
          @foreach ($quickRows as $row)
            <div class="flex flex-wrap items-center justify-between gap-x-6 gap-y-2.5 border-b border-(--site-ink)/10 py-5">
              <dt class="min-w-0 shrink grow basis-full text-[17px] leading-normal text-dark-blue min-[1000px]:basis-[320px]">{{ $row['condition'] }}</dt>
              <dd class="m-0">
                <span class="sr-only">Recommend: </span>
                <a
                  class="{{ $pill }}"
                  href="{{ $row['href'] }}"
                  @if (! empty($row['cover'])) @click="$dispatch('set-cover', { cover: '{{ $row['cover'] }}' })" @endif
                >{{ $row['recommendation'] }}</a>
              </dd>
            </div>
          @endforeach
        </dl>
      </div>
    </div>
  </div>
</section>
