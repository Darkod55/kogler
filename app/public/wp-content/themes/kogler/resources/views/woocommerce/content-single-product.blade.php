{{--
  The template for displaying product content in the single-product template.
  @see https://woocommerce.com/document/template-structure/
  @version 3.6.0
--}}

@php
  global $product;

  do_action('woocommerce_before_single_product');

  if (post_password_required()) {
    echo get_the_password_form();
    return;
  }
@endphp

<div id="product-{{ get_the_ID() }}" {!! wc_product_class('mpx-single-product', $product) !!}>
  <div class="mpx-single-product__grid">
    <div class="mpx-single-product__media">
      @php
        /**
         * Hook: woocommerce_before_single_product_summary.
         *
         * @hooked woocommerce_show_product_sale_flash - 10
         * @hooked woocommerce_show_product_images - 20
         */
        do_action('woocommerce_before_single_product_summary');
      @endphp
    </div>

    <div class="mpx-single-product__summary summary entry-summary">
      @php
        /**
         * Hook: woocommerce_single_product_summary.
         *
         * @hooked woocommerce_breadcrumb - 4 (theme)
         * @hooked woocommerce_template_single_title - 5
         * @hooked woocommerce_template_single_rating - 10
         * @hooked woocommerce_template_single_price - 10
         * @hooked woocommerce_template_single_excerpt - 20
         * @hooked woocommerce_template_single_add_to_cart - 30
         * @hooked woocommerce_template_single_meta - 40
         * @hooked woocommerce_template_single_sharing - 50
         * @hooked WC_Structured_Data::generate_product_data() - 60
         */
        do_action('woocommerce_single_product_summary');
      @endphp
    </div>
  </div>

  @php
    /**
     * Hook: woocommerce_after_single_product_summary.
     * Details panel + related products; tabs / upsells removed in app/wc-template-hooks.php.
     */
    do_action('woocommerce_after_single_product_summary');
  @endphp
</div>

@php
  do_action('woocommerce_after_single_product');
@endphp
