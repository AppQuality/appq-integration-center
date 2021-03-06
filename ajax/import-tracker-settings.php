<?php 


function appq_integration_center_import_tracker_settings() {
    if(!check_ajax_referer('appq-ajax-nonce', 'nonce', false)){
        wp_send_json_error('You don\'t have the permission to do this');
	}
	
	global $tbdb;
	$cp_id = array_key_exists("cp_id",$_POST) ? intval($_POST["cp_id"]) : 0;
	$source_id = array_key_exists("source_id",$_POST) ? intval($_POST["source_id"]) : 0;
	
	if ( $cp_id <= 0 || $source_id <= 0 ) {
		wp_send_json_error('Invalid cp_id "'.$cp_id.'" or source_id "'.$source_id.'"');
	}
	
	$sql = $tbdb->prepare('SELECT * FROM wp_appq_integration_center_config WHERE campaign_id = %d',$source_id);
	$source = $tbdb->get_row($sql);
	
	if (empty($source)) {
		wp_send_json_error("No CP with id " . $source_id);
	}
	
	$sql = $tbdb->prepare('SELECT * FROM wp_appq_integration_center_custom_map WHERE campaign_id = %d',$source_id);
	$map_source = $tbdb->get_results($sql);
	
	$data = (array) $source;
	$data['campaign_id'] = $cp_id;
	
	$tbdb->delete('wp_appq_integration_center_config',array(
		'campaign_id' => $cp_id
	));
	$tbdb->delete('wp_appq_integration_center_custom_map',array(
		'campaign_id' => $cp_id
	));
	
	$tbdb->insert('wp_appq_integration_center_config',$data);
	if (!empty($tbdb->last_error)) {
		wp_send_json_error($tbdb->last_error);
	}
	foreach($map_source as $map) {
		$data = (array) $map;
		$data['campaign_id'] = $cp_id;
		$tbdb->insert('wp_appq_integration_center_custom_map',$data);
		
		if (!empty($tbdb->last_error)) {
			wp_send_json_error($tbdb->last_error);
		}
	}
	
	
	wp_send_json_success();	
}

add_action('wp_ajax_appq_integration_center_import_tracker_settings', 'appq_integration_center_import_tracker_settings');
