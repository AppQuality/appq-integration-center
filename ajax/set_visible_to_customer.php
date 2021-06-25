<?php 

function appq_set_visible_to_customer() {
	if (!current_user_can('manage_options')) {
		wp_send_json_error();
	}

	global $wpdb;
	$slug = array_key_exists("slug", $_POST) ? $_POST["slug"] : "";
    $visible = array_key_exists("visible_to_customer", $_POST) ? intval($_POST["visible_to_customer"]) : 0;

    if ( $slug === "" ) {
		wp_send_json_error();
	}

    // Update field
    $sql = $wpdb->prepare("UPDATE wp_appq_integration_center_integrations 
		SET visible_to_customer = %d WHERE integration_slug = %s;", $visible, $slug);
	
	$res = $wpdb->query($sql);
	
	if ($res === false) {
		wp_send_json_error();
	}
	
	wp_send_json_success();	
}

add_action('wp_ajax_appq_set_visible_to_customer', 'appq_set_visible_to_customer');