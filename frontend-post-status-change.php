<?php
//function to print custom status change buttons
function show_pause_button(){
    ?>
    <form id="pause-<?php echo $post_id; ?>" name="front_end_pause" method="POST" action="">
        <input type="hidden" name="pid" id="pid" value="<?php echo $post_id; ?>">
        <input type="hidden" name="FE_PAUSE" id="FE_PAUSE" value="FE_PAUSE">
        <input type="submit" name="submit" id="submit" value="Post deaktivieren">
    </form>
    <?
    if (isset($_POST['FE_PAUSE']) && $_POST['FE_PAUSE'] == 'FE_PAUSE'){
        $pid = $_POST['pid'] != '' ? $_POST['pid'] : '';
        $post_stuff = array(
            'ID' => $pid,
            'post_status' => 'paused',
        );

        if ( $pid != ''){
            wp_update_post( $post_stuff );
        }
    }
}

function show_resume_button(){
    ?>
    <form id="resume-<?php echo $post_id; ?>" name="front_end_resume" method="POST" action="">
        <input type="hidden" name="pid" id="pid" value="<?php echo $post_id; ?>">
        <input type="hidden" name="FE_RESUME" id="FE_RESUME" value="FE_RESUME">
        <input type="submit" name="submit" id="submit" value="Post aktivieren">
    </form>
    <?
    if (isset($_POST['FE_RESUME']) && $_POST['FE_RESUME'] == 'FE_RESUME'){
        $pid = $_POST['pid'] != '' ? $_POST['pid'] : '';
        $post_stuff = array(
            'ID' => $pid,
            'post_status' => 'pending',
        );

        if ( $pid != ''){
            wp_update_post( $post_stuff );
        }
    }
}
?>