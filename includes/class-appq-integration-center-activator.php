<?php


/**
 * Fired during plugin activation
 *
 * @link       https://bitbucket.org/appqdevel/appq-integration-center
 * @since      1.0.0
 *
 * @package    AppQ_Integration_Center
 * @subpackage AppQ_Integration_Center/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    AppQ_Integration_Center
 * @subpackage AppQ_Integration_Center/includes
 * @author     Davide Bizzi <davide.bizzi@app-quality.com>
 */
class AppQ_Integration_Center_Activator
{

	/**
	 * Method to call on activation
	 *
	 * Create necessary tables for configuration and uploaded bugs
	 * Fail if app-q-test plugin is not active
	 *
	 * @since    1.0.0
	 */
	public static function activate()
	{
		global $wpdb;
		$error = false;

		if (!is_plugin_active('app-q-test/app_q_test.php'))
		{
			if (!$error)
			{
				$error = array();
			}
			$error[] = "App Q Test dependency plugin is not active";
		}

		// CREATE TABLES
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		$table = $wpdb->prefix . "appq_integration_center_bugs";
		if ($wpdb->get_var('SHOW TABLES LIKE "'.$table.'"') == $table) {
			$wpdb->query("ALTER TABLE $table DROP PRIMARY KEY;");
		}
		$charset_collate = $wpdb->get_charset_collate();
		$bugUploadedTable = "CREATE TABLE $table (
			bug_id int NOT NULL,
			integration varchar(32),
            upload_date timestamp NULL DEFAULT CURRENT_TIMESTAMP,
     		PRIMARY KEY  (bug_id, integration)
        ) $charset_collate;";
		dbDelta($bugUploadedTable);

		$table = $wpdb->prefix . "appq_integration_center_config";
		if ($wpdb->get_var('SHOW TABLES LIKE "'.$table.'"') == $table) {
			$wpdb->query("ALTER TABLE $table DROP PRIMARY KEY;");
		}
		$campaignConfigTable = "CREATE TABLE $table (
			campaign_id int NOT NULL,
			integration varchar(32) NOT NULL,
			endpoint varchar(128),
			apikey varchar(512),	
			field_mapping text,
			is_active boolean default 0,
			upload_media boolean default 1,
     		PRIMARY KEY  (campaign_id, integration)
		) $charset_collate;";
		dbDelta($campaignConfigTable);

		if ($error)
		{
			die('Plugin NOT activated: ' . implode(', ', $error));
		}
	}
}
