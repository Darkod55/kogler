{{--
  Homepage brands. Sits directly after the capabilities row.
  Theme files, until the brands repeater on the front page has rows:
  resources/images/brands/logo-kogler-sleep-white.svg
  resources/images/brands/kogler-sleep-innerspring-mattress.webp
  resources/images/brands/logo-goliath-steel-full-colour.png
  resources/images/brands/goliath-3in1-full-assembly.webp
  resources/images/brands/logo-kogler-outdoor-white.svg
--}}
@php
    $themes = [
        'sleep' => [
            'name' => 'Kögler Sleep',
            'slug' => 'kogler-sleep',
            'bg' => 'bg-primary',
            'tagline' => 'text-white',
            'body' => 'text-white',
            'link' => 'border-light-blue text-light-blue',
            'outline' => 'has-[a:focus-visible]:outline-light-blue',
            'panel' => 'bg-white',
            'fit' => 'object-contain',
        ],
        'goliath' => [
            'name' => 'Goliath Steel',
            'slug' => 'goliath-steel',
            'bg' => 'bg-goliath-900',
            'tagline' => 'text-goliath-chrome',
            'body' => 'text-white/82',
            'link' => 'border-goliath-green text-goliath-green',
            'outline' => 'has-[a:focus-visible]:outline-goliath-green',
            'panel' => 'bg-goliath-800',
            'fit' => 'object-cover',
        ],
        'outdoor' => [
            'name' => 'Kögler Outdoor',
            'slug' => 'kogler-outdoor',
            'bg' => 'bg-outdoor-900',
            'tagline' => 'text-outdoor-amber',
            'body' => 'text-white/86',
            'link' => 'border-outdoor-amber text-outdoor-amber',
            'outline' => 'has-[a:focus-visible]:outline-outdoor-amber',
            'panel' => 'bg-outdoor-700',
            'fit' => 'object-cover',
        ],
    ];

    $themeFile = static function (string $file): array {
        $empty = ['url' => '', 'width' => 0, 'height' => 0];

        if ($file === '' || ! class_exists(\Illuminate\Support\Facades\Vite::class)) {
            return $empty;
        }

        try {
            $url = \Illuminate\Support\Facades\Vite::asset('resources/images/brands/' . $file);
        } catch (\Throwable $e) {
            return $empty;
        }

        $width = 0;
        $height = 0;
        $path = function_exists('get_theme_file_path') ? get_theme_file_path('resources/images/brands/' . $file) : '';

        if (is_string($path) && is_file($path)) {
            $size = @getimagesize($path);

            if (is_array($size)) {
                $width = (int) $size[0];
                $height = (int) $size[1];
            } elseif (str_ends_with(strtolower($path), '.svg')) {
                $svg = file_get_contents($path);

                if (is_string($svg) && preg_match('/viewBox="[\d.\s-]+?\s+([\d.]+)\s+([\d.]+)"/', $svg, $box)) {
                    $width = (int) round((float) $box[1]);
                    $height = (int) round((float) $box[2]);
                }
            }
        }

        return ['url' => $url, 'width' => $width, 'height' => $height];
    };

    $imageFromField = static function ($value): array {
        $empty = ['url' => '', 'width' => 0, 'height' => 0];

        if (is_numeric($value) && function_exists('wp_get_attachment_image_src')) {
            $src = wp_get_attachment_image_src((int) $value, 'full');

            if (is_array($src)) {
                return ['url' => (string) $src[0], 'width' => (int) $src[1], 'height' => (int) $src[2]];
            }
        }

        if (! is_array($value)) {
            return $empty;
        }

        $url = ! empty($value['url']) && is_string($value['url']) ? $value['url'] : '';
        $width = (int) ($value['width'] ?? 0);
        $height = (int) ($value['height'] ?? 0);
        $id = (int) ($value['ID'] ?? $value['id'] ?? 0);

        if ($url === '' && $id > 0 && function_exists('wp_get_attachment_image_src')) {
            $src = wp_get_attachment_image_src($id, 'full');

            if (is_array($src)) {
                $url = (string) $src[0];
                $width = $width > 0 ? $width : (int) $src[1];
                $height = $height > 0 ? $height : (int) $src[2];
            }
        }

        return ['url' => $url, 'width' => $width, 'height' => $height];
    };

    $bands = [
        [
            'theme' => 'sleep',
            'tagline' => 'Driving a Truck Is Hard, Sleeping in One Shouldn’t Be.',
            'text' => 'Sleeper cab mattresses built for drivers who spend their nights in the cab, and for the fleets that depend on them being rested.',
            'link_title' => 'Explore Kögler Sleep',
            'link_url' => \App\helpers()->brandPageUrl('kogler-sleep'),
            'logo' => $themeFile('logo-kogler-sleep-white.svg'),
            'image' => $themeFile('kogler-sleep-innerspring-mattress.webp'),
        ],
        [
            'theme' => 'goliath',
            'tagline' => 'Goliath Strength Without the Goliath Price.',
            'text' => 'Commercial truck aftermarket parts: high quality at reasonable prices for fleets, repair shops and distribution partners.',
            'link_title' => 'Explore Goliath Steel',
            'link_url' => \App\helpers()->brandPageUrl('goliath-steel'),
            'logo' => $themeFile('logo-goliath-steel-full-colour.png'),
            'image' => $themeFile('goliath-3in1-full-assembly.webp'),
        ],
        [
            'theme' => 'outdoor',
            'tagline' => 'Sleep Like Home, Wherever You Roam!',
            'text' => 'Our sleep expertise brought to the RV and marine markets, with comfort products made for RVs, campers and boats.',
            'link_title' => 'Explore Kögler Outdoor',
            'link_url' => \App\helpers()->brandPageUrl('kogler-outdoor'),
            'logo' => $themeFile('logo-kogler-outdoor-white.svg'),
            'image' => ['url' => '', 'width' => 0, 'height' => 0],
        ],
    ];

    if (function_exists('get_field')) {
        $saved = get_field('brands');
        $rows = [];

        if (is_array($saved)) {
            foreach ($saved as $row) {
                if (! is_array($row)) {
                    continue;
                }

                $theme = (string) ($row['theme'] ?? '');

                if (! isset($themes[$theme])) {
                    continue;
                }

                $link = $row['link'] ?? [];
                $linkUrl = '';
                $linkTitle = '';

                if (is_array($link)) {
                    $linkUrl = trim((string) ($link['url'] ?? ''));
                    $linkTitle = trim((string) ($link['title'] ?? ''));
                } elseif (is_string($link)) {
                    $linkUrl = trim($link);
                }

                $rows[] = [
                    'theme' => $theme,
                    'tagline' => trim((string) ($row['tagline'] ?? '')),
                    'text' => trim((string) ($row['text'] ?? '')),
                    'link_title' => $linkTitle !== '' ? $linkTitle : 'Explore ' . $themes[$theme]['name'],
                    'link_url' => $linkUrl !== '' ? $linkUrl : \App\helpers()->brandPageUrl($themes[$theme]['slug']),
                    'logo' => $imageFromField($row['logo'] ?? null),
                    'image' => $imageFromField($row['image'] ?? null),
                ];
            }
        }

        if ($rows !== []) {
            $bands = $rows;
        }
    }
@endphp
<section class="bg-white px-clamp py-clamp-xl">
  <div class="container">
    <div class="flex flex-col gap-y-6 min-[641px]:flex-row min-[641px]:flex-wrap min-[641px]:items-end min-[641px]:justify-between min-[641px]:gap-x-16">
      <h2 class="mb-0 max-w-[620px] font-fraunces text-[clamp(38px,4.4vw,62px)] font-semibold leading-[1.02] tracking-[-1px] text-dark-blue">
        Three Brands. <em class="font-medium italic text-primary">One Mission.</em>
      </h2>
      <p class="mb-0 max-w-[440px] text-[18px] leading-[1.7] text-dark-blue/75">
        At Kogler-USA we supply thousands of customers across the commercial truck, RV and marine markets through three brands.
      </p>
    </div>

    <ul class="m-0 mt-14 flex list-none flex-col gap-2.5 p-0">
      @foreach ($bands as $band)
        @php
            $theme = $themes[$band['theme']];
            $bandClass = 'group relative grid grid-cols-1 items-center gap-6 rounded-[18px] px-7 py-8 text-white transition-transform duration-200 hover:translate-x-1.5 motion-reduce:transform-none motion-reduce:transition-none min-[981px]:grid-cols-[200px_minmax(0,1fr)_280px] min-[981px]:gap-8 min-[981px]:px-10 min-[981px]:py-9 min-[1101px]:grid-cols-[260px_minmax(0,1fr)_340px] min-[1101px]:gap-12 has-[a:focus-visible]:outline-2 has-[a:focus-visible]:outline-offset-4';
            $bandClass .= ' ' . $theme['bg'] . ' ' . $theme['outline'];
        @endphp
        <li class="m-0">
          <article class="{{ $bandClass }}">
            @if ($band['logo']['url'] !== '')
              <img
                class="h-auto w-full max-w-[200px] min-[981px]:max-w-[230px]"
                src="{{ $band['logo']['url'] }}"
                alt="{{ $theme['name'] }}"
                @if ($band['logo']['width'] > 0) width="{{ $band['logo']['width'] }}" @endif
                @if ($band['logo']['height'] > 0) height="{{ $band['logo']['height'] }}" @endif
                loading="lazy"
                decoding="async"
              >
            @else
              <p class="sr-only">{{ $theme['name'] }}</p>
            @endif

            <div class="min-w-0">
              @if ($band['tagline'] !== '')
                <h3 class="mb-0 font-fraunces text-[26px] font-medium italic leading-[1.15] min-[641px]:text-[30px] {{ $theme['tagline'] }}">
                  {{ $band['tagline'] }}
                </h3>
              @endif
              @if ($band['text'] !== '')
                <p class="mb-0 mt-3 max-w-[520px] text-[16px] leading-[1.6] {{ $theme['body'] }}">
                  {{ $band['text'] }}
                </p>
              @endif
              <a
                class="mt-[18px] inline-block border-b-2 pb-[3px] text-[15px] font-bold no-underline after:absolute after:inset-0 after:z-10 after:rounded-[18px] after:content-[''] focus-visible:outline-none {{ $theme['link'] }}"
                href="{{ $band['link_url'] }}"
              >{{ $band['link_title'] }} <span aria-hidden="true">→</span></a>
            </div>

            <div class="h-[220px] w-full overflow-hidden rounded-xl min-[981px]:h-[200px] {{ $theme['panel'] }}">
              @if ($band['image']['url'] !== '')
                <img
                  class="h-full w-full {{ $theme['fit'] }}"
                  src="{{ $band['image']['url'] }}"
                  alt=""
                  @if ($band['image']['width'] > 0) width="{{ $band['image']['width'] }}" @endif
                  @if ($band['image']['height'] > 0) height="{{ $band['image']['height'] }}" @endif
                  loading="lazy"
                  decoding="async"
                >
              @endif
            </div>
          </article>
        </li>
      @endforeach
    </ul>
  </div>
</section>
