{{--
  Who We Are — We log the HOURS
  Fraunces is loaded as font-style: normal only, so the HOURS italic is synthesized.
--}}
@php
    $hoursValues = [
        [
            'letter' => 'H',
            'name' => 'Honesty',
            'text' => 'We tell the truth, keep our word, and do the right thing even if it costs us.',
        ],
        [
            'letter' => 'O',
            'name' => 'Ownership',
            'text' => 'Every order, commitment, and problem is ours until it\'s solved.',
        ],
        [
            'letter' => 'U',
            'name' => 'Urgency',
            'text' => 'Downtime costs customers money, so we move fast and follow through.',
        ],
        [
            'letter' => 'R',
            'name' => 'Raise the Bar',
            'text' => 'Good enough never is. We keep improving our products, our processes and ourselves.',
        ],
        [
            'letter' => 'S',
            'name' => 'Service',
            'text' => 'We treat every customer like they\'re our only one, because their success is how we measure ours.',
        ],
    ];
@endphp
<section class="relative bg-light p-clamp-xl">
  <div class="container">
    <h2 class="lead mx-auto mb-0 max-w-[760px] text-center font-fraunces text-dark-blue">
      We Log the <span class="italic text-primary">HOURS</span>
    </h2>

    {{-- Theme base styles put discs and left padding on every ul. --}}
    <ul class="m-0 mt-[72px] grid list-none grid-cols-1 divide-y divide-dark-blue/10 overflow-hidden rounded-3xl bg-white p-0 lg:grid-cols-5 lg:divide-x lg:divide-y-0">
      @foreach ($hoursValues as $value)
        <li class="px-[30px] pt-10 pb-11 md:flex md:items-start md:gap-6 lg:block">
          <div class="font-fraunces text-[clamp(72px,8vw,112px)] font-bold leading-[0.9] text-dark-blue" aria-hidden="true">
            {{ $value['letter'] }}
          </div>
          <div class="min-w-0">
            <h3 class="mt-6 mb-3 text-dark-blue md:mt-0 lg:mt-6">
              {{ kogler_title_case($value['name']) }}
            </h3>
            <p class="mb-0 text-[length:var(--font-size-btn)] leading-[1.65] text-dark-blue/75">
              {{ $value['text'] }}
            </p>
          </div>
        </li>
      @endforeach
    </ul>
  </div>
</section>
