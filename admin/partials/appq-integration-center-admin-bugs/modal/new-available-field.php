<!-- Modal -->
<div class="modal" id="add_field_modal" tabindex="-1" role="dialog" aria-labelledby="addFieldModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?= __('Add available field', 'appq-integration-center'); ?></h5>
      </div>
      <form class="modal-body form px-4" id="add_custom_map">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <?php
              printf('<label for="custom_map_source">%s</label>', __('Source field', 'appq-integration-center'));
              printf('<input required type="text" class="form-control" name="custom_map_source" id="custom_map_source" placeholder="%s">', __('{Bug.xx}', 'appq-integration-center'));
              ?>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <?php
              printf('<label for="custom_map_name">%s</label>', __('Target field', 'appq-integration-center'));
              printf('<input required type="text" class="form-control" name="custom_map_name" id="custom_map_name" placeholder="%s">', __('{Bug.yy}', 'appq-integration-center'));
              ?>
            </div>
          </div>
        </div>
        <div id="custom_field_maps_wrap">
          <div id="custom_field_maps">
          </div>
          <button type="button" id="add_new_field_map" class="btn btn-secondary mt-2 add_new_field_map"><i class="fa fa-plus"></i></button>
        </div>

        <div class="row mt-5 pb-4">
          <div class="col-6 col-lg-2 offset-lg-4 text-right">
            <?php printf(
              '<button type="button" id="add_new_field" class="btn btn-block btn-primary">%s</button>',
              __('Save field', 'appq-integration-center')
            ); ?>
          </div>
          <div class="col-6 col-lg-4">
            <?php printf('<button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="%1$s">%1$s</button>', __('Cancel', 'appq-integration-center')); ?>
          </div>
        </div>
      </div>
      <script type="text/html" id="field_map_template">
        <div class="custom_field_map row mt-2">

          <div class="col-sm-11">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <?php
                  printf('<label for="key">%s</label>', __('Field value', 'appq-integration-center'));
                  printf('<input required type="text" class="key form-control" name="key" placeholder="%s">', __('Some value', 'appq-integration-center'));
                  ?>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <?php
                  printf('<label for="value">%s</label>', __('Map value', 'appq-integration-center'));
                  printf('<input required type="text" class="value form-control" name="value" placeholder="%s">', __('Some other value', 'appq-integration-center'));
                  ?>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-1 text-right">
            <button class="btn btn-secondary remove mt-4"><i class="fa fa-trash"></i></button>
          </div>
        </div>
      </script>
    </div>
  </div>
</div>
