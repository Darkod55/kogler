{{--
  Related Products
  @see https://woocommerce.com/document/template-structure/
  @version 10.3.0
--}}

@php
  defined('ABSPATH') || exit;
@endphp

@if (! empty($related_products))
  @php
    if (function_exists('wp_increase_content_media_count')) {
      $contentMediaCount = wp_increase_content_media_count(0);
      $threshold = wp_omit_loading_attr_threshold();
      if ($contentMediaCount < $threshold) {
        wp_increase_content_media_count($threshold - $contentMediaCount);
      }
    }
  @endphp

  <section class="related products mpx-related-products" aria-labelledby="mpx-related-products-heading">
    <header class="mpx-related-products__header">
      <p class="mpx-related-products__eyebrow">{{ __('Products', 'sage') }}</p>
      <h2 id="mpx-related-products-heading" class="mpx-related-products__heading">
        {{ __('Highly Recommended', 'sage') }}
      </h2>
    </header>

    @php woocommerce_product_loop_start(); @endphp

    @foreach ($related_products as $related_product)
      @php
        $post_object = get_post($related_product->get_id());
        $GLOBALS['post'] = $post_object;
        setup_postdata($GLOBALS['post']);
        wc_get_template_part('content', 'product');
      @endphp
    @endforeach

    @php woocommerce_product_loop_end(); @endphp
  </section>
@endif

@php
  wp_reset_postdata();
@endphp
