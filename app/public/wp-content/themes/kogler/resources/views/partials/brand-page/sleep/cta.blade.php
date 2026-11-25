{{-- Still Not Sure? Panel layout follows in a later prompt. --}}
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
    $ctaButton = 'inline-flex items-center justify-center rounded-full text-center font-bold no-underline transition motion-safe:hover:-translate-y-px motion-reduce:transform-none focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white';
@endphp
<section class="bg-white px-clamp py-clamp-xl">
  <div class="container">
    <div class="flex flex-wrap items-center justify-between gap-8 rounded-4xl bg-dark-blue px-7 py-12 text-white lg:px-14">
      <h2 class="mb-0 font-fraunces text-[clamp(34px,3.8vw,54px)] font-semibold leading-[1.08]">Still Not Sure?</h2>

      <div class="flex flex-wrap gap-3.5">
        <a class="{{ $ctaButton }} border-[1.5px] border-white/60 bg-transparent px-7 py-[14.5px] text-white" href="{{ $distributorUrl }}">Find a Distributor</a>
        <a class="{{ $ctaButton }} bg-white px-[30px] py-4 text-(--site-accent-ink)" href="{{ $contactUrl }}">Contact Sales</a>
      </div>
    </div>
  </div>
</section>
