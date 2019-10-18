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
	        array($this,'campaigns_page'),
	        plugins_url( $this->plugin_name . '/admin/images/icon.png' ),
	        6
	    );
		

	    add_submenu_page(
			'',
	        __( 'Integration center', $this->plugin_name ),
	        'Integration center',
	        'manage_options',
			'integration-center-campaign',
	        array($this,'bugs_page')
	    );
		
		
	}
	
	
	/** 
	 * Campaings page show
	 * @method campaigns_page
	 * @date   2019-10-17T14:30:28+020
	 * @author: Davide Bizzi <clochard>
	 */
	public function campaigns_page() {
		$this->partial('campaigns',array(
			'campaigns' => $this->get_campaigns()
		));
	}
	/** 
	 * Bugs page show
	 * @method campaigns_page
	 * @date   2019-10-17T14:30:28+020
	 * @author: Davide Bizzi <clochard>
	 */
	public function bugs_page() {
		if (!array_key_exists('id',$_GET)) {
			$this->partial('not-found');
			return;
		}
		$campaign = $this->get_campaign($_GET['id']);
		if (!$campaign) {
			$this->partial('not-found');
			return;
		}
		$this->partial('bugs',array(
			'bugs' => $this->get_bugs(),
			'campaign' => $campaign
		));
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
	
	public function get_campaign($id) {
		return array( 'title' => 'CPXXXX - XXXXXXX', 'credentials' => true, 'bugtracker' => 'JIRA');
	}
	
	public function get_campaigns() {
		$campaigns = array(
			array('id' => 1, 'title' => 'CPXXXX - XXXXXXX', 'credentials' => true, 'bugtracker' => 'JIRA'),
			array('id' => 2, 'title' => 'CPXXXX - XXXXXXX', 'credentials' => false),
			array('id' => 3, 'title' => 'CPXXXX - XXXXXXX', 'credentials' => true, 'bugtracker' => 'Redmine'),
			array('id' => 4, 'title' => 'CPXXXX - XXXXXXX', 'credentials' => true, 'bugtracker' => 'Not Set')
		);
		
		return $campaigns;
	}
	public function get_bugs() {
		$campaigns = array(
			array('id' => 1, 'message' => '[XXXXXX] - XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX', 'category' => 'Malfunction', 'status' => 'Approved', 'severity' => 'HIGH', 'duplicate' => true , 'tags' => array('tag1','tag2'),'uploaded' => true),
			array('id' => 2, 'message' => '[XXXXXX] - XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX', 'category' => 'Crash', 'status' => 'Refused', 'severity' => 'LOW', 'tags' => array('tag3'),'duplicate' => false,'uploaded' => true),
			array('id' => 3, 'message' => '[XXXXXX] - XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX', 'category' => 'Performance', 'status' => 'Need Review', 'severity' => 'MEDIUM','duplicate' => false, 'tags' => array('tag1'), 'bugtracker' => 'Redmine','uploaded' => false),
			array('id' => 4, 'message' => '[XXXXXX] - XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX', 'category' => 'Malfunction', 'status' => 'Approved', 'severity' => 'HIGH','duplicate' => false, 'tags' => array('tag2'), 'bugtracker' => 'Not Set','uploaded' => true)
		);
		
		return $campaigns;
	}
	
	public function get_integrations(){
		return $this->integrations;
	}
}
