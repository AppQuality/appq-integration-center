<?php


/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://bitbucket.org/appqdevel/appq-integration-center
 * @since      1.0.0
 *
 * @package    AppQ_Integration_Center
 * @subpackage AppQ_Integration_Center/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    AppQ_Integration_Center
 * @subpackage AppQ_Integration_Center/includes
 * @author     Davide Bizzi <davide.bizzi@app-quality.com>
 */
class AppQ_Integration_Center
{

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      AppQ_Integration_Center_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
	{
		if (defined('APPQ_INTEGRATION_CENTERVERSION')) {
			$this->version = APPQ_INTEGRATION_CENTERVERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'appq-integration-center';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_frontend_hooks();
		//$this->define_admin_hooks();
	}

	public function define_frontend_hooks()
	{
		$scripts = array(
			'popper' => array(
				'src' =>  'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js',
				'version' => '1.12.9'
			),
			'bootstrap-4' => array(
				'src' =>  APPQ_INTEGRATION_CENTER_URL . 'admin/js/bootstrap.min.js',
				'version' => '4.1.3',
				'dependencies' => array('popper')
			),
			'toastr-min' => array(
				'src' =>  APPQ_INTEGRATION_CENTER_URL . 'admin/js/toastr.min.js',
				'version' => '2.1.3',
				'dependencies' => array('jquery')
			),
			'listjs' => array(
				'src' =>  APPQ_INTEGRATION_CENTER_URL . 'admin/js/list.min.js',
				'version' => '1.5.0'
			),
			'listjs-fuzzysearch' => array(
				'src' =>  APPQ_INTEGRATION_CENTER_URL . 'admin/js/list.fuzzysearch.min.js',
				'version' => '0.1.0'
			),
			'introjs' => array(
				'src' => 'https://unpkg.com/intro.js/minified/intro.min.js',
				'version' => '3.3.1'
			),
			$this->plugin_name . '-front' => array(
				'src' => APPQ_INTEGRATION_CENTER_URL . 'assets/js/front.min.js',
				'version' => '1.0',
				'dependencies' => array('wp-i18n')
			),
			$this->plugin_name => array(
				'src' => APPQ_INTEGRATION_CENTER_URL . 'assets/js/admin.min.js',
				'version' => '1.0',
				'dependencies' => array(
					'jquery',
					'listjs',
					'listjs-fuzzysearch',
					'bootstrap-4',
					'toastr'
				)
			)
		);
		$styles = array(
			'bootstrap-style' => array(
				'src' => APPQ_INTEGRATION_CENTER_URL . 'admin/css/bootstrap.min.css',
				'version' => '4.1.3'
			),
			'toastr' => array(
				'src' => APPQ_INTEGRATION_CENTER_URL . 'admin/css/toastr.min.css',
				'version' => '2.1.3'
			),
			$this->plugin_name => array(
				'src' => APPQ_INTEGRATION_CENTER_URL . 'assets/css/admin.css',
				'version' => '1.0',
			),
			'material-bootstrap-ic' => array(
				'src' => get_stylesheet_directory_uri() . '/assets/css/material-bootstrap.css',
				'version' => '1.0',
				'dependencies' => array($this->plugin_name)
			),
			$this->plugin_name . '-front' => array(
				'src' => APPQ_INTEGRATION_CENTER_URL . 'assets/css/front.css',
				'version' => '1.0',
				'dependencies' => array('bootstrap-3')
			),
		);

		$this->add_custom_frontoffice_page(
			'appq-integration-center',
			'appq-integration-center-frontoffice.php',
			$styles,
			$scripts,
			function () {
				$admin = new AppQ_Integration_Center_Admin($this->plugin_name, $this->version);

				add_action('wp_print_scripts', function () {
					wp_dequeue_script('app-script');
					wp_dequeue_style('material-bootstrap');
					wp_dequeue_script('bootstrap');
				});
				add_action('wp_enqueue_scripts', function () {
					wp_localize_script($this->plugin_name, 'appq_ajax', array(
						'url'   => admin_url('admin-ajax.php'),
						'nonce' => wp_create_nonce('appq-ajax-nonce')
					));

					wp_localize_script($this->plugin_name, 'custom_object', array(
						'ajax_url' => admin_url('admin-ajax.php')
					));
				}, 11);


				$admin->enqueue_integration_scripts();
				$admin->enqueue_integration_styles();
			}
		);
	}

	private function add_custom_frontoffice_page(
		$parameter,
		$template,
		$styles = false,
		$scripts = false,
		$fn = false
	) {
		add_action('plugins_loaded', function () use ($parameter, $template, $styles, $scripts, $fn) {
			add_action('init', function () use ($parameter) {
				add_rewrite_rule($parameter . '/([a-z0-9-]+)[/]?$', 'index.php?' . $parameter . '=$matches[1]', 'top');
			}, 8);
			add_action('init', function () use ($parameter) {
				add_rewrite_rule('it/' . $parameter . '/([a-z0-9-]+)[/]?$', 'index.php?' . $parameter . '=$matches[1]&lang=it', 'top');
			}, 8);

			add_filter('query_vars', function ($query_vars) use ($parameter) {
				$query_vars[] = $parameter;
				return $query_vars;
			});


			add_action('parse_request', function (&$wp) use ($parameter, $template, $styles, $scripts, $fn) {
				if (array_key_exists($parameter, $wp->query_vars)) {
					global $custom_translation;
					global $skip_minification;
					$skip_minification = true;
					$custom_translation = true;
					if ($fn) {
						add_action('wp_enqueue_scripts', $fn);
					}
					if (is_array($styles)) {
						foreach ($styles as $name => $style) 
						{
							if (array_key_exists('src', $style)) {
								$version = array_key_exists('version', $style) ? $style['version'] : '1.0';
								$dependencies = array_key_exists('dependencies', $style) ? $style['dependencies'] : array();

								add_action('wp_enqueue_scripts', function () use ($name, $style, $dependencies, $version) {
									wp_enqueue_style($name, $style['src'], $dependencies, $version);
								});
							}
						}
					}
					if (is_array($scripts)) 
					{
						foreach ($scripts as $name => $script) {
							if (array_key_exists('src', $script)) {
								$version = array_key_exists('version', $script) ? $script['version'] : '1.0';
								$dependencies = array_key_exists('dependencies', $script) ? $script['dependencies'] : array();

								add_action('wp_enqueue_scripts', function () use ($name, $script, $dependencies, $version) {
									wp_enqueue_script($name, $script['src'], $dependencies, $version);
									if ($name == "appq-integration-center-front") {
										wp_set_script_translations('appq-integration-center-front', 'appq-integration-center', APPQ_INTEGRATION_CENTER_PATH . 'languages');
									}
								});
							}
						}
					}
					do_action('template_redirect');
					do_action('wp');
					include(dirname(dirname(__FILE__)) . '/front/' . $template);
					exit();
				}
				return;
			});
		});
	}
	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - AppQ_Integration_Center_Loader. Orchestrates the hooks of the plugin.
	 * - AppQ_Integration_Center_i18n. Defines internationalization functionality.
	 * - AppQ_Integration_Center_Admin. Defines all hooks for the admin area.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies()
	{

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-appq-integration-center-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-appq-integration-center-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-appq-integration-center-admin.php';


		/**
		 * The base class responsible for communication with rest api
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'class/class-appq-integration-center-api.php';

		/**
		 * Require ajax actions
		 */
		foreach (glob(plugin_dir_path(dirname(__FILE__)) . 'ajax/*.php') as $filename) {
			require_once $filename;
		}

		$this->loader = new AppQ_Integration_Center_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the AppQ_Integration_Center_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale()
	{

		$plugin_i18n = new AppQ_Integration_Center_i18n();

		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @deprecated 
	 */
	private function define_admin_hooks()
	{

		$plugin_admin = new AppQ_Integration_Center_Admin($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('load-toplevel_page_integration-center', $plugin_admin, 'enqueueAdminAssets');
		$this->loader->add_action('load-admin_page_integration-center-settings', $plugin_admin, 'enqueueAdminAssets');
		$this->loader->add_action('load-admin_page_integration-center-campaign', $plugin_admin, 'enqueueAdminAssets');
		$this->loader->add_action('load-admin_page_campaigns_page', $plugin_admin, 'enqueueAdminAssets');

		$this->loader->add_action('admin_menu', $plugin_admin, 'register_menus');
		$this->loader->add_action('admin_menu', $plugin_admin, 'register_settings');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name()
	{
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    AppQ_Integration_Center_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version()
	{
		return $this->version;
	}
}
