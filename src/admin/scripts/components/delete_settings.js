(function ($) {
  "use strict";
  $(document).ready(function () {
    $("#delete_tracker_settings").click(function (e) {
      e.preventDefault();
      var srcParams = new URLSearchParams(window.location.search);
      var cp_id = srcParams.has("id") ? srcParams.get("id") : -1;
      var data = [];
      data.push({
        name: "action",
        value: "appq_integration_center_delete_tracker_settings",
      });
      data.push({
        name: "cp_id",
        value: cp_id,
      });
      data.push({
        name: "nonce",
        value: appq_ajax.nonce,
      });
      jQuery.ajax({
        type: "post",
        dataType: "json",
        url: appq_ajax.url,
        data: data,
        success: function (msg) {
          location.reload();
        },
      });
    });
  });
})(jQuery);
