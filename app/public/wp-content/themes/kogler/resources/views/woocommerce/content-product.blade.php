{{--
  Product card — shop loop, related products, and product blocks.
  @see https://woocommerce.com/document/template-structure/
  @version 9.4.0
--}}

@php
  defined('ABSPATH') || exit;

  global $product;

  if (! $product instanceof \WC_Product || ! $product->is_visible()) {
    return;
  }

  $permalink = get_permalink($product->get_id());
  $categoryLabel = '';

  $terms = get_the_terms($product->get_id(), 'product_cat');
  if (is_array($terms) && $terms !== []) {
    $categoryLabel = $terms[0]->name;
  }

  $averageRating = (float) $product->get_average_rating();
  $ratingCount = (int) $product->get_rating_count();
  $showRating = $averageRating > 0 && $ratingCount > 0;
  $ratingLabel = $showRating
    ? sprintf(
      /* translators: %s: average rating out of 5 */
      __('(%s/5)', 'sage'),
      number_format_i18n($averageRating, 1)
    )
    : '';

  // Cards never AJAX-add — send shoppers to the product page.
  // Variable / option products keep Woo’s “Select options”; simples use “View product”.
  $hasOptions = $product->get_type() !== 'simple';
  $buttonLabel = $hasOptions
    ? $product->add_to_cart_text()
    : __('View product', 'sage');
  $buttonAria = sprintf(
    /* translators: %s: product name */
    $hasOptions ? __('Select options for “%s”', 'sage') : __('View product “%s”', 'sage'),
    $product->get_name()
  );
  $buttonClasses = implode(' ', [
    'button',
    'mpx-product-card__button',
    'product_type_' . $product->get_type(),
  ]);
@endphp

<li {!! wc_product_class('mpx-product-card', $product) !!}>
  <div class="mpx-product-card__media">
    <a class="mpx-product-card__media-link" href="{{ esc_url($permalink) }}" aria-hidden="true" tabindex="-1">
      {!! $product->get_image('woocommerce_thumbnail', [
        'class' => 'mpx-product-card__image',
        'alt' => esc_attr($product->get_name()),
      ]) !!}
    </a>
  </div>

  <div class="mpx-product-card__body">
    @if ($categoryLabel !== '' || $showRating)
      <div class="mpx-product-card__meta">
        @if ($categoryLabel !== '')
          <p class="mpx-product-card__category">{{ $categoryLabel }}</p>
        @endif

        @if ($showRating)
          <p class="mpx-product-card__rating" aria-label="{{ esc_attr(sprintf(__('Rated %s out of 5', 'sage'), number_format_i18n($averageRating, 1))) }}">
            <span class="mpx-product-card__rating-icon" aria-hidden="true">@svgIcon('star'|14|14)</span>
            <span class="mpx-product-card__rating-value">{{ $ratingLabel }}</span>
          </p>
        @endif
      </div>
    @endif

    <h3 class="mpx-product-card__title woocommerce-loop-product__title">
      <a href="{{ esc_url($permalink) }}">{{ $product->get_name() }}</a>
    </h3>

    <div class="mpx-product-card__price price">
      {!! $product->get_price_html() !!}
    </div>
  </div>

  <div class="mpx-product-card__actions">
    <a
      href="{{ esc_url($permalink) }}"
      class="{{ esc_attr($buttonClasses) }}"
      aria-label="{{ esc_attr($buttonAria) }}"
    >
      <span class="mpx-product-card__button-label">{{ $buttonLabel }}</span>
    </a>
  </div>
</li>
