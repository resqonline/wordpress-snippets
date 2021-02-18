<?php

/*
 * These examples enhance ACF Advanced Custom Fields functionality
 */

// Limit checkbox field choices
function only_allow_3($valid, $value, $field, $input) {
  if (count($value) > 3) {
    $valid = 'Limit your choices to only 3!';
  }
  return $valid;
}
add_filter('acf/validate_value/name=my_field_name', 'only_allow_3', 20, 4);

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


// Add custom directory for "Download" post type file upload field
/*
	Also add this to your htaccess file, to protect files uploaded in this directory to be accessed directly and be redirected to the download_entry single post based on the folder ('download_entry' is the custom post type name), exchange 'mydomain.com' with your domain:

	# BEGIN Download redirect
	<IfModule mod_rewrite.c>
	RewriteEngine On
	RewriteCond expr "! %{HTTP_REFERER} -strmatch '*://%{HTTP_HOST}/*'"
	RewriteCond %{REQUEST_URI} ^(.*?/?)wp-content/uploads/downloads/.* [NC]
	RewriteRule ^wp-content/uploads/downloads/(.+)$ index.php?post_type=download_entry&p=$1 [L,QSA]
	</IfModule>
	#END Download redirect
*/
// Custom upload folder for Download files - exchange field name 'download_file' with your own field name
add_filter('acf/upload_prefilter/name=download_file', 'download_file_upload_prefilter');
function download_file_upload_prefilter( $errors ){
	// in this filter we add a WP filter that alters the upload path
	add_filter('upload_dir', 'download_file_upload_dir');
	return $errors;
}
// we are adding the folder structure like /uploads/downloads/postID - this only works in wp admin!
function download_file_upload_dir( $uploads ){
	$post_id = ( isset( $_REQUEST['post_id'] ) ? $_REQUEST['post_id'] : '' );
	$subdir = $post_id;
	$uploads['subdir'] = $subdir;
	$uploads['path'] = $uploads['basedir'].'/downloads/'.$subdir;
	$uploads['url'] = $uploads['baseurl'].'/downloads/'.$subdir;
	return $uploads;
}


?>
