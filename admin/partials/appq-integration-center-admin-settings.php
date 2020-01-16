<?php

/**
 * The Integration Center settings view area 
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
	<h2>Integration Center Settings</h2>
	<div class="container-fluid">
		
  		<form method="post" action="options.php">
			<?php settings_fields( $group_name ); ?>
			<?php foreach ($settings as $setting_name => $setting_data) : ?>
				<div class="form-group row">
					<label for="<?= $setting_name ?>" class="col-sm-2 col-form-label"><?= $setting_data['label'] ?></label>
					<div class="col-sm-10">
						<?php $this->partial('settings/' . $setting_data['type'],array(
							'setting_name' => $setting_name,
							'setting_data' => $setting_data,
						)) ?>
					</div>
				</div>
			<?php endforeach ?>
  			<?php  submit_button(); ?>
		</form>
	</div>
</div>