{{--
  Homepage audience switcher. Sits directly after the brands section.
  Photos are Media Library attachment IDs. 0 keeps the gray placeholder.
  The 2026/08 uploads to attach, in order:
  kogler-fleet-manager-img, kogler-distributor-img,
  kogler-owner-operator-img, kogler-repair-shop-img.
  The fourth photo is a portrait: object-position center 35%.
--}}
@php
    $attachmentId = static function ($value): int {
        if (is_numeric($value)) {
            return (int) $value;
        }

        if (is_array($value)) {
            return (int) ($value['ID'] ?? $value['id'] ?? 0);
        }

        return 0;
    };

    $photo = static function (int $id, string $class, string $loading): string {
        if ($id < 1 || ! function_exists('wp_get_attachment_image')) {
            return '';
        }

        if (function_exists('wp_attachment_is_image') && ! wp_attachment_is_image($id)) {
            return '';
        }

        $image = wp_get_attachment_image($id, 'full', false, [
            'class' => $class,
            'loading' => $loading,
            'decoding' => 'async',
            'sizes' => '(min-width: 981px) 58vw, 100vw',
        ]);

        return is_string($image) ? $image : '';
    };

    $audiences = [
        [
            'label' => 'Truck Fleet Repair',
            'text' => 'Goliath Steel parts and Kögler mattresses in volume, with one point of contact for every truck you keep on the road.',
            'image_id' => 0,
            'image_class' => 'h-full w-full object-cover',
        ],
        [
            'label' => 'Distributor / Retailer',
            'text' => 'Programs built for resale, with brands your customers ask for and a sales team behind every order.',
            'image_id' => 0,
            'image_class' => 'h-full w-full object-cover',
        ],
        [
            'label' => 'E-Commerce / Big Box',
            'text' => 'Retail-ready products and packaging for shelf and online, shipped next day.',
            'image_id' => 0,
            'image_class' => 'h-full w-full object-cover',
        ],
        [
            'label' => 'Private Label / Customization',
            'text' => 'Your brand on our products, from custom sizes to private label packaging.',
            'image_id' => 0,
            'image_class' => 'h-full w-full object-cover object-[center_35%]',
        ],
    ];

    if (function_exists('get_field')) {
        $saved = get_field('audiences');
        $rows = [];

        if (is_array($saved)) {
            foreach ($saved as $index => $row) {
                if (! is_array($row)) {
                    continue;
                }

                $label = trim((string) ($row['label'] ?? ''));
                $text = trim((string) ($row['text'] ?? ''));

                if ($label === '' && $text === '') {
                    continue;
                }

                $rows[] = [
                    'label' => $label,
                    'text' => $text,
                    'image_id' => $attachmentId($row['image'] ?? 0),
                    'image_class' => $index === 3
                        ? 'h-full w-full object-cover object-[center_35%]'
                        : 'h-full w-full object-cover',
                ];
            }
        }

        if ($rows !== []) {
            $audiences = $rows;
        }
    }

    $count = count($audiences);
@endphp
<section class="bg-light px-clamp py-[120px]" x-data="audienceTabs({{ $count }})">
  <div class="container grid grid-cols-1 items-start gap-10 min-[981px]:grid-cols-[5fr_7fr] min-[981px]:gap-16">
    <div class="min-w-0">
      <h2 class="mb-0 font-fraunces text-[clamp(38px,4.4vw,62px)] font-semibold leading-[1.02] tracking-[-1px] text-dark-blue">
        Find What <em class="font-medium italic text-primary">Fits You</em>
      </h2>
      <p class="mt-[18px] mb-0 max-w-[420px] text-[18px] leading-[1.7] text-dark-blue/75">
        Pick the way you buy and we’ll point you to the right place.
      </p>

      <div
        class="mt-11 flex flex-col border-b border-dark-blue/15"
        role="tablist"
        aria-label="{{ __('Who are you', 'sage') }}"
        aria-orientation="vertical"
      >
        @foreach ($audiences as $index => $audience)
          <button
            type="button"
            role="tab"
            id="aud-tab-{{ $index }}"
            aria-controls="aud-panel-{{ $index }}"
            x-ref="tab{{ $index }}"
            :aria-selected="active === {{ $index }}"
            :tabindex="active === {{ $index }} ? 0 : -1"
            @click="active = {{ $index }}"
            @keydown.arrow-down.prevent="next()"
            @keydown.arrow-up.prevent="prev()"
            @keydown.home.prevent="first()"
            @keydown.end.prevent="last()"
            class="flex min-h-[64px] w-full items-center justify-between gap-4 border-t border-dark-blue/15 py-[18px] text-left font-fraunces text-[22px] leading-[1.15] transition-colors focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-primary min-[641px]:min-h-[76px] min-[641px]:text-[28px]"
            :class="active === {{ $index }} ? 'font-semibold text-dark-blue' : 'font-medium text-dark-blue/55 hover:text-dark-blue'"
          >
            <span>{{ $audience['label'] }}</span>
            <span
              aria-hidden="true"
              class="grid size-9 shrink-0 place-items-center rounded-full text-xl transition-colors min-[641px]:size-11"
              :class="active === {{ $index }} ? 'bg-dark-blue text-white' : 'bg-transparent text-transparent'"
            >→</span>
          </button>
        @endforeach
      </div>
    </div>

    <div class="min-w-0">
      @foreach ($audiences as $index => $audience)
        @php
            $image = $photo(
                (int) $audience['image_id'],
                $audience['image_class'],
                $index === 0 ? 'eager' : 'lazy'
            );
        @endphp
        <div
          class="audience-panel overflow-hidden rounded-[22px] bg-white"
          role="tabpanel"
          id="aud-panel-{{ $index }}"
          aria-labelledby="aud-tab-{{ $index }}"
          tabindex="0"
          x-show="active === {{ $index }}"
          x-transition.opacity.duration.200ms
          @if ($index > 0) x-cloak @endif
        >
          <div class="h-[260px] w-full bg-gray min-[641px]:h-[400px]">
            @if ($image !== '')
              {!! $image !!}
            @endif
          </div>
          <div class="px-6 pt-7 pb-8 min-[641px]:px-10 min-[641px]:pt-9 min-[641px]:pb-10">
            <h3 class="mb-0 text-[26px] font-bold leading-[1.2] text-dark-blue">{{ $audience['label'] }}</h3>
            @if ($audience['text'] !== '')
              <p class="mt-3 mb-0 max-w-[620px] text-[16px] leading-[1.65] text-dark-blue/75">{{ $audience['text'] }}</p>
            @endif
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
