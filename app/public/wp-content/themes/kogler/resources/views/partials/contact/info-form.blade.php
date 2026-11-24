{{--
  Contact — company info, map, and form.
  The footer and header hard-code contact details and do not share a settings
  source. Those strings also differ from this spec, so the values below are
  the signed-off copy. Do not invent a theme-options system for them.
  Fluent Form 4 is imported from docs/fluent-forms/contact.json.
  See docs/fluent-forms/contact-form-update.md.
--}}
@php
    $contact = [
        'phone_display' => '(855) 702-6636',
        'phone_tel' => '+18557026636',
        'email' => 'sales@kogler-usa.com',
        'address_lines' => [
            '939 W North Ave Suite 880',
            'Chicago, IL 60642',
        ],
    ];

    $addressQuery = implode(', ', $contact['address_lines']);
    $mapsUrl = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode($addressQuery);
    $mapsEmbed = 'https://maps.google.com/maps?q=' . rawurlencode($addressQuery) . '&output=embed';

    $formId = 4;
    $formMarkup = '';

    if ($formId && function_exists('shortcode_exists') && shortcode_exists('fluentform')) {
        $formMarkup = do_shortcode('[fluentform id="' . (int) $formId . '"]');
    }

    $linkClass = 'text-dark-blue no-underline hover:underline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary';
    $rowClass = 'flex items-start gap-4 border-t border-dark-blue/10 py-5';
@endphp
<section class="contact-section relative bg-light px-clamp py-clamp-xl" style="--da-error: #B42318;">
  <div class="container">
    <div class="flex flex-wrap items-start gap-6">
      <aside class="flex w-full min-w-0 max-w-none basis-full flex-col gap-4 min-[1000px]:max-w-[440px] min-[1000px]:grow min-[1000px]:shrink min-[1000px]:basis-[340px]" aria-labelledby="company-info">
        <div class="rounded-3xl bg-white p-9">
          <h2 id="company-info" class="mb-2 text-[22px] font-bold text-dark-blue">Company Info</h2>

          <dl class="m-0">
            <div class="{{ $rowClass }}">
              <span class="flex size-11 flex-none items-center justify-center rounded-xl bg-light-blue text-primary" aria-hidden="true">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                </svg>
              </span>
              <div>
                <dt class="text-[13px] font-semibold text-dark-blue/70">Phone</dt>
                <dd class="mt-1 ms-0">
                  <a class="{{ $linkClass }} text-[18px] font-bold" href="tel:{{ $contact['phone_tel'] }}">{{ $contact['phone_display'] }}</a>
                </dd>
              </div>
            </div>

            <div class="{{ $rowClass }}">
              <span class="flex size-11 flex-none items-center justify-center rounded-xl bg-light-blue text-primary" aria-hidden="true">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                  <rect width="20" height="16" x="2" y="4" rx="2" />
                  <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                </svg>
              </span>
              <div>
                <dt class="text-[13px] font-semibold text-dark-blue/70">Email</dt>
                <dd class="mt-1 ms-0">
                  <a class="{{ $linkClass }} text-[18px] font-bold" href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a>
                </dd>
              </div>
            </div>

            <div class="{{ $rowClass }} pb-1">
              <span class="flex size-11 flex-none items-center justify-center rounded-xl bg-light-blue text-primary" aria-hidden="true">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                  <circle cx="12" cy="10" r="3" />
                </svg>
              </span>
              <div>
                <dt class="text-[13px] font-semibold text-dark-blue/70">Headquarters</dt>
                <dd class="mt-1 ms-0 text-[17px] font-semibold leading-normal text-dark-blue">
                  <a class="{{ $linkClass }} text-[17px] font-semibold leading-normal" href="{{ $mapsUrl }}" target="_blank" rel="noopener">
                    {{ $contact['address_lines'][0] }}<br>
                    {{ $contact['address_lines'][1] }}<span class="sr-only"> {{ __('(opens in a new tab)', 'sage') }}</span>
                  </a>
                </dd>
              </div>
            </div>
          </dl>
        </div>

        <div class="h-[260px] w-full overflow-hidden rounded-3xl bg-light-blue">
          <iframe class="block h-full w-full border-0" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="{{ __('Map showing Kogler headquarters, 939 W North Ave, Chicago', 'sage') }}" src="{{ $mapsEmbed }}"></iframe>
        </div>
      </aside>

      <div class="min-w-0 w-full basis-full min-[1000px]:shrink min-[1000px]:grow-[999] min-[1000px]:basis-[560px]">
        <div class="rounded-4xl bg-white p-7 md:p-12">
          <h2 class="sr-only">Contact Form</h2>
          @if ($formMarkup)
            {!! $formMarkup !!}
          @else
            {!! '<!-- Fluent Forms is not connected. Import docs/fluent-forms/contact.json as form 4. See docs/fluent-forms/contact-form-update.md. -->' !!}
          @endif
        </div>
      </div>
    </div>
  </div>
</section>
