(function ($) {
  "use strict";
  $(document).ready(function () {
    $("#import_from_cp_modal").ready(function () {
      var modal = $("#import_from_cp_modal");
      var form = $(modal).find("form");
      var submit_button = $(modal).find('button[type="submit"]');
      var select = $(modal).find(".ux-select");
      form.submit(function (e) {
        e.preventDefault();
        var submit_btn = $(this).find('button[type="submit"]');
        var submit_btn_html = submit_btn.html();
        submit_btn.html('<i class="fa fa-spinner fa-spin"></i>');
        var srcParams = new URLSearchParams(window.location.search);
        var cp_id = srcParams.has("id") ? srcParams.get("id") : -1;
        var data = $(this).serializeArray();
        data.push({
          name: "cp_id",
          value: cp_id,
        });
        data.push({
          name: "action",
          value: "appq_integration_center_import_from_cp",
        });
        data.push({
          name: "nonce",
          value: appq_ajax.nonce,
        });
        jQuery
          .ajax({
            type: "post",
            dataType: "json",
            url: appq_ajax.url,
            data: data,
          })
          .then(function (res) {
            if (res.success) {
              location.reload();
            } else {
              toastr.error(res.data, "Error");
              submit_btn.html(submit_btn_html);
            }
          });
      });
      select.on("select2:select", function (e) {
        toastr.success("Campaign selected!");
        submit_button.prop("disabled", false);
      });
      select.on("select2:unselect", function (e) {
        toastr.error("Campaign unselected!");
        submit_button.prop("disabled", true);
      });
    });
    $("#setup_manually_cp_modal").ready(function () {
      var modal = $("#setup_manually_cp_modal");
      var form = "";
      var submit_button = $(modal).find('button[type="submit"]');
      var select = $(modal).find(".ux-select");
      var settings = $(modal).find(".settings");
      submit_button.on("click", function () {
        var submit_btn = $(this);
        var submit_btn_html = submit_btn.html();
        submit_btn.html('<i class="fa fa-spinner fa-spin"></i>');
        var srcParams = new URLSearchParams(window.location.search);
        var cp_id = srcParams.has("id") ? srcParams.get("id") : -1;
        var bugtracker = $(modal).find('select[name="bugtracker"]').val();
        var media = $(modal).find('input[name="media"]').val();
        var data = [];
        data.push({
          name: "cp_id",
          value: cp_id,
        });
        data.push({
          name: "action",
          value: "appq_save_tracker_settings",
        });
        data.push({
          name: "nonce",
          value: appq_ajax.nonce,
        });
        data.push({
          name: "media",
          value: media,
        });
        data.push({
          name: "bugtracker",
          value: bugtracker,
        });
        jQuery
          .ajax({
            type: "post",
            dataType: "json",
            url: appq_ajax.url,
            data: data,
          })
          .then(function (res) {
            if (res.success) {
              toastr.success("Media settings saved!");
            } else {
              toastr.error(res.data, "Error");
            }
          });

        var tracker_form = $("#" + form);
        tracker_form.submit();
        submit_btn.html(submit_btn_html);
      });
      select.on("select2:select", function (e) {
        toastr.success("Bugtracker selected!");
        settings.show();
        modal.find(".extra-fields").hide();
        modal.find('[data-tracker="' + select.val() + '"]').show();
        submit_button.prop("disabled", false);
        form = select.val() + "_settings";
      });
      select.on("select2:unselect", function (e) {
        toastr.error("Bugtracker unselected!");
        settings.hide();
        submit_button.prop("disabled", true);
      });
    });
  });
})(jQuery);
