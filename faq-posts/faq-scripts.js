// for showing FAQ content
// make sure to register the script in your theme with jquery as dependency!
(function ($) {
  $(window).load(function () {
    $('.faq-title').click(function () {
      var my_content_id = $(this).attr('data-content-id');
      $('#' + my_content_id).slideToggle();
      $(this).toggleClass('close-faq');
    });
  });
})(jQuery);