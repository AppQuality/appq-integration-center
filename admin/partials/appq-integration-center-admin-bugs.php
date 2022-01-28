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
<h2 class="text-primary"><?= $campaign->title ?></h2>
<div class="card">
	<div class="card-head">
		<ul class="nav nav-tabs tabs-accent" id="campaign-tabs" data-toggle="tabs">
			<li class="active"><a id="bugs-tab" data-toggle="tab" href="#bugs_list"><?= __("Bugs", 'appq-integration-center') ?></a></li>
			<li><a id="settings-tab" data-toggle="tab" href="#settings"><?= __("Settings", 'appq-integration-center') ?></a></li>
		</ul>
	</div>

	<div class="card-body">
		<div class="tab-content" id="bugs-tabs-content">
			<div class="tab-pane active" id="bugs_list" role="tabpanel" aria-labelledby="bugs-tab">
				<?php $this->partial('bugs/list', array('bugs' => $bugs)) ?>
			</div>
			<div class="tab-pane" id="settings" role="tabpanel" aria-labelledby="settings-tab">
				<?php $this->partial('bugs/settings', array(
					'integrations' => $this->get_integrations(),
					'campaign'     => $campaign
				)) ?>
			</div>
		</div>
	</div>
</div>