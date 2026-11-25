{{--
  Kögler Sleep — hero
  Set $logoId to the Media Library attachment ID of the white Kögler Sleep logo.
--}}
@php
    $logoId = 0;
    $sleepLogo = '';

    if ($logoId && function_exists('wp_attachment_is_image') && wp_attachment_is_image($logoId)) {
        $sleepLogo = wp_get_attachment_image($logoId, 'full', false, [
            'class' => 'h-auto w-full',
            'alt' => 'Kögler Sleep',
            'loading' => 'eager',
            'decoding' => 'async',
        ]);
    }

    $distributorUrl = \App\helpers()->pageUrlBySlug('find-a-distributor');
    $brandsUrl = function_exists('home_url') ? home_url('/our-brands/') : '#';

    if (function_exists('get_posts') && function_exists('get_permalink')) {
        $brandPages = get_posts([
            'post_type' => 'page',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'meta_key' => '_wp_page_template',
            'meta_value' => 'tpl-brand.blade.php',
            'orderby' => 'date',
            'order' => 'ASC',
        ]);

        if ($brandPages && $brandPages[0] instanceof \WP_Post) {
            $permalink = get_permalink($brandPages[0]);

            if (is_string($permalink) && $permalink !== '') {
                $brandsUrl = $permalink;
            }
        }
    }

    $heroButton = 'inline-flex items-center justify-center rounded-full text-center font-bold no-underline transition motion-safe:hover:-translate-y-px motion-reduce:transform-none focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white';

    $facts = [
        ['title' => 'Made in the USA', 'line' => 'Cleveland, Tennessee'],
        ['title' => 'Ships in 3–5 days', 'line' => 'Standard sizes, from TN & IL'],
        ['title' => 'Roll-packed & sealed', 'line' => 'Easy to store and carry'],
    ];
@endphp
<section class="bg-dark-blue px-clamp py-clamp-xl text-white">
  <div class="container">
    <div class="flex flex-wrap items-center justify-between gap-14">
      <div class="min-w-[min(100%,520px)] shrink grow basis-[520px]">
        <nav class="text-sm font-semibold" aria-label="{{ __('Breadcrumb', 'sage') }}">
          <a class="underline underline-offset-[3px] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white" href="{{ $brandsUrl }}">Our brands</a>
          <span aria-hidden="true"> / </span>
          Kögler Sleep
        </nav>

        <h1 class="mt-9 mb-0 font-fraunces text-[clamp(44px,5.6vw,80px)] font-semibold leading-[1.02] tracking-tight">
          Sleeper Cab <em class="italic font-medium text-light-blue">Mattresses</em>
        </h1>

        <p class="mt-7 mb-0 max-w-[560px] text-[length:var(--font-size-lead)] leading-[1.65] text-white/90">
          Innerspring and gel-infused foam mattresses, in cloth or wipeable covers, for every standard sleeper bunk.
        </p>

        <div class="mt-9 flex flex-wrap gap-3.5">
          <a class="{{ $heroButton }} bg-white px-[30px] py-4 text-(--site-accent-ink)" href="#find-your-size">Find Your Size</a>
          <a class="{{ $heroButton }} border-[1.5px] border-white/60 bg-transparent px-7 py-[14.5px] text-white" href="{{ $distributorUrl }}">Find a Distributor</a>
        </div>
      </div>

      @if ($sleepLogo)
        <div class="w-full max-w-[300px] shrink-0 min-[1000px]:ml-auto min-[1000px]:max-w-[420px]">
          {!! $sleepLogo !!}
        </div>
      @endif
    </div>

    <ul class="mt-16 grid list-none grid-cols-[repeat(auto-fit,minmax(240px,1fr))] gap-6 p-0">
      @foreach ($facts as $fact)
        <li class="border-t-2 border-light-blue pt-[18px]">
          <p class="mb-0 text-[length:var(--font-size-tagline)] font-bold">{{ $fact['title'] }}</p>
          <p class="mt-1 mb-0 text-[length:var(--font-size-btn)] text-white/90">{{ $fact['line'] }}</p>
        </li>
      @endforeach
    </ul>
  </div>
</section>
