<!-- Modal -->
<div class="modal" id="reset_tracker_settings" tabindex="-1" role="dialog" aria-labelledby="reset_tracker_settings" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <?php printf('<h5 class="text-primary">%s</h5>', __('Delete current tracker settings?', 'appq-integration-center')); ?>
      </div>
      <div class="modal-body form px-4">
        <div class="modal-form pb-4">
          <div class="row mt-2">
            <div class="col-6 col-lg-4 offset-lg-2 text-right">
              <?php printf(
                '<button type="button" id="delete_tracker_settings" class="btn btn-primary confirm">%s</button>',
                __('Delete settings', 'appq-integration-center')
              ); ?>
            </div>
            <div class="col-6 col-lg-4">
              <button type="button" class="btn btn-link" data-dismiss="modal">
                <?= __('Cancel', 'appq-integration-center-jira-addon') ?>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>