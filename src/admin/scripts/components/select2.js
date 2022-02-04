(function ($) {
  "use strict";
  $(document).ready(function () {
    $.fn.modal.Constructor.prototype.enforceFocus = function () {};
    $(".ux-select").each(function(){
      var args = {
        width: "100%",
        minimumResultsForSearch: 5
      }
      if ($(this).data('parent') && $($(this).data('parent')).length) {
        args.dropdownParent = $($(this).data('parent'));
      }
      if ($(this).data('clear')) {
        args.allowClear = true;
      }
      $(this).select2(args);
    })
  });
})(jQuery);
