<?php

function appq_delete_custom_field() {
	global $tbdb;
	$cp_id = array_key_exists("cp_id",$_POST) ? intval($_POST["cp_id"]) : 0;
	$custom_map_name = array_key_exists("name",$_POST) ? $_POST["name"] : null;

	$sql = $tbdb->prepare("DELETE FROM wp_appq_integration_center_custom_map 
		WHERE campaign_id = %d AND name = %s",
   		$cp_id, $custom_map_name);
	
	$res = $tbdb->query($sql);
	
	if ($res === false) {
		wp_send_json_error();
	}

	wp_send_json_success();
}

add_action('wp_ajax_appq_delete_custom_field', 'appq_delete_custom_field');
