<!-- Modal -->
<div class="modal" id="reset_tracker_settings" tabindex="-1" role="dialog" aria-labelledby="reset_tracker_settings" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="text-primary"><?= __('Delete current tracker settings?', 'appq-integration-center') ?></h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-link" data-dismiss="modal">
          <?= __('Cancel', 'appq-integration-center-jira-addon') ?>
        </button>
        <button type="button" id="delete_tracker_settings" class="btn btn-primary confirm">
          <?= __('Delete settings', 'appq-integration-center') ?>
        </button>
      </div>
    </div>
  </div>
</div>