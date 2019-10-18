<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://bitbucket.org/appqdevel/appq-integration-center
 * @since      1.0.0
 *
 * @package    AppQ_Integration_Center
 * @subpackage AppQ_Integration_Center/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
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
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/** 
	 * An array of integration types
	 * @var array
	 */
	private $integrations;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $appq_integration_center       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->integrations = apply_filters( 'register_integrations', null );
		


	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( 'bootstrap', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), '4.1.3', 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/appq-integration-center-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( 'bootstrap', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array(), '4.1.3', 'all' );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/appq-integration-center-admin.js', array( 'jquery' ), $this->version, false );

	}
	

	/**
	 * Register the WP admin menus.
	 *
	 * @since    1.0.0
	 */
	public function register_menus() {

	    add_menu_page(
	        __( 'Integration center', $this->plugin_name ),
	        'Integration center',
	        'manage_options',
			'integration-center',
	        array($this,'settings_page'),
	        plugins_url( $this->plugin_name . '/admin/images/icon.png' ),
	        6
	    );
		
		
	}
	
	
	/** 
	 * Settings page show
	 * @method settings_page
	 * @date   2019-10-17T14:30:28+020
	 * @author: Davide Bizzi <clochard>
	 */
	public function settings_page() {
	   $this->partial('settings');
	}
	/** 
	 * Return admin partial path
	 * @var $slug
	 */
	public function get_partial($slug) {
		return $this->plugin_name . '/admin/partials/appq-integration-center-admin-'. $slug .'.php';
	}
	/** 
	 * Include admin partial
	 * @var $slug
	 */
	public function partial($slug,$variables = false) {
		if ($variables) {
			foreach ($variables as $key => $value) {
				${$key} = $value;
			}
		}
		include(WP_PLUGIN_DIR . '/' . $this->get_partial($slug));
	}
	
	}
}
