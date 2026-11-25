{{--
  Shared closing CTA — Ready to work together?
  Contact Us: first published page at contact-us, then contact, else /contact-us/.
  Find a Distributor: published page at find-a-distributor, else /find-a-distributor/.
  Buttons use the shared .btn variants. Colour and size come from buttons.css.

  Defaults match Who We Are: a white section, with top padding only when
  Leadership did not render. Leadership shares whoWeAreHasLeadership.
  Pass $ctaBackground (a background utility) and $ctaPadTop (true or false)
  to override. Brand passes bg-light and false.

  Goliath Steel passes $ctaVariant "goliath", plus $ctaId, $ctaLogo, and
  $ctaPhoto. That variant keeps this headline and the same two page links,
  with the logo, the gloves photo, and the brand buttons.

  Kögler Outdoor passes $ctaVariant "outdoor", plus $ctaId and $ctaLogo.
  Shop on Amazon is hidden while the Customizer URL is empty. Find a
  Distributor is the amber button in that case.
--}}
@php
    $ctaBackground = $ctaBackground ?? 'bg-white';
    $ctaVariant = $ctaVariant ?? 'default';
    $ctaId = $ctaId ?? '';
    $ctaLogo = $ctaLogo ?? '';
    $ctaPhoto = $ctaPhoto ?? '';
    $ctaIntro = $ctaIntro ?? '';

    if (! isset($ctaPadTop)) {
        $leadershipVisible = true;

        if (function_exists('view')) {
            $sharedLeadership = view()->shared('whoWeAreHasLeadership', null);

            if ($sharedLeadership !== null) {
                $leadershipVisible = (bool) $sharedLeadership;
            }
        }

        $ctaPadTop = ! $leadershipVisible;
    }

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

    $distributorUrl = \App\Helpers\Helpers::instance()->pageUrlBySlug('find-a-distributor');
    $amazonUrl = $ctaVariant === 'outdoor' ? \App\helpers()->outdoorAmazonUrl() : '';

    $ctaTopClass = $ctaPadTop ? 'pt-clamp-xl' : 'pt-0';
@endphp
@if ($ctaVariant === 'outdoor')
<section @if ($ctaId !== '') id="{{ $ctaId }}" @endif class="relative {{ $ctaBackground }} px-clamp {{ $ctaTopClass }} pb-clamp-xl text-white">
  <div class="container">
    <div class="flex flex-wrap items-center justify-between gap-10 rounded-t-lg rounded-b-[32px] border-t-4 border-outdoor-amber bg-outdoor-950 px-7 py-12 min-[1000px]:px-14 min-[1000px]:py-[72px]">
      <div class="min-w-0 shrink grow basis-full min-[1000px]:basis-[420px]">
        @if ($ctaLogo !== '')
          {!! $ctaLogo !!}
        @endif

        <h2 class="lead mt-7 mb-0 font-fraunces tracking-tight text-white">
          Ready to Work <em class="italic font-medium text-outdoor-amber">Together?</em>
        </h2>
      </div>

      <div class="flex flex-wrap gap-3.5 max-[400px]:w-full">
        @if ($amazonUrl !== '')
          <a class="btn btn-primary max-[400px]:w-full" href="{{ $amazonUrl }}" target="_blank" rel="noopener">
            Shop on Amazon<span class="sr-only"> (opens in a new tab)</span>
          </a>
          <a class="btn btn-brand-outline max-[400px]:w-full" href="{{ $distributorUrl }}">Find a Distributor</a>
        @else
          <a class="btn btn-primary max-[400px]:w-full" href="{{ $distributorUrl }}">Find a Distributor</a>
        @endif
        <a class="btn btn-brand-outline max-[400px]:w-full" href="{{ $contactUrl }}">Contact Us</a>
      </div>
    </div>
  </div>
</section>
@elseif ($ctaVariant === 'goliath')
<section @if ($ctaId !== '') id="{{ $ctaId }}" @endif class="relative {{ $ctaBackground }} px-clamp {{ $ctaTopClass }} pb-clamp-xl text-white">
  <div class="container">
    <div class="flex flex-wrap items-stretch overflow-hidden rounded-t-lg rounded-b-[32px] border-t-4 border-goliath-green bg-goliath-950">
      <div class="flex min-w-0 shrink grow basis-full flex-col justify-center gap-7 px-7 py-12 min-[1000px]:basis-[520px] min-[1000px]:px-14 min-[1000px]:py-16">
        @if ($ctaLogo !== '')
          {!! $ctaLogo !!}
        @endif

        <h2 class="lead mb-0 font-fraunces tracking-tight text-white">
          Ready to Work <em class="italic font-medium text-goliath-silver">Together?</em>
        </h2>

        <div class="flex flex-wrap gap-3.5 max-[400px]:w-full">
          <a class="btn btn-primary max-[400px]:w-full" href="{{ $distributorUrl }}">Find a Distributor</a>
          <a class="btn btn-brand-outline max-[400px]:w-full" href="{{ $contactUrl }}">Contact Sales</a>
        </div>
      </div>

      @if ($ctaPhoto !== '')
        {!! $ctaPhoto !!}
      @endif
    </div>
  </div>
</section>
@else
<section class="relative {{ $ctaBackground }} p-clamp-x {{ $ctaTopClass }} pb-clamp-xl">
  <div class="container">
    <div class="flex flex-wrap items-center justify-start gap-10 rounded-4xl bg-dark-blue px-7 py-12 text-white lg:justify-between lg:px-14 lg:py-20">
      <div class="min-w-0 max-w-[640px]">
        <h2 class="lead mb-0 font-fraunces text-white">
          Ready to Work <em class="italic font-medium text-secondary">Together?</em>
        </h2>
        @if ($ctaIntro !== '')
          <p class="mt-[18px] mb-0 text-[length:var(--font-size-lead)] leading-[1.6] text-white/80">{{ $ctaIntro }}</p>
        @endif
      </div>

      <div class="flex flex-wrap gap-3.5 max-[400px]:w-full">
        <a class="btn btn-secondary max-[400px]:w-full" href="{{ $contactUrl }}">
          {{ __('Contact Us', 'sage') }}
        </a>
        <a class="btn btn-brand-outline max-[400px]:w-full" href="{{ $distributorUrl }}">
          {{ __('Find a Distributor', 'sage') }}
        </a>
      </div>
    </div>
  </div>
</section>
@endif
