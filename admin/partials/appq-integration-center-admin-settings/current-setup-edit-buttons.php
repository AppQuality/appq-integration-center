<?php $is_visible_to_customer = intval($campaign->bugtracker->visible_to_customer); ?>

<?php if ( isset( $campaign->bugtracker->integration ) && $campaign->bugtracker->integration !== "csv_exporter" ): ?>

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

		<button data-toggle="modal" data-target="#custom_tracker_settings_modal" type="button" class="btn btn-secondary mr-1">
				<i class="fa fa-pencil"></i>
		</button>
		<button data-toggle="modal" data-target="#reset_tracker_settings" type="button" class="btn btn-secondary mr-1">
				<i class="fa fa-trash"></i>
		</button>

		<?php if (!is_a_customer()): ?>
			<label id="label_visible_to_customer" for="visible_to_customer">
				<input id="visible_to_customer" <?= ($is_visible_to_customer) ? 'checked="checked"' : '' ?> type="checkbox" name="visible_to_customer">
				<span><?=  __( 'Visible to customer', $this->plugin_name ) ?></span>
			</label>
		<?php endif; ?>

