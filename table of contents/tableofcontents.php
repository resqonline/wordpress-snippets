<?php 
/**
 * Credit Note: This plugin is based on WP TOC Plugin
 * by Brendon Boshell http://infinity-infinity.com/
 * With several improvement such as support for paginated content, etc.
 * by David Chandra Purnama http://genbumedia.com/plugins/rq-toc/
 * and by Regina Gschladt https://www.resqonline.eu/
**/

/**
 * Content Filters
 * @since 0.1.0
**/
/* filter the content */
add_filter( 'the_content', 'rq_toc_filter_content' );
/**
 * Add ID in each heading in content
 * @since 0.1.0
 */
function rq_toc_filter_content( $content ){
	/* Only in singular and shortcode exist in content */
	if ( is_single() && !is_admin() ) {
		$content = preg_replace_callback( '/(\<h[1-6](.*?))\>(.*)(<\/h[1-6]>)/i', function( $matches ) {
			if ( ! stripos( $matches[0], 'id=' ) ) :
				$matches[0] = $matches[1] . $matches[2] . ' id="' . sanitize_title( $matches[3] ) . '">' . $matches[3] . $matches[4];
			endif;
			return $matches[0];
		}, $content );
	    return $content;	
	}
}

/**
 * Shortcode Utility Functions
 * @since 0.1.0
**/
/**
 * Open Nested Level: Get opening level tag
 * @since 0.1.0
 */
function rq_toc_sc_open_level( $new, $cur, $first, $type ) {
	$levels = $new - $cur;
	$out = "";
	for( $i = $cur; $i < $new; $i++ ) {
		$level = $i - $first + 2;
		if( ( $level % 2 ) == 0){
			$out .= "<{$type} class='toc-even level-{$level}'>\n";
		}
		else{
			$out .= "<{$type} class='toc-odd level-{$level}'>\n";
		}
	}
	return $out;
}
/**
 * Close Nested Level: Get closing level tag
 * @since 0.1.0
 */
function rq_toc_sc_close_level( $new, $cur, $first, $type ) {
	$out = "";
	for( $i = $cur; $i > $new; $i-- ){
		$out .= "</{$type}>\n";
	}
	return $out;
}
/**
 * Get Unique Name of the heading tag
 * this is needed so each internal anchor link can link
 * properly even each heading have the same name.
 * @since 0.1.0
 */
function rq_toc_sc_get_unique_name( $heading ) {
	/* globalize used name array */
	global $rq_toc_used_names;
	/* Slug like. */
	$n = sanitize_title( $heading );
	/* if uniqe name found, add unique id. */
	if ( isset( $rq_toc_used_names[$n] ) ) {
		$rq_toc_used_names[$n]++;
		/* use underscore, to make sure it's unique */
		$n .= "_" . $rq_toc_used_names[$n];
		$rq_toc_used_names[$n] = 0;
	}
	/* if no used name found, display normal anchor */
	else{
		$rq_toc_used_names[$n] = 0;
	}
	/* return the output */
	return $n;
}
/**
 * Reset Unique Name
 * 
 * @since 0.1.0
 */
function rq_toc_sc_unique_names_reset(){
	global $rq_toc_used_names;
	$rq_toc_used_names = array();
	return true;
}

/**
 * Shortcodes
 * @since 0.1.0
**/
/* Add shortcode */
add_shortcode( 'rq_toc', 'rq_toc_shortcode' );
/**
 * [rq_toc] Shortcode to output the TOC.
 * @since 0.1.0
**/
function rq_toc_shortcode( $atts ){
	/* Bail if not in singular */
	if ( is_admin() ) return false;
	/* Get globals */
	global $post;
	/* Reset used names (?) */
	$rq_toc_used_names = array();
	/* Default shortcode attr */
	$default_args = apply_filters( 'rq_toc_default_args', array(
		'depth'          => 6,
		'list'           => 'ol',
		'title'          => __( 'Table of Contents', 'rq-toc' ),
		'title_tag'      => 'div',
	) );
	$attr = shortcode_atts( $default_args, $atts );
	$toc = rq_toc_build_toc( $post->post_content, $attr );
	return apply_filters( 'rq_toc_output', $toc );
}
/**
 * Create TOC from content
 * @since 0.1.0
 */
function rq_toc_build_toc( $content, $args ){
	/* Get globals */
	global $post, $wp_rewrite, $rq_toc_used_names;
	rq_toc_sc_unique_names_reset();
	/* Shortcode attr */
	$default_args = apply_filters( 'rq_toc_default_args', array(
		'depth'          => 6,
		'list'           => 'ol',
		'title'          => __( 'Table of Contents', 'rq-toc' ),
		'title_tag'      => 'div',
	) );
	$attr = wp_parse_args( $args, $default_args );
	extract( $attr );
	/* Sanitize */
	$list = ( 'ul' == $list ) ? 'ul' : 'ol';
	$title_tag = strip_tags( $title_tag );
	$depth = absint( $depth );
	/* Set lowest heading number, default <h1>. <h1> is lower than <h3> */
	$lowest_heading = 1;
	/* Get the lowest value heading (ie <hN> where N is a number) in the post */
	for( $i = 1; $i <= 6; $i++ ){
		/* Find the <h{x}> tag start from 1 to 6 and. if found, use it.  */
		if( preg_match( "#<h" . $i . "#i", $content ) ) {
			$lowest_heading = $i;
			break;
		}
	}
	/* Set maximum heading tag in content e.g 2+6-1 = 7, so it will use <h2> to <h7> */
	$max_heading = $lowest_heading + $depth - 1;
	/* Find page separation points, so it will work on multi page post */
	$next_pages = array();
	preg_match_all( "#<\!--nextpage-->#i", $content, $next_pages, PREG_OFFSET_CAPTURE );
	$next_pages = $next_pages[0];
	/* Get all headings in post content */ 
	$headings = array();
	preg_match_all( "#<h([1-6]).*?>(.*?)</h[1-6]>#i", $content, $headings, PREG_OFFSET_CAPTURE );
	/* Set lowest heading found */
	$cur_level = $lowest_heading;
	/* Default value, start empty */
	$open = '';
	$heading_out = '';
	$close = '';
	$out = ''; //output
	/* Open sesame */
	$open = '<div class="rq-toc rq-toc-id-' . get_the_ID() . '">';
	/* If the Table Of Content title is set, display */
	if ( $title ){
		$open .= '<' . $title_tag . ' class="rq-toc-title">' . $title . '</' . $title_tag . '>';
	}
	/* Get opening level tags, open the list */
	$cur = $lowest_heading - 1;
	for( $i = $cur; $i < $lowest_heading; $i++ ) {
		$level = $i - $lowest_heading + 2;
		$open .= "<{$list} class='rq-toc-list level-{$level}'>\n";
	}
	$first = true;
	$tabs = 1;
	/* the headings */
	foreach( $headings[2] as $i => $heading ) {
		$level = $headings[1][$i][0]; // <hN>
		if( $level > $max_heading ){ // heading too deep
			continue;
		} 
		if( $level > $cur_level ) { // this needs to be nested
			$heading_out .= str_repeat( "\t", $tabs+1 ) . rq_toc_sc_open_level( $level, $cur_level, $lowest_heading, $list );
			$first = true;
			$tabs += 2;
		}
		if( !$first ){
			$heading_out .= str_repeat( "\t", $tabs ) . "</li>\n";
		}
		$first = false;
		if( $level < $cur_level ) { // jump back up from nest
			$heading_out .= str_repeat( "\t", $tabs-1 ) . rq_toc_sc_close_level( $level, $cur_level, $lowest_heading, $list );
			$tabs -= 2;
		}
		$name = rq_toc_sc_get_unique_name( $heading[0] );
		$page_num = 1;
		$pos = $heading[1];
		/* find the current page */
		foreach( $next_pages as $p ) {
			if( $p[1] < $pos ){
				$page_num++;
			}
		}
		/* fix error if heading link overlap / not hieraricaly correct */
		if ( $tabs+1 > 0 ){
			$tabs = $tabs;
		}
		else{
			$tabs = 0;
		}
		/* For disabled shortcode in heading (for docs for example) */
		$heading[0] = str_replace( "[[", "[", $heading[0] );
		$heading[0] = str_replace( "]]", "]", $heading[0] );
		/**
		 * output the Contents item with link to the heading.
		 * Uses unique ID based on the $prefix variable.
		 */
		if( $page_num != 1 ){
			/* Pretty permalink :) */
			$search_permastruct = $wp_rewrite->get_search_permastruct();
			if ( is_multisite() || !empty( $search_permastruct ) ){
				$heading_out .= str_repeat( "\t", $tabs ) . "<li>\n" . str_repeat( "\t", $tabs + 1 ) . "<a href=\"" . user_trailingslashit( trailingslashit( get_permalink( $post->ID ) ) . $page_num ) . "#" . sanitize_title( $name ). "\">" . strip_tags( $heading[0] ) . "</a>\n";
			}
			/* Ugly permalink :( */
			else{
				$heading_out .= str_repeat( "\t", $tabs ) . "<li>\n" . str_repeat( "\t", $tabs + 1 ) . "<a href=\"?p=" . $post->ID . "&page=" . $page_num . "#" . sanitize_title( $name ). "\">" . strip_tags( $heading[0] ) . "</a>\n";
			}
		}
		else{
			$heading_out .= str_repeat( "\t", $tabs ) . "<li>\n" . str_repeat( "\t", $tabs + 1 ) . "<a href=\"" .get_permalink( $post->ID ). "#" . sanitize_title( $name ). "\">" . strip_tags( $heading[0] ) . "</a>\n";
		}
		$cur_level = $level; // set the current level we are at
	} // end heading
	if( !$first ){
		$close = str_repeat( "\t", $tabs ) . "</li>\n";
	}
	/* Get closing level tags, close the list */
	$close .= rq_toc_sc_close_level( 0, $cur_level, $lowest_heading, $list );
	/* Close sesame */
	$close .= "</div>\n";
	/* Check if heading exist. */
	if ( $heading_out ){
		$out = $open . $heading_out . $close;
	}
	/* display */
	return $out;
}


?>