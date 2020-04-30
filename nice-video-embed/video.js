/* 
 * Add this script to your theme's js file or enqueue in your functions.php
 * What does this do? It adds a few parameters to the iframe (note these parameters belong to youtube embed). 
 * When clicking on the overlay button, it starts the video.
 */
// for the video embed
(function ($) {
  $(document).ready(function() {
  	var iframe = $('.video-wrapper').find('iframe');
  		iframe[0].src += "&showinfo=0&modestbranding=1&rel=0";

    $('.video-play-button').click( function(e) {
      e.preventDefault();
      var playicon = $(this);
      var wrapper = playicon.closest('.video-box');
      videoPlay(wrapper);
    });
  });
})(jQuery);

function videoPlay(wrapper) {
  var iframe = wrapper.find('iframe');
  iframe[0].src += "&autoplay=1";
  wrapper.addClass('videoactive');
}