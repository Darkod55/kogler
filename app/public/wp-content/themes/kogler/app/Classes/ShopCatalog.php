<?php

namespace App\Shop;

use WP_Query;
use WP_REST_Request;
use WP_REST_Response;
use WP_Term;

if (! class_exists(__NAMESPACE__ . '\\ShopCatalog')) {
    /**
     * Brand-scoped shop catalog: query, facets, HTML fragments, REST.
     */
    class ShopCatalog
    {
        public const PER_PAGE = 12;

        public const REST_NAMESPACE = 'mpx/v1';

        public const REST_ROUTE = '/shop';

        private static $instance;

        protected function __construct()
        {
            add_action('rest_api_init', [$this, 'registerRestRoutes']);
            add_filter('loop_shop_per_page', static fn (): int => self::PER_PAGE, 20);
            add_action('woocommerce_product_query', [$this, 'applyMainQueryFilters'], 20);
            add_filter('woocommerce_get_catalog_ordering_args', [$this, 'catalogOrderingArgs'], 20);
        }

        public static function instance(): self
        {
            if (! (self::$instance instanceof self)) {
                self::$instance = new self;
            }

            return self::$instance;
        }

        public function registerRestRoutes(): void
        {
            register_rest_route(self::REST_NAMESPACE, self::REST_ROUTE, [
                'methods' => 'GET',
                'callback' => [$this, 'restShop'],
                'permission_callback' => '__return_true',
                'args' => [
                    'brand' => [
                        'type' => 'string',
                        'sanitize_callback' => 'sanitize_title',
                    ],
                    's' => [
                        'type' => 'string',
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                    'product_cat' => [
                        'type' => 'string',
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                    'paged' => [
                        'type' => 'integer',
                        'default' => 1,
                        'sanitize_callback' => 'absint',
                    ],
                ],
            ]);
        }

        public function restShop(WP_REST_Request $request): WP_REST_Response
        {
            $params = $request->get_query_params();
            $payload = $this->buildPayload($params);

            return new WP_REST_Response($payload, 200);
        }

        /**
         * Apply category / attribute / search filters on the main shop query.
         * Brand filter remains in wc-template-hooks (priority 10).
         */
        public function applyMainQueryFilters(WP_Query $query): void
        {
            if (is_admin() || ! function_exists('is_shop') || ! is_shop()) {
                return;
            }

            $parsed = $this->parseRequest($_GET); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

            if ($parsed['search'] !== '') {
                $query->set('s', $parsed['search']);
            }

            $taxQuery = (array) $query->get('tax_query');
            foreach ($this->buildFilterTaxQuery($parsed, []) as $clause) {
                $taxQuery[] = $clause;
            }
            $query->set('tax_query', $taxQuery);
            $query->set('posts_per_page', self::PER_PAGE);
            $query->set('orderby', 'title');
            $query->set('order', 'ASC');
        }

        /**
         * Force shop catalog A–Z by title (Woo default is menu_order / date).
         *
         * @param array<string, mixed> $args
         * @return array<string, mixed>
         */
        public function catalogOrderingArgs(array $args): array
        {
            if (! function_exists('is_shop') || ! is_shop()) {
                return $args;
            }

            $args['orderby'] = 'title';
            $args['order'] = 'ASC';

            return $args;
        }

        /**
         * @param array<string, mixed> $params
         * @return array<string, mixed>
         */
        public function buildPayload(array $params): array
        {
            $parsed = $this->parseRequest($params);
            $query = $this->queryProducts($parsed);
            $facets = $this->getFacets($parsed);

            return [
                'brand' => $parsed['brand'],
                'title' => $parsed['brand']['name'],
                'search' => $parsed['search'],
                'total' => (int) $query->found_posts,
                'pages' => max(1, (int) $query->max_num_pages),
                'paged' => $parsed['paged'],
                'per_page' => self::PER_PAGE,
                'url' => $this->buildUrl($parsed),
                'facets' => $facets,
                'products_html' => $this->renderProductsHtml($query),
                'pagination_html' => $this->renderPaginationHtml($query, $parsed),
                'empty' => (int) $query->found_posts < 1,
            ];
        }

        /**
         * Initial Alpine config for the shop page (SSR state).
         *
         * @return array<string, mixed>
         */
        public function getClientConfig(): array
        {
            $parsed = $this->parseRequest($_GET); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            $facets = $this->getFacets($parsed);

            return [
                'endpoint' => esc_url_raw(rest_url(self::REST_NAMESPACE . self::REST_ROUTE)),
                'shopUrl' => function_exists('wc_get_page_permalink')
                    ? (string) wc_get_page_permalink('shop')
                    : home_url('/shop/'),
                'brand' => $parsed['brand']['slug'],
                'brandName' => $parsed['brand']['name'],
                'search' => $parsed['search'],
                'categories' => $parsed['categories'],
                'attributes' => $parsed['attributes'],
                'paged' => $parsed['paged'],
                'facets' => $facets,
                'perPage' => self::PER_PAGE,
            ];
        }

        /**
         * @param array<string, mixed> $params
         * @return array{
         *   brand: array{slug: string, name: string, subtitle: string},
         *   search: string,
         *   categories: string[],
         *   attributes: array<string, string[]>,
         *   paged: int
         * }
         */
        public function parseRequest(array $params): array
        {
            $brandSlug = sanitize_title((string) ($params['brand'] ?? ''));
            $brand = \App\helpers()->getActiveShopBrandFromSlug($brandSlug);

            $search = sanitize_text_field((string) ($params['s'] ?? ''));

            $categories = $this->parseSlugList($params['product_cat'] ?? '');

            $attributes = [];
            foreach ($this->getAttributeMaps() as $name => $taxonomy) {
                if ($taxonomy === \App\helpers()->getShopBrandTaxonomy()) {
                    continue;
                }
                if (! array_key_exists($name, $params) || $params[$name] === '' || $params[$name] === null) {
                    continue;
                }
                $slugs = $this->parseSlugList($params[$name]);
                if ($slugs !== []) {
                    $attributes[$name] = $slugs;
                }
            }

            $paged = max(1, absint($params['paged'] ?? ($params['page'] ?? 1)));

            return [
                'brand' => $brand,
                'search' => $search,
                'categories' => $categories,
                'attributes' => $attributes,
                'paged' => $paged,
            ];
        }

        /**
         * @param array{
         *   brand: array{slug: string, name: string, subtitle: string},
         *   search: string,
         *   categories: string[],
         *   attributes: array<string, string[]>,
         *   paged: int
         * } $parsed
         */
        public function queryProducts(array $parsed): WP_Query
        {
            $taxQuery = [
                'relation' => 'AND',
                [
                    'taxonomy' => \App\helpers()->getShopBrandTaxonomy(),
                    'field' => 'slug',
                    'terms' => [$parsed['brand']['slug']],
                ],
            ];

            foreach ($this->buildFilterTaxQuery($parsed, []) as $clause) {
                $taxQuery[] = $clause;
            }

            $args = [
                'post_type' => 'product',
                'post_status' => 'publish',
                'posts_per_page' => self::PER_PAGE,
                'paged' => $parsed['paged'],
                'tax_query' => $taxQuery,
                'orderby' => 'title',
                'order' => 'ASC',
            ];

            if ($parsed['search'] !== '') {
                $args['s'] = $parsed['search'];
            }

            // Catalog visibility.
            $args['tax_query'][] = [
                'taxonomy' => 'product_visibility',
                'field' => 'name',
                'terms' => ['exclude-from-catalog'],
                'operator' => 'NOT IN',
            ];

            return new WP_Query($args);
        }

        /**
         * Facets for the active brand. Attribute groups are auto-detected from
         * terms used by that brand's products. Counts reflect other active filters.
         *
         * @param array{
         *   brand: array{slug: string, name: string, subtitle: string},
         *   search: string,
         *   categories: string[],
         *   attributes: array<string, string[]>,
         *   paged: int
         * } $parsed
         * @return array{categories: array<int, array{slug: string, name: string, count: int}>, attributes: array<int, array{name: string, label: string, terms: array<int, array{slug: string, name: string, count: int}>}>}
         */
        public function getFacets(array $parsed): array
        {
            $brandProductIds = $this->getBrandProductIds($parsed['brand']['slug']);

            $categories = [];
            if ($brandProductIds !== []) {
                $catTerms = wp_get_object_terms($brandProductIds, 'product_cat', [
                    'orderby' => 'name',
                    'order' => 'ASC',
                ]);
                if (! is_wp_error($catTerms)) {
                    $allowlist = $this->getBrandCategoryAllowlist($parsed['brand']['slug']);
                    $counts = $this->countTermsForFacet($parsed, 'product_cat', null);
                    foreach ($catTerms as $term) {
                        if (! $term instanceof WP_Term || $term->slug === 'uncategorized') {
                            continue;
                        }
                        if (is_array($allowlist) && ! in_array($term->slug, $allowlist, true)) {
                            continue;
                        }
                        $categories[] = [
                            'slug' => $term->slug,
                            'name' => $term->name,
                            'count' => $counts[$term->slug] ?? 0,
                        ];
                    }
                }
            }

            $attributes = [];
            foreach ($this->getAttributeMaps() as $name => $taxonomy) {
                if ($taxonomy === \App\helpers()->getShopBrandTaxonomy()) {
                    continue;
                }
                if ($brandProductIds === []) {
                    continue;
                }

                $terms = wp_get_object_terms($brandProductIds, $taxonomy, [
                    'orderby' => 'name',
                    'order' => 'ASC',
                ]);
                if (is_wp_error($terms) || $terms === []) {
                    continue;
                }

                $counts = $this->countTermsForFacet($parsed, $taxonomy, $name);
                $termRows = [];
                foreach ($terms as $term) {
                    if (! $term instanceof WP_Term) {
                        continue;
                    }
                    $termRows[] = [
                        'slug' => $term->slug,
                        'name' => $term->name,
                        'count' => $counts[$term->slug] ?? 0,
                    ];
                }

                if ($termRows === []) {
                    continue;
                }

                $attributes[] = [
                    'name' => $name,
                    'label' => wc_attribute_label($taxonomy),
                    'terms' => $termRows,
                ];
            }

            return [
                'categories' => $categories,
                'attributes' => $attributes,
            ];
        }

        /**
         * @param array{
         *   brand: array{slug: string, name: string, subtitle: string},
         *   search: string,
         *   categories: string[],
         *   attributes: array<string, string[]>,
         *   paged: int
         * } $parsed
         * @param string[] $exclude Attribute names or 'product_cat' to omit from the query
         * @return array<int, array<string, mixed>>
         */
        private function buildFilterTaxQuery(array $parsed, array $exclude): array
        {
            $clauses = [];

            if (! in_array('product_cat', $exclude, true) && $parsed['categories'] !== []) {
                $clauses[] = [
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $parsed['categories'],
                    'operator' => 'IN',
                ];
            }

            $maps = $this->getAttributeMaps();
            foreach ($parsed['attributes'] as $name => $slugs) {
                if (in_array($name, $exclude, true) || $slugs === []) {
                    continue;
                }
                if (! isset($maps[$name])) {
                    continue;
                }
                $clauses[] = [
                    'taxonomy' => $maps[$name],
                    'field' => 'slug',
                    'terms' => $slugs,
                    'operator' => 'IN',
                ];
            }

            return $clauses;
        }

        /**
         * @param array{
         *   brand: array{slug: string, name: string, subtitle: string},
         *   search: string,
         *   categories: string[],
         *   attributes: array<string, string[]>,
         *   paged: int
         * } $parsed
         * @return array<string, int> slug => count
         */
        private function countTermsForFacet(array $parsed, string $taxonomy, ?string $attrName): array
        {
            $exclude = $attrName === null ? ['product_cat'] : [$attrName];

            $taxQuery = [
                'relation' => 'AND',
                [
                    'taxonomy' => \App\helpers()->getShopBrandTaxonomy(),
                    'field' => 'slug',
                    'terms' => [$parsed['brand']['slug']],
                ],
            ];
            foreach ($this->buildFilterTaxQuery($parsed, $exclude) as $clause) {
                $taxQuery[] = $clause;
            }
            $taxQuery[] = [
                'taxonomy' => 'product_visibility',
                'field' => 'name',
                'terms' => ['exclude-from-catalog'],
                'operator' => 'NOT IN',
            ];

            $args = [
                'post_type' => 'product',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'fields' => 'ids',
                'no_found_rows' => true,
                'tax_query' => $taxQuery,
            ];
            if ($parsed['search'] !== '') {
                $args['s'] = $parsed['search'];
            }

            $ids = get_posts($args);
            if (! is_array($ids) || $ids === []) {
                return [];
            }

            $counts = [];
            foreach ($ids as $productId) {
                $productTerms = get_the_terms((int) $productId, $taxonomy);
                if (! is_array($productTerms)) {
                    continue;
                }
                $seen = [];
                foreach ($productTerms as $term) {
                    if (! $term instanceof WP_Term || isset($seen[$term->slug])) {
                        continue;
                    }
                    $seen[$term->slug] = true;
                    $counts[$term->slug] = ($counts[$term->slug] ?? 0) + 1;
                }
            }

            return $counts;
        }

        /**
         * Optional per-brand category allowlist.
         * null = show every category used by that brand's products.
         *
         * @return string[]|null
         */
        public function getBrandCategoryAllowlist(string $brandSlug): ?array
        {
            $map = [
                // 'kogler' => ['truck-mattress', 'rv-mattress', 'packs', 'pillows'],
                // 'goliath-steel' => ['wiper-blades', 'mirrors', 'headlamps'],
            ];

            return $map[$brandSlug] ?? null;
        }

        /**
         * @return int[]
         */
        private function getBrandProductIds(string $brandSlug): array
        {
            $ids = get_posts([
                'post_type' => 'product',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'fields' => 'ids',
                'no_found_rows' => true,
                'tax_query' => [
                    [
                        'taxonomy' => \App\helpers()->getShopBrandTaxonomy(),
                        'field' => 'slug',
                        'terms' => [$brandSlug],
                    ],
                    [
                        'taxonomy' => 'product_visibility',
                        'field' => 'name',
                        'terms' => ['exclude-from-catalog'],
                        'operator' => 'NOT IN',
                    ],
                ],
            ]);

            return is_array($ids) ? array_map('absint', $ids) : [];
        }

        /**
         * @return array<string, string> attribute_name => taxonomy
         */
        private function getAttributeMaps(): array
        {
            $maps = [];
            if (! function_exists('wc_get_attribute_taxonomies')) {
                return $maps;
            }
            foreach (wc_get_attribute_taxonomies() as $attribute) {
                $name = (string) $attribute->attribute_name;
                $maps[$name] = wc_attribute_taxonomy_name($name);
            }

            return $maps;
        }

        /**
         * @param mixed $value
         * @return string[]
         */
        private function parseSlugList($value): array
        {
            if (is_array($value)) {
                $parts = $value;
            } else {
                $parts = preg_split('/[,\s]+/', (string) $value) ?: [];
            }

            $slugs = [];
            foreach ($parts as $part) {
                $slug = sanitize_title((string) $part);
                if ($slug !== '') {
                    $slugs[] = $slug;
                }
            }

            return array_values(array_unique($slugs));
        }

        /**
         * @param array{
         *   brand: array{slug: string, name: string, subtitle: string},
         *   search: string,
         *   categories: string[],
         *   attributes: array<string, string[]>,
         *   paged: int
         * } $parsed
         */
        public function buildUrl(array $parsed): string
        {
            $shopUrl = function_exists('wc_get_page_permalink')
                ? (string) wc_get_page_permalink('shop')
                : home_url('/shop/');

            $args = [];
            $defaultBrand = \App\helpers()->getShopBrandOptions()[0]['slug'] ?? 'kogler';
            if ($parsed['brand']['slug'] !== $defaultBrand) {
                $args['brand'] = $parsed['brand']['slug'];
            }
            if ($parsed['search'] !== '') {
                $args['s'] = $parsed['search'];
            }
            if ($parsed['categories'] !== []) {
                $args['product_cat'] = implode(',', $parsed['categories']);
            }
            foreach ($parsed['attributes'] as $name => $slugs) {
                if ($slugs !== []) {
                    $args[$name] = implode(',', $slugs);
                }
            }
            if ($parsed['paged'] > 1) {
                $args['paged'] = $parsed['paged'];
            }

            return $args === [] ? $shopUrl : add_query_arg($args, $shopUrl);
        }

        public function renderProductsHtml(WP_Query $query): string
        {
            if ((int) $query->found_posts < 1) {
                return '<p class="mpx-shop__empty woocommerce-info">' .
                    esc_html__('No products were found matching your selection.', 'sage') .
                    '</p>';
            }

            ob_start();

            $columns = 3;
            wc_set_loop_prop('columns', $columns);
            wc_set_loop_prop('total', (int) $query->found_posts);
            wc_set_loop_prop('total_pages', (int) $query->max_num_pages);
            wc_set_loop_prop('current_page', max(1, (int) $query->get('paged')));
            wc_set_loop_prop('is_shortcode', false);

            woocommerce_product_loop_start();

            while ($query->have_posts()) {
                $query->the_post();
                wc_get_template_part('content', 'product');
            }

            woocommerce_product_loop_end();
            wp_reset_postdata();

            return (string) ob_get_clean();
        }

        /**
         * @param array{
         *   brand: array{slug: string, name: string, subtitle: string},
         *   search: string,
         *   categories: string[],
         *   attributes: array<string, string[]>,
         *   paged: int
         * } $parsed
         */
        public function renderPaginationHtml(WP_Query $query, array $parsed): string
        {
            $total = max(1, (int) $query->max_num_pages);
            if ($total <= 1) {
                return '';
            }

            $current = max(1, $parsed['paged']);
            $links = [];

            for ($page = 1; $page <= $total; $page++) {
                $pageParsed = $parsed;
                $pageParsed['paged'] = $page;
                $links[] = [
                    'page' => $page,
                    'url' => $this->buildUrl($pageParsed),
                    'current' => $page === $current,
                ];
            }

            return view('woocommerce.shop.pagination', [
                'links' => $links,
                'current' => $current,
                'total' => $total,
            ])->render();
        }
    }

    ShopCatalog::instance();
}
