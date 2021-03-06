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
if (function_exists('pll_current_language')) {
    $currentLanguage = pll_current_language() == pll_default_language() ? '' : pll_current_language();
} else {
    $currentLanguage = '';
}

$bugLink = function_exists('appq_get_translated_page') ? appq_get_translated_page('functional-customer-dashboard') : rtrim(site_url(), "/") . '/functional-customer-dashboard';
$bugLink = rtrim($bugLink, "/");

?>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-content">
                    <input id="bugs_list-search" class="form-control custom-search w-100" type="search" placeholder="<?= __("Search...", 'appq-integration-center'); ?>" aria-label="Search">
                </div>
                <div class="input-group-btn">
                    <button class="send-all btn btn-primary btn"><?= __("Send All", 'appq-integration-center') ?></button>
                    <button class="send-selected btn btn-primary btn"><?= __("Send Selected", 'appq-integration-center') ?></button>
                </div>
            </div>
            <p class="help-text text-muted"><?= __("Search by id, name, category, status, severity,tags or 'duplicated','unique','uploaded','to-upload'. The search is in OR, use + to search in AND (e.g. HIGH+approved)", 'appq-integration-center'); ?></p>
        </div>
    </div>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th><input class="select_all" type="checkbox" aria-label="Select all for upload"></th>
            <th>#</th>
            <th><?= __("View", 'appq-integration-center') ?></th>
            <th><?= __("Message", 'appq-integration-center') ?></th>
            <th><?= __("Category", 'appq-integration-center') ?></th>
            <th><?= __("Status", 'appq-integration-center') ?></th>
            <th><?= __("Severity", 'appq-integration-center') ?></th>
            <th><?= __("Duplicated", 'appq-integration-center') ?></th>
            <th><?= __("Tags", 'appq-integration-center') ?></th>
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
                <td><a href="<?= sprintf("%s/?cid=%d&bug_id=%d",$bugLink, $bug->campaign_id, $bug->id); ?>"><i class="fa fa-search"></i></a></td>
                <td class="name"><?= $bug->message ?></td>
                <td class="category"><?= $bug->category ?></td>
                <td class="status"><?= $bug->status ?></td>
                <td class="severity"><?= $bug->severity ?></td>
                <td><?= $bug->is_duplicated ? '<span class="fa fa-check"></span>' : '' ?></td>
                <td class="tags"><?= '#' . implode(', #', $bug->tags) ?></td>
                <td style="display:flex">
                    <?php if ($bug->uploaded) : ?>
                        <?php if (property_exists($bug, 'bugtracker_id')) : ?>
                            <button data-bug-id="<?= $bug->id ?>" class="btn-link text-dark btn fa fa-upload update_bug"></button>
                            <button data-bug-id="<?= $bug->id ?>" data-bugtracker-id="<?= $bug->bugtracker_id ?>" class="btn delete_issue fa fa-trash text-danger"></button>
                        <?php else : ?>
                            <span class="fa fa-upload text-secondary btn-flat btn"></span>
                        <?php endif ?>
                    <?php else : ?>
                        <button data-bug-id="<?= $bug->id ?>" class="btn-link text-dark btn fa fa-upload upload_bug"></button>
                    <?php endif ?>
                <td class="is_uploaded">
                    <?php if ($bug->uploaded) : ?>
                        <?php if ($bug->bugtracker_url) : ?>
                            <a href="<?= $bug->bugtracker_url ?>" target="_blank"><span class="fa fa-external-link"></span></a>
                        <?php else : ?>
                            <span class="fa fa-check"></span>
                        <?php endif ?>
                    <?php endif ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>