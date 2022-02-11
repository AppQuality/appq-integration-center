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
class AppQ_Integration_Center_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
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
	 * @param string $appq_integration_center The name of this plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name  = $plugin_name;
		$this->version      = $version;
		$this->integrations = apply_filters('register_integrations', null);
		if (empty($this->integrations)) {
			$this->integrations = array();
		}

		$this->campaign = null;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles($hook)
	{
		if (strpos($hook, 'integration-center') !== false) {
			wp_enqueue_style('bootstrap-style', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), '4.1.3');
			wp_enqueue_style('toastr', plugin_dir_url(__FILE__) . 'css/toastr.min.css', array(), '2.1.3');
			wp_enqueue_style($this->plugin_name, APPQ_INTEGRATION_CENTER_URL . 'assets/css/admin.css', array(), $this->version);
		}
	}

	public function enqueue_integration_scripts()
	{
		foreach ($this->get_integrations() as $i) {
			$i['class']->enqueue_scripts($i['class']->plugin_name);
		}
	}

	public function enqueue_integration_styles()
	{
		foreach ($this->get_integrations() as $i) {
			$i['class']->enqueue_styles($i['class']->plugin_name);
		}
	}


	/**
	 * Register the WP admin settings.
	 *
	 * @since    1.1.0
	 */
	public function register_settings()
	{
		add_option($this->plugin_name . '_capability', 'manage_options');
		register_setting($this->plugin_name . '_settings_group', $this->plugin_name . '_capability');
	}

	/**
	 * Register the WP admin menus.
	 *
	 * @since    1.0.0
	 * @deprecated 1.1.3
	 */
	public function register_menus()
	{
		$necessary_capability = get_option($this->plugin_name . '_capability');

		add_menu_page(
			__('Integration center', 'appq-integration-center'),
			'Integration center',
			$necessary_capability,
			'integration-center',
			array($this, 'campaigns_page'),
			plugins_url($this->plugin_name . '/admin/images/icon.png'),
			6
		);

		add_submenu_page(
			'',
			__('Integration center', 'appq-integration-center'),
			'Integration center',
			$necessary_capability,
			'integration-center-campaign',
			array($this, 'bugs_page')
		);

		add_submenu_page(
			'integration-center',
			__('Integration center', 'appq-integration-center'),
			'Settings',
			'manage_options',
			'integration-center-settings',
			array($this, 'settings_page')
		);
	}


	/**
	 * Return admin partial path
	 * @var $slug
	 */
	public function get_partial($slug)
	{
		return $this->plugin_name . '/admin/partials/appq-integration-center-admin-' . $slug . '.php';
	}

	/**
	 * Include admin partial
	 * @var $slug
	 */
	public function partial($slug, $variables = false)
	{
		if (is_array($variables)) {
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
	 *
	 * @param int $id The id of the campaign
	 *
	 * @return object                      MVC Campaign Object with bugtracker property and credentials property
	 * @author: Davide Bizzi <clochard>
	 */
	public function get_campaign($id)
	{
		global $tbdb;

		$campaign = $tbdb->get_row(
			$tbdb->prepare("SELECT * FROM wp_appq_evd_campaign WHERE id = %d", $id)
		);

		if (empty($campaign)) return false;

		$bugtracker = $tbdb->get_row(
			$tbdb->prepare('SELECT * FROM ' . $tbdb->prefix . 'appq_integration_center_config WHERE campaign_id = %d AND is_active = 1', $id)
		);

		$campaign->bugtracker  = '';
		$campaign->credentials = false;
		$campaign->url_model   = '';
		if (!empty($bugtracker)) {
			$campaign->bugtracker  = $bugtracker;
			$campaign->credentials = true;
			$integration           = str_replace('-', '_', $bugtracker->integration);
			$url_model_function    = 'appq_ic_' . $integration . '_get_url_model';
			if (function_exists($url_model_function)) {
				$campaign->url_model = $url_model_function($bugtracker);
				$default_bug_id      = AppQ_Integration_Center_Admin::get_uploaded_bug($integration, -$id);
				if (!empty($default_bug_id)) {
					$campaign->bugtracker->default_bug = str_replace('{bugtracker_id}', $default_bug_id, $campaign->url_model);
				}
			}
		}

		$this->campaign = $campaign;

		return $campaign;
	}

	/**
	 * Get all Campaigns with bugtracker data
	 * @method get_campaigns
	 * @date   2019-10-25T12:50:51+020
	 * @return array                      An array of MVC Campaign Objects with bugtracker property and credentials property
	 * @author: Davide Bizzi <clochard>
	 */
	public static function get_campaigns()
	{
		global $tbdb;
		$is_admin = current_user_can('manage_options');
		$campaigns = array();
		$filter_cp_ids = "";

		if (!$is_admin) {
			$available_campaign_ids = AppQ_Integration_Center_Admin::get_bugtracker_available_campaign_ids();
			if (empty($available_campaign_ids)) {
				return [];
			}
			$filter_cp_ids = sprintf("WHERE c.id IN (%s)", implode(",", $available_campaign_ids));
		}

		$campaigns = $tbdb->get_results("
			SELECT c.id, c.title
			FROM wp_appq_evd_campaign c
			JOIN wp_appq_integration_center_config icc ON (icc.campaign_id = c.id)
		" . $filter_cp_ids);

		return $campaigns;
	}

	public static function get_bugtracker_available_campaign_ids()
	{
		global $tbdb, $current_customer;

		$sql = 'SELECT cp.id
			FROM wp_appq_customer c
				JOIN wp_appq_user_to_customer u2c ON c.id = u2c.customer_id
				JOIN wp_appq_project p ON p.customer_id = c.id
				JOIN wp_appq_evd_campaign cp ON p.id = cp.project_id
				JOIN wp_appq_integration_center_config icc ON (cp.id = icc.campaign_id)
				JOIN wp_appq_integration_center_integrations ici ON (ici.integration_slug = icc.integration)
			WHERE u2c.wp_user_id = %d
			AND (EXISTS
					(SELECT * 
					FROM wp_appq_user_to_project u2p 
					WHERE u2p.wp_user_id = %d AND u2p.project_id = p.id)
					OR NOT EXISTS
						(SELECT * 
						FROM wp_appq_user_to_project u2p 
						WHERE u2p.project_id = p.id)
				)
			AND ici.visible_to_customer = 1
		';

		$sql = $tbdb->prepare(
			$sql,
			$current_customer->ID,
			$current_customer->ID
		);

		if (!$sql) {
			return [];
		}

		return $tbdb->get_col($sql);
	}

	public static function get_customer_available_campaign_ids()
	{
		global $tbdb, $current_customer;

		$sql = 'SELECT cp.id
			FROM wp_appq_customer c
				JOIN wp_appq_user_to_customer u2c ON c.id = u2c.customer_id
				JOIN wp_appq_project p ON p.customer_id = c.id
				JOIN wp_appq_evd_campaign cp ON p.id = cp.project_id
			WHERE u2c.wp_user_id = %d
			AND (EXISTS
					(SELECT * 
					FROM wp_appq_user_to_project u2p 
					WHERE u2p.wp_user_id = %d AND u2p.project_id = p.id)
					OR NOT EXISTS
						(SELECT * 
						FROM wp_appq_user_to_project u2p 
						WHERE u2p.project_id = p.id)
				)
		';

		$sql = $tbdb->prepare(
			$sql,
			$current_customer->ID,
			$current_customer->ID
		);

		if (!$sql) {
			return [];
		}
		return $tbdb->get_col($sql);
	}

	/**
	 * Get all Bugs of a Campaign with text values, tags and bugtracker data
	 * @method get_bugs
	 * @date   2019-10-25T12:51:29+020
	 *
	 * @param object $campaign  The campaign
	 *
	 * @return object  Bug Object with status, severity, type as text, a list of tags and a property is_uploaded
	 * @author: Davide Bizzi <clochard>
	 */
	public static function get_bugs($campaign)
	{
		global $tbdb;

		$bugSql = $tbdb->prepare(
			"SELECT * FROM wp_appq_evd_bug WHERE campaign_id = %d AND publish = 1",
			$campaign->id
		);

		if (!current_user_can('manage_options')) {


			if ($campaign->cust_bug_vis == "1") {
				$bugSql .= ' AND status_id IN (2, 4)';
			} else {
				$bugSql .= ' AND status_id = 2'; // only show bugs that are published
			}
		}


		$bugs = $tbdb->get_results($bugSql);


		$type     = $tbdb->get_results('SELECT * FROM ' . $tbdb->prefix . 'appq_evd_bug_type', OBJECT_K);
		$severity = $tbdb->get_results('SELECT * FROM ' . $tbdb->prefix . 'appq_evd_severity', OBJECT_K);
		$status   = $tbdb->get_results('SELECT * FROM ' . $tbdb->prefix . 'appq_evd_bug_status', OBJECT_K);
		$data     = array(
			'status'   => $status,
			'severity' => $severity,
			'type'     => $type
		);


		$bugs     = array_map(function ($bug) use ($data, $campaign) {
			global $tbdb;

			$bug->status   = array_key_exists($bug->status_id, $data['status']) ? $data['status'][$bug->status_id]->name : 'Not valid';
			$bug->severity = array_key_exists($bug->severity_id, $data['severity']) ? $data['severity'][$bug->severity_id]->name : 'Not valid';
			$bug->category = array_key_exists($bug->bug_type_id, $data['type']) ? $data['type'][$bug->bug_type_id]->name : 'Not valid';
			$bug->tags     = $tbdb->get_col($tbdb->prepare('SELECT display_name FROM ' . $tbdb->prefix . 'appq_bug_taxonomy WHERE bug_id = %d', $bug->id));
			$bug->uploaded = false;
			if (!empty($campaign->bugtracker)) {
				$sql = $tbdb->prepare('SELECT bug_id,bugtracker_id FROM ' . $tbdb->prefix . 'appq_integration_center_bugs 
					WHERE bug_id = %d AND integration = %s', $bug->id, $campaign->bugtracker->integration);

				$uploaded_bug_data   = $tbdb->get_row($sql);
				$bug->uploaded       = false;
				$bug->bugtracker_url = false;

				if (!empty($uploaded_bug_data)) {
					$bug->uploaded = true;
					if (!empty($uploaded_bug_data->bugtracker_id)) {
						$bug->bugtracker_id = $uploaded_bug_data->bugtracker_id;
						if (!empty($campaign->url_model)) {
							$bug->bugtracker_url = str_replace('{bugtracker_id}', $uploaded_bug_data->bugtracker_id, $campaign->url_model);
						}
					}
				}
			}

			return $bug;
		}, $bugs);

		return $bugs;
	}

	/**
	 * Get the list of integrations
	 * @method get_integrations
	 * @date   2019-10-25T12:53:53+020
	 * @return array                  An array of integrations array(
	 *     'slug' => the slug of the integration,
	 *     'name' => the extended name of the integration
	 * );
	 * @author: Davide Bizzi <clochard>
	 */
	public function get_integrations()
	{
		$integrations = array();
		foreach ($this->integrations as $k => $v) {
			$visible_to_customer = $this->is_visible_to_customer($v['slug']);
			if ($visible_to_customer || current_user_can('manage_options')) {
				$integrations[$k] = $v;
				$integrations[$k]['visible_to_customer'] = $visible_to_customer;
			}
		}


		return $integrations;
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
	public function settings_page()
	{
		global $wp_roles;
		$capabilities = array();

		$all_roles      = $wp_roles->roles;
		$editable_roles = apply_filters('editable_roles', $all_roles);

		foreach ($editable_roles as $role) {
			$capabilities = array_merge($capabilities, array_keys($role['capabilities']));
		}
		$capabilities = array_unique($capabilities);
		sort($capabilities);

		$necessary_capability = get_option($this->plugin_name . '_capability');

		$integrations = $this->get_integrations();

		$settings             = array(
			$this->plugin_name . '_capability' => array(
				'type'           => 'select',
				'value'          => $necessary_capability,
				'label'          => 'Necessary Capability',
				'select_options' => $capabilities
			)
		);

		wp_enqueue_style('toastr', plugin_dir_url(__FILE__) . 'css/toastr.min.css', array(), '2.1.3');
		wp_enqueue_script('toastr', APPQ_INTEGRATION_CENTER_URL . 'admin/js/toastr.min.js', array(), '2.1.3', 'all');
		wp_enqueue_script('visible_to_customer_ajax', APPQ_INTEGRATION_CENTER_URL . 'admin/js/visible_to_customer.js', array('jquery'), '1.0.0', 'all');

		$this->partial('settings', array(
			'capabilities' => $capabilities,
			'integrations' => $integrations,
			'settings'     => $settings,
			'group_name'   => $this->plugin_name . '_settings_group'
		));
	}

	/**
	 * Campaings page show
	 * @method campaigns_page
	 * @date   2019-10-17T14:30:28+020
	 * @author: Davide Bizzi <clochard>
	 */
	public function campaigns_page()
	{
		$this->partial('campaigns', array(
			'campaigns' => $this->get_campaigns()
		));
	}



	/**
	 * Bugs page show
	 * @method campaigns_page
	 * @date   2019-10-17T14:30:28+020
	 * @author: Davide Bizzi <clochard>
	 */
	public function bugs_page()
	{
		if (!isset($this->campaign)) {
			$id = $this->get_campaign_id();
			if ($id == 0) {
				$this->partial('not-found');

				return;
			}

			$campaign = $this->get_campaign($id);
			if (!$campaign) {
				$this->partial('not-found');
				return;
			}
		}

		$this->partial('bugs', array(
			'bugs'     => $this->get_bugs($this->campaign),
			'campaign' => $this->campaign
		));
	}

	/**
	 * Get Custom Mapping for a campaign
	 * @method get_custom_fields
	 * @date   2020-05-08T14:40:54+020
	 *
	 * @param int $campaign_id
	 *
	 * @return array
	 * @author: Davide Bizzi <clochard>
	 */
	public static function get_custom_fields($campaign_id)
	{
		global $tbdb;

		$sql = $tbdb->prepare('SELECT * FROM wp_appq_integration_center_custom_map 
			WHERE campaign_id = %d', $campaign_id);

		return $tbdb->get_results($sql);
	}

	/**
	 * Fields settings partial for a specific campaign
	 * @method available_fields
	 * @date   2019-10-25T12:55:22+020
	 *
	 * @param object|null $campaign The campaign data
	 *
	 * @author: Davide Bizzi <clochard>
	 */
	public function available_fields($campaign = null)
	{
		if (isset($campaign)) {
			$custom_fields = $this->get_custom_fields($campaign->id);

			$this->partial('bugs/available-fields', array(
				'integrations'  => $this->get_integrations(),
				'campaign'      => $campaign,
				'custom_fields' => $custom_fields,
			));
		}
	}

	public function current_setup($campaign = null)
	{
		$this->partial('bugs/current-setup', ['campaign' => $campaign]);
	}

	public function fields_mapping($campaign = null)
	{
		$this->partial('bugs/fields-mapping', ['campaign' => $campaign]);
	}

	public function current_setup_edit_buttons($campaign = null)
	{
		$this->partial('settings/current-setup-edit-buttons', ['campaign' => $campaign]);
	}

	public static function get_uploaded_bug($integration_type, $bug_id)
	{
		global $tbdb;

		$sql = $tbdb->prepare('SELECT bugtracker_id FROM wp_appq_integration_center_bugs
			WHERE bug_id = %d AND integration = %s', $bug_id, $integration_type);

		return $tbdb->get_var($sql);
	}


	public function get_campaign_id()
	{
		global $wp;
		if (!array_key_exists('id', $_GET) && !array_key_exists('integration-center', $wp->query_vars)) {
			return 0;
		}
		$id = 0;
		if (array_key_exists('id', $_GET)) {
			$id = $_GET['id'];
		}
		if (
			!empty($wp->query_vars)
			&& array_key_exists('integration-center', $wp->query_vars)
			&& !empty($wp->query_vars['integration-center'])
		) {
			$id = $wp->query_vars['integration-center'];
		}
		return $id;
	}

	public function get_integration_by_slug($slug)
	{
		global $tbdb;
		$integration = $tbdb->get_row(
			$tbdb->prepare('SELECT * FROM ' . $tbdb->prefix . 'appq_integration_center_integrations WHERE integration_slug = %s', $slug)
		);

		return $integration;
	}

	public function is_visible_to_customer($slug): bool
	{
		$integration = $this->get_integration_by_slug($slug);

		return $integration->visible_to_customer === "1";
	}
}
