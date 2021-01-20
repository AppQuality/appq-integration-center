<!-- Modal -->
<div class="ux">
  <div class="modal" style="z-index: 99999;" id="setup_manually_cp_modal" tabindex="-1" role="dialog" aria-labelledby="import_from_cp_modalLabel" aria-hidden="true">
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
                <option value="<?= $integration['slug'] ?>"><?= $integration['name'] ?></option>
              <?php endforeach ?>
            </select>
            <div class="settings" style="display: none;">
              <?php
              foreach ($integrations as $integration) {
                $slug = $integration['slug'];
                $name = $integration['name'];
                $class = $integration['class'];
                printf('<div class="extra-fields" data-tracker="%s" style="display: none;">', $slug);
                (method_exists($class, 'main_settings') ? $class->main_settings($campaign) : $class->settings($campaign));
                echo '</div>';
              }
              ?>
              <div class="form-group">
                <?php
                printf('<label for="media">%s</label><br>', __('Media preferences', $this->plugin_name));
                printf('<label><input type="checkbox" class="form-control" name="media" id="media"> %s</label>', __('Upload media', $this->plugin_name));
                ?>
              </div>
            </div>
            <div class="row mt-5">
              <div class="col-6 col-lg-4 offset-lg-2 text-right">
                <?php printf('<button type="submit" class="btn btn-primary" disabled="disabled">%s</button>', __('Save settings', $this->plugin_name)); ?>
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
</div>