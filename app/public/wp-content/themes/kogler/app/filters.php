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

