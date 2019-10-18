(function( $ ) {
	'use strict';
	
	$( document ).ready(function() {
		
		$('.nav-link').click(function(){
			var tabNav = $(this).closest('.nav')
			
			tabNav.find('.nav-link').removeClass('active')
			$(this).addClass('active')
		})


	});

})( jQuery );
