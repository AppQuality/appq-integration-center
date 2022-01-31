(function ($) {
  "use strict";
  $(document).ready(function () {

    if(typeof ClipboardJS !== undefined)
    {
      new ClipboardJS('.copy-to-clipboard');
    } 
  });
})(jQuery);
