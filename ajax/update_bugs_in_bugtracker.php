<?php


/**
 * Generic AJAX action to update bugs to any bug tracker
 * @method appq_upload_bugs_to_bugtracker
 * @date   2019-10-25T12:43:16+020
 * @author: Davide Bizzi <clochard>
 */
function appq_update_bugs_in_bugtracker()
{
	try {
		$cp_id = array_key_exists('cp_id', $_POST) ? intval($_POST['cp_id']) : false;
		$bug_id = array_key_exists('bug_id', $_POST) ? $_POST['bug_id'] : false;
		if ($bug_id != 'default') {
			$bug_id = intval($bug_id);
		}
		
		if (!$cp_id || !$bug_id) {
			wp_send_json_error('Invalid data: CP_ID or BUG_ID not set');
		}
		$admin = new AppQ_Integration_Center_Admin('appq-integration-center', APPQ_INTEGRATION_CENTERVERSION);
		$campaign = $admin->get_campaign($cp_id);

		$bugtracker = $campaign->bugtracker;
		if (property_exists($bugtracker, 'integration')) {
			$update_fn = 'appq_' . str_replace('-', '_', $bugtracker->integration) . '_update_bugs';
			
			if (!function_exists($update_fn)) {
				wp_send_json_error("Current bugtracker cannot handle updates. Update fn \"$update_fn\" does not exists");
			}
		} else {
			wp_send_json_error("You need to configure the bugtracker");
		}

		$res = $update_fn($cp_id,$bug_id);
		if ($res['status']) {
			wp_send_json_success($res['message']);
		} else {
			wp_send_json_error($res['message']);
		}
	} catch (\Throwable $ex) {
		wp_send_json_error($ex->getMessage());
	}
}

add_action('wp_ajax_appq_update_bugs_in_bugtracker', 'appq_update_bugs_in_bugtracker');
