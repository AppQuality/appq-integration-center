<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://bitbucket.org/appqdevel/appq-integration-center
 * @since      1.0.0
 *
 * @package    AppQ_Integration_Center
 * @subpackage AppQ_Integration_Center/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    AppQ_Integration_Center
 * @subpackage AppQ_Integration_Center/includes
 * @author     Davide Bizzi <davide.bizzi@app-quality.com>
 */
class AppQ_Integration_Center_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		$apl=get_option('active_plugins');
		foreach ($apl as $active_plugin) {
			$plugin_name = 'appq-integration-center';
			$is_from_this_type = strpos($active_plugin,$plugin_name) === 0;
			$is_main_plugin = strpos($active_plugin,$plugin_name .'.php') !== false;
			if( $is_from_this_type && ! $is_main_plugin) {
				add_action('update_option_active_plugins',function() use($active_plugin){
					deactivate_plugins($active_plugin);
				});
			}
		}
	}

}
