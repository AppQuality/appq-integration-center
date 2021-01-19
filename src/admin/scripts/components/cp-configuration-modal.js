(function ($) {
  "use strict";
  $(document).ready(function () {
    $("#import_from_cp_modal").ready(function () {
      var modal = $("#import_from_cp_modal");
      var form = $(modal).find('form');
      var submit_button = $(modal).find('button[type="submit"]');
      var select = $(modal).find('.ux-select');
      form.submit(function(e){
        e.preventDefault()
        var submit_btn = $(this).find('button[type="submit"]')
        var submit_btn_html = submit_btn.html()
        submit_btn.html('<i class="fa fa-spinner fa-spin"></i>')
        var srcParams = new URLSearchParams(window.location.search)
        var cp_id = srcParams.has('id') ? srcParams.get('id') : -1
        var data = $(this).serializeArray()
        data.push({
          'name': 'cp_id',
          'value': cp_id
        })
        data.push({
          'name': 'action',
          'value': 'appq_integration_center_import_from_cp'
        })
        jQuery.ajax({
          type: "post",
          dataType: "json",
          url: custom_object.ajax_url,
          data: data
        }).then(function(res){
          if (res.success) {
            location.reload()
          } else {
            toastr.error(res.data,'Error')
            submit_btn.html(submit_btn_html)
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
      var form = $(modal).find('form');
      var submit_button = $(modal).find('button[type="submit"]');
      var select = $(modal).find('.ux-select');
      var settings = $(modal).find('.settings');

      select.on("select2:select", function (e) {
        var data = e.params.data;
        console.log(data);
        toastr.success("Bugtracker selected!");
        settings.show();
        submit_button.prop("disabled", false);
      });
      select.on("select2:unselect", function (e) {
        toastr.error("Bugtracker unselected!");
        settings.hide();
        submit_button.prop("disabled", true);
      });
    });
  });
})(jQuery);
