<!-- Modal -->
<div class="modal" id="add_field_modal" tabindex="-1" role="dialog" aria-labelledby="addFieldModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="text-primary"><?= __('Add available field', 'appq-integration-center'); ?></h5>
      </div>
      <form class="modal-body form px-4" id="add_custom_map">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="custom_map_source"><?= __('Source field', 'appq-integration-center') ?></label>
              <input required type="text" class="form-control" name="custom_map_source" id="custom_map_source" placeholder="<?= __('{Bug.xx}', 'appq-integration-center') ?>">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label for="custom_map_name"><?= __('Target field', 'appq-integration-center') ?></label>
              <input required type="text" class="form-control" name="custom_map_name" id="custom_map_name" placeholder="<?= __('{Bug.yy}', 'appq-integration-center') ?>">
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
            <button type="button" id="add_new_field" class="btn btn-block btn-primary">
              <?= __('Save field', 'appq-integration-center') ?>
            </button>
          </div>
          <div class="col-6 col-lg-4">
            <button type="button" class="btn btn-link" data-dismiss="modal">
              <?= __('Cancel', 'appq-integration-center') ?>
            </button>
          </div>
        </div>
      </form>
    </div>
    <script type="text/html" id="field_map_template">
      <div class="custom_field_map row mt-2">

        <div class="col-sm-11">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="key"><?= __('Field value', 'appq-integration-center') ?></label>
                <input required type="text" class="key form-control" name="key" placeholder="<?= __('Some value', 'appq-integration-center') ?>">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="value"><?= __('Map value', 'appq-integration-center') ?></label>
                <input required type="text" class="value form-control" name="value" placeholder="<?= __('Some other value', 'appq-integration-center') ?>">
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