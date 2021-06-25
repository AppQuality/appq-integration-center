<?php if ( isset( $campaign->bugtracker->integration ) && $campaign->bugtracker->integration !== "csv_exporter" ): ?>

	<?php if ( isset( $campaign->bugtracker->default_bug ) ): ?>

						<button id="update_default_bug" class="btn btn-secondary mr-1" title="Click to update the example bug previously uploaded" type="button">
			<?= __( 'Update example issue', $this->plugin_name ) ?>
						</button>
						<a href="<?= $campaign->bugtracker->default_bug; ?>" target="_blank" class="btn btn-secondary mr-1"
							title="<?= __( 'Show example issue', $this->plugin_name ) ?>">
								<i class="fa fa-external-link"></i>
						</a>

	<?php else: ?>

						<button id="import_default_bug" type="button" class="btn btn-secondary mr-1">
			<?=  __( 'Create example issue', $this->plugin_name ) ?>
						</button>
	<?php endif; ?>

<?php endif; ?>

		<button data-toggle="modal" data-target="#custom_tracker_settings_modal" type="button" class="btn btn-secondary mr-1">
				<i class="fa fa-pencil"></i>
		</button>
		<button data-toggle="modal" data-target="#reset_tracker_settings" type="button" class="btn btn-secondary mr-1">
				<i class="fa fa-trash"></i>
		</button>
