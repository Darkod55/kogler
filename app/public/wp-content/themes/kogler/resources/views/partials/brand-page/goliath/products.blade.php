{{--
  Goliath Steel — ABS Assemblies & Air Brake Hoses.
  Part numbers live in App\Goliath\AbsCatalog, shared with the later Quick Reference.
  In-page offset is html scroll-padding-top (--site-chrome-height).
--}}
@php
    $products = \App\Goliath\AbsCatalog::products();
@endphp
<section id="products" class="relative bg-goliath-950 p-clamp-xl text-white">
  <div class="container">
    <h2 class="mb-0 font-fraunces text-white">
      ABS Assemblies &amp; <em class="italic font-medium text-goliath-silver">Air Brake Hoses</em>
    </h2>
    <p class="mt-[18px] mb-0 max-w-[640px] lead leading-[1.7] text-white/80">
      Heavy-duty air and electrical connections for tractor-trailer service.
    </p>

    <div class="mt-10 flex flex-col gap-10">
      @foreach ($products as $product)
        @include('partials.brand-page.goliath.product-card', ['product' => $product])
      @endforeach
    </div>
  </div>
</section>
