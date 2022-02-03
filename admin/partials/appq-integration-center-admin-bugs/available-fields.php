<?php
/*
 * The general settings partial
 *
 * @Author: Davide Bizzi <clochard>
 * @Date:   23/10/2019
 * @Filename: general-settings.php
 * @Last modified by:   clochard
 * @Last modified time: 25/10/2019
 */
$api = new IntegrationCenterRestApi($campaign->id, null, null);
?>
<div class="offcanvas-pane" id="oc-available-fields-<?= $campaign->id ?>" style="min-width: 480px; width: 50vw;">
    <div class="offcanvas-head background-filled">
        <h4 class="text-default-bright" style="margin: 12px auto;"><?= __('Available fields', 'appq-integration-center') ?></h4>
        <div class="offcanvas-tools">
            <div class="btn-group pull-right">
                <button type="button" class="btn btn-default-bright btn-icon-toggle pull-right" title="<?= __('Add new', 'appq-integration-center'); ?>" data-toggle="modal" data-target="#add_field_modal">
                    <i class="fa fa-plus" style="color: white;"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="offcanvas-body">
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-hover table-condensed" id="availableFields">
                    <thead>
                        <tr>
                            <th scope="col"><?= __("Bug Field", 'appq-integration-center'); ?></th>
                            <th scope="col"><?= __("Field Value", 'appq-integration-center'); ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($api->mappings as $key => $value) : ?>
                            <tr>
                                <td class="text-primary text-medium"><?= $key ?></td>
                                <td><?= $value['description'] ?></td>
                                <td></td>
                            </tr>
                        <?php endforeach; ?>

                        <?php foreach ($custom_fields as $custom_field) : ?>
                            <?php
                            $source = $custom_field->source;
                            $name = $custom_field->name;
                            $map = $custom_field->map;
                            ?>
                            <tr data-name="<?= $custom_field->name ?>">
                                <td class="text-primary text-medium"><?= $custom_field->name ?></td>
                                <td><?= isset($custom_field->map) ? implode(', ', (array) json_decode($custom_field->map)) : '' ?></td>
                                <td class="text-right actions">
                                    <div class="btn-group">
                                        <button data-toggle="modal" data-target="#edit_available_field_modal" type="button" class="btn btn-primary btn-icon-toggle edit-available-field" data-source='<?= $source ?>' data-name='<?= $name ?>' data-map='<?= $map ?>'>
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button data-toggle="modal" data-target="#delete_available_field_modal" type="button" class="btn btn-danger btn-icon-toggle delete-available-field" data-name="<?= $custom_field->name ?>">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php
$this->partial('bugs/modal/delete-available-field-modal', array());
$this->partial('bugs/modal/edit-available-field-modal', array());
?>