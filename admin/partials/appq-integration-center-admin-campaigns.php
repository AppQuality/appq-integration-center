<?php
/**
 * The settings view area 
 *
 * @link       https://bitbucket.org/appqdevel/appq-integration-center
 * @since      1.0.0
 *
 * @package    AppQ_Integration_Center
 * @subpackage AppQ_Integration_Center/admin/partials
 */

?>

<h2>Integration Center Settings</h2>
<div id="campaigns_list">
	<input class="float-right form-control mr-sm-2 fuzzy-search" type="search" placeholder="Search by id, name or bugtracker" aria-label="Search">
	<table class="table table-striped">
		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Has Credentials?</th>
				<th>Bug Tracker</th>
			</tr>
		</thead>
		<tbody class="list">
			<?php foreach ($campaigns as $campaign) : ?>
				<tr onclick="document.location = '<?= admin_url('/admin.php?page=integration-center-campaign&id=' . $campaign->id )?>';" style="cursor: pointer ">
					<td class="id"><?= $campaign->id ?></td>
					<td class="name"><?= $campaign->title ?></td>
					<td><?= $campaign->credentials ? '<span class="fa fa-check"></span>' : '' ?></td>
					<td class="bugtracker"><?= property_exists($campaign,'bugtracker') && !empty($campaign->bugtracker) ? $campaign->bugtracker->integration  : '' ?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>