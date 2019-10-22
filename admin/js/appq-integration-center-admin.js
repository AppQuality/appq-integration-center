(function( $ ) {
	'use strict';
	
	$( document ).ready(function() {
		$('#campaign-tabs .nav-link').click(function(){
			window.location.hash = $(this).attr('href')
		})
		
		var hash = window.location.hash;
		$('#campaign-tabs a[href="' + hash + '"]').click();
		
		
		$('#save_general_settings').click(function(){
			var srcParams = new URLSearchParams(window.location.search)
			var cp_id = srcParams.has('id') ? srcParams.get('id') : -1
			var button = $(this)
			var text = button.text()
			var data = $('#general_settings').serializeArray()
			data.push({
				'name' : 'action',
				'value': 'appq_integration_center_save_settings'
			})
			data.push({
				'name' : 'cp_id',
				'value': cp_id
			})
		 	button.text("")
			button.append('<span class="fa fa-spinner fa-spin"></span>')
			jQuery.ajax({
				type: "post",
				dataType: "json",
				url: custom_object.ajax_url,
				data: data,
				success: function(msg) {
			 		button.text(text)
					console.log(msg);
				}
			});
		})

	});

})( jQuery );
