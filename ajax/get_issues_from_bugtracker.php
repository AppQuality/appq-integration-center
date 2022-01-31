<?php


/**
 * Generic AJAX action to get an issue from any bug tracker
 * @method appq_get_issues_from_bugtracker
 * @date   2019-10-25T12:43:16+020
 * @author: Davide Bizzi <clochard>
 */
function appq_get_issue_from_bugtracker()
{
	try {
		$cp_id = array_key_exists('cp_id', $_POST) ? intval($_POST['cp_id']) : false;
		$issue_id = array_key_exists('issue_id', $_POST) ? $_POST['issue_id'] : false;
		$admin = new AppQ_Integration_Center_Admin('appq-integration-center', APPQ_INTEGRATION_CENTERVERSION);


		if (!$cp_id || !$issue_id) {
			wp_send_json_error('Invalid data: CP_ID or ISSUE_ID not set');
		}
		$campaign = $admin->get_campaign($cp_id);

		$bugtracker = $campaign->bugtracker;
		if (property_exists($bugtracker, 'integration')) {
			$upload_fn = 'appq_' . str_replace('-', '_', $bugtracker->integration) . '_get_issue';
		} else {
			wp_send_json_error("You need to configure the bugtracker");
		}

		$res = $upload_fn($cp_id,$issue_id);
		if ($res['status']) {
			wp_send_json_success($res['message']);
		} else {
			wp_send_json_error($res['message']);
		}
	} catch (\Throwable $ex) {
		wp_send_json_error($ex->getMessage());
	}
}

add_action('wp_ajax_appq_get_issue_from_bugtracker', 'appq_get_issue_from_bugtracker');
