<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    AppQ_Integration_Center
 * @subpackage AppQ_Integration_Center/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    AppQ_Integration_Center
 * @subpackage AppQ_Integration_Center/admin
 * @author     Davide Bizzi <davide.bizzi@app-quality.com>
 */
class AppQ_Integration_Center_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $appq_integration_center    The ID of this plugin.
	 */
	private $appq_integration_center;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $appq_integration_center       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $appq_integration_center, $version ) {

		$this->appq_integration_center = $appq_integration_center;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in AppQ_Integration_Center_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The AppQ_Integration_Center_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->appq_integration_center, plugin_dir_url( __FILE__ ) . 'css/appq-integration-center-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in AppQ_Integration_Center_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The AppQ_Integration_Center_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->appq_integration_center, plugin_dir_url( __FILE__ ) . 'js/appq-integration-center-admin.js', array( 'jquery' ), $this->version, false );

	}

}
