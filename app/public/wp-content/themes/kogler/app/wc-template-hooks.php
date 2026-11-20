<?php

/**
 * WooCommerce Template Hooks
 *
 * Action/filter hooks used for WooCommerce functions/templates.
 *
 * @package WooCommerce/Templates
 * @version 2.1.0
 */

 namespace App;

// remove_filter('body_class', 'wc_body_class');
// remove_filter('post_class', 'wc_product_post_class', 20);

/**
 * WP Header.
 *
 * @see wc_generator_tag()
 */
// remove_filter('get_the_generator_html', 'wc_generator_tag', 10);
// remove_filter('get_the_generator_xhtml', 'wc_generator_tag', 10);

/**
 * Content Wrappers.
 *
 * Drop Woo’s default `#primary` / nested `<main>` markup — Sage already
 * wraps `@yield('content')` in `#main`. Use theme container + clamp padding.
 *
 * @see woocommerce_output_content_wrapper()
 * @see woocommerce_output_content_wrapper_end()
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', function () {
    echo '<div class="woocommerce-site px-clamp py-clamp"><div class="container">';
}, 10);

add_action('woocommerce_after_main_content', function () {
    echo '</div></div>';
}, 10);

/**
 * Single product: Testimonial + Form CTA patterns after the product shell
 * (outside `.container` so section blocks keep full-bleed padding/bg).
 */
add_action('woocommerce_after_main_content', function () {
    if (! function_exists('is_product') || ! is_product()) {
        return;
    }

    echo view('woocommerce.single-product.bottom-patterns')->render();
}, 20);

/**
 * Sale flashes.
 *
 * @see woocommerce_show_product_loop_sale_flash()
 * @see woocommerce_show_product_sale_flash()
 */
// remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
// remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);

/**
 * Breadcrumbs — move into the product summary column.
 *
 * @see woocommerce_breadcrumb()
 */
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
add_action('woocommerce_single_product_summary', 'woocommerce_breadcrumb', 4);

/**
 * Sidebar.
 *
 * @see woocommerce_get_sidebar()
 */
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

/**
 * Archive descriptions.
 *
 * @see woocommerce_taxonomy_archive_description()
 * @see woocommerce_product_archive_description()
 */
// remove_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10);
// remove_action('woocommerce_archive_description', 'woocommerce_product_archive_description', 10);

/**
 * Product loop start.
 */
// remove_filter('woocommerce_product_loop_start', 'woocommerce_maybe_show_product_subcategories');

/**
 * Products Loop.
 *
 * @see woocommerce_result_count()
 * @see woocommerce_catalog_ordering()
 */
// remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
// remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
// remove_action('woocommerce_no_products_found', 'wc_no_products_found');

/**
 * Product Loop Items.
 *
 * @see woocommerce_template_loop_product_link_open()
 * @see woocommerce_template_loop_product_link_close()
 * @see woocommerce_template_loop_add_to_cart()
 * @see woocommerce_template_loop_product_thumbnail()
 * @see woocommerce_template_loop_product_title()
 * @see woocommerce_template_loop_category_link_open()
 * @see woocommerce_template_loop_category_title()
 * @see woocommerce_template_loop_category_link_close()
 * @see woocommerce_template_loop_price()
 * @see woocommerce_template_loop_rating()
 */
// remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
// remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
// remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
// remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
// remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);

// remove_action('woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10);
// remove_action('woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10);
// remove_action('woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10);

// remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
// remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);

/**
 * Subcategories.
 *
 * @see woocommerce_subcategory_thumbnail()
 */
// remove_action('woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10);

/**
 * Before Single Products Summary Div.
 *
 * @see woocommerce_show_product_images()
 * @see woocommerce_show_product_thumbnails()
 */
// remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
// remove_action('woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20);

/**
 * After Single Products Summary Div.
 *
 * Custom description + specification panel, then related products.
 *
 * @see woocommerce_output_product_data_tabs()
 * @see woocommerce_upsell_display()
 * @see woocommerce_output_related_products()
 */
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

add_action('woocommerce_after_single_product_summary', function () {
    echo view('woocommerce.single-product.details')->render();
}, 10);

add_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

/**
 * Related products: 4 cards to match the design grid.
 */
add_filter('woocommerce_output_related_products_args', function (array $args): array {
    $args['posts_per_page'] = 4;
    $args['columns'] = 4;

    return $args;
});

add_filter('woocommerce_related_products_columns', fn (): int => 4);

/**
 * Always attempt related output, and pad with other catalog products
 * when category/tag matches return fewer than 4.
 */
add_filter('woocommerce_product_related_posts_force_display', '__return_true');

add_filter('woocommerce_related_products', function (array $related, int $productId, array $args): array {
    $limit = max(1, (int) ($args['limit'] ?? 4));
    $exclude = array_map('absint', (array) ($args['excluded_ids'] ?? []));
    $exclude[] = $productId;

    $related = array_values(array_unique(array_filter(array_map('absint', $related))));
    $related = array_values(array_diff($related, $exclude));

    if (count($related) >= $limit) {
        return array_slice($related, 0, $limit);
    }

    $needed = $limit - count($related);
    $filler = wc_get_products([
        'status' => 'publish',
        'limit' => $needed,
        'exclude' => array_values(array_unique(array_merge($exclude, $related))),
        'orderby' => 'date',
        'order' => 'DESC',
        'return' => 'ids',
        'visibility' => 'catalog',
    ]);

    if (is_array($filler) && $filler !== []) {
        $related = array_merge($related, array_map('absint', $filler));
    }

    return array_slice(array_values(array_unique($related)), 0, $limit);
}, 10, 3);

/**
 * Product cards: star rating markup lives in the card template meta row.
 */
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);

/**
 * Shop archive: 3-up product grid (related / products block stay 4 via CSS).
 */
add_filter('loop_shop_columns', fn (): int => 3);

/**
 * Shop brand toggle — filter main shop query by pa_brand (Kogler default).
 */
add_action('woocommerce_product_query', function (\WP_Query $query): void {
    if (is_admin() || ! function_exists('is_shop') || ! is_shop()) {
        return;
    }

    $taxonomy = \App\helpers()->getShopBrandTaxonomy();
    if (! taxonomy_exists($taxonomy)) {
        return;
    }

    $brand = \App\helpers()->getActiveShopBrand();
    $taxQuery = (array) $query->get('tax_query');
    $taxQuery[] = [
        'taxonomy' => $taxonomy,
        'field' => 'slug',
        'terms' => [$brand['slug']],
    ];

    $query->set('tax_query', $taxQuery);
});

/**
 * Shop page title mirrors the active brand.
 */
add_filter('woocommerce_page_title', function (string $title): string {
    if (! function_exists('is_shop') || ! is_shop()) {
        return $title;
    }

    return \App\helpers()->getActiveShopBrand()['name'];
});

/**
 * Shop archive: drop result count + catalog ordering (brand toggle replaces them).
 * Custom AJAX pagination replaces Woo’s default pager on the shop page.
 */
add_action('wp', function (): void {
    if (! function_exists('is_shop') || ! is_shop()) {
        return;
    }

    remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
    remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
    remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
});

/**
 * Category / attribute archives: clean header + product grid only.
 */
add_action('wp', function (): void {
    if (! function_exists('is_product_taxonomy') || ! is_product_taxonomy()) {
        return;
    }

    remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
    remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
});

/**
 * Product Summary Box.
 *
 * @see woocommerce_template_single_title()
 * @see woocommerce_template_single_rating()
 * @see woocommerce_template_single_price()
 * @see woocommerce_template_single_excerpt()
 * @see woocommerce_template_single_meta()
 * @see woocommerce_template_single_sharing()
 */
// remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
// remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
// remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
// remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);

/**
 * Reviews
 *
 * @see woocommerce_review_display_gravatar()
 * @see woocommerce_review_display_rating()
 * @see woocommerce_review_display_meta()
 * @see woocommerce_review_display_comment_text()
 */
// remove_action('woocommerce_review_before', 'woocommerce_review_display_gravatar', 10);
// remove_action('woocommerce_review_before_comment_meta', 'woocommerce_review_display_rating', 10);
// remove_action('woocommerce_review_meta', 'woocommerce_review_display_meta', 10);
// remove_action('woocommerce_review_comment_text', 'woocommerce_review_display_comment_text', 10);

/**
 * Product Add to cart.
 *
 * @see woocommerce_template_single_add_to_cart()
 * @see woocommerce_simple_add_to_cart()
 * @see woocommerce_grouped_add_to_cart()
 * @see woocommerce_variable_add_to_cart()
 * @see woocommerce_external_add_to_cart()
 * @see woocommerce_single_variation()
 * @see woocommerce_single_variation_add_to_cart_button()
 */
// remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
// remove_action('woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30);
// remove_action('woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30);
// remove_action('woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30);
// remove_action('woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30);
// remove_action('woocommerce_single_variation', 'woocommerce_single_variation', 10);
// remove_action('woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20);

/**
 * Pagination after shop loops.
 *
 * @see woocommerce_pagination()
 */
// remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);

/**
 * Product page tabs.
 */
// remove_filter('woocommerce_product_tabs', 'woocommerce_default_product_tabs');
// remove_filter('woocommerce_product_tabs', 'woocommerce_sort_product_tabs', 99);

/**
 * Additional Information tab.
 *
 * @see wc_display_product_attributes()
 */
// remove_action('woocommerce_product_additional_information', 'wc_display_product_attributes', 10);

/**
 * Checkout.
 *
 * @see woocommerce_checkout_login_form()
 * @see woocommerce_checkout_coupon_form()
 * @see woocommerce_order_review()
 * @see woocommerce_checkout_payment()
 * @see wc_checkout_privacy_policy_text()
 * @see wc_terms_and_conditions_page_content()
 * @see wc_get_pay_buttons()
 */
// remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10);
remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
// remove_action('woocommerce_checkout_order_review', 'woocommerce_order_review', 10);
// remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);
// remove_action('woocommerce_checkout_terms_and_conditions', 'wc_checkout_privacy_policy_text', 20);
// remove_action('woocommerce_checkout_terms_and_conditions', 'wc_terms_and_conditions_page_content', 30);
// remove_action('woocommerce_checkout_before_customer_details', 'wc_get_pay_buttons', 30);

/**
 * Cart widget
 */
// remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10);
// remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout',20);
// remove_action('woocommerce_widget_shopping_cart_total', 'woocommerce_widget_shopping_cart_subtotal', 10);

/**
 * Cart.
 *
 * @see woocommerce_cross_sell_display()
 * @see woocommerce_cart_totals()
 * @see wc_get_pay_buttons()
 * @see woocommerce_button_proceed_to_checkout()
 * @see wc_empty_cart_message()
 */
// remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
// remove_action('woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10);
// remove_action('woocommerce_proceed_to_checkout', 'wc_get_pay_buttons', 10);
// remove_action('woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20);
// remove_action('woocommerce_cart_is_empty', 'wc_empty_cart_message', 10);

/**
 * Footer.
 *
 * @see  wc_print_js()
 * @see woocommerce_demo_store()
 */
// remove_action('wp_footer', 'wc_print_js', 25);
// remove_action('wp_footer', 'woocommerce_demo_store');

/**
 * Order details.
 *
 * @see woocommerce_order_details_table()
 * @see woocommerce_order_again_button()
 */
// remove_action('woocommerce_view_order', 'woocommerce_order_details_table', 10);
// remove_action('woocommerce_thankyou', 'woocommerce_order_details_table', 10);
// remove_action('woocommerce_order_details_after_order_table', 'woocommerce_order_again_button');

/**
 * Order downloads.
 *
 * @see woocommerce_order_downloads_table()
 */
// remove_action('woocommerce_available_downloads', 'woocommerce_order_downloads_table', 10);

/**
 * Auth.
 *
 * @see woocommerce_output_auth_header()
 * @see woocommerce_output_auth_footer()
 */
// remove_action('woocommerce_auth_page_header', 'woocommerce_output_auth_header', 10);
// remove_action('woocommerce_auth_page_footer', 'woocommerce_output_auth_footer', 10);

/**
 * Comments.
 *
 * Disable Jetpack comments.
 */
// remove_filter('jetpack_comment_form_enabled_for_product', '__return_false');

/**
 * My Account.
 */
// remove_action('woocommerce_account_navigation', 'woocommerce_account_navigation');
// remove_action('woocommerce_account_content', 'woocommerce_account_content');
// remove_action('woocommerce_account_orders_endpoint', 'woocommerce_account_orders');
// remove_action('woocommerce_account_view-order_endpoint', 'woocommerce_account_view_order');
// remove_action('woocommerce_account_downloads_endpoint', 'woocommerce_account_downloads');
// remove_action('woocommerce_account_edit-address_endpoint', 'woocommerce_account_edit_address');
// remove_action('woocommerce_account_payment-methods_endpoint', 'woocommerce_account_payment_methods');
// remove_action('woocommerce_account_add-payment-method_endpoint', 'woocommerce_account_add_payment_method');
// remove_action('woocommerce_account_edit-account_endpoint', 'woocommerce_account_edit_account');
// remove_action('woocommerce_register_form', 'wc_registration_privacy_policy_text', 20);

/**
 * Notices.
 */
// remove_action('woocommerce_cart_is_empty', 'woocommerce_output_all_notices', 5);
// remove_action('woocommerce_shortcode_before_product_cat_loop', 'woocommerce_output_all_notices', 10);
// remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
// remove_action('woocommerce_before_single_product', 'woocommerce_output_all_notices', 10);
// remove_action('woocommerce_before_cart', 'woocommerce_output_all_notices', 10);
// remove_action('woocommerce_before_checkout_form_cart_notices', 'woocommerce_output_all_notices', 10);
// remove_action('woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 10);
// remove_action('woocommerce_account_content', 'woocommerce_output_all_notices', 5);
// remove_action('woocommerce_before_customer_login_form', 'woocommerce_output_all_notices', 10);
// remove_action('woocommerce_before_lost_password_form', 'woocommerce_output_all_notices', 10);
// remove_action('before_woocommerce_pay', 'woocommerce_output_all_notices', 10);
// remove_action('woocommerce_before_reset_password_form', 'woocommerce_output_all_notices', 10);
