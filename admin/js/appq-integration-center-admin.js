(function( $ ) {
	'use strict';
	
	$( document ).ready(function() {
		
		$('.nav-link').click(function(){
			var tabNav = $(this).closest('.nav')
			
			tabNav.find('.nav-link').removeClass('active')
			$(this).addClass('active')
		})
		$('#campaign-tabs .nav-link').click(function(){
			window.location.hash = $(this).attr('href')
		})
		
		var hash = window.location.hash;
		$('#campaign-tabs a[href="' + hash + '"]').click();

	});

})( jQuery );
