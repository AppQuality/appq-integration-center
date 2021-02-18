<?php 


function appq_add_custom_field() {
	global $wpdb;
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
	
	
	$sql = $wpdb->prepare("INSERT INTO wp_appq_integration_center_custom_map 
		(campaign_id,source,name,map)
		VALUES (%d,%s,%s,%s)
		ON DUPLICATE KEY UPDATE
		   source = %s, 
		   map = %s",
   		$cp_id,$custom_map_source,$custom_map_name,$custom_map,
		$custom_map_source,$custom_map);
	
	$res = $wpdb->query($sql);
	   
	
	if ($res === false) {
		wp_send_json_error();
	}  
	wp_send_json_success($custom_map);	
}

add_action('wp_ajax_appq_add_custom_field', 'appq_add_custom_field');
