
<table class="table table-striped">
	<thead>
		<tr>
			<th><input type="checkbox" aria-label="Select all for upload"></th>
			<th>#</th>
			<th>Message</th>
			<th>Category</th>
			<th>Status</th>
			<th>Severity</th>
			<th>Duplicate</th>
			<th>Tags</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($bugs as $bug) : ?>
			<tr>
				<td>
				  <input type="checkbox" aria-label="Select for upload">
				</td>
				<td><?= $bug->id ?></td>
				<td><?= $bug->message ?></td>
				<td><?= $bug->category ?></td>
				<td><?= $bug->status ?></td>
				<td><?= $bug->severity ?></td>
				<td><?= $bug->is_duplicated ? '<span class="fa fa-check"></span>' : '' ?></td>
				<td><?= '#' . implode(', #',$bug->tags) ?></td>
				<td><?= $bug->uploaded ? '<span class="fa fa-upload text-secondary"></span>' : '<span data-bug-id="'.$bug->id.'" class="fa fa-upload"></span>' ?></td>
				<td><?= $bug->uploaded ? '<span class="fa fa-check"></span>' : '' ?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>