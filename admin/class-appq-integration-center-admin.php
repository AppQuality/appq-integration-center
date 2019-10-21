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
		$campaign_model = mvc_model('Campaign');		
		$campaign = $campaign_model->find_by_id($id);
		$campaign->bugtracker = 'jira';
		$campaign->credentials = true;
		return $campaign;
	}
	
	public function get_campaigns() {
		$campaign_model = mvc_model('Campaign');
		
		$campaigns = $campaign_model->find();
		$campaigns = array_map(function($cp) {
			$cp->bugtracker = 'jira';
			$cp->credentials = true;
			return $cp;
		},$campaigns);
		
		return $campaigns;
	}
	public function get_bugs($cp_id) {
		global $wpdb;
		
		$bug_model = mvc_model('Bug');
		$bugs = $bug_model->find_by_campaign_id($cp_id);
		
		$campaign = $this->get_campaign($cp_id);
		
		$type = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'appq_evd_bug_type',OBJECT_K);
		$severity = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'appq_evd_severity',OBJECT_K);
		$status = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'appq_evd_bug_status',OBJECT_K);
		$data = array(
			'status' => $status,
			'severity' => $severity,
			'type' => $type
		);
		$bugs = array_map(function($bug) use($data,$campaign) {
			global $wpdb;
			
			$bug->status = array_key_exists($bug->status_id,$data['status']) ? $data['status'][$bug->status_id]->name : 'Not valid';
			$bug->severity = array_key_exists($bug->severity_id,$data['severity']) ? $data['severity'][$bug->severity_id]->name : 'Not valid';
			$bug->category = array_key_exists($bug->bug_type_id,$data['type']) ? $data['type'][$bug->bug_type_id]->name : 'Not valid';
			$bug->tags = $wpdb->get_col($wpdb->prepare('SELECT display_name FROM '. $wpdb->prefix.'appq_bug_taxonomy WHERE bug_id = %d',$bug->id));
			$bug->uploaded = $wpdb->get_var(
				$wpdb->prepare('SELECT COUNT(bug_id) FROM ' . $wpdb->prefix .'appq_integration_center_bugs WHERE bug_id = %d AND integration = %s',$bug->id,$campaign->bugtracker)
			) > 0;
			return $bug;
		},$bugs);
		
		return $bugs;
	}
	
	public function get_integrations(){
		return $this->integrations;
	}
	
	
	
	/**
	 * PAGES AND PARTIALS
	 */
	
	 
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
 			'bugs' => $this->get_bugs($_GET['id']),
 			'campaign' => $campaign
 		));
 	}
	
	public function general_settings() {
		$this->partial('bugs/general-settings',array(
			'integrations' => $this->get_integrations()
		));
	}
	
}
