<?php 
// Register FAQ Post Type

function register_faq() {

    register_post_type( 'faq-post', array(
        'label'           => 'FAQs',
        'description'     => '',
        'public'          => true,
        'show_ui'         => true,
        'show_in_menu'    => true,
        'capability_type' => 'page',
        'map_meta_cap'    => true,
        'hierarchical'    => false,
        'rewrite'         => array(
                'slug'       => 'faq-post',
                'with_front' => true
            ),
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-editor-help',
        'supports'              => array('title','editor', 'page-attributes'),
        'taxonomies'            => array('custom-taxonomy'),
        'labels'                => array (
                'name'               => 'FAQs',
                'singular_name'      => 'FAQ',
                'menu_name'          => 'FAQs',
            )
        ) 
    );
}
add_action('init', 'register_faq');

function faq_taxonomy(){
    $labels = array(
        'name'                       => _x( 'FAQ Kategorien', 'Taxonomy General Name', 'mythemeslug' ),
        'singular_name'              => _x( 'FAQ Kategorie', 'Taxonomy Singular Name', 'mythemeslug' ),
        'menu_name'                  => __( 'FAQ Kategorien', 'mythemeslug' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
    );
    register_taxonomy( 'faq_taxonomy', array( 'faq-post' ), $args );
}

add_action( 'init', 'faq_taxonomy', 0 );


/* Adding shortcode functions:
 * [faqlist] to show all
 * [faqlist category='name'] to show a specific category
 * [faqlist category='name' title='My Awesome Title'] to show a specific category and adding title
 * [faqlist category='uncategorized,wordpress,plugins' title='My Awesome Title'] to show several categories and adding a title
 */

add_shortcode('faqlist', 'faqlist_shortcode');

function faqlist_shortcode( $attr ) {
    $atts = shortcode_atts( array(
      'category' => '',
      'title' => '',
    ), $attr );

    ob_start();

    echo '<div class="faq-list">';

    if( $atts['title'] != ''){
        printf('<h2 class="faq-main-title">%s</h2>', $atts['title'] );
    }

    $args = array(
        'post_status'    => 'publish',
        'posts_per_page' => 0,
        'post_type'      => 'faq-post',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    );    

    if ( isset($atts['category']) && ! empty( $atts['category'] ) ) {
        $taxargs = array(
            'tax_query' => array(
                array(
                    'taxonomy' => 'faq_taxonomy',
                    'field'    => 'slug',
                    'terms' => $atts['category'],
                ),
            ),
        );
        $args = array_merge( $args, $taxargs );
    }

    $faq_query = new WP_Query( $args );

    if( $faq_query->have_posts() ) :
        while( $faq_query->have_posts() ) : $faq_query->the_post();

        $post_id = $post->ID;
        $title = get_the_title( $post_id );
        $text = apply_filters( 'the_content', get_the_content( $post_id ) );

        echo '<article class="faq-entry" id="faq-entry-' . $post_id . '">
            <h3 class="faq-title close-faq" data-content-id="faq-content-' . $post_id . '">' . $title . '</h3>
            <div class="faq-content" id="faq-content-' . $post_id .'">' . $text . '</div></article>';

        endwhile;
    endif;

    echo '</div>';

    return ob_get_clean();
}
?>