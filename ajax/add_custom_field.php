<?php 


function appq_add_custom_field() {
	$custom_map_source = array_key_exists("custom_map_source",$_POST) ? $_POST["custom_map_source"] : null;
	$custom_map_name = array_key_exists("custom_map_name",$_POST) ? $_POST["custom_map_name"] : null;
	$custom_map = array_key_exists("custom_map",$_POST) ? $_POST["custom_map"] : null;
	
	wp_send_json_error($custom_map);
}

add_action('wp_ajax_appq_add_custom_field', 'appq_add_custom_field');
