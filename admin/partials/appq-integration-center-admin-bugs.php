<?php

/**
 * The settings view area 
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

<div>
	<ul class="nav nav-tabs" id="campaign-tabs" role="tablist">
	  <li class="nav-item">
	    <a class="nav-link active" id="bugs-tab" data-toggle="tab" href="#bugs" role="tab" aria-controls="home" aria-selected="true">Bugs</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="home" aria-selected="true">Settings</a>
	  </li>
	</ul>
	<div class="tab-content" id="bugs-tabs-content">
	  <h2><?= $campaign->title ?></h2>
	  <input id="cp_id" type="hidden" value="<?= $campaign->id ?>"/>
	  <div class="tab-pane active" id="bugs" role="tabpanel" aria-labelledby="bugs-tab"><?php $this->partial('bugs/list',array('bugs' => $bugs)) ?></div>
	  <div class="tab-pane" id="settings" role="tabpanel" aria-labelledby="settings-tab"><?php $this->partial('bugs/settings',array('integrations' => $this->get_integrations(), 'campaign' => $campaign)) ?></div>
	</div>
</div>