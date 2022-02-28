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

/*
 * Add dynamic checkbox options via dynamic population
 */
add_filter( 'gform_pre_render', 'my_populate_cpt_as_choices' );
add_filter( 'gform_pre_validation', 'my_populate_cpt_as_choices' );
add_filter( 'gform_pre_submission_filter', 'my_populate_cpt_as_choices' );
add_filter( 'gform_admin_pre_render', 'my_populate_cpt_as_choices' );
function my_populate_cpt_as_choices( $form ) {
 
    foreach ( $form['fields'] as &$field ) {

    	$field_id = $field->id;
 	
 	// only fields with parameter my_custom_parameter
        if ( strpos( $field->inputName, 'my_custom_parameter' ) === false ) {
            continue;
        }
 
        // you can add additional parameters here to alter the posts that are retrieved
        // more info: http://codex.wordpress.org/Template_Tags/get_posts
        $postargs = array(
        	'post_type' => 'my_cpt',
		'post_status' => 'publish',
		'posts_per_page' => '-1',
        );
        $posts = get_posts( $postargs );
 	
	// this is important - if you use the same function to dynamically populate radio and checkbox fields
        $choices = array();
        $inputs = array();
 	
 	$input_id = 1; // this makes sure the checkbox labels and inputs correspond

        foreach ( $posts as $post ) {

        	//skipping index that are multiples of 10 (multiples of 10 create problems as the input IDs)
            if ( $input_id % 10 == 0 ) {
                $input_id++;
            }

        	$post_id = $post->ID;
		// getting other fields for this post to display as values or checkbox labels
        	
        	$text = 'My custom label text';

        	$choices[] = array( 'text' => $text, 'value' => $post_id );
        	$inputs[] = array( 'label' => $text, 'id' => "{$field_id}.{$input_id}" );

        	$input_id++;
        }
 
        // populate our choices
        $field->choices = $choices;

        // checkbox fields need input parameters filled https://docs.gravityforms.com/gform_pre_render/#2-populate-choices-checkboxes
        if ( $field->type == 'checkbox') {
        	$field->inputs = $inputs;
        }
 
    }
 
    return $form;
}
?>
