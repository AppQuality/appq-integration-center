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
<div class="offcanvas-pane width-15" id="oc-available-fields-<?= $campaign->id ?>">
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
        <div class="row mb-2 p-0">
            <div class="col-12">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr>
                            <th scope="col"><?= __("Bug Field", 'appq-integration-center'); ?></th>
                            <th scope="col"><?= __("Field Value", 'appq-integration-center'); ?></th>
                            <th scope="col" class="col-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($api->mappings as $key => $value) : ?>
                            <tr>
                                <th scope="row"><?= $key ?></th>
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
                                <th scope="row"><?= $custom_field->name ?></th>
                                <td><?= isset($custom_field->map) ? implode(', ', (array) json_decode($custom_field->map)) : '' ?></td>
                                <td class="text-right actions">
                                    <button data-toggle="modal" data-target="#edit_available_field_modal" type="button" class="btn btn-info btn-icon-toggle mr-1 edit-available-field" data-source='<?= $source ?>' data-name='<?= $name ?>' data-map='<?= $map ?>'>
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button data-toggle="modal" data-target="#delete_available_field_modal" type="button" class="btn btn-danger btn-icon-toggle delete-available-field" data-name="<?= $custom_field->name ?>">
                                        <i class="fa fa-trash"></i>
                                    </button>
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