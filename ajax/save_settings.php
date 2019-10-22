<?php

function appq_integration_center_save_settings()
{
	global $wpdb;
	$cp_id = array_key_exists('cp_id', $_POST) ? intval($_POST['cp_id']) : false;
	$bugtracker = array_key_exists('bugtracker', $_POST) ? $_POST['bugtracker'] : false;

	if (!($cp_id > 0) || !$bugtracker)
	{
		wp_send_json_error("Invalid data");
	}

	$has_active = intval($wpdb->get_var($wpdb->prepare('SELECT COUNT(*) FROM ' . $wpdb->prefix . 'appq_integration_center_config 
		WHERE campaign_id = %d AND is_active = 1', $cp_id)));
	if ($has_active > 0) {
		$sql = $wpdb->prepare('UPDATE ' . $wpdb->prefix . 'appq_integration_center_config
		SET is_active = 0
		WHERE campaign_id = %d AND is_active = 1
		', $cp_id);
		$wpdb->query($sql);
	}

	$sql = $wpdb->prepare('INSERT INTO ' . $wpdb->prefix . 'appq_integration_center_config (campaign_id,integration,is_active)
	VALUES (%d,%s,1) ON DUPLICATE KEY UPDATE is_active = 1
	', $cp_id, $bugtracker);
	$wpdb->query($sql);
	wp_send_json_success("ok");
}

add_action('wp_ajax_appq_integration_center_save_settings', 'appq_integration_center_save_settings');
