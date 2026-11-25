{{--
  Sister-brand link cards. Pass $currentBrand to hide that brand.
  Defaults to the page's kogler_brand. Sleep and Goliath can include this later.
  Logos share one height so the cards line up. 0 keeps the text name.
--}}
@php
    $currentBrand = $currentBrand ?? \App\helpers()->brandTheme();

    $sleepLogoId = 395;
    $goliathLogoId = 397;
    $outdoorLogoId = 396;
    $logoClass = 'block h-10 w-auto max-w-full object-contain object-left';

    $brandLogo = function (int $id, string $alt, string $class): string {
        if ($id < 1 || ! function_exists('wp_get_attachment_image')) {
            return '';
        }

        $mime = function_exists('get_post_mime_type') ? (string) get_post_mime_type($id) : '';
        $isImage = function_exists('wp_attachment_is_image') && wp_attachment_is_image($id);

        if (! $isImage && $mime !== 'image/svg+xml') {
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

    $brands = [
        'kogler-sleep' => [
            'card' => 'bg-primary',
            'logo' => $brandLogo($sleepLogoId, 'Kögler Sleep', $logoClass),
            'name' => 'Kögler',
            'name_class' => 'text-[24px] font-extrabold tracking-tight',
            'line' => 'High-quality sleep products for the commercial truck cab.',
            'line_class' => 'text-white/85',
        ],
        'goliath-steel' => [
            'card' => 'bg-goliath-900',
            'logo' => $brandLogo($goliathLogoId, 'Goliath Steel', $logoClass),
            'name' => 'GOLIATH STEEL',
            'name_class' => 'text-[20px] font-extrabold tracking-[0.15em] text-goliath-chrome',
            'line' => 'Heavy-duty commercial truck aftermarket parts, high quality at reasonable prices.',
            'line_class' => 'text-white/80',
        ],
        'kogler-outdoor' => [
            'card' => 'bg-outdoor-950',
            'logo' => $brandLogo($outdoorLogoId, 'Kögler Outdoor', $logoClass),
            'name' => 'Kögler Outdoor',
            'name_class' => 'text-[24px] font-extrabold tracking-tight',
            'line' => 'Adventure sleep products for life on the road and on the water.',
            'line_class' => 'text-white/85',
        ],
    ];

    unset($brands[$currentBrand]);
@endphp
<div class="mt-5 grid grid-cols-1 gap-5 md:grid-cols-2">
  @foreach ($brands as $slug => $brand)
    <a
      class="flex items-center justify-between gap-4 rounded-3xl px-8 py-7 text-white no-underline transition hover:-translate-y-[3px] motion-reduce:transform-none focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-(--site-accent) {{ $brand['card'] }}"
      href="{{ \App\helpers()->brandPageUrl($slug) }}"
    >
      <span class="min-w-0">
        @if ($brand['logo'] !== '')
          {!! $brand['logo'] !!}
        @else
          <span class="block {{ $brand['name_class'] }}">{{ $brand['name'] }}</span>
        @endif
        <span class="mt-1 block text-[length:var(--font-size-btn)] {{ $brand['line_class'] }}">{{ $brand['line'] }}</span>
      </span>
      <span class="shrink-0 text-2xl leading-none" aria-hidden="true">→</span>
    </a>
  @endforeach
</div>
