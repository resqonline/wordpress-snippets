<?php

/*
 * Include these functions in your functions.php where the scripts are enqued etc.
 */

// Loading Gmap scripts

wp_register_script( 'google-maps-js', plugin_dir_url( __FILE__ ) . 'inc/google-maps.js', false, '1.0', true);

//wp_register_script( 'google-maps-clusterer-js', plugin_dir_url( __FILE__ ) . 'inc/markerclusterer.js', false, '1.0', true);
//wp_register_script( 'spiderfier-js', plugin_dir_url( __FILE__ ) . 'inc/oms.min.js', true);

wp_localize_script( 'google-maps-js', 'pluginDirURI', plugin_dir_url( dirname(__FILE__) ) ) ;

?>