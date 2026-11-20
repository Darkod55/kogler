@php
    if (! function_exists('wc_get_products')) {
        return;
    }

    $products = \App\helpers()->getBlockProducts([
        'source' => $a['source'] ?? 'latest',
        'count' => $a['count'] ?? 4,
        'products' => $a['products'] ?? [],
        'category' => $a['category'] ?? null,
    ]);
@endphp

@if ($products !== [])
  <div class="mpx-products-block woocommerce" useBlockProps>
    @php
      wc_set_loop_prop('columns', 4);
      woocommerce_product_loop_start();
    @endphp

    @foreach ($products as $loopProduct)
      @php
        if (! $loopProduct instanceof \WC_Product) {
          continue;
        }

        $postObject = get_post($loopProduct->get_id());
        if (! $postObject instanceof \WP_Post) {
          continue;
        }

        $GLOBALS['post'] = $postObject;
        $GLOBALS['product'] = $loopProduct;
        setup_postdata($postObject);
        wc_get_template_part('content', 'product');
      @endphp
    @endforeach

    @php
      woocommerce_product_loop_end();
      wp_reset_postdata();
      unset($GLOBALS['product']);
    @endphp
  </div>
@elseif (! empty($isEditor))
  <div class="mpx-products-block mpx-products-block--empty" useBlockProps>
    <p>{{ __('Select products to display, or publish catalog products first.', 'sage') }}</p>
  </div>
@endif
