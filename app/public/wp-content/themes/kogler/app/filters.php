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
 * Brand page chrome. Post meta kogler_brand, or a dedicated brand template.
 *
 * @param  array<int, string>  $classes
 * @return array<int, string>
 */
add_filter('body_class', function (array $classes) {
    if (! function_exists('App\\helpers')) {
        return $classes;
    }

    $brand = \App\helpers()->brandTheme();

    if ($brand !== '') {
        $classes[] = 'brand-' . sanitize_html_class($brand);
    }

    return $classes;
});

/**
 * Native select for kogler_brand. The Brand Page template reads this.
 */
add_action('add_meta_boxes_page', function () {
    add_meta_box(
        'kogler_brand',
        __('Brand', 'sage'),
        function (\WP_Post $post) {
            $current = (string) get_post_meta($post->ID, 'kogler_brand', true);
            $choices = [
                '' => __('Default (site navy)', 'sage'),
                'kogler-sleep' => __('Kögler Sleep', 'sage'),
                'goliath-steel' => __('Goliath Steel', 'sage'),
                'kogler-outdoor' => __('Kögler Outdoor', 'sage'),
            ];

            wp_nonce_field('kogler_brand_save', 'kogler_brand_nonce');
            echo '<p><label for="kogler-brand-select">' . esc_html__('Brand theme for the Brand Page template.', 'sage') . '</label></p>';
            echo '<div class="kogler-brand-field">';
            echo '<select id="kogler-brand-select" name="kogler_brand">';

            foreach ($choices as $value => $label) {
                printf(
                    '<option value="%s"%s>%s</option>',
                    esc_attr($value),
                    selected($current, $value, false),
                    esc_html($label)
                );
            }

            echo '</select>';
            echo '</div>';
        },
        'page',
        'side'
    );
});

/**
 * The closed select sizes itself to its longest option, which is wider
 * than the block-editor sidebar and makes that column scroll sideways.
 */
add_action('admin_head', function () {
    $screen = function_exists('get_current_screen') ? get_current_screen() : null;

    if (! $screen || $screen->base !== 'post' || $screen->post_type !== 'page') {
        return;
    }

    echo '<style>
        #kogler_brand .inside { min-width: 0; max-width: 100%; }
        #kogler_brand .inside p { max-width: 100%; overflow-wrap: break-word; }
        #kogler_brand .kogler-brand-field { display: grid; grid-template-columns: minmax(0, 1fr); max-width: 100%; }
        #kogler_brand select { box-sizing: border-box; width: 100%; max-width: 100%; min-width: 0; }
    </style>';
});

add_action('save_post_page', function ($post_id) {
    if (! isset($_POST['kogler_brand_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['kogler_brand_nonce'])), 'kogler_brand_save')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (! current_user_can('edit_page', $post_id)) {
        return;
    }

    $brand = isset($_POST['kogler_brand']) ? sanitize_text_field(wp_unslash($_POST['kogler_brand'])) : '';
    $allowed = ['kogler-sleep', 'goliath-steel', 'kogler-outdoor'];

    if (! in_array($brand, $allowed, true)) {
        delete_post_meta($post_id, 'kogler_brand');

        return;
    }

    update_post_meta($post_id, 'kogler_brand', $brand);
});

/**
 * Ordering cards on the Goliath Steel brand page.
 * The repeater is label, headline, and detail. It only appears once ACF
 * is installed, and only on a Brand Page set to Goliath Steel.
 */
add_action('acf/init', function () {
    if (! function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group([
        'key' => 'group_kogler_goliath_ordering',
        'title' => __('Goliath Ordering Information', 'sage'),
        'fields' => [
            [
                'key' => 'field_kogler_goliath_ordering',
                'label' => __('Ordering Information', 'sage'),
                'name' => 'goliath_ordering',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => __('Add card', 'sage'),
                'sub_fields' => [
                    [
                        'key' => 'field_kogler_goliath_ordering_label',
                        'label' => __('Label', 'sage'),
                        'name' => 'label',
                        'type' => 'text',
                        'instructions' => __('Stored in normal case. The page uppercases it.', 'sage'),
                    ],
                    [
                        'key' => 'field_kogler_goliath_ordering_headline',
                        'label' => __('Headline', 'sage'),
                        'name' => 'headline',
                        'type' => 'text',
                    ],
                    [
                        'key' => 'field_kogler_goliath_ordering_detail',
                        'label' => __('Detail', 'sage'),
                        'name' => 'detail',
                        'type' => 'textarea',
                        'rows' => 2,
                        'new_lines' => '',
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'tpl-brand-page.blade.php',
                ],
                [
                    'param' => 'kogler_brand',
                    'operator' => '==',
                    'value' => 'goliath-steel',
                ],
            ],
        ],
    ]);

    acf_add_local_field_group([
        'key' => 'group_kogler_who_we_are',
        'title' => __('Who We Are Sections', 'sage'),
        'fields' => [
            ['key' => 'field_wwa_brands_title', 'label' => __('Our Brands Title', 'sage'), 'name' => 'wwa_brands_title', 'type' => 'text'],
            ['key' => 'field_wwa_brands_intro', 'label' => __('Our Brands Intro', 'sage'), 'name' => 'wwa_brands_intro', 'type' => 'textarea', 'rows' => 2, 'new_lines' => ''],
            ['key' => 'field_wwa_we_are_title', 'label' => __('We Are Title', 'sage'), 'name' => 'wwa_we_are_title', 'type' => 'text'],
            ['key' => 'field_wwa_we_are_intro', 'label' => __('We Are Intro', 'sage'), 'name' => 'wwa_we_are_intro', 'type' => 'textarea', 'rows' => 2, 'new_lines' => ''],
            ['key' => 'field_wwa_we_serve_title', 'label' => __('We Serve Title', 'sage'), 'name' => 'wwa_we_serve_title', 'type' => 'text'],
            ['key' => 'field_wwa_we_serve_intro', 'label' => __('We Serve Intro', 'sage'), 'name' => 'wwa_we_serve_intro', 'type' => 'textarea', 'rows' => 3, 'new_lines' => ''],
            ['key' => 'field_wwa_hours_title', 'label' => __('Hours Title', 'sage'), 'name' => 'wwa_hours_title', 'type' => 'text', 'instructions' => __('End the title with HOURS to keep that word in the italic style.', 'sage')],
            ['key' => 'field_wwa_hours_intro', 'label' => __('Hours Intro', 'sage'), 'name' => 'wwa_hours_intro', 'type' => 'textarea', 'rows' => 2, 'new_lines' => ''],
            ['key' => 'field_wwa_leadership_title', 'label' => __('Leadership Title', 'sage'), 'name' => 'wwa_leadership_title', 'type' => 'text'],
            ['key' => 'field_wwa_leadership_intro', 'label' => __('Leadership Intro', 'sage'), 'name' => 'wwa_leadership_intro', 'type' => 'textarea', 'rows' => 3, 'new_lines' => ''],
            ['key' => 'field_wwa_cta_intro', 'label' => __('Closing Intro', 'sage'), 'name' => 'wwa_cta_intro', 'type' => 'textarea', 'rows' => 2, 'new_lines' => ''],
        ],
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'tpl-who-we-are.blade.php',
                ],
            ],
        ],
    ]);

    acf_add_local_field_group([
        'key' => 'group_kogler_outdoor_products',
        'title' => __('Outdoor Products', 'sage'),
        'fields' => [
            [
                'key' => 'field_kogler_outdoor_products',
                'label' => __('Outdoor Products', 'sage'),
                'name' => 'outdoor_products',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => __('Add product', 'sage'),
                'sub_fields' => [
                    [
                        'key' => 'field_kogler_outdoor_product_title',
                        'label' => __('Title', 'sage'),
                        'name' => 'title',
                        'type' => 'text',
                    ],
                    [
                        'key' => 'field_kogler_outdoor_product_image',
                        'label' => __('Image', 'sage'),
                        'name' => 'image',
                        'type' => 'image',
                        'return_format' => 'id',
                        'preview_size' => 'medium',
                        'library' => 'all',
                    ],
                    [
                        'key' => 'field_kogler_outdoor_product_detail',
                        'label' => __('Detail', 'sage'),
                        'name' => 'detail',
                        'type' => 'text',
                        'instructions' => __('Sizes or the marine list. Leave empty to hide the line.', 'sage'),
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'tpl-brand-page.blade.php',
                ],
                [
                    'param' => 'kogler_brand',
                    'operator' => '==',
                    'value' => 'kogler-outdoor',
                ],
            ],
        ],
    ]);
});

add_filter('acf/location/rule_types', function ($choices) {
    if (! is_array($choices)) {
        return $choices;
    }

    if (! isset($choices['Page']) || ! is_array($choices['Page'])) {
        $choices['Page'] = [];
    }

    $choices['Page']['kogler_brand'] = __('Brand', 'sage');

    return $choices;
});

add_filter('acf/location/rule_values/kogler_brand', function ($choices) {
    if (! is_array($choices)) {
        $choices = [];
    }

    $choices['goliath-steel'] = __('Goliath Steel', 'sage');
    $choices['kogler-outdoor'] = __('Kögler Outdoor', 'sage');

    return $choices;
});

add_filter('acf/location/rule_match/kogler_brand', function ($match, $rule, $screen) {
    $postId = is_array($screen) ? (int) ($screen['post_id'] ?? 0) : 0;
    $brand = $postId > 0 ? (string) get_post_meta($postId, 'kogler_brand', true) : '';
    $isMatch = $brand === (string) ($rule['value'] ?? '');

    if (($rule['operator'] ?? '==') === '!=') {
        return ! $isMatch;
    }

    return $isMatch;
}, 10, 3);

