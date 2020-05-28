<?php


/**
 * Generic AJAX action to delete bugs from any bug tracker
 * @method appq_delete_bug_from_bugtracker
 * @date   2020-05-26T18:12:39+020
 * @author: Davide Bizzi <clochard>
 */
function appq_delete_bug_from_bugtracker()
{
	try {
		$cp_id = array_key_exists('cp_id', $_POST) ? intval($_POST['cp_id']) : false;
		$bugtracker_id = array_key_exists('bugtracker_id', $_POST) ? $_POST['bugtracker_id'] : false;

		if (!$cp_id || !$bugtracker_id) {
			wp_send_json_error('Invalid data: CP_ID or bugtracker_id not set');
		}
		$campaign = AppQ_Integration_Center_Admin::get_campaign($cp_id);

		$bugtracker = $campaign->bugtracker;
		if (property_exists($bugtracker, 'integration')) {
			$delete_fn = 'appq_' . str_replace('-', '_', $bugtracker->integration) . '_delete_bugs';
		} else {
			wp_send_json_error("You need to configure the bugtracker");
		}

		$res = $delete_fn($cp_id,$bugtracker_id);
		if ($res['status']) {
			wp_send_json_success($res['data']);
		} else {
			wp_send_json_error($res['data']);
		}
	} catch (\Throwable $ex) {
		wp_send_json_error($ex->getMessage());
	}
}

add_action('wp_ajax_appq_delete_bug_from_bugtracker', 'appq_delete_bug_from_bugtracker');
