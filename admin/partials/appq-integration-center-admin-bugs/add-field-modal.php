
<!-- Modal -->
<div class="modal" style="z-index: 99999;" id="addFieldModal" tabindex="-1" role="dialog" aria-labelledby="addFieldModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div style="z-index: 99999;" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addFieldModalLabel">Add a custom field mapping</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body form mt-2" id="add_custom_map">
          <div class="form-group row m-2 mb-2">
            <label for="fields_to_map" style="position: absolute;top:0 ;font-size: 12px; opacity: 0.5; margin-bottom: 0;">What field do you want to map?</label>
            <input class="form-control col-5" type="text" name="custom_map_source" placeholder="{Bug.severity}" />
            <input class="form-control col-5" type="text" name="custom_map_name" placeholder="{Bug.my_field}" />
            <button type="button" id="add_new_field" class="col-2 btn btn-primary">Add Map</button>
          </div>
          <div id="custom_field_maps">
          </div>
          <button type="button" id="add_new_field_map" class="d-block m-auto btn btn-primary pl-4 pr-4"><i class="fa fa-plus"></i></button>
      </div>
      <script type="text/html" id="field_map_template">
          <div class="custom_field_map row mt-4">
              <div class="col-6 form-group" style="position: relative;">
                  <label for="fields_to_map" style="position: absolute;top:-20px ;font-size: 12px; opacity: 0.5; margin-bottom: 0;">Field Value</label>
                  <input class="form-control col-12" type="text" name="key" placeholder="LOW" />
              </div>
              <div class="col-6 form-group" style="position: relative;">
                  <label for="fields_to_map" style="position: absolute;top: -20px ;font-size: 12px; opacity: 0.5; margin-bottom: 0;">Map value</label>
                  <input class="form-control col-12" type="text" name="value" placeholder="Customer severity - low" />
              </div>
          </div>
      </script>
    </div>
  </div>
</div>