(function( $ ) {
	'use strict';
	
	$( document ).ready(function() {
		$('#campaign-tabs .nav-link').click(function(){
			window.location.hash = $(this).attr('href')
		})
		
		var hash = window.location.hash;
		$('#campaign-tabs a[href="' + hash + '"]').click();

	});

})( jQuery );
