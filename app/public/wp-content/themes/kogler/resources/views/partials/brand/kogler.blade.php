{{--
  Brand — Kogler
  No ACF. Specs and fitments are edited in the arrays below.
  A WP-admin-editable version of the spec table would need ACF.
  EXAMPLE DATA — replace with real fitments before launch. These rows use
  invented makes and models, not real truck names.
--}}
@php
    $imageId = 0;
    $koglerImage = '';

    if ($imageId && function_exists('wp_attachment_is_image') && wp_attachment_is_image($imageId)) {
        $koglerImage = wp_get_attachment_image($imageId, 'full', false, [
            'class' => 'h-full w-full object-cover',
            'loading' => 'lazy',
            'decoding' => 'async',
            'alt' => __('Kogler mattress fitted in a truck sleeper cab', 'sage'),
            'sizes' => '(min-width: 1024px) 640px, calc(100vw - 48px)',
        ]);
    }

    $koglerLogo = function_exists('content_url')
        ? content_url('uploads/2026/08/kogler-logo-white.webp')
        : '';

    $specs = [
        ['label' => 'Widths', 'value' => ['29"', '32"', '36"', '38/39"', '42"']],
        ['label' => 'Length', 'value' => '80"'],
        ['label' => 'Thickness', 'value' => '7"'],
        ['label' => 'Construction', 'value' => 'Foam or innerspring'],
        ['label' => 'Cover', 'value' => 'Nylon or cloth'],
    ];

    // EXAMPLE DATA — replace with real fitments before launch.
    $fitments = [
        [
            'make' => 'Example Make A',
            'model' => 'Example Model 1',
            'width' => '42',
            'length' => '80',
            'thickness' => '7',
            'productUrl' => '',
        ],
        [
            'make' => 'Example Make A',
            'model' => 'Example Model 2',
            'width' => '38',
            'length' => '80',
            'thickness' => '7',
            'productUrl' => '/example-mattress',
        ],
        [
            'make' => 'Example Make B',
            'model' => 'Example Model 3',
            'width' => '36',
            'length' => '80',
            'thickness' => '7',
        ],
    ];

    // Same resolution as the Who We Are closing CTA.
    $contactUrl = function_exists('home_url') ? home_url('/contact-us/') : '#';

    if (function_exists('get_page_by_path') && function_exists('get_permalink')) {
        foreach (['contact-us', 'contact'] as $contactSlug) {
            $contactPage = get_page_by_path($contactSlug);

            if ($contactPage instanceof \WP_Post) {
                $contactUrl = get_permalink($contactPage);
                break;
            }
        }
    }

    // Future parts guide. Empty means the strip is not rendered.
    $parts = [];
@endphp
<section id="kogler" class="relative bg-white px-clamp py-clamp-xl">
  <div class="container">
    <div class="flex flex-wrap items-center gap-16">
      <div class="min-w-[min(100%,460px)] shrink grow basis-[460px]">
        @if ($koglerLogo)
          <span class="inline-flex h-12 items-center rounded-xl bg-primary px-5">
            <img src="{{ $koglerLogo }}" alt="{{ __('Kogler', 'sage') }}" class="h-6 w-auto" height="24">
          </span>
        @endif

        <h2 class="mt-6 mb-0 font-fraunces text-[clamp(34px,3.8vw,54px)] font-semibold leading-[1.08] tracking-tight text-dark-blue">
          Driving a truck is hard, <em class="italic font-medium text-primary">sleeping in one shouldn’t be.</em>
        </h2>

        <p class="mt-6 mb-0 max-w-[560px] text-[length:var(--font-size-tagline)] leading-[1.7] text-dark-blue/80">
          Kogler makes high-quality sleep products for the commercial trucking industry. Our sleeper mattresses are built for drivers who spend their nights in the cab and for the fleets that depend on them being rested.
        </p>
      </div>

      <div
        class="h-[280px] min-w-[min(100%,460px)] w-full shrink grow basis-[460px] overflow-hidden rounded-3xl bg-light-blue lg:h-[420px]"
        @unless ($koglerImage) aria-hidden="true" @endunless
      >
        @if ($koglerImage)
          {!! $koglerImage !!}
        @endif
      </div>
    </div>

    <div class="mt-[72px] flex flex-wrap items-stretch gap-6">
      <div class="min-w-[min(100%,520px)] shrink grow-[3] basis-[520px]">
        <h3 class="mb-5 text-[24px] font-bold text-dark-blue">Sleeper mattresses</h3>

        <div class="overflow-hidden rounded-3xl border border-dark-blue/12">
          <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left text-base text-dark-blue">
              <thead class="bg-light">
                <tr>
                  <th class="w-[34%] px-6 py-4 text-[12px] font-bold uppercase tracking-widest" scope="col">Spec</th>
                  <th class="px-6 py-4 text-[12px] font-bold uppercase tracking-widest" scope="col">Options</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($specs as $spec)
                  <tr class="border-t border-dark-blue/10">
                    <th class="px-6 py-[18px] text-left font-bold" scope="row">{{ $spec['label'] }}</th>
                    <td class="px-6 py-[18px]">
                      @if (is_array($spec['value']))
                        <div class="flex flex-wrap gap-1.5">
                          @foreach ($spec['value'] as $chip)
                            <span class="rounded-lg bg-light-blue px-3 py-1.5 text-sm font-bold text-dark-blue">{{ $chip }}</span>
                          @endforeach
                        </div>
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

      <div class="flex min-w-[min(100%,340px)] shrink grow-[2] basis-[340px] flex-col justify-between gap-7 rounded-3xl bg-dark-blue p-9 text-white">
        <div>
          <p class="mb-0 text-[13px] font-semibold text-secondary">Manufacturer’s Fitment Guide</p>
          <h3 class="mt-2.5 mb-0 font-fraunces text-[34px] font-semibold leading-[1.1]">Find your mattress</h3>
        </div>

        <form
          class="flex flex-col gap-3"
          x-data="fitmentGuide()"
          data-fitments='@json($fitments)'
          data-contact-url="{{ $contactUrl }}"
          @submit.prevent="submit()"
        >
          <label class="flex flex-col gap-1.5 text-[13px] font-semibold text-white/85">
            [Make]
            <select
              x-model="make"
              @change="onMakeChange()"
              :disabled="makes.length === 0"
              class="h-[50px] rounded-xl bg-white px-3.5 text-[length:var(--font-size-base)] text-dark-blue disabled:cursor-not-allowed disabled:opacity-60"
            >
              <option value="">[Select]</option>
              <template x-for="item in makes" :key="item">
                <option :value="item" x-text="item"></option>
              </template>
            </select>
          </label>

          <label class="flex flex-col gap-1.5 text-[13px] font-semibold text-white/85">
            [Model]
            <select
              x-model="model"
              :disabled="!make"
              class="h-[50px] rounded-xl bg-white px-3.5 text-[length:var(--font-size-base)] text-dark-blue disabled:cursor-not-allowed disabled:opacity-60"
            >
              <option value="">[Select]</option>
              <template x-for="item in models" :key="item">
                <option :value="item" x-text="item"></option>
              </template>
            </select>
          </label>

          <button
            type="submit"
            class="mt-1.5 h-[52px] w-full rounded-full bg-secondary text-[length:var(--font-size-base)] font-bold text-dark-blue disabled:cursor-not-allowed disabled:opacity-60"
            :disabled="!make || !model"
          >
            Find your mattress
          </button>

          {{-- Copy TBC: no-match line and the Contact Sales label. --}}
          <div aria-live="polite">
            <template x-if="result && result.status === 'match'">
              <p class="mb-0 text-[length:var(--font-size-base)]">
                <span x-text="sizeLabel(result)"></span>
                <a class="mt-2 block text-secondary underline" x-show="result.productUrl" :href="result.productUrl">View product</a>
              </p>
            </template>
            <template x-if="result && result.status === 'none'">
              <p class="mb-0 text-[length:var(--font-size-base)]">
                No match found.
                <a class="text-secondary underline" :href="contactUrl">Contact Sales</a>
              </p>
            </template>
          </div>
        </form>
      </div>
    </div>

    {{--
      Parts guide slot. Render nothing while $parts is empty.
      When it has items: grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mt-6.
    --}}
    @if ($parts)
      <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4"></div>
    @endif
  </div>
</section>
