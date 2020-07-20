<?php

/*
 * These examples enhance ACF Advanced Custom Fields functionality
 */

// Change acf_form post title field label
function rq_post_title_acf_name( $field ) {
	if ( ! is_admin() ) { // we only want to change this for the frontend form
		$field['label'] = 'My Custom Label'; // rename "Title" to whatever you like
	}
	return $field;
}
add_filter('acf/load_field/name=_post_title', 'rq_post_title_acf_name');

// Change acf_form post content field into simple textarea
function rq_post_content_acf_name( $field ) {
	if ( ! is_admin() ) { // we only want to change this for the frontend form
		$field["type"] = 'textarea'; // instead of WP Tiny MCE WYSIWYG field, we just want a regular textarea
		$field["label"] = 'My Custom Label'; // rename "Content" to whatever you like
		$field['required'] = true; // if you want post_content to be required field
	}
	return $field;
}
add_filter('acf/load_field/name=_post_content', 'rq_post_content_acf_name');

?>