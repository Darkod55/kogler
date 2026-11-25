{{--
  Homepage contact. Last section before the footer.
  Phone, email, and address come from the footer contact details.
  Import docs/fluent-forms/homepage-quote.json, then set cta_form to that form’s ID.
  Phone is collected for the quote. No SMS opt-in until the client confirms texts are sent.
--}}
@php
    $title = \App\helpers()->pageField('cta_title', 'Ready to Experience the Difference?');
    $text = \App\helpers()->pageField('cta_text', 'Fill out the form and receive a detailed quote within 24 hours.');
    $words = preg_split('/\s+/u', trim($title), -1, PREG_SPLIT_NO_EMPTY) ?: [];
    $emWords = count($words) >= 2 ? array_splice($words, -2) : $words;
    $lead = implode(' ', $words);
    $emphasis = implode(' ', $emWords);

    $contact = \App\helpers()->siteContact();
    $formId = 0;

    if (function_exists('get_field')) {
        $chosen = get_field('cta_form');

        if (is_numeric($chosen)) {
            $formId = (int) $chosen;
        }
    }

    $formMarkup = '';

    if ($formId > 0 && function_exists('shortcode_exists') && shortcode_exists('fluentform')) {
        $formMarkup = do_shortcode('[fluentform id="' . $formId . '"]');
    }
@endphp
<section id="contact" class="bg-white px-clamp py-[120px]">
  <div class="container grid grid-cols-1 items-start gap-10 rounded-[22px] bg-dark-blue px-5 py-10 text-white min-[641px]:rounded-[28px] min-[641px]:px-8 min-[641px]:py-14 min-[981px]:grid-cols-[5fr_7fr] min-[981px]:gap-14 min-[981px]:px-14 min-[981px]:py-[72px]">
    <div class="min-w-0">
      <h2 class="mb-0 font-fraunces text-[clamp(36px,4vw,56px)] font-semibold leading-[1.04] tracking-[-0.8px] text-white">
        @if ($lead !== '')
          {{ $lead }}
        @endif
        @if ($emphasis !== '')
          <em class="font-medium italic text-secondary">{{ $emphasis }}</em>
        @endif
      </h2>
      @if ($text !== '')
        <p class="mt-5 mb-0 text-[18px] leading-[1.65] text-white/84">{{ $text }}</p>
      @endif

      <div class="lane-h lane-rule mt-10 h-[3px]" aria-hidden="true"></div>

      <ul class="m-0 mt-7 flex list-none flex-col gap-3.5 p-0 text-base">
        <li>
          <a class="font-semibold text-white no-underline hover:underline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-white" href="tel:{{ $contact['phone_tel'] }}">{{ $contact['phone_display'] }}</a>
        </li>
        <li>
          <a class="font-semibold text-white no-underline hover:underline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-white" href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a>
        </li>
        <li class="text-white/80">{{ $contact['address'] }}</li>
      </ul>
    </div>

    <div class="kg-form rounded-[20px] bg-white p-6 text-dark-blue min-[641px]:p-9">
      @if ($formMarkup !== '')
        {!! $formMarkup !!}
      @else
        <!-- Homepage quote form: import docs/fluent-forms/homepage-quote.json and set the cta_form field to its ID. -->
      @endif
    </div>
  </div>
</section>
