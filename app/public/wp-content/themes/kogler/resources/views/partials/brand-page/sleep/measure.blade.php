{{--
  Kögler Sleep — How to Measure Your Bunk.
  Intro and steps are edited in the arrays below. The theme has no ACF.
  The follow-up line back to the Size Finder is waiting on client sign-off.
--}}
@php
    $measureIntro = 'Sleepers vary by model year and options, so a quick measurement is the surest way to get the right fit.';

    $steps = [
        [
            'title' => 'Remove the Old Mattress',
            'text' => 'Measure the bare bunk platform, not the mattress.',
            'icon' => 'bed',
        ],
        [
            'title' => 'Measure the Width',
            'text' => 'Wall to the inside edge of the bunk, at both the head and the foot.',
            'icon' => 'width',
        ],
        [
            'title' => 'Measure the Length',
            'text' => 'Head to foot along the wall side and the open side.',
            'icon' => 'length',
        ],
        [
            'title' => 'Check the Clearance',
            'text' => 'Note the space above the platform, especially on upper bunks, to make sure a 7" mattress fits.',
            'icon' => 'clearance',
        ],
    ];
@endphp
<section id="measure" class="relative bg-light p-clamp-xl">
  <div class="container">
    <h2 class="mb-0 font-fraunces text-dark-blue">
      How to Measure <em class="italic font-medium text-darker-blue">Your Bunk</em>
    </h2>
    <p class="mt-[18px] mb-0 max-w-[640px] lead leading-[1.7] text-(--site-ink)/80">{{ $measureIntro }}</p>

    <ol class="mt-10 grid list-none grid-cols-1 gap-5 p-0 sm:grid-cols-2 lg:grid-cols-4">
      @foreach ($steps as $index => $step)
        <li class="flex flex-col rounded-3xl bg-white p-8">
          <svg class="size-7 text-dark-blue" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            @if ($step['icon'] === 'bed')
              <path d="M2 4v16" />
              <path d="M2 8h18a2 2 0 0 1 2 2v10" />
              <path d="M2 17h20" />
              <path d="M6 8v9" />
            @elseif ($step['icon'] === 'width')
              <path d="m18 8 4 4-4 4" />
              <path d="M2 12h20" />
              <path d="m6 8-4 4 4 4" />
            @elseif ($step['icon'] === 'length')
              <path d="M12 2v20" />
              <path d="m8 18 4 4 4-4" />
              <path d="m8 6 4-4 4 4" />
            @else
              <path d="M5 3h14" />
              <path d="m18 13-6-6-6 6" />
              <path d="M12 7v14" />
            @endif
          </svg>
          <span class="mt-4 font-fraunces text-[48px] leading-none font-semibold text-dark-blue" aria-hidden="true">{{ $index + 1 }}</span>
          <h3 class="mt-5 mb-2 text-dark-blue">{{ $step['title'] }}</h3>
          <p class="mb-0 text-[length:var(--font-size-btn)] leading-[1.6] text-(--site-ink)/80">{{ $step['text'] }}</p>
        </li>
      @endforeach
    </ol>
  </div>
</section>
