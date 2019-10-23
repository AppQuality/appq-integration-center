<?php 

function appq_upload_bugs_to_bugtracker(){
	try {
		$cp_id = array_key_exists('cp_id', $_POST) ? intval($_POST['cp_id']) : false;
		$bug_id = array_key_exists('bug_id', $_POST) ? intval($_POST['bug_id']) : false;
		
		if (!$cp_id || !$bug_id) {
			wp_send_json_error('Invalid data: CP_ID or BUG_ID not set');
		}
		$campaign = AppQ_Integration_Center_Admin::get_campaign($cp_id);
		
		$bugtracker = $campaign->bugtracker;
		if (property_exists($bugtracker,'integration')) {
			$upload_fn = 'appq_' . str_replace('-','_',$bugtracker->integration) . '_upload_bugs';
		}
		
		$res = $upload_fn($cp_id,$bug_id);
		if (is_null($res)) {
			wp_send_json_error( "Error on upload bug." );
		}
		wp_send_json_success( $res );
	} catch (\Throwable $ex) {
		wp_send_json_error( $ex->getMessage() );
	}
}

add_action( 'wp_ajax_appq_upload_bugs_to_bugtracker', 'appq_upload_bugs_to_bugtracker' );
