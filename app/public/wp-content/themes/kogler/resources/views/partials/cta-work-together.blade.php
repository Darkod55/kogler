{{--
  Shared closing CTA — Ready to work together?
  Contact Us: first published page at contact-us, then contact, else /contact-us/.
  Find a Distributor: published page at find-a-distributor, else /find-a-distributor/.
  Buttons use the shared .btn variants. Colour and size come from buttons.css.

  Defaults match Who We Are: a white section, with top padding only when
  Leadership did not render. Leadership shares whoWeAreHasLeadership.
  Pass $ctaBackground (a background utility) and $ctaPadTop (true or false)
  to override. Brand passes bg-light and false.
--}}
@php
    $ctaBackground = $ctaBackground ?? 'bg-white';

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

    $ctaTopClass = $ctaPadTop ? 'pt-clamp-xl' : 'pt-0';
@endphp
<section class="relative {{ $ctaBackground }} p-clamp-x {{ $ctaTopClass }} pb-clamp-xl">
  <div class="container">
    <div class="flex flex-wrap items-center justify-start gap-10 rounded-4xl bg-dark-blue px-7 py-12 text-white lg:justify-between lg:px-14 lg:py-20">
      <h2 class="lead mb-0 max-w-[640px] font-fraunces text-white">
        Ready to Work <em class="italic font-medium text-secondary">Together?</em>
      </h2>

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
