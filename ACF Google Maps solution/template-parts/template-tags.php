<?php
/*
 * The following template tags can be included in your theme or plugin template tag files or function.php
 */

if ( ! function_exists( 'load_gmap_scripts' ) ) :
function load_gmap_scripts() {
	//use only if you added an ACF options page with a field called 'gmaps_api_key' in it, otherwise include your API key here
	$apikey = get_field('gmaps_api_key', 'option'); 

	// this is the general google maps script
	echo '<script src="https://maps.googleapis.com/maps/api/js?key='.$apikey.'"></script>';
	// this is your custom script file, that your registered before
	wp_enqueue_script( 'google-maps-js' );

	// if you also included spiderfier and clusterer in your theme files you can also enque them here
	// wp_enqueue_script( 'google-maps-clusterer-js' );
	// wp_enqueue_script( 'spiderfier-js' );
}
endif;


// Getting the map based on the passed query
if ( ! function_exists( 'load_map' ) ) :
function load_map( $mapargs = null ){

	// Get the main query if one isn't specified
	if ( ! $mapargs ) {
	  global $wp_query;
		$mapargs = $wp_query->query_vars;
	}

	$mapargs['posts_per_page'] = 500; // set this to whatever you like, -1 or 0 to get all doesn't work in this case

	query_posts( $mapargs );

	if( have_posts() ) :
		map_legend(); //this is the template tag for displaying a legend for the map
		echo '<div id="mapwrap"><div class="acf-map">'; // I am always putting acf map into another div
		while ( have_posts()) : the_post();
			post_map_marker(); //this is the template tag to call the marker display
		endwhile;
		echo '</div></div>';
	endif;
	wp_reset_query();

	load_gmap_scripts(); //this is for including our scripts only when the map is called, see template tag from above
}
endif;

// Getting the map for single post display
function single_post_map(){
	
	echo '<div id="mapwrap" class="single_post_map"><div class="acf-map">'; // yep, we can style it differently here
			post_map_marker();
	echo '</div></div>';
	
	load_gmap_scripts();
}

// Creating the legend content for the map
function map_legend(){
	// add some content here like explaining your marker icons or something
}

//used for distributing data to the marker function
function post_map_marker() {

	$location = get_field( 'address' );
	$title = get_the_title();
	$link = get_the_permalink();

	// if you don't use custom icon, make sure to remove it or change to what you need
	// if you use an ACF image field make sure to set the return value to URL
	$icon = get_field( 'map_icon' );

?>
	<div class="marker" data-lat="<?php echo !empty($location['lat']) ? $location['lat'] : ''  ?>" data-lng="<?php echo !empty($location['lng']) ? $location['lng'] : '' ; ?>" data-title="<?php echo $title; ?>" data-url="<?php echo $link; ?>" data-icon="<?php echo $icon; ?>">
		<?php // if you use custom post type, change it to whatever post type you use
		if (! is_singular('post') ) { ?>
		<div class="markerwrap">
			<div class="marker-content">
				<div class="marker-title">
					<a href="<?php the_permalink() ?>"><?php echo $title; ?></a>
				</div>
				<a href="<?php the_permalink() ?>">
					<button class="readmore">
						<?php _e('Click to read more', 'your-theme-name-for-translation');?>
					</button>
				</a>
			</div>
		</div>
		<?php } ?>
	</div>
<?

}
?>