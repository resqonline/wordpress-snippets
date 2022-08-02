<?php 

// get your ACF event fields
$event_id = get_the_ID();
$start = strtotime( get_field('start') );
$start_date = date_i18n('F j, Y', $start);
$start_time = date_i18n('h:i a', $start);
$end = strtotime( get_field('end') );
$end_date = date_i18n('F j, Y', $end);
$end_time = date_i18n('h:i a', $end);
$location = get_field('event_location');
$info = strip_tags( get_field('additional_information') );
$summary = get_the_title();

?>

<a class="button style2" href="#registration">Register for event</a>

<form method="post" action="<?php echo get_template_directory_uri().'/inc/download-ics.php'; ?>">
	<input type="hidden" name="date_start" value="<?php echo $start; ?>">
	<input type="hidden" name="date_end" value="<?php echo $end; ?>">
	<input type="hidden" name="location" value="<?php echo $lovation; ?>">
	<input type="hidden" name="description" value="<?php echo $info; ?>">
	<input type="hidden" name="summary" value="<?php echo $summary; ?>">
	<input type="hidden" name="url" value="<?php the_permalink(); ?>">
	<button class="style3" type="submit" name="Add to Calendar">Add to Calendar</button>
</form>