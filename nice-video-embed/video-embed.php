<?php
// We are using ACF field oEmbed and Image for the video and the thumbnail

	// this code is inside a repeater field, if you use regular fields, just change get_sub_field to get_field
	$video = ( get_sub_field('video') ) ? get_sub_field('video') : '';
	$thumb = ( get_sub_field('video_thumb') ) ? get_sub_field('video_thumb') : '';

	$videobox = '';

	if ( $video ) {
		$videobox = '<div class="video-box">
		<div class="video-wrapper">'.$video.'</div>
		<div class="video-overlay" style="background-image: url('.$thumb.');">
			<div class="video-play-button"></div>
		</div>
		</div>';
	} else {
		$videobox = '<div class="video-box" style="background-image: url('.$thumb.');"></div>';
	}

	// you can now echo or return the video box based on your functions
?>