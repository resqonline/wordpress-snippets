<?php
/*
 * Register Taxonomy Region with terms for Land and Bundesland or Kanton for the DACH region
 *
 */
function region_terms() {
	// if you use this short slug for the country, pay attention if you use a multi-language plugin! otherwise change it to something different 
	wp_insert_term('Deutschland', 'region', array( 'slug' => 'de')); 
    wp_insert_term('Österreich', 'region', array( 'slug' => 'at'));
    wp_insert_term('Schweiz', 'region', array( 'slug' => 'ch'));

	$parent_term1 = term_exists( 'de', 'region' ); // array is returned if taxonomy is given
	$parent_term_id1 = $parent_term1['term_id']; // get numeric term id
	wp_insert_term( 'Baden-Württemberg', 'region', array( 'slug' => 'baden-wuerttemberg', 'parent' => $parent_term_id1, ) );
	wp_insert_term( 'Bayern', 'region', array( 'slug' => 'bayern', 'parent' => $parent_term_id1, ) );
	wp_insert_term( 'Berlin', 'region', array( 'slug' => 'berlin', 'parent' => $parent_term_id1, ) );
	wp_insert_term( 'Brandenburg', 'region', array( 'slug' => 'brandenburg', 'parent' => $parent_term_id1, ) );
	wp_insert_term( 'Bremen', 'region', array( 'slug' => 'bremen', 'parent' => $parent_term_id1, ) );
	wp_insert_term( 'Hamburg', 'region', array( 'slug' => 'hamburg', 'parent' => $parent_term_id1, ) );
	wp_insert_term( 'Hessen', 'region', array( 'slug' => 'hessen', 'parent' => $parent_term_id1, ) );
	wp_insert_term( 'Mecklenburg-Vorpommern', 'region', array( 'slug' => 'mecklenburg-vorpommern', 'parent' => $parent_term_id1, ) );
	wp_insert_term( 'Niedersachsen', 'region', array( 'slug' => 'niedersachsen', 'parent' => $parent_term_id1, ) );
	wp_insert_term( 'Nordrhein-Westfalen', 'region', array( 'slug' => 'nordrhein-westfalen', 'parent' => $parent_term_id1, ) );
	wp_insert_term( 'Rheinland-Pfalz', 'region', array( 'slug' => 'rheinland-pfalz', 'parent' => $parent_term_id1, ) );
	wp_insert_term( 'Saarland', 'region', array( 'slug' => 'saarland', 'parent' => $parent_term_id1, ) );
	wp_insert_term( 'Sachsen', 'region', array( 'slug' => 'sachsen', 'parent' => $parent_term_id1, ) );
	wp_insert_term( 'Sachsen-Anhalt', 'region', array( 'slug' => 'sachsen-anhalt', 'parent' => $parent_term_id1, ) );
	wp_insert_term( 'Schleswig-Holstein', 'region', array( 'slug' => 'schleswig-holstein', 'parent' => $parent_term_id1, ) );
	wp_insert_term( 'Thüringen', 'region', array( 'slug' => 'thueringen', 'parent' => $parent_term_id1, ) );

	$parent_term2 = term_exists( 'at', 'region' ); // array is returned if taxonomy is given
	$parent_term_id2 = $parent_term2['term_id']; // get numeric term id
	wp_insert_term( 'Burgenland', 'region', array( 'slug' => 'burgenland', 'parent' => $parent_term_id2, ) );
	wp_insert_term( 'Kärnten', 'region', array( 'slug' => 'kaernten', 'parent' => $parent_term_id2, ) );
	wp_insert_term( 'Niederösterreich', 'region', array( 'slug' => 'niederoesterreich', 'parent' => $parent_term_id2, ) );
	wp_insert_term( 'Oberösterreich', 'region', array( 'slug' => 'oberoesterreich', 'parent' => $parent_term_id2, ) );
	wp_insert_term( 'Salzburg', 'region', array( 'slug' => 'salzburg', 'parent' => $parent_term_id2, ) );
	wp_insert_term( 'Steiermark', 'region', array( 'slug' => 'steiermark', 'parent' => $parent_term_id2, ) );
	wp_insert_term( 'Tirol', 'region', array( 'slug' => 'tirol', 'parent' => $parent_term_id2, ) );
	wp_insert_term( 'Vorarlberg', 'region', array( 'slug' => 'vorarlberg', 'parent' => $parent_term_id2, ) );
	wp_insert_term( 'Wien', 'region', array( 'slug' => 'wien', 'parent' => $parent_term_id2, ) );

	$parent_term3 = term_exists( 'ch', 'region' ); // array is returned if taxonomy is given
	$parent_term_id3 = $parent_term3['term_id']; // get numeric term id
	wp_insert_term( 'Aargau', 'region', array( 'slug' => 'aargau', 'parent' => $parent_term_id3, ) );
	wp_insert_term( 'Appenzell Innerhoden', 'region', array( 'slug' => 'aargau', 'parent' => $parent_term_id3, ) );
	wp_insert_term( 'Appenzell Ausserhoden', 'region', array( 'slug' => 'aargau', 'parent' => $parent_term_id3, ) );
	wp_insert_term( 'Bern', 'region', array( 'slug' => 'aargau', 'parent' => $parent_term_id3, ) );
	wp_insert_term( 'Basel Land', 'region', array( 'slug' => 'aargau', 'parent' => $parent_term_id3, ) );
	wp_insert_term( 'Basel Stadt', 'region', array( 'slug' => 'aargau', 'parent' => $parent_term_id3, ) );
	wp_insert_term( 'Freiburg', 'region', array( 'slug' => 'aargau', 'parent' => $parent_term_id3, ) );
	wp_insert_term( 'Genf', 'region', array( 'slug' => 'aargau', 'parent' => $parent_term_id3, ) );
	wp_insert_term( 'Glarus', 'region', array( 'slug' => 'aargau', 'parent' => $parent_term_id3, ) );
	wp_insert_term( 'Graubünden', 'region', array( 'slug' => 'aargau', 'parent' => $parent_term_id3, ) );
	wp_insert_term( 'Jura', 'region', array( 'slug' => 'aargau', 'parent' => $parent_term_id3, ) );
	wp_insert_term( 'Luzern', 'region', array( 'slug' => 'aargau', 'parent' => $parent_term_id3, ) );
	wp_insert_term( 'Neuenburg', 'region', array( 'slug' => 'aargau', 'parent' => $parent_term_id3, ) );
	wp_insert_term( 'Nidwalden', 'region', array( 'slug' => 'aargau', 'parent' => $parent_term_id3, ) );
	wp_insert_term( 'Obwalden', 'region', array( 'slug' => 'aargau', 'parent' => $parent_term_id3, ) );
	wp_insert_term( 'St. Gallen', 'region', array( 'slug' => 'aargau', 'parent' => $parent_term_id3, ) );
	wp_insert_term( 'Schaffhausen', 'region', array( 'slug' => 'aargau', 'parent' => $parent_term_id3, ) );
	wp_insert_term( 'Solothurn', 'region', array( 'slug' => 'aargau', 'parent' => $parent_term_id3, ) );
	wp_insert_term( 'Schwyz', 'region', array( 'slug' => 'aargau', 'parent' => $parent_term_id3, ) );
	wp_insert_term( 'Thurgau', 'region', array( 'slug' => 'aargau', 'parent' => $parent_term_id3, ) );
	wp_insert_term( 'Tessin', 'region', array( 'slug' => 'aargau', 'parent' => $parent_term_id3, ) );
	wp_insert_term( 'Uri', 'region', array( 'slug' => 'aargau', 'parent' => $parent_term_id3, ) );
	wp_insert_term( 'Waadt', 'region', array( 'slug' => 'aargau', 'parent' => $parent_term_id3, ) );
	wp_insert_term( 'Wallis', 'region', array( 'slug' => 'aargau', 'parent' => $parent_term_id3, ) );
	wp_insert_term( 'Zug', 'region', array( 'slug' => 'aargau', 'parent' => $parent_term_id3, ) );
	wp_insert_term( 'Zürich', 'region', array( 'slug' => 'aargau', 'parent' => $parent_term_id3, ) );

}

function region_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Regionen', 'Taxonomy General Name', 'theme-slug' ), // you can change 'theme-slug' to fit your plugin or theme
		'singular_name'              => _x( 'Region', 'Taxonomy Singular Name', 'theme-slug' ),
		'menu_name'                  => __( 'Regionen', 'theme-slug' ),
		'new_item_name'              => __( 'Neue Region', 'theme-slug' ),
		'add_new_item'               => __( 'Region hinzufügen', 'theme-slug' ),
		'edit_item'                  => __( 'Region bearbeiten', 'theme-slug' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'query_var'                  => 'region',
	);
	register_taxonomy( 'region', array( 'post' ), $args ); // change 'post' to the post-type you want this taxonomy and terms to show up with

}
add_action( 'init', 'region_taxonomy', 0 );
add_action( 'init', 'region_terms', 0 );

?>
