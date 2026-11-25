{{--
  Homepage services. Sits directly after the benefits section.
  A plain ledger. The last word of the title is italic.
--}}
@php
    $title = \App\helpers()->pageField('services_title', 'Our Services');
    $intro = \App\helpers()->pageField('services_intro', 'Support that carries on long after the order ships.');
    $words = preg_split('/\s+/u', trim($title), -1, PREG_SPLIT_NO_EMPTY) ?: [];
    $lastWord = $words === [] ? '' : (string) array_pop($words);
    $lead = implode(' ', $words);

    $buttonLabel = 'Talk to Our Team';
    $buttonUrl = \App\helpers()->pageUrlBySlug('contact-us');

    if (function_exists('get_field')) {
        $button = get_field('services_button');

        if (is_array($button)) {
            $label = trim((string) ($button['title'] ?? ''));
            $url = trim((string) ($button['url'] ?? ''));

            if ($label !== '') {
                $buttonLabel = $label;
            }

            if ($url !== '') {
                $buttonUrl = $url;
            }
        }
    }

    $services = [
        [
            'title' => 'Warranty & Product Assurance',
            'text' => 'Comprehensive warranty coverage and quality assurance to guarantee durability, performance, and customer satisfaction.',
        ],
        [
            'title' => 'Manufacturing & Private Label',
            'text' => 'Flexible production capabilities with private label options for partners and distributors.',
        ],
        [
            'title' => 'Product Support & Consultation',
            'text' => 'Expert guidance to help you choose the right mattress based on usage, comfort, and performance needs.',
        ],
        [
            'title' => 'Fleet Supply & Bulk Orders',
            'text' => 'Reliable supply for fleets with volume pricing, consistent quality, and fast fulfillment.',
        ],
    ];

    if (function_exists('get_field')) {
        $saved = get_field('services');
        $rows = [];

        if (is_array($saved)) {
            foreach ($saved as $row) {
                if (! is_array($row) || count($rows) >= 6) {
                    continue;
                }

                $rowTitle = trim((string) ($row['title'] ?? ''));
                $rowText = trim((string) ($row['text'] ?? ''));

                if ($rowTitle === '' && $rowText === '') {
                    continue;
                }

                $rows[] = [
                    'title' => $rowTitle,
                    'text' => $rowText,
                ];
            }
        }

        if ($rows !== []) {
            $services = $rows;
        }
    }
@endphp
<section class="bg-white px-clamp py-[120px]">
  <div class="container grid grid-cols-1 items-start gap-10 min-[981px]:grid-cols-[4fr_8fr] min-[981px]:gap-16">
    <div class="min-w-0 min-[981px]:sticky min-[981px]:top-[calc(var(--site-chrome-height,7rem)+1.5rem)] min-[981px]:self-start">
      <h2 class="mb-0 font-fraunces text-[clamp(38px,4.4vw,62px)] font-semibold leading-[1.02] tracking-[-1px] text-dark-blue">
        @if ($lead !== '')
          {{ $lead }}
        @endif
        @if ($lastWord !== '')
          <em class="font-medium italic text-primary">{{ $lastWord }}</em>
        @endif
      </h2>
      @if ($intro !== '')
        <p class="mt-[18px] mb-0 max-w-[340px] text-[18px] leading-[1.7] text-dark-blue/75">{{ $intro }}</p>
      @endif
      <a
        class="mt-8 inline-block rounded-full bg-dark-blue px-7 py-4 text-[16px] font-bold text-white no-underline transition-transform hover:-translate-y-px motion-reduce:transform-none motion-reduce:transition-none focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-dark-blue"
        href="{{ $buttonUrl }}"
      >{{ $buttonLabel }}</a>
    </div>

    <dl class="m-0 border-t-2 border-dark-blue">
      @foreach ($services as $service)
        <div class="grid grid-cols-1 items-baseline gap-3 border-b border-dark-blue/15 py-7 min-[721px]:grid-cols-[5fr_6fr] min-[721px]:gap-8 min-[721px]:py-8">
          <dt>
            @if ($service['title'] !== '')
              <h3 class="m-0 font-fraunces text-[24px] font-semibold leading-[1.15] text-dark-blue min-[721px]:text-[28px]">{{ $service['title'] }}</h3>
            @endif
          </dt>
          <dd class="m-0 text-[16px] leading-[1.65] text-dark-blue/75">{{ $service['text'] }}</dd>
        </div>
      @endforeach
    </dl>
  </div>
</section>
