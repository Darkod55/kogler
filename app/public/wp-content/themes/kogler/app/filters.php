<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});

/**
 * Breadcrumb separators match the design comps (` / `).
 *
 * @param  array<string, mixed>  $defaults
 * @return array<string, mixed>
 */
add_filter('woocommerce_breadcrumb_defaults', function (array $defaults) {
    $defaults['delimiter'] = ' <span class="woocommerce-breadcrumb__sep">/</span> ';
    $defaults['wrap_before'] = '<nav class="woocommerce-breadcrumb mpx-product-breadcrumb" aria-label="Breadcrumb">';
    $defaults['wrap_after'] = '</nav>';

    return $defaults;
});

/**
 * Disable FlexSlider’s built-in thumbnail strip — theme uses Alpine thumbs.
 *
 * @param  array<string, mixed>  $options
 * @return array<string, mixed>
 */
add_filter('woocommerce_single_product_carousel_options', function (array $options) {
    $options['controlNav'] = false;

    return $options;
});

/**
 * Refresh header cart total + count after AJAX add-to-cart.
 *
 * @param  array<string, string>  $fragments
 * @return array<string, string>
 */
add_filter('woocommerce_add_to_cart_fragments', function (array $fragments) {
    if (! function_exists('WC') || ! WC()->cart) {
        return $fragments;
    }

    $count = (int) WC()->cart->get_cart_contents_count();
    $total = html_entity_decode(
        wp_strip_all_tags(wc_price(WC()->cart->get_displayed_subtotal())),
        ENT_QUOTES,
        'UTF-8'
    );

    $fragments['span.header-cart__total'] = sprintf(
        '<span class="header-cart__total">%s</span>',
        esc_html($total)
    );

    $fragments['span.header-cart__count'] = sprintf(
        '<span class="header-cart__count" aria-hidden="true"%s>%d</span>',
        $count === 0 ? ' hidden' : '',
        $count
    );

    return $fragments;
});
