<!-- Modal -->
<div class="modal" style="z-index: 99999;" id="import_tracker_settings_modal" tabindex="-1" role="dialog" aria-labelledby="import_from_cp_modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div style="z-index: 99999;" class="modal-content">
      <div class="modal-header">
        <?php printf('<h5 class="text-primary">%s</h5>', __('Import settings', 'appq-integration-center')); ?>
      </div>
      <div class="modal-body form px-4">
        <form id="import_from_cp" class="modal-form pb-4">
          <select data-clear data-parent="#import_from_cp" name="source_id" class="ux-select select2" data-placeholder="<?php _e('Search campaign', 'appq-integration-center'); ?>">
            <option selected disabled></option>
            <?php foreach ($campaigns as $campaign) {
              if ($campaign->id != $current->id) {
                printf('<option value="%1$s">%1$s - %2$s</option>', $campaign->id, $campaign->title);
              }
            } ?>
          </select>
          <div class="row mt-5">
            <div class="col-6 col-lg-4 offset-lg-2 text-right">
              <?php printf('<button type="submit" class="btn btn-primary" disabled="disabled">%s</button>', __('Import now', 'appq-integration-center')); ?>
            </div>
            <div class="col-6 col-lg-4">
              <button type="button" class="btn btn-link" data-dismiss="modal">
                <?= __('Cancel', 'appq-integration-center') ?>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>