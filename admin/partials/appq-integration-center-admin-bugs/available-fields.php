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
<div class="row mb-2">
    <div class="col-4">
        <?php printf('<small><strong>%s</strong></small>', __('Bug ID', $this->plugin_name)); ?>
    </div>
    <div class="col-4">
        <?php printf('<small><strong>%s</strong></small>', __('Definition', $this->plugin_name)); ?>
    </div>
    <div class="col-4">
        <?php printf('<small><strong>%s</strong></small>', __('Field values ', $this->plugin_name)); ?>
    </div>
</div>
<?php foreach ($api->mappings as $key => $value) { ?>
    <div class="row mb-2">
        <?php
        printf(
            '<div class="col-4">%s</div><div class="col-4">%s</div><div class="col-4"></div>',
            $key,
            $value['description']
        );
        ?>
    </div>
<?php } ?>
<?php foreach ($custom_fields as $custom_field) { ?>
    <div class="row mb-2 custom" title="<?php _e('Edit', $this->plugin_name); ?>" data-target="#add_field_modal" data-map="<?= esc_attr($custom_field->map) ?>" data-source="<?= esc_attr($custom_field->source) ?>" data-name="<?= esc_attr($custom_field->name) ?>">
        <?php
        printf(
            '<div class="col-4">%s</div><div class="col-4"></div><div class="col-4">%s</div>',
            $custom_field->name,
            isset($custom_field->map) ? implode(', ', (array) json_decode($custom_field->map)) : ''
        );
        ?>
    </div>
<?php } ?>