{{--
  Goliath Steel — Diamond-Grip and black nitrile gloves.
  Copy and part numbers come from App\Goliath\AbsCatalog (group: gloves).
  Set image_id and box_image_id on the diamond-grip product.
  Orange is only used in this section.
--}}
@php
    $gloves = [];

    foreach (\App\Goliath\AbsCatalog::byGroup('gloves') as $product) {
        $gloves[$product['id']] = $product;
    }

    $diamond = $gloves['diamond-grip'] ?? null;
    $black = $gloves['black-nitrile'] ?? null;

    $attachment = function (int $id, string $alt, string $class): string {
        if ($id < 1 || ! function_exists('wp_get_attachment_image')) {
            return '';
        }

        if (function_exists('wp_attachment_is_image') && ! wp_attachment_is_image($id)) {
            return '';
        }

        $image = wp_get_attachment_image($id, 'full', false, [
            'class' => $class,
            'alt' => $alt,
            'loading' => 'lazy',
            'decoding' => 'async',
        ]);

        return is_string($image) ? $image : '';
    };

    $gloveImage = $diamond
        ? $attachment((int) ($diamond['image_id'] ?? 0), (string) ($diamond['image_alt'] ?? ''), 'aspect-[7/8] w-full rounded-3xl object-cover')
        : '';
    $boxImage = $diamond
        ? $attachment((int) ($diamond['box_image_id'] ?? 0), (string) ($diamond['box_alt'] ?? ''), 'h-[104px] w-40 rounded-xl bg-white object-contain')
        : '';
    $orangeParts = $diamond['variants'][0]['parts'] ?? [];
    $blackParts = $black['variants'][0]['parts'] ?? [];
@endphp
@if ($diamond)
  <section id="gloves" class="relative bg-goliath-950 p-clamp-xl text-white">
    <div class="container">
      <div class="flex flex-wrap items-center gap-14">
        <div class="mx-auto w-full min-w-0 max-w-[360px] shrink grow basis-full min-[1000px]:mx-0 min-[1000px]:max-w-[440px] min-[1000px]:basis-[340px]">
          @if ($gloveImage !== '')
            {!! $gloveImage !!}
          @else
            <div class="aspect-[7/8] w-full rounded-3xl bg-goliath-900" aria-hidden="true"></div>
          @endif
        </div>

        <div class="min-w-0 w-full shrink grow-[999] basis-full min-[1000px]:basis-[520px]">
          <p class="mb-0 inline-flex items-center gap-2.5 text-sm font-bold tracking-[0.15em] text-white/80 uppercase">
            <span class="size-3 rounded-sm bg-goliath-orange" aria-hidden="true"></span>
            Orange · Sizes S – XXL
          </p>
          <h2 class="mt-4 mb-0 font-fraunces text-white">
            Diamond-Grip <em class="italic font-medium text-goliath-orange-light">Nitrile Gloves</em>
          </h2>
          <p class="mt-[18px] mb-0 max-w-[560px] lead leading-[1.7] text-white/80">{{ $diamond['intro'] }}</p>

          <dl class="mt-8 mb-0 grid grid-cols-1 gap-5 sm:grid-cols-3">
            @foreach ($diamond['stats'] as $stat)
              <div class="flex flex-col-reverse border-t-[3px] border-goliath-orange pt-3.5">
                <dt class="mt-2 text-sm text-white/75">{{ $stat['label'] }}</dt>
                <dd class="m-0 font-fraunces text-[2.5rem] font-semibold leading-none">{{ $stat['value'] }}</dd>
              </div>
            @endforeach
          </dl>
        </div>
      </div>

      <div class="mt-12 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($diamond['cards'] as $card)
          <article class="rounded-[20px] border border-white/[0.08] bg-goliath-900 px-7 py-[26px]">
            <h3 class="mb-0 text-[length:var(--font-size-base)] font-extrabold tracking-[0.03em] uppercase">{{ $card['title'] }}</h3>
            <p class="mt-2 mb-0 text-[length:var(--font-size-btn)] leading-[1.6] text-white/75">{{ $card['text'] }}</p>
          </article>
        @endforeach
      </div>

      <div class="mt-12 flex flex-wrap items-start gap-4">
        <div class="hidden shrink-0 sm:block">
          @if ($boxImage !== '')
            {!! $boxImage !!}
          @else
            <div class="h-[104px] w-40 rounded-xl bg-white" aria-hidden="true"></div>
          @endif
        </div>

        <div class="min-w-0 shrink grow basis-full sm:basis-[520px]">
          <h3 class="mb-3.5 text-[length:var(--font-size-tagline)] font-bold text-white">Part Numbers</h3>
          <div class="overflow-x-auto rounded-[18px] border border-white/10">
            <table class="w-full min-w-[520px] border-collapse text-[length:var(--font-size-btn)]">
              <thead class="bg-goliath-800">
                <tr>
                  <th class="px-5 py-3.5 text-left fs-xs font-bold tracking-widest uppercase" scope="col">Part no.</th>
                  <th class="px-5 py-3.5 text-left fs-xs font-bold tracking-widest uppercase" scope="col">Description</th>
                  <th class="px-5 py-3.5 text-left fs-xs font-bold tracking-widest uppercase" scope="col">Size</th>
                  <th class="px-5 py-3.5 text-left fs-xs font-bold tracking-widest uppercase" scope="col">Case</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($orangeParts as $part)
                  <tr class="border-t border-white/[0.08]">
                    <th class="px-5 py-[13px] text-left font-bold" scope="row">{{ $part['sku'] }}</th>
                    <td class="px-5 py-[13px] text-white/85">{{ $part['description'] }}</td>
                    <td class="px-5 py-[13px] font-bold">{{ $part['size'] }}</td>
                    <td class="px-5 py-[13px] text-white/75 tabular-nums">{{ $part['case'] }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <p class="mt-3.5 mb-0 text-sm text-white/70">{{ $diamond['note'] }}</p>
        </div>
      </div>

      @if ($black)
        <div class="mt-14 rounded-[28px] border border-white/[0.08] bg-goliath-900 p-7 min-[1000px]:p-12">
          <p class="mb-0 text-sm font-bold tracking-[0.15em] text-goliath-green uppercase">Also available</p>
          <h3 class="mt-3 mb-0 font-fraunces text-white">{{ $black['title'] }}</h3>
          <p class="mt-3 mb-0 text-[length:var(--font-size-base)] leading-[1.65] text-white/80">{{ $black['intro'] }}</p>

          <div class="mt-7 flex flex-wrap items-start gap-8 min-[1000px]:flex-nowrap min-[1000px]:gap-10">
            <table class="w-full shrink-0 basis-full border-collapse text-[length:var(--font-size-btn)] min-[1000px]:w-[34%] min-[1000px]:max-w-[380px] min-[1000px]:basis-[34%]">
              <thead>
                <tr class="border-b-2 border-goliath-green">
                  <th class="w-[40%] pr-4 pb-3 text-left fs-xs font-bold tracking-widest uppercase" scope="col">Feature</th>
                  <th class="pb-3 text-left fs-xs font-bold tracking-widest uppercase" scope="col">Benefit</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($black['features'] as $feature)
                  <tr class="border-b border-white/10">
                    <th class="py-3 pr-4 text-left font-bold" scope="row">{{ $feature['feature'] }}</th>
                    <td class="py-3 text-white/80">{{ $feature['benefit'] }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>

            <div class="min-w-0 shrink grow basis-full overflow-x-auto rounded-[18px] border border-white/10 min-[1000px]:basis-auto min-[1000px]:overflow-visible">
              <table class="w-full min-w-[520px] border-collapse text-[length:var(--font-size-btn)] min-[1000px]:min-w-0">
                <thead class="bg-goliath-800">
                  <tr>
                    <th class="px-4 py-3.5 text-left fs-xs font-bold tracking-widest whitespace-nowrap uppercase" scope="col">Part no.</th>
                    <th class="px-4 py-3.5 text-left fs-xs font-bold tracking-widest uppercase" scope="col">Description</th>
                    <th class="px-4 py-3.5 text-left fs-xs font-bold tracking-widest whitespace-nowrap uppercase" scope="col">Size</th>
                    <th class="px-4 py-3.5 text-left fs-xs font-bold tracking-widest whitespace-nowrap uppercase" scope="col">Color</th>
                    <th class="px-4 py-3.5 text-left fs-xs font-bold tracking-widest whitespace-nowrap uppercase" scope="col">Sold by</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($blackParts as $part)
                    <tr class="border-t border-white/[0.08]">
                      <th class="px-4 py-[13px] text-left font-bold whitespace-nowrap" scope="row">{{ $part['sku'] }}</th>
                      <td class="px-4 py-[13px] text-white/85">{{ $part['description'] }}</td>
                      <td class="px-4 py-[13px] font-bold whitespace-nowrap">{{ $part['size'] }}</td>
                      <td class="px-4 py-[13px] whitespace-nowrap">{{ $part['color'] }}</td>
                      <td class="px-4 py-[13px] text-white/75 whitespace-nowrap">{{ $part['sold_by'] }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      @endif
    </div>
  </section>
@endif
