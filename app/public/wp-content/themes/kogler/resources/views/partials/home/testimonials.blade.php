{{--
  Homepage testimonials. Sits directly after Our Services.
  Michael R. is the published quote. The other two are samples so the
  previous/next controls can be checked. Replace them with real quotes.
--}}
@php
    $testimonials = [
        [
            'quote' => 'Finally, a mattress that actually fits my sleeper cab. It’s comfortable, supportive, and made a huge difference on long hauls.',
            'name' => 'Michael R.',
            'role' => 'Owner-Operator',
        ],
        [
            'quote' => 'Sample quote. Short enough to show the slide height staying put.',
            'name' => 'Sample Name',
            'role' => 'Sample role',
        ],
        [
            'quote' => 'Sample quote. This one runs longer so the next and previous controls can be checked without the page jumping when the quote changes length. Replace this with a real driver quote before launch.',
            'name' => 'Sample Name',
            'role' => 'Sample role',
        ],
    ];

    if (function_exists('get_field')) {
        $saved = get_field('testimonials');
        $rows = [];

        if (is_array($saved)) {
            foreach ($saved as $row) {
                if (! is_array($row)) {
                    continue;
                }

                $quote = trim((string) ($row['quote'] ?? ''));
                $name = trim((string) ($row['name'] ?? ''));
                $role = trim((string) ($row['role'] ?? ''));
                $quote = trim($quote, "\"“”‘’");

                if ($quote === '') {
                    continue;
                }

                $rows[] = [
                    'quote' => $quote,
                    'name' => $name,
                    'role' => $role,
                ];
            }
        }

        if ($rows !== []) {
            $testimonials = $rows;
        }
    }

    $count = count($testimonials);
    $carousel = $count > 1;
@endphp
<section
  class="bg-light px-clamp py-[120px]"
  @if ($carousel)
    aria-roledescription="carousel"
    aria-label="{{ __('Testimonials', 'sage') }}"
    x-data="testimonials({{ $count }})"
    @keydown.left.prevent="prev()"
    @keydown.right.prevent="next()"
  @endif
>
  <div class="container">
    <div class="flex flex-wrap items-end justify-between gap-6">
      <h2 class="mb-0 font-fraunces text-[clamp(34px,3.6vw,52px)] font-semibold leading-[1.05] tracking-[-0.8px] text-dark-blue">
        What Drivers Say About Us
      </h2>
      @if ($carousel)
        <div class="flex items-center gap-3">
          <span aria-hidden="true" class="min-w-14 text-center text-[15px] font-semibold text-dark-blue" x-text="label()"></span>
          <button
            type="button"
            class="grid size-[52px] place-items-center rounded-full border-[1.5px] border-dark-blue bg-transparent text-dark-blue transition-colors hover:bg-dark-blue hover:text-white focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-dark-blue"
            @click="prev()"
            aria-label="{{ __('Previous testimonial', 'sage') }}"
          >
            <svg class="size-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M12.5 4.5 7 10l5.5 5.5" />
            </svg>
          </button>
          <button
            type="button"
            class="grid size-[52px] place-items-center rounded-full border-[1.5px] border-dark-blue bg-transparent text-dark-blue transition-colors hover:bg-dark-blue hover:text-white focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-dark-blue"
            @click="next()"
            aria-label="{{ __('Next testimonial', 'sage') }}"
          >
            <svg class="size-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M7.5 4.5 13 10l-5.5 5.5" />
            </svg>
          </button>
        </div>
      @endif
    </div>

    <div class="mt-16 grid" @if ($carousel) aria-live="polite" @endif>
      @foreach ($testimonials as $index => $item)
        <figure
          class="col-start-1 row-start-1 m-0 flex h-full items-stretch gap-10 transition-opacity duration-[250ms] motion-reduce:transition-none max-[720px]:gap-6 {{ $index > 0 ? 'invisible' : '' }}"
          @if ($carousel)
            role="group"
            aria-roledescription="slide"
            :aria-label="`{{ $index + 1 }} of ${count}`"
            :aria-hidden="active !== {{ $index }}"
            :class="active === {{ $index }} ? 'visible opacity-100' : 'invisible opacity-0'"
          @endif
        >
          <div class="lane-v lane-primary w-[3px] shrink-0 self-stretch" aria-hidden="true"></div>
          <div class="flex h-full max-w-[1000px] min-w-0 flex-1 flex-col">
            <blockquote class="m-0 font-fraunces text-[clamp(22px,2.2vw,32px)] font-medium leading-[1.35] tracking-[-0.3px] text-dark-blue">
              <p class="m-0">“{{ $item['quote'] }}”</p>
            </blockquote>
            <figcaption class="mt-auto pt-8 text-base text-dark-blue">
              @if ($item['name'] !== '')
                <strong class="font-bold">{{ $item['name'] }}</strong>
              @endif
              @if ($item['role'] !== '')
                <span class="text-dark-blue/70">@if ($item['name'] !== '') · @endif{{ $item['role'] }}</span>
              @endif
            </figcaption>
          </div>
        </figure>
      @endforeach
    </div>
  </div>
</section>
