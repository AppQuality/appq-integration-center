<!-- Modal -->
<div class="modal" id="edit_available_field_modal" tabindex="-1" role="dialog" aria-labelledby="addFieldModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="text-primary"><?= __('Edit available field', 'appq-integration-center'); ?></h5>
            </div>
            <form class="form" id="edit_available_field_form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input readonly required type="text" class="form-control" name="custom_map_source" id="custom_map_source" placeholder="<?= __('{Bug.xx}', 'appq-integration-center') ?>">
                                <label for="custom_map_source"><?= __('Source field', 'appq-integration-center') ?></label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input readonly required type="text" class="form-control" name="custom_map_name" id="custom_map_name" placeholder="<?= __('{Bug.yy}', 'appq-integration-center') ?>">
                                <label for="custom_map_name"><?= __('Target field', 'appq-integration-center') ?></label>
                            </div>
                        </div>
                    </div>
                    <div id="custom_field_maps_wrap_edit">
                        <div id="custom_field_maps_edit">
                        </div>
                        <button type="button" class="btn btn-secondary mt-2 add_new_field_map"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">
                        <?= __('Cancel', 'appq-integration-center') ?>
                    </button>
                    <button type="button" id="edit_field" class="btn btn-primary"><?= __('Save field', 'appq-integration-center') ?></button>
                </div>
            </form>
        </div>
        <script type="text/html" id="field_map_template">
            <div class="custom_field_map">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input required type="text" class="key form-control" name="key" placeholder="<?= __('Some value', 'appq-integration-center') ?>">
                            <label for="key"><?= __('Field value', 'appq-integration-center') ?></label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-content">
                                    <input required type="text" class="value form-control" name="value" placeholder="<?= __('Some other value', 'appq-integration-center') ?>">
                                    <label for="value"><?= __('Map value', 'appq-integration-center') ?></label>
                                </div>
                                <div class="input-group-btn">
                                    <button class="btn btn-secondary remove"><i class="fa fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </script>
    </div>
</div>