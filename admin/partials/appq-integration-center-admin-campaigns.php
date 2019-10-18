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

<h2>Integration Center Settings</h2>
<div>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Has Credentials?</th>
				<th>Bug Tracker</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($campaigns as $campaign) : ?>
				<tr onclick="document.location = '<?= admin_url('/admin.php?page=integration-center-campaign&id=' . $campaign['id'] )?>';" style="cursor: pointer ">
					<td><?= $campaign['id'] ?></td>
					<td><?= $campaign['title'] ?></td>
					<td><?= $campaign['credentials'] ? '<span class="fa fa-check"></span>' : '' ?></td>
					<td><?= array_key_exists('bugtracker',$campaign) ? $campaign['bugtracker']  : '' ?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>