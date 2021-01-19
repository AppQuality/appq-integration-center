<?php

function appq_save_tracker_settings()
{
    if(!check_ajax_referer('appq-ajax-nonce', 'nonce', false)){
        wp_send_json_error('You don\'t have the permission to do this');
    }

    global $wpdb;
    $cp_id = array_key_exists('cp_id', $_POST) ? intval($_POST['cp_id']) : false;
    $bugtracker = array_key_exists('bugtracker', $_POST) ? $_POST['bugtracker'] : false;
	$upload_media = array_key_exists('media', $_POST) ? $_POST['media'] == 'on' : false;

    $data = apply_filters('appq-save-tracker-settings-data', $_REQUEST, $bugtracker);

    extract($data);

    $has_value = intval($wpdb->get_var(
        $wpdb->prepare('SELECT COUNT(*) FROM ' . $wpdb->prefix . 'appq_integration_center_config WHERE integration = "%s" AND campaign_id = %d', $bugtracker, $cp_id)
    ));
    if ($has_value === 0) {
        $wpdb->insert($wpdb->prefix . 'appq_integration_center_config', array(
            'integration' => $bugtracker,
            'campaign_id' => $cp_id,
        ));
    }
    $wpdb->update($wpdb->prefix . 'appq_integration_center_config', array(
        'endpoint' => $endpoint,
        'apikey' => $auth,
        'upload_media' => $upload_media ? 1 : 0
    ), array(
        'integration' => $bugtracker,
        'campaign_id' => $cp_id
    ));
    wp_send_json_success('ok');
}

add_action('wp_ajax_appq_save_tracker_settings', 'appq_save_tracker_settings');
