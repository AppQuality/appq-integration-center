(function ($) {
  "use strict";
  $(document).ready(function () {
    $("#delete_tracker_settings").click(function (e) {
      e.preventDefault();
      var cp_id = $('#campaign_id').val();
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
        value: integration_center_obj.nonce,
      });
      jQuery.ajax({
        type: "post",
        dataType: "json",
        url: integration_center_obj.ajax_url,
        data: data,
        success: function (msg) {
          location.reload();
        },
      });
    });
  });
})(jQuery);
