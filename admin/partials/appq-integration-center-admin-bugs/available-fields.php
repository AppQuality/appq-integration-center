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
                <?php foreach ($api->mappings as $key => $value): ?>
                    <tr>
                        <th scope="row"><?= $key ?></th>
                        <td><?= $value['description'] ?></td>
                        <td></td>
                    </tr>
                <?php endforeach; ?>

                <?php foreach ($custom_fields as $custom_field): ?>
                    <?php
                        $source = $custom_field->source;
                        $name = $custom_field->name;
                        $map = $custom_field->map;
                    ?>
                    <tr data-name="<?= $custom_field->name ?>">
                        <th scope="row"><?= $custom_field->name ?></th>
                        <td><?= isset($custom_field->map) ? implode(', ', (array) json_decode($custom_field->map)) : '' ?></td>
                        <td class="text-right actions">
                            <button data-toggle="modal" data-target="#edit_available_field_modal" type="button" class="btn btn-info btn-icon-toggle mr-1 edit-available-field"
                                data-source='<?= $source ?>'
                                data-name='<?= $name ?>'
                                data-map='<?= $map ?>'>
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button data-toggle="modal" data-target="#delete_available_field_modal" type="button" class="btn btn-danger btn-icon-toggle delete-available-field"
                                data-name="<?= $custom_field->name ?>">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$this->partial('bugs/modal/delete-available-field-modal', array());
$this->partial('bugs/modal/edit-available-field-modal', array());
?>
