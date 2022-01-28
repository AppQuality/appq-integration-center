<!-- Modal -->
<div class="modal" id="delete_available_field_modal" tabindex="-1" role="dialog" aria-labelledby="reset_tracker_settings" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <?php printf('<h5 class="modal-title">%s</h5>', __('Delete this field?', 'appq-integration-center')); ?>
            </div>
            <div class="modal-body form px-4">
                <div class="modal-form pb-4">
                    <form id="delete_available_field_form">
                        <input type="hidden" name="name">
                        <div class="row mt-2">
                            <div class="col-6 col-lg-4 offset-lg-2 text-right">
                                <?php printf(
                                    '<button type="submit" id="delete_available_field" class="btn btn-primary confirm">%s</button>',
                                    __('Delete field', 'appq-integration-center')
                                ); ?>
                            </div>
                            <div class="col-6 col-lg-4">
                                <?php printf('<button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="%1$s">%1$s</button>', __('Cancel', 'appq-integration-center')); ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>