{{--
  Who We Are — Leadership
  Optional. The client has not confirmed this section.
  There is no ACF or Blockstudio page-field pattern in this theme, so the
  list lives here. Set $people to [] to hide the heading and the grid.
  Swap [Name], [Title], and image_id for real people. $grayscale is off.
--}}
@php
    $grayscale = false;

    $people = [
        ['name' => '[Name]', 'title' => '[Title]', 'image_id' => 0],
        ['name' => '[Name]', 'title' => '[Title]', 'image_id' => 0],
        ['name' => '[Name]', 'title' => '[Title]', 'image_id' => 0],
        ['name' => '[Name]', 'title' => '[Title]', 'image_id' => 0],
    ];

    // The closing CTA is pt-0 when this section renders. Share the flag so the
    // CTA can add its own top padding when the list is empty.
    if (function_exists('view')) {
        view()->share('whoWeAreHasLeadership', $people !== []);
    }
@endphp

@if ($people)
  <section class="relative bg-white p-clamp-xl">
    <div class="container">
      <h2 class="mb-0 font-fraunces text-dark-blue">
        Leadership
      </h2>

      {{-- Theme base styles put discs and left padding on every ul. --}}
      <ul class="m-0 mt-14 grid list-none grid-cols-1 gap-6 p-0 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($people as $person)
          @php
              $portrait = '';
              $portraitId = (int) ($person['image_id'] ?? 0);

              if ($portraitId && function_exists('wp_attachment_is_image') && wp_attachment_is_image($portraitId)) {
                  $portrait = wp_get_attachment_image($portraitId, 'full', false, [
                      'class' => 'h-full w-full object-cover object-top',
                      'loading' => 'lazy',
                      'decoding' => 'async',
                      'alt' => sprintf(__('Portrait of %s', 'sage'), $person['name']),
                      'sizes' => '(min-width: 1024px) 307px, (min-width: 640px) calc((100vw - 72px) / 2), calc(100vw - 48px)',
                  ]);
              }
          @endphp
          <li>
            <div
              class="aspect-[4/5] w-full overflow-hidden rounded-3xl bg-light-blue {{ $grayscale ? 'grayscale' : '' }}"
              @unless ($portrait) aria-hidden="true" @endunless
            >
              @if ($portrait)
                {!! $portrait !!}
              @endif
            </div>
            <h3 class="mt-5 mb-1 text-dark-blue">
              {{ kogler_title_case($person['name']) }}
            </h3>
            <p class="mb-0 text-[length:var(--font-size-btn)] text-dark-blue/75">
              {{ $person['title'] }}
            </p>
          </li>
        @endforeach
      </ul>
    </div>
  </section>
@endif
