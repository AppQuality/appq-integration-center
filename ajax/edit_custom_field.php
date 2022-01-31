<?php 


function appq_edit_custom_field() {
	global $tbdb;
	$cp_id = array_key_exists("cp_id",$_POST) ? intval($_POST["cp_id"]) : 0;
	$custom_map_source = array_key_exists("custom_map_source",$_POST) ? $_POST["custom_map_source"] : null;
	$custom_map_name = array_key_exists("custom_map_name",$_POST) ? $_POST["custom_map_name"] : null;
	$custom_map = array_key_exists("custom_map",$_POST) ? $_POST["custom_map"] : null;
	
	if ( $cp_id <= 0 || empty($custom_map_source) || empty($custom_map_name)) {
		wp_send_json_error($custom_map);
	}
	$custom_map_object = new stdClass();
	foreach($custom_map as $map) {
		if (array_key_exists('key',$map) && array_key_exists('value',$map) ) {
			$key = $map['key'];
			$custom_map_object->$key = $map['value'];
		}
	}
	$custom_map = json_encode($custom_map_object);
	
	$sql = $tbdb->prepare(
	    "UPDATE wp_appq_integration_center_custom_map 
		SET map = %s
        WHERE name = %s
        AND source = %s
        AND campaign_id = %d",
        $custom_map, $custom_map_name, $custom_map_source, $cp_id);
	
	$res = $tbdb->query($sql);
	
	if ($res === false) {
		wp_send_json_error();
	}  
	wp_send_json_success($custom_map);	
}

add_action('wp_ajax_appq_edit_custom_field', 'appq_edit_custom_field');
