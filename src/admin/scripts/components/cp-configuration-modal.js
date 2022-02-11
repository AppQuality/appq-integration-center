(function ($) {
  "use strict";
  $(document).ready(function () {
    $("#import_tracker_settings_modal").ready(function () {
      var modal = $("#import_tracker_settings_modal");
      var form = $(modal).find("form");
      var submit_button = $(modal).find('button[type="submit"]');
      var select = $(modal).find(".import-select");
      form.submit(function (e) {
        e.preventDefault();
        var submit_btn = $(this).find('button[type="submit"]');
        var submit_btn_html = submit_btn.html();
        submit_btn.html('<i class="fa fa-spinner fa-spin"></i>');
  			var cp_id = $('#campaign_id').val()
        var data = $(this).serializeArray();
        data.push({
          name: "cp_id",
          value: cp_id,
        });
        data.push({
          name: "action",
          value: "appq_integration_center_import_tracker_settings",
        });
        data.push({
          name: "nonce",
          value: integration_center_obj.nonce,
        });
        jQuery
          .ajax({
            type: "post",
            dataType: "json",
            url: integration_center_obj.ajax_url,
            data: data,
          })
          .then(function (res) {
            if (res.success) {
              location.reload();
            } else {
              toastr.error(res.data);
              submit_btn.html(submit_btn_html);
            }
          });
      });
      select.on("select2:select", function (e) {
        submit_button.prop("disabled", false);
      });
      select.on("select2:unselect", function (e) {
        submit_button.prop("disabled", true);
      });
    });
    $("#custom_tracker_settings_modal").ready(function () {
      var modal = $("#custom_tracker_settings_modal");
      var submit_button = $(modal).find(".confirm");
      var select = $(modal).find(".settings-select");
      var form = select.val() ? select.val() + "_tracker_settings" : "";
      var settings = $(modal).find(".settings");
      submit_button.on("click", function () {
        var submit_btn = $(this);
        var submit_btn_html = submit_btn.html();
        submit_btn.html('<i class="fa fa-spinner fa-spin"></i>');
        var tracker_form = $("#" + form);
        tracker_form.trigger("submit");
        submit_btn.html(submit_btn_html);
      });
      select.on("select2:select", function (e) {
        settings.show();
        modal.find(".extra-fields").hide();
        modal.find('[data-tracker="' + select.val() + '"]').show();
        submit_button.prop("disabled", false);
        form = select.val() + "_tracker_settings";
      });
      select.on("select2:unselect", function (e) {
        settings.hide();
        submit_button.prop("disabled", true);
      });
    });
  });
})(jQuery);
