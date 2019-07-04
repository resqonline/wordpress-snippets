<?php 
/* 
 * Open 360 Pano View in Fancybox lightbox
 * Fancybox: https://fancyapps.com/fancybox/3/
 *
 */
$panoramaurl = get_post_meta(get_the_ID(), 'vr_panorama_url', true);
$panoramathumb = get_post_meta(get_the_ID(), 'vr_panorama_thumb', true);
if( $panoramathumb ): ?>
       <a class="iframe" data-fancybox="360-view" data-src="<?php echo $panoramaurl;?>" href="javascript:;">
              <span class="icon360"><i class="fa fa-3x fa-plus-circle" aria-hidden="true"></i><br>
                     <?php _e('Click to view 360° view', 'vr-files'); ?>
              </span>
              <img src="<?php echo $panoramathumb; ?>" />
       </a><!-- this is the content from vr-file-upload -->
<?php endif; ?>