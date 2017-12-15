<?php
/*
 * Include this in your functions.php file to include empty taxonomies in the Yoast SEO Sitemap xml
 */
add_filter('wpseo_sitemap_exclude_empty_terms', '__return_false');


?>