{{--
  Kögler Sleep — Still Not Sure?
  Contact Sales stays a plain contact URL until a truck is chosen.
  The contact form is not pre-filled; that sentence is waiting on client sign-off.
--}}
@php
    $contactUrl = function_exists('home_url') ? home_url('/contact-us/') : '#';

    if (function_exists('get_page_by_path') && function_exists('get_permalink')) {
        foreach (['contact-us', 'contact'] as $contactSlug) {
            $contactPage = get_page_by_path($contactSlug);

            if ($contactPage instanceof \WP_Post) {
                $contactUrl = get_permalink($contactPage);
                break;
            }
        }
    }

    $distributorUrl = \App\helpers()->pageUrlBySlug('find-a-distributor');
    $ctaButton = 'inline-flex items-center justify-center rounded-full text-center text-[length:var(--font-size-base)] font-bold no-underline transition motion-safe:hover:-translate-y-px motion-reduce:transform-none focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white max-[400px]:w-full';
@endphp
<section id="still-not-sure" class="relative bg-white px-clamp pt-0 pb-clamp-block-xl">
  <div class="container">
    <div class="flex flex-wrap items-center justify-between gap-10 rounded-4xl bg-dark-blue px-7 py-12 text-white min-[1000px]:px-14 min-[1000px]:py-[72px]">
      <div class="min-w-0 w-full shrink grow basis-full min-[1000px]:max-w-[680px] min-[1000px]:basis-[480px]">
        <h2 class="mb-0 font-fraunces text-[clamp(36px,4.2vw,60px)] font-semibold leading-[1.05] tracking-tight">
          Still Not <em class="italic font-medium text-light-blue">Sure?</em>
        </h2>
        <p class="mt-[18px] mb-0 text-[length:var(--font-size-tagline)] leading-[1.7] text-white/90">
          Send us your truck's year, make, model, sleeper size and bunk measurements, and our team will match you to the right mattress.
        </p>
      </div>

      <div class="flex flex-wrap gap-3.5 max-[400px]:w-full">
        <a class="{{ $ctaButton }} bg-white px-8 py-[18px] text-dark-blue hover:bg-light-blue" href="{{ $distributorUrl }}">Find a Distributor</a>
        <a
          class="{{ $ctaButton }} border-[1.5px] border-white/60 bg-transparent px-[30px] py-[16.5px] text-white hover:border-white"
          href="{{ $contactUrl }}"
          :href="$store.fitment.contactHref({{ \Illuminate\Support\Js::from($contactUrl) }})"
        >Contact Sales</a>
      </div>
    </div>
  </div>
</section>
