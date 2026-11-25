{{--
  Homepage benefits. Sits directly after What’s Inside.
  The photo is a Media Library attachment. 398 is the night truck.
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

    $benefits = [
        [
            'title' => 'Consistent Support',
            'text' => 'Maintains shape and support over time for reliable comfort every night.',
        ],
        [
            'title' => 'Better Rest on the Road',
            'text' => 'Designed to reduce pressure and improve sleep quality during long hauls.',
        ],
        [
            'title' => 'Long-Lasting Durability',
            'text' => 'High-quality materials built to withstand daily use and demanding conditions.',
        ],
    ];

    $imageId = 398;

    if (function_exists('get_field')) {
        $saved = get_field('benefits');
        $rows = [];

        if (is_array($saved)) {
            foreach ($saved as $row) {
                if (! is_array($row) || count($rows) >= 3) {
                    continue;
                }

                $title = trim((string) ($row['title'] ?? ''));
                $text = trim((string) ($row['text'] ?? ''));

                if ($title === '' && $text === '') {
                    continue;
                }

                $rows[] = [
                    'title' => $title,
                    'text' => $text,
                ];
            }
        }

        if ($rows !== []) {
            $benefits = $rows;
        }

        $chosen = $attachmentId(get_field('benefits_image'));

        if ($chosen > 0) {
            $imageId = $chosen;
        }
    }

    $photo = '';
    $photoAlt = 'Semi truck driving at night';

    if ($imageId > 0 && function_exists('wp_get_attachment_image') && function_exists('wp_attachment_is_image') && wp_attachment_is_image($imageId)) {
        $alt = function_exists('get_post_meta')
            ? trim(wp_strip_all_tags((string) get_post_meta($imageId, '_wp_attachment_image_alt', true)))
            : '';

        if ($alt !== '') {
            $photoAlt = $alt;
        }

        $rendered = wp_get_attachment_image($imageId, 'full', false, [
            'class' => 'block h-[300px] w-full rounded-[22px] object-cover min-[641px]:h-[420px] min-[981px]:h-[600px]',
            'alt' => $photoAlt,
            'loading' => 'lazy',
            'decoding' => 'async',
            'sizes' => '(min-width: 981px) 46vw, 100vw',
        ]);
        $photo = is_string($rendered) ? $rendered : '';
    }
@endphp
<section class="bg-dark-blue px-clamp py-[120px] text-white">
  <div class="container grid grid-cols-1 items-center gap-12 min-[981px]:grid-cols-2 min-[981px]:gap-[72px]">
    @if ($photo !== '')
      {!! $photo !!}
    @else
      <div class="h-[300px] w-full rounded-[22px] bg-dark-blue min-[641px]:h-[420px] min-[981px]:h-[600px]" aria-hidden="true"></div>
    @endif

    <div class="min-w-0">
      <h2 class="mb-0 font-fraunces text-[clamp(34px,3.6vw,52px)] font-semibold leading-[1.08] tracking-[-0.8px] text-white">
        We Deliver Comfort and Durability <em class="font-medium italic text-secondary">for Life on the Road</em>
      </h2>

      <ol class="lane-v m-0 mt-12 flex list-none flex-col gap-10 p-0 pl-10 max-[640px]:gap-8 max-[640px]:pl-8">
        @foreach ($benefits as $benefit)
          <li class="relative">
            <span aria-hidden="true" class="absolute top-[5px] -left-10 size-[13px] bg-secondary max-[640px]:-left-8"></span>
            @if ($benefit['title'] !== '')
              <h3 class="m-0 mb-2 text-[19px] font-bold text-white min-[641px]:text-[21px]">{{ $benefit['title'] }}</h3>
            @endif
            @if ($benefit['text'] !== '')
              <p class="m-0 text-base leading-[1.65] text-white/82">{{ $benefit['text'] }}</p>
            @endif
          </li>
        @endforeach
      </ol>
    </div>
  </div>
</section>
