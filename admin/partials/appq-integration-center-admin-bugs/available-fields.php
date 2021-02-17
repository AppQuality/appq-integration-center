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
        <table class="table">
            <thead>
            <tr>
                <th scope="col">AppQuality Bug Field</th>
                <th scope="col">Description</th>
                <th scope="col">Field Values</th>
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
                    <tr>
                        <th scope="row"><?= $custom_field->name ?></th>
                        <td><?= $value['description'] ?></td>
                        <td><?= isset($custom_field->map) ? implode(', ', (array) json_decode($custom_field->map)) : '' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>