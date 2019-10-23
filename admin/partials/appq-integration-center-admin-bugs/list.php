<input id="bugs_list-search" class="float-right form-control mr-sm-2 custom-search" type="search" placeholder="Search by id, name, category, status, severity,tags or 'duplicated','uploaded'. The search is in OR, use + to search in AND (e.g. HIGH+approved)" aria-label="Search">
<button class="send-all btn-primary btn">Send All</button>
<button class="send-selected btn-primary btn">Send Selected</button>
<table class="table table-striped">
	<thead>
		<tr>
			<th><input class="select_all" type="checkbox" aria-label="Select all for upload"></th>
			<th>#</th>
			<th>Message</th>
			<th>Category</th>
			<th>Status</th>
			<th>Severity</th>
			<th>Duplicated</th>
			<th>Tags</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody class="list">
		<?php foreach ($bugs as $bug) : ?>
			<tr>
				<td class="uploaded" style="display:none"><?= $bug->uploaded ? 'uploaded' : '' ?></td>
				<td class="duplicated" style="display:none"><?= $bug->is_duplicated ? 'duplicated' : '' ?></td>
				<td>
				  <input class="check" type="checkbox" aria-label="Select for upload">
				</td>
				<td class="id"><?= $bug->id ?></td>
				<td class="name"><?= $bug->message ?></td>
				<td class="category"><?= $bug->category ?></td>
				<td class="status"><?= $bug->status ?></td>
				<td class="severity"><?= $bug->severity ?></td>
				<td data-is_duplicated="<?= $bug->is_duplicated ? 'duplicated' : '' ?>"><?= $bug->is_duplicated ? '<span class="fa fa-check"></span>' : '' ?></td>
				<td class="tags"><?= '#' . implode(', #',$bug->tags) ?></td>
				<td><?= $bug->uploaded ? '<span class="fa fa-upload text-secondary"></span>' : '<span data-bug-id="'.$bug->id.'" class="fa fa-upload"></span>' ?></td>
				<td class="is_uploaded"><?= $bug->uploaded ? '<span class="fa fa-check"></span>' : '' ?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
<button class="send-all btn-primary btn">Send All</button>
<button class="send-selected btn-primary btn">Send Selected</button>