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
		if (empty($this->integrations))
		{
			$this->integrations = array();
		}


	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles($hook) {
		if (strpos($hook, 'integration-center') !== false)
		{
			wp_enqueue_style( 'bootstrap', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), '4.1.3', 'all' );
			wp_enqueue_style( 'toastr', plugin_dir_url( __FILE__ ) . 'css/toastr.min.css', array(), '2.1.3', 'all' );
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/appq-integration-center-admin.css', array(), $this->version, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts($hook) {

		if (strpos($hook, 'integration-center') !== false)
		{
			wp_enqueue_script( 'bootstrap', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array(), '4.1.3', 'all' );
			wp_enqueue_script( 'toastr', plugin_dir_url( __FILE__ ) . 'js/toastr.min.js', array(), '2.1.3', 'all' );
			wp_enqueue_script( 'listjs', plugin_dir_url( __FILE__ ) . 'js/list.min.js', array(), '1.5.0', 'all' );
			wp_enqueue_script( 'listjs-fuzzysearch', plugin_dir_url( __FILE__ ) . 'js/list.fuzzysearch.min.js', array(), '0.1.0', 'all' );
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/appq-integration-center-admin.js', array( 'jquery' ), $this->version, false );
		}
	}
	

	/**
	 * Register the WP admin settings.
	 *
	 * @since    1.1.0
	 */
	public function register_settings() {		
   		add_option( $this->plugin_name . '_capability', 'manage_options');
   		register_setting( $this->plugin_name . '_settings_group', $this->plugin_name . '_capability' );
	}
	
	/**
	 * Register the WP admin menus.
	 *
	 * @since    1.0.0
	 */
	public function register_menus() {
  	 	$necessary_capability = get_option($this->plugin_name . '_capability');

	    add_menu_page(
	        __( 'Integration center', $this->plugin_name ),
	        'Integration center',
	        $necessary_capability,
			'integration-center',
	        array($this,'campaigns_page'),
	        plugins_url( $this->plugin_name . '/admin/images/icon.png' ),
	        6
	    );
		

	    add_submenu_page(
			'',
	        __( 'Integration center', $this->plugin_name ),
	        'Integration center',
	        $necessary_capability,
			'integration-center-campaign',
	        array($this,'bugs_page')
	    );
		
	    add_submenu_page(
			'integration-center',
	        __( 'Integration center', $this->plugin_name ),
	        'Settings',
	        'manage_options',
			'integration-center-settings',
	        array($this,'settings_page')
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
	
	
	/**
	 * Get a Campaign by id with bugtracker data
	 * @method get_campaign
	 * @date   2019-10-25T12:48:21+020
	 * @author: Davide Bizzi <clochard>
	 * @param  int                  $id The id of the campaign
	 * @return object                      MVC Campaign Object with bugtracker property and credentials property
	 */
	public static function get_campaign($id) {
		global $wpdb;
		$campaign_model = mvc_model('Campaign');		
		$campaign = $campaign_model->find_by_id($id);
		$bugtracker = $wpdb->get_row(
			$wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'appq_integration_center_config WHERE campaign_id = %d AND is_active = 1', $id)
		);
		$campaign->bugtracker = !empty($bugtracker) ? $bugtracker : '' ;
		$campaign->credentials = !empty($bugtracker);
		return $campaign;
	}
	
	/**
	 * Get all Campaigns with bugtracker data
	 * @method get_campaigns
	 * @date   2019-10-25T12:50:51+020
	 * @author: Davide Bizzi <clochard>
	 * @return array                      An array of MVC Campaign Objects with bugtracker property and credentials property
	 */
	public static function get_campaigns() {
		global $wpdb;
		$campaign_model = mvc_model('Campaign');
		$bugtrackers = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'appq_integration_center_config WHERE is_active = 1',OBJECT_K);
		
		$campaigns = $campaign_model->find();
		$campaigns = array_map(function($cp) use($bugtrackers){
			$cp->bugtracker = array_key_exists($cp->id,$bugtrackers) ? $bugtrackers[$cp->id] : '' ;
			$cp->credentials = array_key_exists($cp->id,$bugtrackers);
			return $cp;
		},$campaigns);
		
		return $campaigns;
	}
	
	/**
	 * Get all Bugs of a Campaign with text values, tags and bugtracker data
	 * @method get_bugs
	 * @date   2019-10-25T12:51:29+020
	 * @author: Davide Bizzi <clochard>
	 * @param  int                  $cp_id The id of the campaign
	 * @return object                         MVC Bug Object with status, severity, type as text, a list of tags and a property is_uploaded
	 */
	public static function get_bugs($cp_id) {
		global $wpdb;
		
		$bug_model = mvc_model('Bug');
		$bugs = $bug_model->find_by_campaign_id($cp_id);
		
		$campaign = AppQ_Integration_Center_Admin::get_campaign($cp_id);
		
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
			$bug->uploaded = false;	
			if (!empty($campaign->bugtracker)) {
				$bug->uploaded = $wpdb->get_var(
					$wpdb->prepare('SELECT COUNT(bug_id) FROM ' . $wpdb->prefix .'appq_integration_center_bugs WHERE bug_id = %d AND integration = %s',$bug->id, $campaign->bugtracker->integration)
					) > 0;
			}
			return $bug;
		},$bugs);
		
		return $bugs;
	}
	
	/**
	 * Get the list of integrations
	 * @method get_integrations
	 * @date   2019-10-25T12:53:53+020
	 * @author: Davide Bizzi <clochard>
	 * @return array                  An array of integrations array(
	 *	 'slug' => the slug of the integration,
     *	 'name' => the extended name of the integration
	 * );
	 */
	public function get_integrations(){
		return $this->integrations;
	}
	
	
	
	/**
	 * PAGES AND PARTIALS
	 */
	
	 
 	/** 
 	 * Settings page show
 	 * @method campaigns_page
 	 * @date   2019-10-17T14:30:28+020
 	 * @author: Davide Bizzi <clochard>
 	 */
 	public function settings_page() {
	    global $wp_roles;
		$capabilities = array();

	    $all_roles = $wp_roles->roles;
    	$editable_roles = apply_filters('editable_roles', $all_roles);
		
		foreach($editable_roles as $role) {
			$capabilities = array_merge($capabilities, array_keys($role['capabilities']));
		}
		$capabilities = array_unique($capabilities);
		sort($capabilities);
		
  	 	$necessary_capability = get_option($this->plugin_name . '_capability');
		$settings = array(
			$this->plugin_name . '_capability' => array(
				'type' => 'select',
				'value' => $necessary_capability,
				'label' => 'Necessary Capability',
				'select_options' => $capabilities
			)
		);
 		$this->partial('settings',array(
			'capabilities' => $capabilities,
			'settings' => $settings,
			'group_name' =>  $this->plugin_name . '_settings_group'
		));
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
 			'bugs' => $this->get_bugs($_GET['id']),
 			'campaign' => $campaign
 		));
 	}
	
	/**
	 * Get Custom Mapping for a campaign
	 * @method get_custom_fields
	 * @date   2020-05-08T14:40:54+020
	 * @author: Davide Bizzi <clochard>
	 * @param  int                  $campaign_id 
	 * @return array                               
	 */
	private function get_custom_fields($campaign_id) {
		global $wpdb;
		
		$sql = $wpdb->prepare('SELECT * FROM wp_appq_integration_center_custom_map 
			WHERE campaign_id = %d',$campaign_id);
		
		return $wpdb->get_results($sql);
	}
	
	/**
	 * General settings partial for a specific campaign
	 * @method general_settings
	 * @date   2019-10-25T12:55:22+020
	 * @author: Davide Bizzi <clochard>
	 * @param  int                  $campaign The campaign data
	 */
	public function general_settings($campaign = null) {
		$additional_fields = appq_get_campaign_additional_fields($campaign->id);
		$custom_fields = $this->get_custom_fields($campaign->id);

		$this->partial('bugs/general-settings',array(
			'integrations' => $this->get_integrations(),
			'campaign' => $campaign,
 			'additional_fields' => $additional_fields,
 			'custom_fields' => $custom_fields,
		));
	}
	
}
