(function($) {
$('.select2').on('focus', function ()
	 {
			 $(this).select2('focus');
			 if($('.select2-search__field').length)
			 {
					 $('.select2-search__field').focus();
			 }
	 });
})(jQuery);
