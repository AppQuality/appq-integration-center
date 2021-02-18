(function ($) {
  "use strict";
  $(document).ready(function () {
    $.fn.modal.Constructor.prototype.enforceFocus = function () {};
    $(".ux-select").select2({
      width: "100%",
      allowClear: true,
    });
  });
})(jQuery);
