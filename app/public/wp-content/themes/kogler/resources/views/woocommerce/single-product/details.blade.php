{{--
  Product description + specification panel below the buy box.
--}}

@php
  defined('ABSPATH') || exit;

  global $product;

  if (! $product instanceof \WC_Product) {
    return;
  }

  $description = $product->get_description();
  $attributes = $product->get_attributes();
  $specRows = [];

  foreach ($attributes as $attribute) {
    if (! $attribute instanceof \WC_Product_Attribute) {
      continue;
    }

    if (! $attribute->get_visible()) {
      continue;
    }

    $name = $attribute->get_name();
    $label = wc_attribute_label($name);
    $values = [];

    if ($attribute->is_taxonomy()) {
      $terms = wc_get_product_terms($product->get_id(), $name, ['fields' => 'all']);
      foreach ($terms as $term) {
        if ($term instanceof \WP_Term) {
          $values[] = $term->name;
        }
      }
    } else {
      $values = array_map('trim', array_filter($attribute->get_options()));
    }

    if ($values === []) {
      continue;
    }

    $key = $attribute->is_taxonomy() ? $name : sanitize_title($name);

    $specRows[] = [
      'key' => $key,
      'attr' => 'attribute_' . sanitize_title($name),
      'label' => $label,
      'values' => $values,
      'value' => implode(', ', $values),
      'is_variation' => (bool) $attribute->get_variation(),
    ];
  }

  $dimensionLabels = [
    'width' => __('Width', 'sage'),
    'length' => __('Length', 'sage'),
    'height' => __('Height', 'sage'),
  ];
@endphp

<section class="mpx-product-details" aria-label="{{ __('Product details', 'sage') }}">
  <div class="mpx-product-details__grid">
    <div class="mpx-product-details__main">
      @if ($description !== '')
        <div class="mpx-product-details__description">
          <h2 class="mpx-product-details__heading">{{ __('Product Description', 'sage') }}</h2>
          <div class="mpx-product-details__content">
            {!! wc_format_content($description) !!}
          </div>
        </div>
      @endif

      <aside class="mpx-product-shipping" aria-labelledby="mpx-product-shipping-heading">
        <h2 id="mpx-product-shipping-heading" class="mpx-product-shipping__heading">
          {{ __('Shipping & Delivery', 'sage') }}
        </h2>
        <p class="mpx-product-shipping__text">
          {{ __('We make the buying process easy and hassle-free. Our products are shipped directly to your doorstep, carefully wrapped, and packaged for convenient handling. Whether you are across town or across the country, we offer nationwide delivery services.', 'sage') }}<br><br>
          {{ __('You can trust us to ensure that your order arrives safely and promptly, ready for you to enjoy on your next task or trip.', 'sage') }}
        </p>
      </aside>

      <aside class="mpx-product-warranty" aria-labelledby="mpx-product-warranty-heading">
        <h2 id="mpx-product-warranty-heading" class="mpx-product-warranty__heading">
          {{ __('Warranty & Returns', 'sage') }}
        </h2>
        <ul class="mpx-product-warranty__list">
          @foreach ([
            [
              'title' => __('Full Manufacturer Warranty', 'sage'),
              'text' => __('Covers defects in materials and workmanship.', 'sage'),
            ],
            [
              'title' => __('30-Day Sleep Trial', 'sage'),
              'text' => __('Try it on the road. Not satisfied? We’ll take it back.', 'sage'),
            ],
            [
              'title' => __('Fleet Coverage', 'sage'),
              'text' => __('Same warranty terms apply to bulk and contract orders.', 'sage'),
            ],
          ] as $item)
            <li class="mpx-product-warranty__item">
              <span class="mpx-product-warranty__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="20" height="20" focusable="false">
                  <circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.5" />
                  <path
                    d="M7.5 12.2l3 3 6-6"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                </svg>
              </span>
              <span class="mpx-product-warranty__copy">
                <strong class="mpx-product-warranty__label">{{ $item['title'] }}</strong>
                <span class="mpx-product-warranty__sep" aria-hidden="true"> — </span>
                <span class="mpx-product-warranty__text">{{ $item['text'] }}</span>
              </span>
            </li>
          @endforeach
        </ul>
      </aside>

      <section class="mpx-product-faq" aria-labelledby="mpx-product-faq-heading">
        <h2 id="mpx-product-faq-heading" class="mpx-product-faq__heading">
          {{ __('Frequently Asked Questions', 'sage') }}
        </h2>
        <div class="mpx-product-faq__list">
          @foreach ([
            [
              'question' => __('What sleeper cab sizes does this mattress fit?', 'sage'),
              'answer' => __('This mattress is offered in 32", 36", 38", and 42" widths — each 80" long and 7" thick — so you can match common sleeper cab bunks. Choose the size that fits your cab dimensions, or contact us if you need help confirming the right fit.', 'sage'),
            ],
            [
              'question' => __('Do you offer bulk pricing for fleets?', 'sage'),
              'answer' => __('Yes. Fleet and contract orders qualify for volume pricing, with the same warranty terms as individual purchases. Reach out to our team with your quantity and timeline and we’ll put together a quote.', 'sage'),
            ],
          ] as $index => $faq)
            @php
              $faqId = 'mpx-product-faq-' . ($index + 1);
            @endphp
            <div class="mpx-product-faq__item" x-data="{ open: false }">
              <button
                type="button"
                id="{{ $faqId }}-button"
                class="mpx-product-faq__question"
                :class="{ 'is-open': open }"
                :aria-expanded="open.toString()"
                aria-controls="{{ $faqId }}-panel"
                @click="open = ! open"
              >
                <span class="mpx-product-faq__question-text">{{ $faq['question'] }}</span>
                <span class="mpx-product-faq__icon" aria-hidden="true"></span>
              </button>
              <div
                id="{{ $faqId }}-panel"
                class="mpx-product-faq__panel"
                :class="{ 'is-open': open }"
                role="region"
                aria-labelledby="{{ $faqId }}-button"
                :inert="! open"
              >
                <div class="mpx-product-faq__answer">
                  <p>{{ $faq['answer'] }}</p>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </section>
    </div>

    @if ($specRows !== [])
      <div class="mpx-product-details__specs">
        <h2 class="mpx-product-details__heading">{{ __('Product Specification', 'sage') }}</h2>
        <dl class="mpx-product-specs" data-mpx-product-specs>
          @foreach ($specRows as $row)
            <div
              class="mpx-product-specs__row"
              data-mpx-spec="{{ $row['key'] }}"
              data-mpx-spec-attr="{{ $row['attr'] }}"
              data-mpx-spec-default="{{ $row['value'] }}"
              @if ($row['is_variation']) data-mpx-spec-variation="1" @endif
            >
              <dt class="mpx-product-specs__label">{{ $row['label'] }}</dt>
              <dd class="mpx-product-specs__value" data-mpx-spec-value>
                @foreach ($row['values'] as $part)
                  <span class="mpx-product-specs__option">{{ $part }}</span>
                @endforeach
              </dd>
            </div>
          @endforeach

          @foreach ($dimensionLabels as $dimKey => $dimLabel)
            <div
              class="mpx-product-specs__row mpx-product-specs__row--dimension"
              data-mpx-spec="{{ $dimKey }}"
              data-mpx-spec-dimension="1"
              hidden
            >
              <dt class="mpx-product-specs__label">{{ $dimLabel }}</dt>
              <dd class="mpx-product-specs__value" data-mpx-spec-value></dd>
            </div>
          @endforeach
        </dl>
      </div>
    @endif
  </div>
</section>
