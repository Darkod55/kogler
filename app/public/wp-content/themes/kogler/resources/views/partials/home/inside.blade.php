{{--
  Homepage What’s Inside. Sits directly after Find What Fits You.
  The cross-section and poster are Media Library attachment IDs.
  inside_image is 0 until the plain cross-section is attached.
  The video falls back to the mattress file already in the library.
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

    $features = [
        [
            'title' => 'Durable Protective Cover',
            'text' => 'Easy-to-clean, long-lasting cover built to withstand demanding truck environments.',
        ],
        [
            'title' => 'Pressure-Relief Foam',
            'text' => 'Advanced foam designed to reduce pressure points and improve circulation, helping drivers rest better during long hauls.',
        ],
        [
            'title' => 'High-Density Support Core',
            'text' => 'A durable base layer that maintains shape and provides consistent support over time, even under heavy daily use.',
        ],
        [
            'title' => 'Reinforced Edge Support',
            'text' => 'Strengthened edges for added stability and extended mattress lifespan.',
        ],
    ];

    $imageId = 0;
    $posterId = 0;
    $videoId = 0;

    if (function_exists('get_field')) {
        $saved = get_field('inside_features');
        $rows = [];

        if (is_array($saved)) {
            foreach ($saved as $row) {
                if (! is_array($row) || count($rows) >= 4) {
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
            $features = $rows;
        }

        $imageId = $attachmentId(get_field('inside_image'));
        $posterId = $attachmentId(get_field('inside_video_poster'));
        $videoId = $attachmentId(get_field('inside_video'));
    }

    $crossSection = '';

    if ($imageId > 0 && function_exists('wp_get_attachment_image') && function_exists('wp_attachment_is_image') && wp_attachment_is_image($imageId)) {
        $rendered = wp_get_attachment_image($imageId, 'full', false, [
            'class' => 'block h-auto w-full',
            'alt' => 'Cross-section of a Kögler mattress: protective cover, pressure-relief foam, high-density support core and reinforced edges',
            'width' => 1200,
            'height' => 500,
            'loading' => 'lazy',
            'decoding' => 'async',
        ]);
        $crossSection = is_string($rendered) ? $rendered : '';
    }

    $poster = '';

    if ($posterId > 0 && function_exists('wp_get_attachment_image') && function_exists('wp_attachment_is_image') && wp_attachment_is_image($posterId)) {
        $renderedPoster = wp_get_attachment_image($posterId, 'full', false, [
            'class' => 'absolute inset-0 h-full w-full object-cover',
            'alt' => '',
            'loading' => 'lazy',
            'decoding' => 'async',
        ]);
        $poster = is_string($renderedPoster) ? $renderedPoster : '';
    }

    $videoUrl = '';

    if ($videoId > 0 && function_exists('wp_get_attachment_url')) {
        $resolved = wp_get_attachment_url($videoId);
        $videoUrl = is_string($resolved) ? $resolved : '';
    }

    if ($videoUrl === '' && function_exists('content_url')) {
        $videoUrl = content_url('uploads/2026/08/kogler-video-mattress.mp4');
    }

    $markers = [
        ['n' => '1', 'class' => 'left-[87.5%] top-[6%] bg-dark-blue text-white ring-2 ring-white'],
        ['n' => '2', 'class' => 'left-[87.5%] top-[23.4%] bg-dark-blue text-white ring-2 ring-white'],
        ['n' => '3', 'class' => 'left-[87.5%] top-[66.8%] bg-white text-dark-blue'],
        ['n' => '4', 'class' => 'left-[3%] top-[66.8%] bg-white text-dark-blue'],
    ];
@endphp
<section class="bg-white px-clamp py-[120px]">
  <div class="container">
    <div class="flex flex-col gap-y-6 min-[641px]:flex-row min-[641px]:flex-wrap min-[641px]:items-end min-[641px]:justify-between min-[641px]:gap-x-16">
      <h2 class="mb-0 font-fraunces text-[clamp(38px,4.4vw,62px)] font-semibold leading-[1.02] tracking-[-1px] text-dark-blue">
        What’s Inside <em class="font-medium italic text-primary">Matters</em>
      </h2>
      <p class="mb-0 max-w-[460px] text-[18px] leading-[1.7] text-dark-blue/75">
        Every Kögler mattress is built in layers, and each layer has a job to do on the road.
      </p>
    </div>

    <div class="mt-14 grid grid-cols-1 items-stretch gap-8 min-[981px]:grid-cols-[7fr_5fr] min-[981px]:gap-12">
      <div class="rounded-[22px] bg-light px-5 pt-7 pb-7 min-[641px]:px-11 min-[641px]:pt-12 min-[641px]:pb-11">
        <figure class="m-0">
          <div class="relative aspect-[12/5] w-full">
            @if ($crossSection !== '')
              {!! $crossSection !!}
            @endif
            @foreach ($markers as $marker)
              <span aria-hidden="true" class="absolute grid size-6 -translate-x-1/2 -translate-y-1/2 place-items-center rounded-full text-[11px] font-bold min-[641px]:size-[30px] min-[641px]:text-[13px] {{ $marker['class'] }}">{{ $marker['n'] }}</span>
            @endforeach
          </div>
          <figcaption class="mt-3 text-[13px] text-dark-blue/70">Illustrative cross-section. Layers vary by model.</figcaption>
        </figure>

        <ol class="m-0 mt-10 grid list-none grid-cols-1 gap-y-6 p-0 min-[721px]:grid-cols-2 min-[721px]:gap-x-10 min-[721px]:gap-y-7">
          @foreach ($features as $index => $feature)
            <li class="flex gap-4">
              <span aria-hidden="true" class="grid size-[30px] shrink-0 place-items-center rounded-full bg-dark-blue text-[13px] font-bold text-white">{{ $index + 1 }}</span>
              <div class="min-w-0">
                @if ($feature['title'] !== '')
                  <h3 class="mt-0.5 mb-1.5 text-lg font-bold text-dark-blue">{{ $feature['title'] }}</h3>
                @endif
                @if ($feature['text'] !== '')
                  <p class="m-0 text-[15px] leading-[1.6] text-dark-blue/75">{{ $feature['text'] }}</p>
                @endif
              </div>
            </li>
          @endforeach
        </ol>
      </div>

      <div class="relative aspect-[4/5] min-h-0 overflow-hidden rounded-[22px] bg-dark-blue text-white min-[981px]:aspect-auto min-[981px]:min-h-[560px]" x-data="{ playing: false }">
        <div class="absolute inset-0" x-show="! playing">
          @if ($poster !== '')
            {!! $poster !!}
          @endif
          <div
            class="pointer-events-none absolute inset-0"
            aria-hidden="true"
            style="background: linear-gradient(180deg, transparent 40%, color-mix(in srgb, var(--color-dark-blue) 90%, transparent) 100%)"
          ></div>
          @if ($videoUrl !== '')
            <button
              type="button"
              class="absolute inset-0 z-10 m-auto grid size-[88px] place-items-center rounded-full bg-white text-dark-blue transition-transform hover:-translate-y-px motion-reduce:transform-none motion-reduce:transition-none focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-white"
              @click="playing = true; $nextTick(() => $refs.v.play())"
              aria-label="{{ __('Play the Process and Warranty video', 'sage') }}"
            >
              <svg class="size-7" viewBox="0 0 28 28" fill="currentColor" aria-hidden="true">
                <path d="M10 7.2a1.2 1.2 0 0 1 1.8-1.04l9 5.8a1.2 1.2 0 0 1 0 2.08l-9 5.8A1.2 1.2 0 0 1 10 18.8z" />
              </svg>
            </button>
          @endif
        </div>

        <div class="absolute right-9 bottom-9 left-9 z-10" :class="playing && 'sr-only'">
          <h3 class="m-0 font-fraunces text-[30px] font-semibold leading-[1.1] text-white">Process &amp; Warranty</h3>
          <p class="mt-2.5 text-[15px] leading-[1.6] text-white/82" x-show="! playing">See how a Kögler mattress is made in Cleveland, TN, and what the warranty covers.</p>
        </div>

        @if ($videoUrl !== '')
          <video
            x-ref="v"
            x-show="playing"
            x-cloak
            class="absolute inset-0 h-full w-full bg-dark-blue object-cover"
            src="{{ $videoUrl }}"
            controls
            playsinline
            preload="none"
          ></video>
        @endif
      </div>
    </div>
  </div>
</section>
