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
        <div class="row">
          <div class="col-6 col-lg-4 offset-lg-2 text-center">
            <div class="wrapper p-3">
              <?php
              printf('<h4>%s</h4>', __('Import settings from an existing campaign', $this->plugin_name));
              printf('<p>%s</p>', __('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', $this->plugin_name));
              printf('<button data-toggle="modal" data-target="#import_from_cp_modal" type="button" class="btn btn-primary mt-3">%s</button>', __('Import settings', $this->plugin_name));
              ?>
            </div>
          </div>
          <div class="col-6 col-lg-4 text-center">
            <div class="wrapper p-3">
              <?php
              printf('<h4>%s</h4>', __('Create a new setup', $this->plugin_name));
              printf('<p>%s</p>', __('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', $this->plugin_name));
              printf('<button data-toggle="modal" data-target="#setup_manually_cp_modal" type="button" class="btn btn-secondary mt-3">%s</button>', __('Setup manually', $this->plugin_name));
              ?>
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
      <div class="settings-group">
        <?php
        printf('<h4>%s</h4>', __('Current setup', $this->plugin_name));
        ?>
        <div class="row">
          <div class="col-1">
            logo
          </div>
          <div class="col-11">
            <div class="row">
              <div class="col-3">Endpoint</div>
              <div class="col-3">Authentication</div>
              <div class="col-3">
                <div class="row">
                  <div class="col-6">Project ID</div>
                  <div class="col-6">Media upload</div>
                </div>
              </div>
              <div class="col-3">
                <div class="row">
                  <div class="col-6">Upload default bug</div>
                  <div class="col-6">Edit / delete</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php (method_exists($class, 'full_settings') ? $class->full_settings($campaign) : $class->settings($campaign)); ?>
    </div>
  <?php
  } ?>
</div>






<div class="row">
  <div class="col-2">
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
      <a class="nav-link active" id="general-tab" data-toggle="pill" href="#general" role="tab" aria-controls="general" aria-selected="true">Home</a>
      <?php foreach ($integrations as $integration) : ?>
        <?php
        $slug = $integration['slug'];
        $name = $integration['name'];
        ?>
        <a class="nav-link" id="<?= $slug ?>-tab" data-toggle="pill" href="#<?= $slug ?>" role="tab" aria-controls="<?= $slug ?>" aria-selected="true"><?= $name ?></a>
      <?php endforeach ?>
    </div>
  </div>
  <div class="col-10">
    <div class="tab-content" id="v-pills-tabContent">
      <div class="tab-pane active" id="general" role="tabpanel" aria-labelledby="general-tab"><?php $this->general_settings($campaign) ?></div>
      <?php foreach ($integrations as $integration) : ?>
        <?php
        $slug = $integration['slug'];
        $name = $integration['name'];
        $class = $integration['class'];
        ?>
        <div class="tab-pane" id="<?= $slug ?>" role="tabpanel" aria-labelledby="<?= $slug ?>-tab"><?= (method_exists($class, 'main_settings') ? $class->main_settings($campaign) : $class->settings($campaign)) ?></div>
      <?php endforeach ?>
    </div>
  </div>
</div>