<?php
$endpoint = isset(json_decode($campaign->bugtracker->endpoint)->endpoint) ? json_decode($campaign->bugtracker->endpoint)->endpoint : $campaign->bugtracker->endpoint;
$project = isset(json_decode($campaign->bugtracker->endpoint)->project) ? json_decode($campaign->bugtracker->endpoint)->project : false;

printf('<h4 class="title py-3">%s</h4>', __('Current setup', $this->plugin_name));
?>
<div class="row mb-3">
    <div class="col-1">
        <?php printf('<small>%s</small>', __('Tracker', $this->plugin_name)); ?>
        <?php
        printf(
            '<img src="%s" alt="%s">',
            APPQ_INTEGRATION_CENTERURL . 'admin/images/' . $campaign->bugtracker->integration . '.svg',
            $campaign->bugtracker->integration
        );
        ?>
    </div>
    <div class="col-3">
        <?php
        printf('<small>%s</small>', __('Endpoint', $this->plugin_name));
        echo $endpoint;
        ?>
    </div>
    <div class="col-3">
        <?php
        printf('<small>%s</small>', __('Authentication', $this->plugin_name));
        echo $campaign->bugtracker->apikey;
        ?>
    </div>
    <div class="col-1">
        <?php
        printf('<small>%s</small>', __('Project ID', $this->plugin_name));
        echo $project;
        ?>
    </div>
    <div class="col-1">
        <?php
        printf('<small>%s</small>', __('Media upload', $this->plugin_name));
        echo (isset($campaign->bugtracker->upload_media) && $campaign->bugtracker->upload_media == 1 ? __('Yes', $this->plugin_name) : __('No', $this->plugin_name));
        ?>
    </div>
    <div class="col-3 text-right actions">
        <?php
        if (isset($campaign->bugtracker->default_bug)) {
            printf(
                '<button id="update_default_bug" type="button" class="btn btn-secondary mr-2">%s</button>',
                __('Update', $this->plugin_name)
            );
            printf(
                '<a href="%s" target="_blank" class="btn btn-secondary mr-1" title="%s"><i class="fa fa-external-link"></i></a>',
                $campaign->bugtracker->default_bug,
                __('Show bug', $this->plugin_name)
            );
        } else {
            printf(
                '<button id="import_default_bug" type="button" class="btn btn-secondary mr-1">%s</button>',
                __('Import bug', $this->plugin_name)
            );
        }
        ?>
        <button data-toggle="modal" data-target="#custom_tracker_settings_modal" type="button" class="btn btn-secondary mr-1"><i class="fa fa-pencil"></i></button>
        <button data-toggle="modal" data-target="#reset_tracker_settings" type="button" class="btn btn-secondary"><i class="fa fa-trash"></i></button>
    </div>
</div>