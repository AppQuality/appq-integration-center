<!-- Modal -->
<div class="modal" style="z-index: 99999;" id="custom_tracker_settings_modal" tabindex="-1" role="dialog" aria-labelledby="custom_tracker_settings_modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div style="z-index: 99999;" class="modal-content">
      <div class="modal-header">
        <?php printf('<h5 class="modal-title">%s</h5>', __('Setup your issue tracker', $this->plugin_name)); ?>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body form px-4">
        <div id="setup_manually_cp" class="modal-form pb-4">
          <select name="bugtracker" class="ux-select" data-placeholder="<?php _e('Select Issue Tracker', $this->plugin_name); ?>">
            <option></option>
            <?php foreach ($integrations as $integration) : ?>
              <option value="<?= $integration['slug'] ?>" <?php isset($campaign->bugtracker->integration) ? selected($campaign->bugtracker->integration, $integration['slug']) : '' ?>><?= $integration['name'] ?></option>
            <?php endforeach ?>
          </select>
          <div class="settings" style="display: <?php echo (isset($campaign->bugtracker->integration) ? 'block' : 'none'); ?>;">
            <?php
            foreach ($integrations as $integration) {
              $slug = $integration['slug'];
              $name = $integration['name'];
              $class = $integration['class'];
              printf(
                '<div class="extra-fields" data-tracker="%s" style="display: %s;">',
                $slug,
                isset($campaign->bugtracker->integration) && $slug == $campaign->bugtracker->integration ? 'block' : 'none'
              );
              $class->get_settings($campaign, 'tracker-settings');
              echo '</div>';
            }
            ?>
          </div>
          <div class="row mt-5">
            <div class="col-6 col-lg-4 offset-lg-2 text-right">
              <?php printf(
                '<button type="button" class="btn btn-primary confirm"%s>%s</button>',
                isset($campaign->bugtracker->integration) ? '' : ' disabled="disabled"',
                __('Save settings', $this->plugin_name)
              ); ?>
            </div>
            <div class="col-6 col-lg-4">
              <?php printf('<button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="%1$s">%1$s</button>', __('Cancel', $this->plugin_name)); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>