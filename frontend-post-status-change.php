<?php
//function to print custom status change buttons
function show_pause_button(){
    global $post;
    ?>
    <form name="front_end_pause" method="POST" action="">
        <input type="hidden" name="pid" id="pid" value="<?php echo $post->ID; ?>">
        <input type="hidden" name="FE_PAUSE" id="FE_PAUSE" value="FE_PAUSE">
        <input type="submit" name="submit" id="submit" value="Deaktivieren">
    </form>
    <?
	if (isset($_POST['FE_PAUSE']) && $_POST['FE_PAUSE'] == 'FE_PAUSE'){
	    if (isset($_POST['pid']) && !empty($_POST['pid'])){
	        change_post_status((int)$_POST['pid'],'paused');
	    }
	}
}

function show_resume_button(){
    global $post;
    ?>
    <form name="front_end_resume" method="POST" action="">
        <input type="hidden" name="pid" id="pid" value="<?php echo $post->ID; ?>">
        <input type="hidden" name="FE_RESUME" id="FE_RESUME" value="FE_RESUME">
        <input type="submit" name="submit" id="submit" value="Aktivieren">
    </form>
    <?
	if (isset($_POST['FE_RESUME']) && $_POST['FE_RESUME'] == 'FE_RESUME'){
	    if (isset($_POST['pid']) && !empty($_POST['pid'])){
	        change_post_status((int)$_POST['pid'],'pending');
	    }
	}
}

//function to update post status
function change_post_status( $post_id, $status ){
    $current_post = get_post( $post_id, 'ARRAY_A' );
    $current_post['post_status'] = $status;
    wp_update_post( $current_post );
}
?>