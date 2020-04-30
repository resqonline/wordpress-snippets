<?php 
/*
 * adding random_number parameter to Gravity Forms field
 * use random_number as a parameter for a hidden field to produce a unique ID with each form submit
 * it can be used as a query string for the success-page
 */
add_filter("gform_field_value_random_number", "generate_random_number");
function generate_random_number($value){
   return uniqid();
}

/*
 * Add some content right after each gravity form shortcode
 * thanks to https://wordpress.stackexchange.com/a/228596/187139
 */
function insert_after_form_shortcode( $content ) {
    if( ! has_shortcode( $content, 'gravityform' ) ) {
        return $content;
    }

    ob_start();

    $pbox = get_field('privacy_text', 'options'); //this is some ACF text field in an options page

    echo '<div class="privacy-box">'.$pbox.'</div>';

    $additional_html = ob_get_clean();
    preg_match_all( '/'. get_shortcode_regex() .'/s', $content, $matches, PREG_SET_ORDER );

	if( ! empty( $matches ) ) {

        foreach ( $matches as $shortcode ) {

            if ( 'gravityform' === $shortcode[2] ) {
                $new_content = $shortcode[0] . $additional_html;
                $content     = str_replace( $shortcode[0], $new_content, $content );
            }
        }
    }

    return $content;
}
add_filter( 'the_content', 'insert_after_form_shortcode' );

?>
