<!-- Modal -->
<div class="modal" id="import_tracker_settings_modal" tabindex="-1" role="dialog" aria-labelledby="import_from_cp_modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="text-primary"><?= __('Import settings', 'appq-integration-center') ?></h4>
      </div>
      <form id="import_from_cp" class="modal-form pb-4">
        <div class="modal-body form px-4">
          <div class="form-group">
            <label for="import-from-cp-settings" style="margin-bottom: 4px;"><?= _x('Campaign', 'select label', 'appq-integration-center') ?></label>
            <p class="margin-top-xxl margin-bottom-lg no-x-margin"><b><?= count($campaigns) ;?></b> <?= _x('Campaigns available', 'select label', 'appq-integration-center') ?></p>
            <select id="import-from-cp-settings" data-clear data-parent="#import_from_cp" name="source_id" class="ux-select import-select form-control" data-placeholder="<?php _e('Search campaign', 'appq-integration-center'); ?>">
              <option selected disabled></option>
              <?php foreach ($campaigns as $campaign) {
                if ($campaign->id != $current->id) {
                  printf('<option value="%1$s">%1$s - %2$s</option>', $campaign->id, $campaign->title);
                }
              } ?>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link" data-dismiss="modal">
            <?= __('Cancel', 'appq-integration-center') ?>
          </button>
          <button type="submit" class="btn btn-primary" disabled="disabled"><?= __('Import now', 'appq-integration-center') ?></button>
        </div>
      </form>
    </div>
  </div>
</div>