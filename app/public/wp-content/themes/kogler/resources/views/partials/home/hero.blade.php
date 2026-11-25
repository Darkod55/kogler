{{--
  Homepage hero. Sits under the site header. The capabilities row is the
  page content that follows. Title, intro, video and poster are ACF fields
  on the front page when that plugin is installed.
--}}
@php
    $line1 = \App\helpers()->pageField('hero_title_line_1', 'Sleep Better');
    $line2 = \App\helpers()->pageField('hero_title_line_2', 'Drive Safer.');
    $intro = \App\helpers()->pageField('hero_intro', 'Premium truck mattresses and heavy-duty parts from America’s trusted manufacturer. Serving 500+ fleets nationwide with next-day shipping.');

    $mediaUrl = static function ($value): string {
        if (is_array($value)) {
            if (! empty($value['url']) && is_string($value['url'])) {
                return $value['url'];
            }

            $id = (int) ($value['ID'] ?? $value['id'] ?? 0);

            if ($id > 0 && function_exists('wp_get_attachment_url')) {
                $url = wp_get_attachment_url($id);

                return is_string($url) ? $url : '';
            }
        }

        if (is_numeric($value) && function_exists('wp_get_attachment_url')) {
            $url = wp_get_attachment_url((int) $value);

            return is_string($url) ? $url : '';
        }

        return is_string($value) ? $value : '';
    };

    $videoUrl = function_exists('content_url')
        ? content_url('uploads/2026/11/kogler-new-video-homepage.mp4')
        : '';
    $posterUrl = function_exists('content_url')
        ? content_url('uploads/2026/11/kogler-new-video-homepage-cover.webp')
        : '';

    if (function_exists('get_field')) {
        $video = $mediaUrl(get_field('hero_video'));
        $poster = $mediaUrl(get_field('hero_video_poster'));

        if ($video !== '') {
            $videoUrl = $video;
        }

        if ($poster !== '') {
            $posterUrl = $poster;
        }
    }

    $shopUrl = function_exists('home_url') ? home_url('/shop/') : '/shop/';
@endphp
<section
  class="relative h-auto min-h-[600px] overflow-hidden bg-darker-blue text-white min-[641px]:h-[640px] min-[1025px]:h-[760px]"
  x-data="{ playing: ! window.matchMedia('(prefers-reduced-motion: reduce)').matches }"
  x-init="if (! playing && $refs.vid) { $refs.vid.pause() }"
>
  <div
    class="absolute inset-0 bg-darker-blue bg-cover bg-center"
    @if ($posterUrl !== '') style="background-image: url('{{ esc_url($posterUrl) }}')" @endif
  >
    @if ($videoUrl !== '')
      <video
        x-ref="vid"
        class="absolute inset-0 h-full w-full object-cover"
        src="{{ esc_url($videoUrl) }}"
        @if ($posterUrl !== '') poster="{{ esc_url($posterUrl) }}" @endif
        autoplay
        muted
        loop
        playsinline
        preload="metadata"
        aria-hidden="true"
        tabindex="-1"
      ></video>
    @endif
  </div>

  <div
    class="pointer-events-none absolute inset-0"
    aria-hidden="true"
    style="background: linear-gradient(180deg, color-mix(in srgb, var(--color-darker-blue) 35%, transparent) 0%, color-mix(in srgb, var(--color-darker-blue) 8%, transparent) 28%, color-mix(in srgb, var(--color-darker-blue) 78%, transparent) 42%, color-mix(in srgb, var(--color-darker-blue) 94%, transparent) 100%)"
  ></div>

  <div class="relative flex h-full flex-col justify-end px-clamp pb-16 min-[641px]:pb-[88px]">
    <div class="container">
      <div class="grid grid-cols-1 items-end gap-8 min-[1025px]:grid-cols-[1.5fr_1fr] min-[1025px]:gap-14">
        <h1 class="mb-0 font-fraunces text-[56px] font-semibold leading-[0.92] tracking-[-2.5px] text-white min-[400px]:text-[clamp(4rem,8.4vw,8.25rem)]">
          {{ $line1 }}<br>
          <em class="font-medium italic text-secondary">{{ $line2 }}</em>
        </h1>

        <div class="min-[1025px]:pb-2.5">
          <p class="mb-0 max-w-[440px] font-jakarta text-[length:var(--font-size-tagline)] leading-[1.65] text-white/90">
            {{ $intro }}
          </p>
          <div class="mt-7 flex flex-wrap items-center gap-6">
            <a
              class="inline-flex items-center justify-center rounded-full bg-white px-[30px] py-[17px] text-[length:var(--font-size-base)] font-bold text-dark-blue no-underline transition-transform duration-150 hover:-translate-y-px motion-reduce:transform-none motion-reduce:transition-none focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
              href="{{ $shopUrl }}"
            >Explore All Products</a>
            <button
              type="button"
              class="grid size-12 place-items-center rounded-full border-[1.5px] border-white/55 text-white hover:bg-white/10 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
              @click="if (! $refs.vid) return; playing ? $refs.vid.pause() : $refs.vid.play(); playing = ! playing"
              :aria-label="playing ? 'Pause background video' : 'Play background video'"
              :aria-pressed="(! playing).toString()"
            >
              <svg x-show="playing" class="size-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                <rect x="3" y="2" width="3.5" height="12" rx="1" />
                <rect x="9.5" y="2" width="3.5" height="12" rx="1" />
              </svg>
              <svg x-show="! playing" x-cloak class="size-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                <path d="M4.5 2.8a1 1 0 0 1 1.5-.86l7 4.2a1 1 0 0 1 0 1.72l-7 4.2A1 1 0 0 1 4.5 13.2z" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
