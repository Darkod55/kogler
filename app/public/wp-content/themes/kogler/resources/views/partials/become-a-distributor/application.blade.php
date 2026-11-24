{{--
  Become a Distributor — application form.
  The form is Fluent Forms ID 3.
  No ACF. A missing [fluentform] shortcode prints an HTML comment only.
--}}
@php
    $formId = 3;
    $formMarkup = '';

    if ($formId && function_exists('shortcode_exists') && shortcode_exists('fluentform')) {
        $formMarkup = do_shortcode('[fluentform id="' . (int) $formId . '"]');
    }
@endphp
<section
  id="apply"
  class="distributor-application relative bg-light px-clamp py-clamp-xl"
  style="--da-error: #B42318;"
>
  <div class="container">
    <div class="mx-auto max-w-[920px] rounded-4xl bg-white p-7 shadow-xl md:p-14">
      <h2 class="sr-only">Application Form</h2>
      @if ($formMarkup)
        {!! $formMarkup !!}
      @else
        {!! '<!-- Fluent Forms is not connected. Import docs/fluent-forms/become-a-distributor.json, then set $formId in resources/views/partials/become-a-distributor/application.blade.php. -->' !!}
      @endif
    </div>
  </div>
</section>
