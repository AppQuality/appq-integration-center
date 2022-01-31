<?php 


function appq_integration_center_delete_tracker_settings() {
    if(!check_ajax_referer('appq-ajax-nonce', 'nonce', false)){
        wp_send_json_error('You don\'t have the permission to do this');
	}
	
	global $tbdb;
	$cp_id = array_key_exists("cp_id",$_POST) ? intval($_POST["cp_id"]) : 0;
	
	if ( $cp_id <= 0) {
		wp_send_json_error('Invalid cp_id "'.$cp_id.'"');
	}
	
	$sql = $tbdb->prepare('SELECT * FROM ' .$tbdb->prefix .'appq_integration_center_config WHERE campaign_id = %d',$cp_id);
	$source = $tbdb->get_row($sql);
	
	if (empty($source)) {
		wp_send_json_error("No CP with id " . $cp_id);
	}

	$tbdb->delete($tbdb->prefix .'appq_integration_center_config',array(
		'campaign_id' => $cp_id
	));	
	
	wp_send_json_success();	
}

add_action('wp_ajax_appq_integration_center_delete_tracker_settings', 'appq_integration_center_delete_tracker_settings');
