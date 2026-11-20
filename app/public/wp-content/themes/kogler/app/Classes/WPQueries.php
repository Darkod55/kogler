<?php

namespace App\WPQueries;

if (!class_exists('App\WPQueries\WPQueries')) {
    /**
     * Class WPQueries
     *
     * A home for all custom DB queries
     *
     * @package App\WPQueries
     */
    class WPQueries
    {
        private static $instance;

        /**
         * WPQueries constructor.
         */
        protected function __construct()
        {
            // set up the site's main query
            $this->setMainQuery();
        }

        /**
         * Modify WP_Query's main query
         *
         * TODO: use the main query for the above-the-fold content (trending posts) or in some other efficient way.
         *
         * This has benefits, as it can be modified to provide a useful query, rather than writing an additional query.
         *
         * @see: https://codex.wordpress.org/Plugin_API/Action_Reference/pre_get_posts
         * @see: https://developer.wordpress.org/reference/hooks/pre_get_posts/
         * @see: https://kinsta.com/blog/wp-query/
         */
        private function setMainQuery()
        {
            add_action('pre_get_posts', function ($query) {
                // abort if current page is an admin page
                if (is_admin()) return;

                // modify the query
                if ($query->is_main_query()) {
                    $this->preMainQuery($query);

                    if (is_post_type_archive()) {
                        $this->preArchivePages($query);
                    }

                    // Product category / attribute / tag archives need found_rows
                    // for the loop total + pagination (shop is covered above).
                    if ($query->is_tax(get_object_taxonomies('product'))) {
                        $query->set('no_found_rows', false);
                    }

                    if (is_home()) { // posts page
                        $this->preArchivePages($query);
                    }

                    if (is_search()) {
                        $this->preSearchPage($query);
                    }
                }
            });
        }

        /**
         * Set up pre_get_posts for the main query
         *
         * @param $query
         */
        private function preMainQuery($query)
        {
            $query->set('no_found_rows', true);
        }

        /**
         * Set up pre_get_posts for the taxonomies
         *
         * @param $query
         */
        private function preTaxonomy($query)
        {
//            // order sector by taxonomy name A-Z, then name
//            if (is_tax('sector')) {
//                $query->set('posts_per_page', -1);
//                $query->set('orderby' , 'taxonomy, name');
//                $query->set('order' , 'ASC');
//            }
        }

        /**
         * Set up pre_get_posts for the all archive pages
         *
         * @param $query
         */
        private function preArchivePages($query)
        {
            if (isset($_POST['orderby'])) {
                $query->set('orderby', sanitize_text_field($_POST['orderby']));
                $query->set('order', ($_POST['orderby'] === 'date-desc') ? 'DESC' : 'ASC');
            }
            $query->set('no_found_rows', false);    // needs to be false for pagination
        }

        /**
         * Set up pre_get_posts for the all archive pages
         *
         * @param $query
         */
        private function preBlogArchivePage($query)
        {
        }

        /**
         * Set up pre_get_posts for the Search pages
         *
         * @param $query
         */
        private function preSearchPage($query)
        {
            $query->set('post_type', ['post', 'page', 'product']);
            $query->set('orderby', 'post_type');
            $query->set('order', 'ASC');
            $query->set('posts_per_page', -1);
            // preMainQuery disables SQL_CALC_FOUND_ROWS site-wide; turn it
            // back on so the search template can read found_posts.
            $query->set('no_found_rows', false);
        }

        /**
         * Singleton
         *
         * @return WPQueries
         */
        public static function instance()
        {
            if (! (self::$instance instanceof self)) {
                self::$instance = new self;
            }

            return self::$instance;
        }
    }

    WPQueries::instance();
}
