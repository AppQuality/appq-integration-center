<!-- Modal -->
<div class="modal" id="custom_tracker_settings_modal" tabindex="-1" role="dialog" aria-labelledby="custom_tracker_settings_modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="text-primary"><?= __('Setup your issue tracker', 'appq-integration-center'); ?></h4>
      </div>
      <div class="modal-body form px-4">
        <div id="setup_manually_cp" class="modal-form pb-4">
          <div class="form-group">
            <label for="bugtracker_select" style="margin-bottom: 4px;"><?= _x('Bug Tracker', 'select label', 'appq-integration-center') ?></label>
            <p class="margin-top-xxl margin-bottom-lg no-x-margin"><b><?= count($integrations); ?></b> <?= _x('Integrations available', 'select label', 'appq-integration-center') ?></p>
            <select <?= isset($campaign->bugtracker->integration) ? '' : 'data-clear' ?> id="bugtracker_select" name="bugtracker" data-parent="#setup_manually_cp" class="ux-select settings-select" data-placeholder="<?php _e('Select Issue Tracker', 'appq-integration-center'); ?>">
              <option></option>
              <?php foreach ($integrations as $integration) : ?>
                <option value="<?= $integration['slug'] ?>" <?= (isset($campaign->bugtracker->integration) && ($campaign->bugtracker->integration === $integration['slug'])) ? 'selected' : '' ?>><?= $integration['name'] ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div>
            <?php
            foreach ($integrations as $integration) :
              $slug = $integration['slug'];
              $name = $integration['name'];
              $class = $integration['class'];
            ?>
              <div class="extra-fields" data-tracker="<?= $slug ?>" style="display: <?= isset($campaign->bugtracker->integration) && strcmp($slug, $campaign->bugtracker->integration) == 0 ? 'block' : 'none' ?>;">
                <?php
                if (isset($class)) {
                  $class->get_settings($campaign, 'tracker-settings');
                } else {
                  echo '<p>' . __('No settings available for this issue tracker', 'appq-integration-center') . '</p>';
                }
                ?>
              </div>
            <?php endforeach; ?>

          </div>
        </div>
      </div><!-- END .modal-body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-link" data-dismiss="modal">
          <?= __('Cancel', 'appq-integration-center') ?>
        </button>
        <button type="submit" id="save_tracker_settings" class="btn btn-primary confirm" <?= isset($campaign->bugtracker->integration) ? '' : 'disabled="disabled"' ?>>
          <?= __('Save settings', 'appq-integration-center') ?>
        </button>
      </div>
    </div>
  </div>
</div>