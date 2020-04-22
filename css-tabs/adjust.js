(function( $ ) {
	$(document).ready(function(){

		//Making sure, our outer flex-container adjust height according to tab content
		$('.tab-content').each(function() {
			var height = $(this).outerHeight();
			var target = $(this).parent().parent();
			if ( target.css('min-height') < height + 'px'){
				console.log( height, target.css('min-height') );
				target.css('min-height', height + 'px' );
			}
		});

	});
})(jQuery);