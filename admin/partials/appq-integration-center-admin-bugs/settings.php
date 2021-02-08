<?php
/*
 * The settings tab partial
 * 
 * @Author: Davide Bizzi <clochard>
 * @Date:   23/10/2019
 * @Filename: settings.php
 * @Last modified by:   clochard
 * @Last modified time: 25/10/2019
 */
?>
<div class="ux py-4">
  <?php if (empty($campaign->bugtracker)) { ?>
    <div class="settings-wizard">
      <div class="info pb-5">
        <?php
        printf('<h3 class="title">%s</h3>', __('Setup your issue tracker', $this->plugin_name));
        printf('<p class="description">%s</p>', __('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', $this->plugin_name));
        ?>
      </div>
      <div class="actions">
        <div class="container">
          <div class="row">
            <div class="col-6 col-lg-4 offset-lg-2 text-center">
              <div class="wrapper p-3">
                <?php
                printf('<h4>%s</h4>', __('Import settings from an existing campaign', $this->plugin_name));
                printf('<p>%s</p>', __('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', $this->plugin_name));
                printf('<button data-toggle="modal" data-target="#import_tracker_settings_modal" type="button" class="btn btn-primary mt-3">%s</button>', __('Import settings', $this->plugin_name));
                ?>
              </div>
            </div>
            <div class="col-6 col-lg-4 text-center">
              <div class="wrapper p-3">
                <?php
                printf('<h4>%s</h4>', __('Create a new setup', $this->plugin_name));
                printf('<p>%s</p>', __('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', $this->plugin_name));
                printf('<button data-toggle="modal" data-target="#custom_tracker_settings_modal" type="button" class="btn btn-secondary mt-3">%s</button>', __('Setup manually', $this->plugin_name));
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php } else {
    $bugtracker_slug = $campaign->bugtracker->integration;
    $bugtracker = array_filter($integrations, function ($var) use ($bugtracker_slug) {
      return ($var['slug'] == $bugtracker_slug);
    });
    sort($bugtracker);
    $bugtracker = $bugtracker[0];
    $class = $bugtracker['class'];
  ?>
    <div class="settings container-fluid">
      <?php $class->get_settings($campaign, 'current-settings'); ?>
      <div class="settings-group available_fields">
        <div class="row">
          <div class="col-10">
            <button class="btn btn-no-style collapsed" type="button" data-toggle="collapse" data-target="#available_fields" aria-expanded="false" aria-controls="available_fields">
            <?php printf('<h4 class="title py-3">%s</h4>', __('Available fields', $this->plugin_name)); ?>
            <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </button>
          </div>
          <div class="col-2 text-right actions">
            <button type="button" class="btn btn-secondary  mt-2" data-toggle="modal" data-target="#add_field_modal"><?php _e('New available field', $this->plugin_name); ?></button>
          </div>
        </div>
        <div class="collapse mb-3" id="available_fields">
          <?php $this->fields_settings($campaign) ?>
        </div>
      </div>
      <div class="settings-group fields_mapping border-0">
        <?php $class->get_settings($campaign, 'fields-settings') ?>
      </div>
    </div>
  <?php
  }
  $this->partial('bugs/add-field-modal', array());
  $this->partial('bugs/import-tracker-modal', [
    'campaigns' => AppQ_Integration_Center_Admin::get_campaigns()
  ]);
  $this->partial('bugs/custom-tracker-modal', [
    'campaign' => $campaign,
    'integrations' => $integrations,
  ]);
  $this->partial('bugs/reset-tracker-modal');
  ?>
</div>