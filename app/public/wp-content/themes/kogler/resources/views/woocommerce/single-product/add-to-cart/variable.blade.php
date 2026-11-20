{{--
  Variable product add to cart — pill attribute UI synced to hidden selects.
  @see https://woocommerce.com/document/template-structure/
  @version 10.9.0
--}}

@php
  defined('ABSPATH') || exit;

  global $product;

  $attribute_keys = array_keys($attributes);
  $variations_json = wp_json_encode($available_variations);
  $variations_attr = function_exists('wc_esc_json')
    ? wc_esc_json($variations_json)
    : _wp_specialchars($variations_json, ENT_QUOTES, 'UTF-8', true);

  do_action('woocommerce_before_add_to_cart_form');
@endphp

<form
  class="variations_form cart mpx-variations-form"
  action="{{ esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())) }}"
  method="post"
  enctype="multipart/form-data"
  data-product_id="{{ absint($product->get_id()) }}"
  data-product_variations="{!! $variations_attr !!}"
>
  @php do_action('woocommerce_before_variations_form'); @endphp

  @if (empty($available_variations) && false !== $available_variations)
    <p class="stock out-of-stock">
      {{ apply_filters('woocommerce_out_of_stock_message', __('This product is currently out of stock and unavailable.', 'woocommerce')) }}
    </p>
  @else
    <div class="variations mpx-variations" role="presentation">
      @foreach ($attributes as $attribute_name => $options)
        @php
          $sanitized = sanitize_title($attribute_name);
          $selected = isset($_REQUEST['attribute_' . $sanitized])
            ? wc_clean(wp_unslash($_REQUEST['attribute_' . $sanitized]))
            : $product->get_variation_default_attribute($attribute_name);

          // Preselect first available option so ATC is usable on first paint.
          if ($selected === '' && ! empty($options)) {
            $selected = taxonomy_exists($attribute_name)
              ? (string) reset($options)
              : (string) $options[array_key_first($options)];
          }

          $label = wc_attribute_label($attribute_name);
          $terms = [];

          if ($product && taxonomy_exists($attribute_name)) {
            $terms = wc_get_product_terms(
              $product->get_id(),
              $attribute_name,
              ['fields' => 'all']
            );
          }

          $selected_label = '';
          if ($selected !== '') {
            if (taxonomy_exists($attribute_name)) {
              $term = get_term_by('slug', $selected, $attribute_name);
              $selected_label = $term ? $term->name : $selected;
            } else {
              $selected_label = (string) $selected;
            }
          }
        @endphp

        <div class="mpx-variation" data-attribute="{{ $sanitized }}">
          <div class="mpx-variation__heading">
            <span class="mpx-variation__label">{{ $label }} :</span>
            <span class="mpx-variation__selected" data-mpx-selected-label aria-live="polite">{{ $selected_label }}</span>
          </div>

          <div class="mpx-variation__pills" role="listbox" aria-label="{{ $label }}">
            @if (! empty($options))
              @if ($product && taxonomy_exists($attribute_name))
                @foreach ($terms as $term)
                  @if (in_array($term->slug, $options, true))
                    <button
                      type="button"
                      class="mpx-variation__pill{{ $selected === $term->slug ? ' is-selected' : '' }}"
                      role="option"
                      aria-selected="{{ $selected === $term->slug ? 'true' : 'false' }}"
                      data-value="{{ $term->slug }}"
                      data-label="{{ $term->name }}"
                    >
                      {{ $term->name }}
                    </button>
                  @endif
                @endforeach
              @else
                @foreach ($options as $option)
                  <button
                    type="button"
                    class="mpx-variation__pill{{ sanitize_title($selected) === sanitize_title($option) ? ' is-selected' : '' }}"
                    role="option"
                    aria-selected="{{ sanitize_title($selected) === sanitize_title($option) ? 'true' : 'false' }}"
                    data-value="{{ $option }}"
                    data-label="{{ $option }}"
                  >
                    {{ $option }}
                  </button>
                @endforeach
              @endif
            @endif
          </div>

          <div class="mpx-variation__select-wrap" aria-hidden="true">
            @php
              wc_dropdown_variation_attribute_options([
                'options' => $options,
                'attribute' => $attribute_name,
                'product' => $product,
                'selected' => $selected,
                'class' => 'mpx-variation__select',
              ]);
            @endphp
          </div>

          @if (end($attribute_keys) === $attribute_name)
            {!! wp_kses_post(apply_filters(
              'woocommerce_reset_variations_link',
              '<a class="reset_variations" href="#" aria-label="' . esc_attr__('Clear options', 'woocommerce') . '">' . esc_html__('Clear', 'woocommerce') . '</a>'
            )) !!}
          @endif
        </div>
      @endforeach
    </div>

    <div class="reset_variations_alert screen-reader-text" role="alert" aria-live="polite" aria-relevant="all"></div>

    @php do_action('woocommerce_after_variations_table'); @endphp

    <div class="single_variation_wrap">
      @php
        do_action('woocommerce_before_single_variation');
        do_action('woocommerce_single_variation');
        do_action('woocommerce_after_single_variation');
      @endphp
    </div>
  @endif

  @php do_action('woocommerce_after_variations_form'); @endphp
</form>

@php do_action('woocommerce_after_add_to_cart_form'); @endphp
