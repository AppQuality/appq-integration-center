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
		
		<div id="capability">
			<form method="post" action="options.php">
				<?php settings_fields( $group_name ); ?>
				<?php foreach ($settings as $setting_name => $setting_data) : ?>
					<div class="form-group row">
						<h4 for="<?= $setting_name ?>" class="col-sm-2 col-form-label"><?= $setting_data['label'] ?></h4>
						<div class="col-sm-10">
							<?php $this->partial('settings/' . $setting_data['type'],array(
								'setting_name' => $setting_name,
								'setting_data' => $setting_data,
							)) ?>
						</div>
					</div>
				<?php endforeach ?>
				<?php submit_button(__( "Save Capability", 'appq-integration-center' )); ?>
			</form>
		</div>
			
		<div id="visibility">
			<h4><?= __( 'Customer Visibility', 'appq-integration-center' ) ?></h4>
			<table>
				<tbody>
					<?php foreach ($integrations as $integration) : ?>
						<tr>
							<td>
								<b><?= __( $integration['name'], 'appq-integration-center' ) ?></b>
								<?= __( 'Add On', 'appq-integration-center' ) ?>
								<?=  __( 'visible to customer', 'appq-integration-center' ) ?>
							</td>
							<td>
								<input data-integration="<?= $integration['slug'] ?>" class="visible_to_customer" <?= ($integration['visible_to_customer']) ? 'checked="checked"' : '' ?> type="checkbox" name="visible_to_customer" style="margin-left: 10px;">
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
			<p class="submit">
				<button id="save_visibility" type="button" class="button button-primary"><?= __( "Save Visibility", 'appq-integration-center' ); ?></button>
			</p>
		</div>
		
	</div>
</div>