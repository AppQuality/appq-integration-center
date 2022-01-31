<div class="btn-group">
	<?php if (isset($campaign->bugtracker->integration) && $campaign->bugtracker->integration !== "csv_exporter") : ?>

		<?php if (isset($campaign->bugtracker->default_bug)) : ?>

			<button id="update_default_bug" class="btn btn-primary" title="Click to update the example bug previously uploaded" type="button">
				<?= __('Update example issue', 'appq-integration-center') ?>
			</button>
			<a href="<?= $campaign->bugtracker->default_bug; ?>" target="_blank" class="btn btn-primary" title="<?= __('Show example issue', 'appq-integration-center') ?>">
				<i class="fa fa-external-link"></i>
			</a>

		<?php else : ?>

			<button id="import_default_bug" type="button" class="btn btn-primary">
				<?= __('Create example issue', 'appq-integration-center') ?>
			</button>
		<?php endif; ?>

	<?php endif; ?>

	<button data-toggle="modal" data-target="#custom_tracker_settings_modal" type="button" class="btn btn-primary">
		<i class="fa fa-pencil"></i>
	</button>
	<button data-toggle="modal" data-target="#reset_tracker_settings" type="button" class="btn btn-primary">
		<i class="fa fa-trash"></i>
	</button>
</div>