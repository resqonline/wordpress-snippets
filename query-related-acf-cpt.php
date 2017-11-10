<?php
/*
 * Query and function examples to explain an extensive multi-level relationship between two post-types with custom fields.
 *
 * Post Type 1 = 'first_posttype' with taxonomy 'region', an ACF field called "rel_post" and a hidden WP custom field called "rel_branche" to pre-store values
 * Post Type 2 = 'second_posttype' with taxonomy 'branche'
 *
 * This is one of the moste extreme things you can think of! 
 */

// I added this query inside a function to use it in several templates

function my_post_list(){

	$region = get_query_var( 'region' ); // this returns a value when we are on the taxonomy archive or on a term page of taxonomy 'branche'
	$branche = get_query_var( 'branche' ); // this returns a value when we are on the taxonomy archive or on a term page of taxonomy 'region'
	$posttype2 = get_query_var( 'second_posttype' ); // this returns a value when we are on a single 'second_posttype' page
	$kid = get_the_ID( $posttype2 ); // this gets us the ID of $posttype2 to be used for comparison

	$term = get_queried_object()->term_id; // this returns the value (ID) of a queried term

	if ( is_home() ) { // we want to get all posts from first_posttype on home
		$args = array(
			'post_type' => 'first_posttype',
		);
	}

	// this is a simple tax-query for the taxonomy-archive pages of 'region'
	if ( is_tax('region') ) { 
		$args = array(
			'post_type' => 'first_posttype',
			'tax_query' => array(
				array(
					'taxonomy' => 'region',
					'terms' => $term,
				),
			),
		);
	}

	// now here comes a complicated thing, which will be explained further down
	if ( is_tax('branche') ) { 
		$args = array(
			'post_type' => 'first_posttype',
			'meta_key'     => 'rel_branche', // that's our custom-field stored in the database
			'meta_value'   => '"'.$term.'"', // this is how we need to format the term in order to compare it with the value from the database
			'meta_compare' => 'LIKE', // it needs to be 'LIKE'
		);
	}

	// this get's all related first_posttype posts to be displayed on the single second_posttype page
	if ( is_singular('second_posttype') ) { 
		$args = array(
			'post_type' => 'first_posttype',
			'meta_query' => array(
				array(
					'key' => 'rel_post', // this is our ACF relationship field storing the ID of the chosen post (second_posttype)
					'value' => $kid,
					'compare' => 'LIKE',
				),
			),
		);
	}
	
	$customquery = new WP_Query( $args );
	// ... here follows the query stuff 'The Loop' with have_posts() and so on
}


/*
 * pre-set values for Branche in 'first_posttype'
 * we are working with the ACF relationship field "Post Object", which saves the ID of the chosen post (second_posttype)
 */
function first_posttype_branche_save_post( $post_id ) {

	$post_type = get_post_type( $post_id );

	if ( $post_type != 'first_posttype' ) {
		// not our post type, bail early
		return;
	}
    
    // get new value
    $pt2_id = get_field( 'rel_post' ); // this is our ACF relationship field and returns the ID 
    $values = get_field( 'branche_pt2', $pt2_id, true); // this is another ACF field (taxonomy select) inside second_posttype, which returns an array of selected term-IDs

    // format our new value to be stored exactly like the data from 'branche_pt2' which is: "a:3:{i:0;s:1:"3";i:1;s:1:"4";i:2;s:1:"5";}"
    // this way we can easily compare the values, which are inside double quotes, otherwise the comparison wouldn't work
    foreach( $values as $key => $value ){
    	$newvalue[] = strval($value);
    }
    
    // do something

    update_post_meta( $post_id, 'rel_branche', $newvalue ); 
    // update_post_meta() will create the custom post meta if it doesn't exist and update the value if it does exist
    
}

add_action('acf/save_post', 'first_posttype_branche_save_post', 20); // set priority to 20 to fire before the actual saving

?>