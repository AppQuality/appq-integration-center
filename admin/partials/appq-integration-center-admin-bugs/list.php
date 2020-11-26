<?php 
/*
 * The Bugs list tab partial for upload
 * 
 * @Author: Davide Bizzi <clochard>
 * @Date:   23/10/2019
 * @Filename: list.php
 * @Last modified by:   clochard
 * @Last modified time: 26/05/2020
 */

?>
<input id="bugs_list-search" class="float-right form-control mr-sm-2 custom-search" type="search" placeholder="Search by id, name, category, status, severity,tags or 'duplicated','unique','uploaded','to-upload'. The search is in OR, use + to search in AND (e.g. HIGH+approved)" aria-label="Search">
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
				<td class="uploaded" style="display:none"><?= $bug->uploaded ? 'uploaded' : 'to-upload' ?></td>
				<td class="duplicated" style="display:none"><?= $bug->is_duplicated ? 'duplicated' : 'unique' ?></td>
				<td>
				  <input class="check" type="checkbox" aria-label="Select for upload">
				</td>
				<td class="id"><?= $bug->id ?></td>
				<td class="name"><?= $bug->message ?></td>
				<td class="category"><?= $bug->category ?></td>
				<td class="status"><?= $bug->status ?></td>
				<td class="severity"><?= $bug->severity ?></td>
				<td><?= $bug->is_duplicated ? '<span class="fa fa-check"></span>' : '' ?></td>
				<td class="tags"><?= '#' . implode(', #',$bug->tags) ?></td>
				<td style="display:flex">
					<?php if ($bug->uploaded) : ?>
						<?php if (property_exists($bug,'bugtracker_id')) : ?>
							<button data-bug-id="<?= $bug->id ?>" class="btn-link text-dark btn fa fa-upload update_bug"></button>
							<button data-bug-id="<?= $bug->id ?>" data-bugtracker-id="<?= $bug->bugtracker_id ?>" class="btn delete_issue fa fa-close text-danger"></button>
						<?php else : ?>
							<span class="fa fa-upload text-secondary btn-flat btn"></span>
						<?php endif ?>
					<?php else: ?>
						<button data-bug-id="<?= $bug->id ?>" class="btn-link text-dark btn fa fa-upload upload_bug"></button>
					<?php endif ?>
				<td class="is_uploaded">
				<?php if ($bug->uploaded): ?>
					<?php if ($bug->bugtracker_url) : ?>
						<a href="<?=$bug->bugtracker_url ?>" target="_blank"><span class="fa fa-external-link"></span></a>
					<?php else: ?>
						<span class="fa fa-check"></span>
					<?php endif ?>
				<?php endif ?>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
<button class="send-all btn-primary btn">Send All</button>
<button class="send-selected btn-primary btn">Send Selected</button>
