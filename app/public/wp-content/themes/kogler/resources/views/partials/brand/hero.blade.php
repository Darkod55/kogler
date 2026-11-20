{{--
  Brand — hero
  Jump targets #kogler, #goliath-steel, and #kogler-outdoor are later sections.
  Fraunces italic is synthesized; the theme only loads the roman face.
--}}
<section class="relative bg-dark-blue px-clamp pt-clamp-block-xl pb-clamp-block-xl text-left text-white">
  <div class="container">
    <h1 class="mb-0 font-fraunces text-[clamp(44px,6vw,84px)] font-semibold leading-[1.02] tracking-tight text-white">
      Our <em class="italic font-medium text-secondary">brands</em>
    </h1>

    <p class="mt-8 mb-0 max-w-[620px] text-[length:var(--font-size-lead)] leading-[1.65] text-white/85">
      At Kogler-USA we supply thousands of customers across the commercial truck, RV and marine markets through three brands: Kogler, Goliath Steel and Kogler Outdoor.
    </p>

    <nav class="mt-14" aria-label="{{ __('Brands on this page', 'sage') }}">
      <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <a class="group flex items-center justify-between gap-4 rounded-3xl border border-white/15 bg-white/[0.07] px-7 py-6 text-white no-underline transition hover:bg-white/[0.14] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-secondary motion-reduce:transform-none" href="#kogler">
          <span class="flex flex-col gap-1">
            <span class="text-[22px] font-extrabold tracking-tight">Kogler</span>
            <span class="text-sm text-white/75">{{ __('Sleeper mattresses', 'sage') }}</span>
          </span>
          <span class="text-[22px] text-secondary transition motion-safe:group-hover:translate-y-0.5 motion-reduce:transform-none" aria-hidden="true">↓</span>
        </a>

        <a class="group flex items-center justify-between gap-4 rounded-3xl border border-white/15 bg-white/[0.07] px-7 py-6 text-white no-underline transition hover:bg-white/[0.14] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-secondary motion-reduce:transform-none" href="#goliath-steel">
          <span class="flex flex-col gap-1">
            <span class="text-[22px] font-extrabold tracking-tight">Goliath Steel</span>
            <span class="text-sm text-white/75">{{ __('Product categories', 'sage') }}</span>
          </span>
          <span class="text-[22px] text-secondary transition motion-safe:group-hover:translate-y-0.5 motion-reduce:transform-none" aria-hidden="true">↓</span>
        </a>

        <a class="group flex items-center justify-between gap-4 rounded-3xl border border-white/15 bg-white/[0.07] px-7 py-6 text-white no-underline transition hover:bg-white/[0.14] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-secondary motion-reduce:transform-none" href="#kogler-outdoor">
          <span class="flex flex-col gap-1">
            <span class="text-[22px] font-extrabold tracking-tight">Kogler Outdoor</span>
            <span class="text-sm text-white/75">{{ __('Products', 'sage') }}</span>
          </span>
          <span class="text-[22px] text-secondary transition motion-safe:group-hover:translate-y-0.5 motion-reduce:transform-none" aria-hidden="true">↓</span>
        </a>
      </div>
    </nav>
  </div>
</section>
