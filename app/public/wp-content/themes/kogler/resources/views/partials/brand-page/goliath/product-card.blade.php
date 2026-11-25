{{--
  One Goliath ABS product card. $product comes from App\Goliath\AbsCatalog.
  Photos are Media Library attachment IDs. 0 leaves the white frame empty.
--}}
@php
    $product = $product ?? [];
    $variants = $product['variants'] ?? [];
    $keys = array_column($variants, 'key');
    $firstKey = $keys[0] ?? '';
    $hasSwitch = count($variants) > 1;
    $state = \Illuminate\Support\Js::from([
        'variant' => $firstKey,
        'keys' => array_values($keys),
    ]);

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

    $mainImage = $attachment(
        (int) ($product['image_id'] ?? 0),
        (string) ($product['image_alt'] ?? ''),
        'aspect-square w-full rounded-[20px] bg-white object-contain'
    );
    $detailImage = $attachment(
        (int) ($product['detail_image_id'] ?? 0),
        (string) ($product['detail_alt'] ?? ''),
        'aspect-[5/2] w-full rounded-2xl bg-white object-contain'
    );
@endphp
<article
  id="{{ $product['id'] }}"
  class="relative flex flex-wrap gap-12 rounded-[28px] border border-white/[0.08] bg-goliath-900 p-7 min-[1000px]:p-12"
  x-data="goliathProduct({{ $state }})"
>
  <div class="mx-auto flex w-full max-w-[360px] shrink grow basis-full flex-col gap-3.5 min-[1000px]:mx-0 min-[1000px]:max-w-[440px] min-[1000px]:basis-[340px]">
    @if ($mainImage !== '')
      {!! $mainImage !!}
    @else
      <div class="aspect-square w-full rounded-[20px] bg-white" aria-hidden="true"></div>
    @endif

    @if (! empty($product['detail_captions']))
      <figure class="m-0">
        @if ($detailImage !== '')
          {!! $detailImage !!}
        @else
          <div class="aspect-[5/2] w-full rounded-2xl bg-white" aria-hidden="true"></div>
        @endif
        <figcaption class="mt-2 flex justify-around text-xs font-bold tracking-widest text-white/65 uppercase">
          @foreach ($product['detail_captions'] as $caption)
            <span>{{ $caption }}</span>
          @endforeach
        </figcaption>
      </figure>
    @endif
  </div>

  <div class="min-w-0 w-full shrink grow-[999] basis-full min-[1000px]:basis-[520px]">
    <h3 class="lead mb-0 font-fraunces text-white">{{ $product['title'] }}</h3>
    <p class="mt-3 mb-0 text-[length:var(--font-size-base)] leading-[1.65] text-white/80">{{ $product['intro'] }}</p>

    <table class="mt-7 w-full border-collapse text-[length:var(--font-size-btn)]">
      <thead>
        <tr class="border-b-2 border-goliath-green">
          <th class="w-[40%] pr-4 pb-3 text-left fs-xs font-bold tracking-widest uppercase" scope="col">Feature</th>
          <th class="pb-3 text-left fs-xs font-bold tracking-widest uppercase" scope="col">Benefit</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($product['features'] as $feature)
          <tr class="border-b border-white/10">
            <th class="py-[13px] pr-4 text-left font-bold" scope="row">{{ $feature['feature'] }}</th>
            <td class="py-[13px] leading-normal text-white/80">{{ $feature['benefit'] }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="relative mt-9">
      @if ($hasSwitch)
        <div
          class="mb-4 inline-flex rounded-full bg-goliath-800 p-1 min-[1000px]:absolute min-[1000px]:top-0 min-[1000px]:right-0 min-[1000px]:mb-0"
          role="tablist"
          aria-label="{{ $product['tablist_label'] }}"
          @keydown.right.prevent="next(1)"
          @keydown.left.prevent="next(-1)"
        >
          @foreach ($variants as $variant)
            <button
              type="button"
              role="tab"
              data-tab="{{ $variant['key'] }}"
              id="{{ $product['id'] }}-tab-{{ $variant['key'] }}"
              :aria-selected="variant === '{{ $variant['key'] }}'"
              :tabindex="variant === '{{ $variant['key'] }}' ? 0 : -1"
              aria-controls="{{ $product['id'] }}-parts-{{ $variant['key'] }}"
              class="cursor-pointer rounded-full px-[18px] py-2.5 text-sm font-bold"
              :class="variant === '{{ $variant['key'] }}' ? 'bg-goliath-green text-goliath-green-ink' : 'bg-transparent text-white hover:bg-white/[0.06]'"
              @click="variant = '{{ $variant['key'] }}'"
            >{{ $variant['label'] }}</button>
          @endforeach
        </div>
      @endif

      @foreach ($variants as $variant)
        @php
            $showBox = ($variant['show_box'] ?? true) && array_key_exists('box_image_id', $variant) && $hasSwitch;
            $boxImage = $showBox
                ? $attachment((int) $variant['box_image_id'], (string) ($variant['box_alt'] ?? ''), 'h-[104px] w-[120px] rounded-xl bg-white object-contain')
                : '';
        @endphp
        <div x-show="variant === '{{ $variant['key'] }}'">
          <h4 class="mb-0 font-fraunces text-white min-[1000px]:pr-56">{{ $variant['title'] }}</h4>

          <div
            id="{{ $product['id'] }}-parts-{{ $variant['key'] }}"
            @if ($hasSwitch) role="tabpanel" aria-labelledby="{{ $product['id'] }}-tab-{{ $variant['key'] }}" @endif
            class="mt-4 flex items-start gap-4"
          >
            @if ($showBox)
              <div class="hidden shrink-0 sm:block" x-show="variant === '{{ $variant['key'] }}'">
                @if ($boxImage !== '')
                  {!! $boxImage !!}
                @else
                  <div class="h-[104px] w-[120px] rounded-xl bg-white" aria-hidden="true"></div>
                @endif
              </div>
            @endif

            <div class="min-w-0 flex-1 overflow-x-auto rounded-[18px] border border-white/10">
              <table class="w-full min-w-[520px] border-collapse text-[length:var(--font-size-btn)]">
                <thead class="bg-goliath-800">
                  <tr>
                    <th class="px-5 py-3.5 text-left fs-xs font-bold tracking-widest uppercase" scope="col">Part no.</th>
                    <th class="px-5 py-3.5 text-left fs-xs font-bold tracking-widest uppercase" scope="col">Description</th>
                    <th class="px-5 py-3.5 text-left fs-xs font-bold tracking-widest uppercase" scope="col">Length</th>
                    <th class="px-5 py-3.5 text-left fs-xs font-bold tracking-widest uppercase" scope="col">Packaging</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($variant['parts'] as $part)
                    <tr class="border-t border-white/[0.08]">
                      <th class="px-5 py-[13px] text-left font-bold tabular-nums" scope="row">{{ $part['sku'] }}</th>
                      <td class="px-5 py-[13px] text-white/85">{{ $part['description'] }}</td>
                      <td class="px-5 py-[13px] whitespace-nowrap">{{ $part['length'] }}</td>
                      <td class="px-5 py-[13px] text-white/75">{{ $part['packaging'] }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>

          @if (! empty($variant['note']))
            <p class="mt-3.5 mb-0 text-sm leading-[1.6] text-white/70">
              @if (is_array($variant['note']))
                <strong class="font-bold text-white">{{ $variant['note']['lead'] }}</strong>
                {{ $variant['note']['text'] }}
              @else
                {{ $variant['note'] }}
              @endif
            </p>
          @endif
        </div>
      @endforeach
    </div>
  </div>
</article>
