(function ($) {
  "use strict";
  $(document).ready(function () {
    $("#add_new_field_values").change(function () {
      var wrap = $("#custom_field_maps_wrap");
      wrap.toggle();
    });

    $(".available_fields .custom").click(function () {
      var set_field_checkbox = $("#add_new_field_values");
      if (!set_field_checkbox.is(":checked")) {
        $("#add_new_field_values").click();
      }
    });
  
    $("#add_field_modal").on("hidden.bs.modal", function (e) {
      var set_field_checkbox = $("#add_new_field_values");
      if (set_field_checkbox.is(":checked")) {
        $("#add_new_field_values").click();
      }
      $("#custom_field_maps_wrap").hide();
      $("#custom_field_maps").html('');
      $("#custom_map_source").val('');
      $("#custom_map_name").val('');
    });
  });
})(jQuery);
