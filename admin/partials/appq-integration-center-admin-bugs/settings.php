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
<div class="row prevent-cols-breaking">
	<div class="col-sm-6">
		<h4 class="text-primary"><?= __("Tracker settings", 'appq-integration-center') ?></h4>
	</div>
	<div class="col-sm-6">
		<a class="btn btn-link btn-primary stick-top-right" href="#oc-available-fields-<?= $campaign->id ?>" data-toggle="offcanvas">
			<?= __('Available fields', 'appq-integration-center') ?>
			<i class="fa fa-bars fa-fw"></i>
		</a>
	</div>
</div>
<?php if (empty($campaign->bugtracker)) : ?>
	<div class="settings-wizard">
		<div class="info pb-5">
			<h3 class="title"><?= __('Setup your issue tracker', 'appq-integration-center'); ?></h3>
		</div>
		<div class="actions">
			<div class="container">
				<div class="row">
					<div class="col-6 col-lg-4 offset-lg-2 text-center">
						<div class="wrapper p-3">
							<h4><?= __('Import settings from an existing campaign', 'appq-integration-center'); ?></h4>
							<button data-toggle="modal" data-target="#import_tracker_settings_modal" type="button" class="btn btn-primary mt-3">
								<?= __('Import settings', 'appq-integration-center'); ?>
							</button>',
						</div>
					</div>
					<div class="col-6 col-lg-4 text-center">
						<div class="wrapper p-3">
							<h4><?= __('Create a new setup', 'appq-integration-center') ?></h4>
							<button data-toggle="modal" data-target="#custom_tracker_settings_modal" type="button" class="btn btn-secondary mt-3">
								<?= __('Setup manually', 'appq-integration-center') ?>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php $this->partial('bugs/modal/import-tracker', [
		'campaigns' => AppQ_Integration_Center_Admin::get_campaigns(),
		'current' => $campaign
	]); ?>
<?php else :
	$bugtracker_slug = $campaign->bugtracker->integration;
	$bugtracker = array_filter($integrations, function ($var) use ($bugtracker_slug) {
		return ($var['slug'] == $bugtracker_slug);
	});
	sort($bugtracker);
	$bugtracker = $bugtracker[0];
	$class      = $bugtracker['class'];

	$class->current_setup($campaign); //Settings row
?>
	<hr>

	<!-- START .fields_mapping -->
<?php $class->get_settings($campaign, 'fields-settings'); //<!-- END .fields_mapping -->

	$this->partial('bugs/modal/new-available-field');
	$this->partial('bugs/modal/delete-tracker-settings');


	$this->partial('bugs/modal/edit-tracker', [
		'campaign'     => $campaign,
		'integrations' => $integrations,
	]);
	$apikey = '';
	if (
		property_exists($campaign, 'bugtracker')
		&& property_exists($campaign->bugtracker, 'apikey')
	) {
		$apikey = $campaign->bugtracker->apikey;
	}
	$this->partial('bugs/modal/api-key-modal', array(
		'apikey' => $apikey
	));
endif;
