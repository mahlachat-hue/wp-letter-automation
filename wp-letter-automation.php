<?php
/**
 * Plugin Name: WP Letter Automation
 * Plugin URI: https://github.com/mahlachat-hue/wp-letter-automation
 * Description: A comprehensive WordPress plugin for automating letter generation, management, and delivery with ACF integration and advanced user management features.
 * Version: 1.0.0
 * Author: Mahlachat
 * Author URI: https://github.com/mahlachat-hue
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wp-letter-automation
 * Domain Path: /languages
 * Requires at least: 5.0
 * Requires PHP: 7.4
 * Requires Plugins: advanced-custom-fields
 * Network: false
 *
 * @package WP_Letter_Automation
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define plugin constants
 */
define( 'WP_LETTER_AUTOMATION_VERSION', '1.0.0' );
define( 'WP_LETTER_AUTOMATION_FILE', __FILE__ );
define( 'WP_LETTER_AUTOMATION_PATH', plugin_dir_path( WP_LETTER_AUTOMATION_FILE ) );
define( 'WP_LETTER_AUTOMATION_URL', plugin_dir_url( WP_LETTER_AUTOMATION_FILE ) );
define( 'WP_LETTER_AUTOMATION_BASENAME', plugin_basename( WP_LETTER_AUTOMATION_FILE ) );

/**
 * WP Letter Automation Main Plugin Class
 *
 * @class WP_Letter_Automation
 * @version 1.0.0
 */
final class WP_Letter_Automation {

	/**
	 * Single instance of the class
	 *
	 * @var WP_Letter_Automation
	 */
	private static $instance = null;

	/**
	 * Plugin name
	 *
	 * @var string
	 */
	public $plugin_name = 'WP Letter Automation';

	/**
	 * Plugin version
	 *
	 * @var string
	 */
	public $version = WP_LETTER_AUTOMATION_VERSION;

	/**
	 * Get singleton instance
	 *
	 * @return WP_Letter_Automation
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	private function __construct() {
		$this->init();
	}

	/**
	 * Initialize the plugin
	 *
	 * @return void
	 */
	private function init() {
		// Check if ACF is active
		if ( ! $this->check_acf() ) {
			add_action( 'admin_notices', array( $this, 'acf_missing_notice' ) );
			return;
		}

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_textdomain' ) );

		// Include required files
		$this->include_files();

		// Initialize plugin components
		add_action( 'init', array( $this, 'initialize_components' ) );

		// Register activation and deactivation hooks
		register_activation_hook( WP_LETTER_AUTOMATION_FILE, array( $this, 'activate' ) );
		register_deactivation_hook( WP_LETTER_AUTOMATION_FILE, array( $this, 'deactivate' ) );

		// Enqueue admin scripts and styles
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_enqueue_scripts' ) );

		// Initialize admin menu
		add_action( 'admin_menu', array( $this, 'register_admin_menu' ) );
	}

	/**
	 * Check if ACF is active
	 *
	 * @return bool
	 */
	private function check_acf() {
		// Check if ACF Pro is active
		if ( class_exists( 'ACF' ) ) {
			return true;
		}

		// Check if ACF Free is active
		if ( function_exists( 'get_field' ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Display ACF missing notice
	 *
	 * @return void
	 */
	public function acf_missing_notice() {
		if ( current_user_can( 'manage_options' ) ) {
			?>
			<div class="notice notice-error is-dismissible">
				<p>
					<?php
					printf(
						/* translators: %s: plugin name */
						esc_html__( '%s requires Advanced Custom Fields (ACF) to be installed and activated.', 'wp-letter-automation' ),
						'<strong>' . esc_html( $this->plugin_name ) . '</strong>'
					);
					?>
				</p>
			</div>
			<?php
		}

		// Deactivate plugin
		deactivate_plugins( WP_LETTER_AUTOMATION_BASENAME );
	}

	/**
	 * Load plugin text domain for translations
	 *
	 * @return void
	 */
	public function load_textdomain() {
		load_plugin_textdomain(
			'wp-letter-automation',
			false,
			dirname( WP_LETTER_AUTOMATION_BASENAME ) . '/languages'
		);
	}

	/**
	 * Include required plugin files
	 *
	 * @return void
	 */
	private function include_files() {
		// Core classes
		require_once WP_LETTER_AUTOMATION_PATH . 'includes/class-wp-letter-automation-post-types.php';
		require_once WP_LETTER_AUTOMATION_PATH . 'includes/class-wp-letter-automation-taxonomies.php';
		require_once WP_LETTER_AUTOMATION_PATH . 'includes/class-wp-letter-automation-acf.php';
		require_once WP_LETTER_AUTOMATION_PATH . 'includes/class-wp-letter-automation-user-manager.php';
		require_once WP_LETTER_AUTOMATION_PATH . 'includes/class-wp-letter-automation-letter-generator.php';
		require_once WP_LETTER_AUTOMATION_PATH . 'includes/class-wp-letter-automation-mailer.php';
		require_once WP_LETTER_AUTOMATION_PATH . 'includes/class-wp-letter-automation-database.php';

		// Admin classes
		require_once WP_LETTER_AUTOMATION_PATH . 'includes/admin/class-wp-letter-automation-admin.php';
		require_once WP_LETTER_AUTOMATION_PATH . 'includes/admin/class-wp-letter-automation-settings.php';

		// Helpers
		require_once WP_LETTER_AUTOMATION_PATH . 'includes/helpers/wp-letter-automation-functions.php';
	}

	/**
	 * Initialize plugin components
	 *
	 * @return void
	 */
	public function initialize_components() {
		if ( ! class_exists( 'ACF' ) && ! function_exists( 'get_field' ) ) {
			return;
		}

		// Initialize post types and taxonomies
		WP_Letter_Automation_Post_Types::get_instance();
		WP_Letter_Automation_Taxonomies::get_instance();

		// Initialize ACF fields
		WP_Letter_Automation_ACF::get_instance();

		// Initialize user management
		WP_Letter_Automation_User_Manager::get_instance();

		// Initialize letter generator
		WP_Letter_Automation_Letter_Generator::get_instance();

		// Initialize mailer
		WP_Letter_Automation_Mailer::get_instance();

		// Initialize database
		WP_Letter_Automation_Database::get_instance();

		// Initialize admin
		if ( is_admin() ) {
			WP_Letter_Automation_Admin::get_instance();
			WP_Letter_Automation_Settings::get_instance();
		}

		/**
		 * Hook: wp_letter_automation_initialized
		 *
		 * Fired when the plugin components are initialized.
		 *
		 * @since 1.0.0
		 */
		do_action( 'wp_letter_automation_initialized' );
	}

	/**
	 * Enqueue admin scripts and styles
	 *
	 * @return void
	 */
	public function admin_enqueue_scripts() {
		// Enqueue admin styles
		wp_enqueue_style(
			'wp-letter-automation-admin',
			WP_LETTER_AUTOMATION_URL . 'assets/css/admin.css',
			array(),
			WP_LETTER_AUTOMATION_VERSION
		);

		// Enqueue admin scripts
		wp_enqueue_script(
			'wp-letter-automation-admin',
			WP_LETTER_AUTOMATION_URL . 'assets/js/admin.js',
			array( 'jquery', 'jquery-ui-sortable' ),
			WP_LETTER_AUTOMATION_VERSION,
			true
		);

		// Localize script
		wp_localize_script(
			'wp-letter-automation-admin',
			'wpLetterAutomation',
			array(
				'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
				'nonce'     => wp_create_nonce( 'wp_letter_automation_nonce' ),
				'pluginUrl' => WP_LETTER_AUTOMATION_URL,
			)
		);
	}

	/**
	 * Enqueue frontend scripts and styles
	 *
	 * @return void
	 */
	public function frontend_enqueue_scripts() {
		// Enqueue frontend styles
		wp_enqueue_style(
			'wp-letter-automation-frontend',
			WP_LETTER_AUTOMATION_URL . 'assets/css/frontend.css',
			array(),
			WP_LETTER_AUTOMATION_VERSION
		);

		// Enqueue frontend scripts
		wp_enqueue_script(
			'wp-letter-automation-frontend',
			WP_LETTER_AUTOMATION_URL . 'assets/js/frontend.js',
			array( 'jquery' ),
			WP_LETTER_AUTOMATION_VERSION,
			true
		);
	}

	/**
	 * Register admin menu
	 *
	 * @return void
	 */
	public function register_admin_menu() {
		add_menu_page(
			esc_html__( 'Letter Automation', 'wp-letter-automation' ),
			esc_html__( 'Letter Automation', 'wp-letter-automation' ),
			'manage_options',
			'wp-letter-automation',
			array( $this, 'render_admin_page' ),
			'dashicons-mail',
			6
		);

		add_submenu_page(
			'wp-letter-automation',
			esc_html__( 'Dashboard', 'wp-letter-automation' ),
			esc_html__( 'Dashboard', 'wp-letter-automation' ),
			'manage_options',
			'wp-letter-automation'
		);

		add_submenu_page(
			'wp-letter-automation',
			esc_html__( 'Settings', 'wp-letter-automation' ),
			esc_html__( 'Settings', 'wp-letter-automation' ),
			'manage_options',
			'wp-letter-automation-settings',
			array( WP_Letter_Automation_Settings::get_instance(), 'render' )
		);
	}

	/**
	 * Render admin page
	 *
	 * @return void
	 */
	public function render_admin_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have permission to access this page.', 'wp-letter-automation' ) );
		}

		?>
		<div class="wrap">
			<h1><?php echo esc_html( $this->plugin_name ); ?></h1>
			<div id="wp-letter-automation-dashboard">
				<p><?php esc_html_e( 'Welcome to the Letter Automation plugin dashboard.', 'wp-letter-automation' ); ?></p>
			</div>
		</div>
		<?php
	}

	/**
	 * Plugin activation hook
	 *
	 * @return void
	 */
	public static function activate() {
		// Check ACF requirement
		if ( ! function_exists( 'get_field' ) && ! class_exists( 'ACF' ) ) {
			deactivate_plugins( WP_LETTER_AUTOMATION_BASENAME );
			wp_die(
				esc_html__( 'This plugin requires Advanced Custom Fields (ACF) to be installed and activated.', 'wp-letter-automation' )
			);
		}

		// Create custom post types
		if ( class_exists( 'WP_Letter_Automation_Post_Types' ) ) {
			WP_Letter_Automation_Post_Types::get_instance()->register_post_types();
		}

		// Create database tables
		if ( class_exists( 'WP_Letter_Automation_Database' ) ) {
			WP_Letter_Automation_Database::get_instance()->create_tables();
		}

		// Create plugin options
		if ( ! get_option( 'wp_letter_automation_settings' ) ) {
			add_option(
				'wp_letter_automation_settings',
				array(
					'version'       => WP_LETTER_AUTOMATION_VERSION,
					'activated_at'  => current_time( 'mysql' ),
					'letter_format' => 'pdf',
				)
			);
		}

		// Set plugin activation transient for redirect
		set_transient( 'wp_letter_automation_activation_redirect', true, MINUTE_IN_SECONDS );

		/**
		 * Hook: wp_letter_automation_activated
		 *
		 * Fired when the plugin is activated.
		 *
		 * @since 1.0.0
		 */
		do_action( 'wp_letter_automation_activated' );

		// Flush rewrite rules
		flush_rewrite_rules();
	}

	/**
	 * Plugin deactivation hook
	 *
	 * @return void
	 */
	public static function deactivate() {
		// Clear any transients
		delete_transient( 'wp_letter_automation_activation_redirect' );

		/**
		 * Hook: wp_letter_automation_deactivated
		 *
		 * Fired when the plugin is deactivated.
		 *
		 * @since 1.0.0
		 */
		do_action( 'wp_letter_automation_deactivated' );

		// Flush rewrite rules
		flush_rewrite_rules();
	}

	/**
	 * Get plugin version
	 *
	 * @return string
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Get plugin name
	 *
	 * @return string
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Get plugin path
	 *
	 * @return string
	 */
	public function get_plugin_path() {
		return WP_LETTER_AUTOMATION_PATH;
	}

	/**
	 * Get plugin URL
	 *
	 * @return string
	 */
	public function get_plugin_url() {
		return WP_LETTER_AUTOMATION_URL;
	}
}

/**
 * Initialize the plugin
 */
function wp_letter_automation_init() {
	return WP_Letter_Automation::get_instance();
}

// Initiate the plugin
wp_letter_automation_init();
