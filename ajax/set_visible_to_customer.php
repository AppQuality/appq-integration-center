<?php 

function appq_set_visible_to_customer() {
	global $wpdb;
	$cp_id = array_key_exists("cp_id", $_POST) ? intval($_POST["cp_id"]) : 0;
    $visible = array_key_exists("visible_to_customer", $_POST) ? intval($_POST["visible_to_customer"]) : 0;

    if ( $cp_id <= 0 ) {
		wp_send_json_error();
	}

    // Update field
    $sql = $wpdb->prepare("UPDATE wp_appq_integration_center_config 
		SET visible_to_customer = %d WHERE is_active = 1 && campaign_id = %d;", $visible, $cp_id);
	
	$res = $wpdb->query($sql);
	
	if ($res === false) {
		wp_send_json_error();
	}
	
	wp_send_json_success();	
}

add_action('wp_ajax_appq_set_visible_to_customer', 'appq_set_visible_to_customer');