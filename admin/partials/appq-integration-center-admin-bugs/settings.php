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

	<h4 class="pb-3"><?= __("Tracker settings", $this->plugin_name) ?></h4>
	<div class="pb-4">
		<?php if ( empty( $campaign->bugtracker ) ): ?>
	        <div class="settings-wizard">
	            <div class="info pb-5">
					<?php
					printf( '<h3 class="title">%s</h3>', __( 'Setup your issue tracker', $this->plugin_name ) );
					?>
	            </div>
	            <div class="actions">
	                <div class="container">
	                    <div class="row">
	                        <div class="col-6 col-lg-4 offset-lg-2 text-center">
	                            <div class="wrapper p-3">
									<?php
									printf( '<h4>%s</h4>', __( 'Import settings from an existing campaign', $this->plugin_name ) );
									printf( '<button data-toggle="modal" data-target="#import_tracker_settings_modal" type="button" class="btn btn-primary mt-3">%s</button>', __( 'Import settings', $this->plugin_name ) );
									?>
	                            </div>
	                        </div>
	                        <div class="col-6 col-lg-4 text-center">
	                            <div class="wrapper p-3">
									<?php
									printf( '<h4>%s</h4>', __( 'Create a new setup', $this->plugin_name ) );
									printf( '<button data-toggle="modal" data-target="#custom_tracker_settings_modal" type="button" class="btn btn-secondary mt-3">%s</button>', __( 'Setup manually', $this->plugin_name ) );
									?>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
		<?php else :
		$bugtracker_slug = $campaign->bugtracker->integration;
		$bugtracker = array_filter( $integrations, function ( $var ) use ( $bugtracker_slug ) {
			return ( $var['slug'] == $bugtracker_slug );
		} );
		sort( $bugtracker );
		$bugtracker = $bugtracker[0];
		$class      = $bugtracker['class'];
		?>
	    <div class="settings">
	        <div class="settings-group mb-3">
				<?php $class->current_setup( $campaign ) ?>
	        </div>
	        <div class="settings-group available_fields accordion-fields-<?= $bugtracker_slug; ?>">
	            <div class="accordion" id="accordionFields">
	                <div class="row">
	                    <div class="col-12">
	                        <a class="btn btn-link btn-block p-0" type="button" data-toggle="collapse" data-target="#available_fields_<?= $bugtracker_slug; ?>" aria-expanded="true" aria-controls="available_fields">
	                            <div class="card-header">
	                                <h5 class="m-0 text-left">
										<?= __( 'Available fields', $this->plugin_name ); ?>
	                                    <i class="fa fa-angle-down"></i>
	                                </h5>
	                            </div>
	                        </a>
	                    </div>
	                </div>

	                <div id="available_fields_<?= $bugtracker_slug; ?>" class="collapse" aria-labelledby="available_fields" data-parent="#accordionFields">
	                    <div class="row">
	                        <div class="col">
	                            <button type="button" class="btn btn-secondary float-right m-2" data-toggle="modal" data-target="#add_field_modal">
			                        <?php _e( 'Add new field', $this->plugin_name ); ?>
	                            </button>
	                        </div>
	                    </div>

						<?php $this->available_fields( $campaign ) ?>
	                </div>
	            </div>
	        </div>
	    </div>

	    <!-- START .fields_mapping -->
	    <div class="settings-group fields_mapping border-0">
			<?php
			$class->get_settings( $campaign, 'fields-settings' ) ?>
	    </div><!-- END .fields_mapping -->
	</div>
	<?php

	$this->partial( 'bugs/modal/new-available-field' );
	$this->partial( 'bugs/modal/delete-tracker-settings' );
	endif;

	$this->partial( 'bugs/modal/import-tracker', [
		'campaigns' => AppQ_Integration_Center_Admin::get_campaigns(),
		'current' => $campaign
	] );
	$this->partial( 'bugs/modal/edit-tracker', [
		'campaign'     => $campaign,
		'integrations' => $integrations,
	] );
	$apikey = '';
	if (
		property_exists($campaign,'bugtracker')
		&& property_exists($campaign->bugtracker,'apikey')
	) {
		$apikey = $campaign->bugtracker->apikey;
	}
	$this->partial( 'bugs/modal/api-key-modal', array(
		'apikey' => $apikey
	));
	?>
	</div>
