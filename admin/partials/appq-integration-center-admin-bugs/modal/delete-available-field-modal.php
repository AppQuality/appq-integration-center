<!-- Modal -->
<div class="modal" id="delete_available_field_modal" tabindex="-1" role="dialog" aria-labelledby="delete_available_field_modal_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="delete_available_field_modal_label" class="text-primary"><?= __('Delete this field?', 'appq-integration-center'); ?></h4>
            </div>
            <div class="modal-body">
                <p><?= __("Are you sure you want to remove this field?", 'appq-integration-center') ?></p>
            </div><!-- END .modal-body -->

            <div class="modal-footer">
                <form id="delete_available_field_form">
                    <input type="hidden" name="name">
                    <button type="button" class="btn btn-link" data-dismiss="modal">
                        <?= __('Cancel', 'appq-integration-center-jira-addon') ?>
                    </button>
                    <button type="submit" id="delete_available_field" class="btn btn-primary confirm">
                        <?= __('Delete field', 'appq-integration-center-jira-addon'); ?>
                    </button>
                </form>
            </div><!-- END .modal-footer -->
        </div>
    </div>
</div>