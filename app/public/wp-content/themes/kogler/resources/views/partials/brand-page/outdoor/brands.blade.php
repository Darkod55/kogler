{{--
  Kögler Outdoor — One Company. Three Brands.
  Made in the USA and Quality copy comes from App\Content\CompanyStory,
  the same source as the Who We Are page.
  Set $showMadeInUsa to false if Outdoor products are not made in Cleveland, TN.
  Sister brands are partials/brand-page/other-brands.blade.php.
  In-page offset is html scroll-padding-top (--site-chrome-height).
--}}
@php
    $showMadeInUsa = true;
    $madeInUsa = \App\Content\CompanyStory::madeInUsa();
    $quality = \App\Content\CompanyStory::quality();
@endphp
<section id="one-company" class="relative bg-outdoor-900 px-clamp py-clamp-xl text-white">
  <div class="container">
    <h2 class="mb-0 max-w-[860px] font-fraunces tracking-tight text-white">
      One Company. Three Brands. <em class="italic font-medium text-outdoor-amber">Built for the People Who Keep America Moving.</em>
    </h2>

    <div class="mt-12 grid grid-cols-1 gap-5 md:grid-cols-2">
      @if ($showMadeInUsa)
        <article class="rounded-3xl bg-outdoor-950 p-9">
          <p class="mb-0 flex flex-wrap items-baseline gap-3">
            <span class="font-fraunces text-[64px] font-semibold leading-none text-outdoor-amber">{{ $madeInUsa['stat'] }}</span>
            <span class="text-sm whitespace-nowrap text-white/80">{{ $madeInUsa['stat_line'] }}</span>
          </p>
          <h3 class="mt-[18px] mb-2 text-white">{{ $madeInUsa['title'] }}</h3>
          <p class="mb-0 text-[length:var(--font-size-base)] leading-[1.65] text-white/80">{{ $madeInUsa['text'] }}</p>
        </article>
      @endif

      <article class="rounded-3xl bg-outdoor-950 p-9">
        <div class="flex size-[52px] items-center justify-center rounded-[14px] bg-outdoor-amber/15 text-outdoor-amber">
          <svg class="size-[26px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
            <path d="m9 12 2 2 4-4" />
          </svg>
        </div>
        <h3 class="mt-[18px] mb-2 text-white">{{ $quality['title'] }}</h3>
        <p class="mb-0 text-[length:var(--font-size-base)] leading-[1.65] text-white/80">{{ $quality['text'] }}</p>
      </article>
    </div>

    @include('partials.brand-page.other-brands', ['currentBrand' => 'kogler-outdoor'])
  </div>
</section>
