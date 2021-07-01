<?php 

function appq_set_visible_to_customer() {
	if (!current_user_can('manage_options')) {
		wp_send_json_error(array( "type" => "error", "message" => "You don't have permission to do this" ));
	}

    $data = array_key_exists("integrations", $_POST) ? json_decode(str_replace("\\", "", $_POST['integrations'])) : array();

	if (empty($data)) {
		wp_send_json_error(array( "type" => "error", "message" => json_last_error() ));
	}

	// Update fields
	global $wpdb;

	foreach ($data as $slug => $visible_to_customer) {
		$sql = $wpdb->prepare(
			"UPDATE " . $wpdb->prefix . "appq_integration_center_integrations SET visible_to_customer = %d WHERE integration_slug = %s;", 
			$visible_to_customer, $slug
		);
		$res = $wpdb->query($sql);

		if ($res === false) {
			wp_send_json_error(array( "type" => "error", "message" => "Something went wrong during the update" ));
		}
	}
	
	wp_send_json_success(array( "type" => "success", "message" => "Settings successfully updated!" ));	
}

add_action('wp_ajax_appq_set_visible_to_customer', 'appq_set_visible_to_customer');