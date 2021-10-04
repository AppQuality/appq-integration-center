<!-- Modal -->
<div class="modal" style="z-index: 99999;" id="custom_tracker_settings_modal" tabindex="-1" role="dialog" aria-labelledby="custom_tracker_settings_modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div style="z-index: 99999;" class="modal-content">
      <div class="modal-header">
        <?php printf('<h5 class="modal-title">%s</h5>', __('Setup your issue tracker', 'appq-integration-center')); ?>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body form px-4">
        <div id="setup_manually_cp" class="modal-form pb-4">
          <select <?= isset($campaign->bugtracker->integration) ? '' : 'data-clear' ?> name="bugtracker" data-parent="#setup_manually_cp" class="ux-select" data-placeholder="<?php _e('Select Issue Tracker', 'appq-integration-center'); ?>">
            <option></option>
            <?php if (is_a_customer()): ?>
              <?php foreach ($integrations as $integration) : ?>
                <?php if ($integration['visible_to_customer']): ?>
                  <option value="<?= $integration['slug'] ?>" <?= (isset($campaign->bugtracker->integration) && ($campaign->bugtracker->integration === $integration['slug'])) ? 'selected' : '' ?>><?= $integration['name'] ?></option>
                <?php endif; ?>
              <?php endforeach ?>
            <?php else: ?>
              <?php foreach ($integrations as $integration) : ?>
                  <option value="<?= $integration['slug'] ?>" <?= (isset($campaign->bugtracker->integration) && ($campaign->bugtracker->integration === $integration['slug'])) ? 'selected' : '' ?>><?= $integration['name'] ?></option>
              <?php endforeach ?>
            <?php endif; ?>
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
                __('Save settings', 'appq-integration-center')
              ); ?>
            </div>
            <div class="col-6 col-lg-4">
              <?php printf('<button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="%1$s">%1$s</button>', __('Cancel', 'appq-integration-center')); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
