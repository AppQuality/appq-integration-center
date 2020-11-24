<?php


/**
 * Generic AJAX action to upload bugs to any bug tracker
 * @method appq_upload_bugs_to_bugtracker
 * @date   2019-10-25T12:43:16+020
 * @author: Davide Bizzi <clochard>
 */
function appq_upload_bugs_to_bugtracker()
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
		$campaign = AppQ_Integration_Center_Admin::get_campaign($cp_id);

		$bugtracker = $campaign->bugtracker;
		if (property_exists($bugtracker, 'integration')) {
			$upload_fn = 'appq_' . str_replace('-', '_', $bugtracker->integration) . '_upload_bugs';
			
			if (!function_exists($upload_fn)) {
				wp_send_json_error("Current bugtracker cannot handle uploads. Upload fn \"$upload_fn\" does not exists");
			}
			
			if ($bug_id == 'default') {
				if (property_exists($bugtracker,'default_bug')) {
					wp_send_json_error("The bug is already uploaded on $bugtracker->default_bug");
				}
			} else {
				$uploaded_bug_id = AppQ_Integration_Center_Admin::get_uploaded_bug($bugtracker->integration,$bug_id);
			}
			
			
			if ($uploaded_bug_id) {
				$url_model_fn = 'appq_ic_'.str_replace('-', '_', $bugtracker->integration).'_get_url_model';
				if (!function_exists($url_model_fn)) {
					wp_send_json_error("$bugtracker->integration does not have a bug url model");
				}
				
				$uploaded_bug_url = str_replace('{bugtracker_id}',$uploaded_bug_id,$url_model_fn($bugtracker));
				wp_send_json_error("The bug is already uploaded on $uploaded_bug_url");
			}
		} else {
			wp_send_json_error("You need to configure the bugtracker");
		}

		$res = $upload_fn($cp_id,$bug_id);
		if ($res['status']) {
			wp_send_json_success($res['message']);
		} else {
			wp_send_json_error($res['message']);
		}
	} catch (\Throwable $ex) {
		wp_send_json_error($ex->getMessage());
	}
}

add_action('wp_ajax_appq_upload_bugs_to_bugtracker', 'appq_upload_bugs_to_bugtracker');
