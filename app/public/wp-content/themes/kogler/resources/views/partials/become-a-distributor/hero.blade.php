{{--
  Become a Distributor — hero
  No ACF. Benefits are edited in the array below.
  Find a Distributor URL: App\Helpers\Helpers::pageUrlBySlug(), same lookup as the shared CTA.
  The theme's only breadcrumb is the WooCommerce product trail, which uses
  <nav aria-label="Breadcrumb">. This back link uses that same label.
--}}
@php
    $distributorUrl = \App\Helpers\Helpers::instance()->pageUrlBySlug('find-a-distributor');

    $benefits = [
        'Three brands from one supplier: sleep, heavy-duty parts and RV/marine',
        'A dedicated point of contact',
        'Product information and images for your catalog and website',
        'Shipment tracking on every order',
        'Private label opportunities available',
    ];
@endphp
<section class="bg-dark-blue p-clamp-xl text-white">
  <div class="container">
    <div class="flex flex-wrap items-start gap-14">
      <div class="min-w-[min(100%,460px)] shrink grow basis-[460px]">
        <nav aria-label="{{ __('Breadcrumb', 'sage') }}">
          <a class="inline-flex items-center gap-2 text-sm font-semibold text-secondary no-underline hover:underline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-secondary" href="{{ $distributorUrl }}">
            <span aria-hidden="true">←</span> Find a Distributor
          </a>
        </nav>

        <h1 class="mt-6 mb-0 font-fraunces">
          Become a <em class="italic font-medium text-secondary">Distributor</em>
        </h1>

        <p class="mt-8 mb-0 max-w-[560px] lead leading-[1.7] text-white/85">
          We grow through our distribution partners. If you sell to fleets, repair shops, dealerships or RV and marine customers, our brands give you products your customers need at margins that work for your business.
        </p>
      </div>

      <div class="min-w-[min(100%,420px)] w-full shrink grow basis-[420px] lg:max-w-[520px]">
        <div class="rounded-3xl bg-white px-9 pt-9 pb-6 text-dark-blue">
          <h2 class="mb-2 text-dark-blue">What Partners Get</h2>

          <ul class="m-0 flex list-none flex-col p-0">
            @foreach ($benefits as $benefit)
              <li class="flex items-start gap-3.5 border-t border-dark-blue/10 py-3.5">
                <svg class="mt-0.5 size-[22px] flex-none text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <path d="M20 6 9 17l-5-5" />
                </svg>
                <span class="text-[length:var(--font-size-base)] leading-[1.55]">{{ $benefit }}</span>
              </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
