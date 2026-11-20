{{--
  Single Product Meta
  @see https://woocommerce.com/document/template-structure/
  @version 9.7.0
--}}

@php
  use Automattic\WooCommerce\Enums\ProductType;

  if (! defined('ABSPATH')) {
    exit;
  }

  global $product;
@endphp

<div class="product_meta mpx-product-meta">
  @php do_action('woocommerce_product_meta_start'); @endphp

  @if (wc_product_sku_enabled() && ($product->get_sku() || $product->is_type(ProductType::VARIABLE)))
    <span class="sku_wrapper">
      {{ esc_html__('SKU:', 'woocommerce') }}
      <span class="sku">{{ ($sku = $product->get_sku()) ? $sku : esc_html__('N/A', 'woocommerce') }}</span>
    </span>
  @endif

  {!! wc_get_product_category_list(
    $product->get_id(),
    ', ',
    '<span class="posted_in">' . _n('Category:', 'Categories:', count($product->get_category_ids()), 'woocommerce') . ' ',
    '</span>'
  ) !!}

  @php do_action('woocommerce_product_meta_end'); @endphp
</div>
