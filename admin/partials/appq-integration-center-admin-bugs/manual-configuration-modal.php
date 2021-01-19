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
          <form id="setup_manually_cp" class="modal-form pb-4">
            <select name="bugtracker" class="ux-select" data-placeholder="<?php _e('Select Issue Tracker', $this->plugin_name); ?>">
              <option></option>
              <?php foreach ($integrations as $integration) : ?>
                <option value="<?= $integration['slug'] ?>"><?= $integration['name'] ?></option>
              <?php endforeach ?>
            </select>
            <div class="settings" style="display: none;">
              <div class="form-group mt-5">
                <?php
                printf('<label for="endpoint">%s</label>', __('Endpoint', $this->plugin_name));
                printf('<input type="text" class="form-control" name="endpoint" id="endpoint" placeholder="%s">', __('https://yourcompanyname.atlassian.com', $this->plugin_name));
                ?>
              </div>
              <div class="form-group">
                <?php
                printf('<label for="auth">%s</label>', __('Authentication', $this->plugin_name));
                printf('<input type="text" class="form-control" name="auth" id="auth" placeholder="%s">', __('email@adress.com:APITOKEN', $this->plugin_name));
                ?>
              </div>
              <?php foreach ($integrations as $integration) { ?>
                <div class="extra-fields" data-tracker="<?= $integration['slug'];?>">
                  <?php do_action('appq-save-tracker-settings-fields', $integration['slug']); ?>
                </div>
              <?php } ?>
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
          </form>
        </div>
      </div>
    </div>
  </div>
</div>