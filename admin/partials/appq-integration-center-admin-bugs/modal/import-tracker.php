<!-- Modal -->
<div class="modal" style="z-index: 99999;" id="import_tracker_settings_modal" tabindex="-1" role="dialog" aria-labelledby="import_from_cp_modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div style="z-index: 99999;" class="modal-content">
      <div class="modal-header">
        <?php printf('<h5 class="modal-title">%s</h5>', __('Import settings', $this->plugin_name)); ?>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body form px-4">
        <form id="import_from_cp" class="modal-form pb-4">
          <select name="source_id" class="ux-select" data-placeholder="<?php _e('Search campaign', $this->plugin_name); ?>">
            <option></option>
            <?php foreach ($campaigns as $campaign) {
              if ($campaign->id != $current->id) {
                printf('<option value="%1$s">%1$s - %2$s</option>', $campaign->id, $campaign->title);
              }
            } ?>
          </select>
          <div class="row mt-5">
            <div class="col-6 col-lg-4 offset-lg-2 text-right">
              <?php printf('<button type="submit" class="btn btn-primary" disabled="disabled">%s</button>', __('Import now', $this->plugin_name)); ?>
            </div>
            <div class="col-6 col-lg-4">
              <?php printf('<button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="%1$s">%1$s</button>', __('Cancel', $this->plugin_name)); ?>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
