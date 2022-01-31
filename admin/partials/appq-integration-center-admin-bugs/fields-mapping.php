<?php
$api = new JiraRestApi($campaign->id);
$field_mapping = !empty(json_decode($campaign->bugtracker->field_mapping, true)) ? json_decode($campaign->bugtracker->field_mapping, true) : [];
foreach ($api->basic_configuration as $key => $value) {
    if (!in_array($key, array_keys($field_mapping))) {
        $field_mapping[$key] = $value;
    }
}
?>

<div class="row">
    <div class="col-6"><?php printf('<h4 class="title py-3">%s</h4>', __('Field mapping', 'appq-integration-center')); ?></div>
    <div class="col-6 text-right actions mt-2">
        <button type="button" class="btn btn-secondary mr-1" data-toggle="modal" data-target="#get_from_bug"><?php _e('Get mapping from bug', 'appq-integration-center'); ?></button>
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#add_mapping_field_modal"><?php _e('New mapping field', 'appq-integration-center'); ?></button>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <table class="table table-card visible-md visible-lg">
            <thead>
                <tr>
                    <th><?= __("Name", 'appq-integration-center'); ?></th>
                    <th><?= __("Content", 'appq-integration-center'); ?></th>
                    <th class="text-center"><?= __("Needs sanitizing", 'appq-integration-center'); ?></th>
                    <th class="text-center"><?= __("Contains JSON", 'appq-integration-center'); ?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($field_mapping as $key => $item) : ?>
                    <tr>
                        <td><?= $key ?></td>
                        <td><?= array_key_exists('value', $item) ? nl2br($item['value']) : '' ?></td>
                        <td><i class="fa <?= array_key_exists('sanitize', $item) && $item['sanitize'] == 'on' ? 'fa-check text-success' : '' ?>"></i></td>
                        <td><i class="fa <?= array_key_exists('is_json', $item) && $item['is_json'] == 'on' ? 'fa-minus' : '' ?>"></i></td>
                        <td>
                            <button data-toggle="modal" data-target="#add_mapping_field_modal" type="button" class="btn btn-secondary mr-1 edit-mapping-field" data-key="<?= esc_attr($key) ?>" data-content="<?= isset($item['value']) ? esc_attr($item['value']) : '' ?>" data-sanitize="<?= isset($item['sanitize']) ? esc_attr($item['sanitize']) : '' ?>" data-json="<?= isset($item['is_json']) ? esc_attr($item['is_json']) : '' ?>">
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button data-toggle="modal" data-target="#delete_mapping_field_modal" type="button" class="btn btn-secondary delete-mapping-field" data-key="<?= esc_attr($key) ?>">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>