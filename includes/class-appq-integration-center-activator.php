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
class AppQ_Integration_Center_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		$error = false;
		
		if (!is_plugin_active('app-q-test/app_q_test.php'))
		{
			if (!$error)
			{
				$error = array();
			}
			$error[] = "App Q Test dependency plugin is not active";
		}
		
		
		
		
		if ($error) 
		{
			die('Plugin NOT activated: ' . implode(', ',$error));
		}
	}

}
