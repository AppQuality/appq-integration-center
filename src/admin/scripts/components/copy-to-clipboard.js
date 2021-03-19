(function ($) {
  "use strict";
  $(document).ready(function () {
    $('[data-copy-to-clipboard]').click(function(e){
      $(this).append('<input>'); $(this).find('input').val($(this).text());
      var i = $(this).find('input')[0]; 
      i.select();
      i.setSelectionRange(0,9999999); document.execCommand('copy');
      $(this).find('input').remove()
      $(this).append('<span data-clip-icon ></span>');
      $(this).find('[data-clip-icon]').fadeOut( 1000, function() {
        $(this).remove()
      });
    })
  });
})(jQuery);
