{{--
  Goliath Steel — Private Label Programs Available.
  Set $imageId to the Media Library attachment of the retail box photo.
  Contact Sales is a plain contact link. The private-label form sentence
  is waiting on client sign-off, so the URL is not pre-filled.
--}}
@php
    $imageId = 415;
    $boxImage = '';

    if ($imageId && function_exists('wp_attachment_is_image') && wp_attachment_is_image($imageId)) {
        $rendered = wp_get_attachment_image($imageId, 'full', false, [
            'class' => 'aspect-[4/3] w-full rounded-[20px] object-cover',
            'alt' => 'Goliath Steel 3-in-1 air power line retail box',
            'loading' => 'lazy',
            'decoding' => 'async',
            'sizes' => '(min-width: 1000px) 520px, calc(100vw - 48px)',
        ]);
        $boxImage = is_string($rendered) ? $rendered : '';
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
@endphp
<section id="private-label" class="relative bg-goliath-900 p-clamp-xl text-white">
  <div class="container">
    <div class="flex flex-wrap items-center gap-12 rounded-t-lg rounded-b-[28px] border-t-4 border-goliath-green bg-goliath-800 p-7 min-[1000px]:p-14">
      <div class="min-w-[min(100%,460px)] shrink grow basis-[460px]">
        <h2 class="mb-0 font-fraunces text-white">
          Private Label Programs <em class="italic font-medium text-goliath-silver">Available</em>
        </h2>
        <p class="mt-5 mb-0 max-w-[520px] lead leading-[1.7] text-white/80">
          Your brand on our 3-in-1 assemblies, 7-way cables and air brake hoses, with full brand customization.
        </p>
        <p class="mt-3.5 mb-0 lead font-bold text-white">
          Ask your Kogler USA sales representative for details.
        </p>
        <a class="btn mt-7 bg-white text-goliath-900 hover:bg-goliath-chrome max-[400px]:w-full" href="{{ $contactUrl }}">Contact Sales</a>
      </div>

      <div class="min-w-0 w-full max-w-none shrink grow basis-full min-[1000px]:max-w-[520px] min-[1000px]:basis-[380px]">
        @if ($boxImage !== '')
          {!! $boxImage !!}
        @else
          <div class="aspect-[4/3] w-full rounded-[20px] bg-goliath-900" aria-hidden="true"></div>
        @endif
      </div>
    </div>
  </div>
</section>
