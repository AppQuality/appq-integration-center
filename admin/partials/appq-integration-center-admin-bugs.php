<?php

/**
 * The Bug upload and settings view area
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://bitbucket.org/appqdevel/appq-integration-center
 * @since      1.0.0
 *
 * @package    AppQ_Integration_Center
 * @subpackage AppQ_Integration_Center/admin/partials
 */
?>
<input type="hidden" value="<?= $campaign->id ?>" id="campaign_id" />
<h2><?= $campaign->title ?></h2>
<div class="card">
    <ul class="nav nav-tabs" id="campaign-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active px-5 clean" id="bugs-tab" data-toggle="tab" href="#bugs_list">
                Bugs
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link px-5 clean" id="settings-tab" data-toggle="tab" href="#settings" role="tab">
                Settings
            </a>
        </li>
    </ul>
  <div class="card-body">
    <div class="tab-content" id="bugs-tabs-content">
        <input id="cp_id" type="hidden" value="<?= $campaign->id ?>"/>
        <div class="tab-pane active" id="bugs_list" role="tabpanel"
             aria-labelledby="bugs-tab">
            <?php $this->partial( 'bugs/list', array( 'bugs' => $bugs ) ) ?>
        </div>
        <div class="tab-pane" id="settings" role="tabpanel"
             aria-labelledby="settings-tab">
            <?php $this->partial( 'bugs/settings', array(
				'integrations' => $this->get_integrations(),
				'campaign'     => $campaign
			) ) ?>
        </div>
    </div>
</div>
</div>
