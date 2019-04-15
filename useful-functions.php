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


/*
 * Add custom logo to WP login screen
 */
function logo_filter_login_head() {
 
    if ( has_custom_logo() ) :
 
        $image = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );
        ?>
        <style type="text/css">
            .login h1 a {
                background-image: url(<?php echo esc_url( $image[0] ); ?>);
                background-size: contain;
                height: 120px;
                width: 320px;
            }
        </style>
        <?php
    endif;
}
add_action( 'login_head', 'logo_filter_login_head', 100 );

?>