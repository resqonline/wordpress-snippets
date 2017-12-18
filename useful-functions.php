<?php
/*
 * Include this in your functions.php file to include empty taxonomies in the Yoast SEO Sitemap xml
 */
add_filter('wpseo_sitemap_exclude_empty_terms', '__return_false');


/*
 * Hides WP Admin Dashboard for non-admins and redirects them to a front-end url like /member-account
 */
add_action( 'init', 'blockusers_init' );
function blockusers_init() {
    if ( is_admin() && ! current_user_can( 'administrator' ) &&
    ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
        wp_redirect( home_url('/member-account') ); // you can change this url to whatever your sites front-end user-profile url is
        exit;
    }
}

?>