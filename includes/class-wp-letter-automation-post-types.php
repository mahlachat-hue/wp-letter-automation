<?php
/**
 * Post Types and Custom Statuses Registration
 *
 * This class handles the registration of custom post types and custom post statuses
 * for the WP Letter Automation plugin.
 *
 * @package WP_Letter_Automation
 * @subpackage Includes
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class WP_Letter_Automation_Post_Types
 *
 * Manages custom post types and custom post statuses for letter automation.
 *
 * @since 1.0.0
 */
class WP_Letter_Automation_Post_Types {

	/**
	 * Initialize the class and register hooks.
	 *
	 * @since 1.0.0
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_post_types' ), 10 );
		add_action( 'init', array( __CLASS__, 'register_post_statuses' ), 11 );
	}

	/**
	 * Register custom post types.
	 *
	 * @since 1.0.0
	 */
	public static function register_post_types() {
		// Register Letter post type
		self::register_letter_post_type();

		// Register Letter Template post type
		self::register_letter_template_post_type();

		// Register Letter Campaign post type
		self::register_letter_campaign_post_type();

		// Register Letter Log post type
		self::register_letter_log_post_type();
	}

	/**
	 * Register the Letter post type.
	 *
	 * @since 1.0.0
	 */
	private static function register_letter_post_type() {
		$labels = array(
			'name'                  => _x( 'Letters', 'Post Type General Name', 'wp-letter-automation' ),
			'singular_name'         => _x( 'Letter', 'Post Type Singular Name', 'wp-letter-automation' ),
			'menu_name'             => __( 'Letters', 'wp-letter-automation' ),
			'name_admin_bar'        => __( 'Letter', 'wp-letter-automation' ),
			'archives'              => __( 'Letter Archives', 'wp-letter-automation' ),
			'attributes'            => __( 'Letter Attributes', 'wp-letter-automation' ),
			'parent_item_colon'     => __( 'Parent Letter:', 'wp-letter-automation' ),
			'all_items'             => __( 'All Letters', 'wp-letter-automation' ),
			'add_new_item'          => __( 'Add New Letter', 'wp-letter-automation' ),
			'add_new'               => __( 'Add New', 'wp-letter-automation' ),
			'new_item'              => __( 'New Letter', 'wp-letter-automation' ),
			'edit_item'             => __( 'Edit Letter', 'wp-letter-automation' ),
			'update_item'           => __( 'Update Letter', 'wp-letter-automation' ),
			'view_item'             => __( 'View Letter', 'wp-letter-automation' ),
			'view_items'            => __( 'View Letters', 'wp-letter-automation' ),
			'search_items'          => __( 'Search Letter', 'wp-letter-automation' ),
			'not_found'             => __( 'Not found', 'wp-letter-automation' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'wp-letter-automation' ),
			'featured_image'        => __( 'Featured Image', 'wp-letter-automation' ),
			'set_featured_image'    => __( 'Set featured image', 'wp-letter-automation' ),
			'remove_featured_image' => __( 'Remove featured image', 'wp-letter-automation' ),
			'use_featured_image'    => __( 'Use as featured image', 'wp-letter-automation' ),
			'insert_into_item'      => __( 'Insert into Letter', 'wp-letter-automation' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Letter', 'wp-letter-automation' ),
			'items_list'            => __( 'Letters list', 'wp-letter-automation' ),
			'items_list_navigation' => __( 'Letters list navigation', 'wp-letter-automation' ),
			'filter_items_list'     => __( 'Filter Letters list', 'wp-letter-automation' ),
		);

		$args = array(
			'label'               => __( 'Letter', 'wp-letter-automation' ),
			'description'         => __( 'Letters for automation', 'wp-letter-automation' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'custom-fields' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'show_in_rest'        => true,
			'rest_base'           => 'letters',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			'menu_position'       => 25,
			'menu_icon'           => 'dashicons-email-alt',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'query_var'           => 'letter',
			'rewrite'             => array(
				'slug'       => 'letters',
				'with_front' => true,
			),
			'capabilities'        => array(
				'read'              => 'read_letter',
				'edit_posts'        => 'edit_letters',
				'edit_others_posts' => 'edit_others_letters',
				'create_posts'      => 'create_letters',
				'publish_posts'     => 'publish_letters',
				'read_private_posts' => 'read_private_letters',
				'delete_posts'      => 'delete_letters',
			),
			'map_meta_cap'        => true,
		);

		register_post_type( 'letter', $args );
	}

	/**
	 * Register the Letter Template post type.
	 *
	 * @since 1.0.0
	 */
	private static function register_letter_template_post_type() {
		$labels = array(
			'name'                  => _x( 'Letter Templates', 'Post Type General Name', 'wp-letter-automation' ),
			'singular_name'         => _x( 'Letter Template', 'Post Type Singular Name', 'wp-letter-automation' ),
			'menu_name'             => __( 'Templates', 'wp-letter-automation' ),
			'name_admin_bar'        => __( 'Template', 'wp-letter-automation' ),
			'archives'              => __( 'Template Archives', 'wp-letter-automation' ),
			'attributes'            => __( 'Template Attributes', 'wp-letter-automation' ),
			'parent_item_colon'     => __( 'Parent Template:', 'wp-letter-automation' ),
			'all_items'             => __( 'All Templates', 'wp-letter-automation' ),
			'add_new_item'          => __( 'Add New Template', 'wp-letter-automation' ),
			'add_new'               => __( 'Add New', 'wp-letter-automation' ),
			'new_item'              => __( 'New Template', 'wp-letter-automation' ),
			'edit_item'             => __( 'Edit Template', 'wp-letter-automation' ),
			'update_item'           => __( 'Update Template', 'wp-letter-automation' ),
			'view_item'             => __( 'View Template', 'wp-letter-automation' ),
			'view_items'            => __( 'View Templates', 'wp-letter-automation' ),
			'search_items'          => __( 'Search Template', 'wp-letter-automation' ),
			'not_found'             => __( 'Not found', 'wp-letter-automation' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'wp-letter-automation' ),
			'featured_image'        => __( 'Featured Image', 'wp-letter-automation' ),
			'set_featured_image'    => __( 'Set featured image', 'wp-letter-automation' ),
			'remove_featured_image' => __( 'Remove featured image', 'wp-letter-automation' ),
			'use_featured_image'    => __( 'Use as featured image', 'wp-letter-automation' ),
			'insert_into_item'      => __( 'Insert into Template', 'wp-letter-automation' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Template', 'wp-letter-automation' ),
			'items_list'            => __( 'Templates list', 'wp-letter-automation' ),
			'items_list_navigation' => __( 'Templates list navigation', 'wp-letter-automation' ),
			'filter_items_list'     => __( 'Filter Templates list', 'wp-letter-automation' ),
		);

		$args = array(
			'label'               => __( 'Letter Template', 'wp-letter-automation' ),
			'description'         => __( 'Reusable letter templates', 'wp-letter-automation' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'author', 'custom-fields' ),
			'hierarchical'        => false,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => 'edit.php?post_type=letter',
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => false,
			'show_in_rest'        => true,
			'rest_base'           => 'letter-templates',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			'menu_position'       => null,
			'menu_icon'           => null,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'query_var'           => false,
			'rewrite'             => false,
			'capabilities'        => array(
				'read'              => 'read_letter_template',
				'edit_posts'        => 'edit_letter_templates',
				'edit_others_posts' => 'edit_others_letter_templates',
				'create_posts'      => 'create_letter_templates',
				'publish_posts'     => 'publish_letter_templates',
				'read_private_posts' => 'read_private_letter_templates',
				'delete_posts'      => 'delete_letter_templates',
			),
			'map_meta_cap'        => true,
		);

		register_post_type( 'letter_template', $args );
	}

	/**
	 * Register the Letter Campaign post type.
	 *
	 * @since 1.0.0
	 */
	private static function register_letter_campaign_post_type() {
		$labels = array(
			'name'                  => _x( 'Letter Campaigns', 'Post Type General Name', 'wp-letter-automation' ),
			'singular_name'         => _x( 'Letter Campaign', 'Post Type Singular Name', 'wp-letter-automation' ),
			'menu_name'             => __( 'Campaigns', 'wp-letter-automation' ),
			'name_admin_bar'        => __( 'Campaign', 'wp-letter-automation' ),
			'archives'              => __( 'Campaign Archives', 'wp-letter-automation' ),
			'attributes'            => __( 'Campaign Attributes', 'wp-letter-automation' ),
			'parent_item_colon'     => __( 'Parent Campaign:', 'wp-letter-automation' ),
			'all_items'             => __( 'All Campaigns', 'wp-letter-automation' ),
			'add_new_item'          => __( 'Add New Campaign', 'wp-letter-automation' ),
			'add_new'               => __( 'Add New', 'wp-letter-automation' ),
			'new_item'              => __( 'New Campaign', 'wp-letter-automation' ),
			'edit_item'             => __( 'Edit Campaign', 'wp-letter-automation' ),
			'update_item'           => __( 'Update Campaign', 'wp-letter-automation' ),
			'view_item'             => __( 'View Campaign', 'wp-letter-automation' ),
			'view_items'            => __( 'View Campaigns', 'wp-letter-automation' ),
			'search_items'          => __( 'Search Campaign', 'wp-letter-automation' ),
			'not_found'             => __( 'Not found', 'wp-letter-automation' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'wp-letter-automation' ),
			'featured_image'        => __( 'Featured Image', 'wp-letter-automation' ),
			'set_featured_image'    => __( 'Set featured image', 'wp-letter-automation' ),
			'remove_featured_image' => __( 'Remove featured image', 'wp-letter-automation' ),
			'use_featured_image'    => __( 'Use as featured image', 'wp-letter-automation' ),
			'insert_into_item'      => __( 'Insert into Campaign', 'wp-letter-automation' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Campaign', 'wp-letter-automation' ),
			'items_list'            => __( 'Campaigns list', 'wp-letter-automation' ),
			'items_list_navigation' => __( 'Campaigns list navigation', 'wp-letter-automation' ),
			'filter_items_list'     => __( 'Filter Campaigns list', 'wp-letter-automation' ),
		);

		$args = array(
			'label'               => __( 'Letter Campaign', 'wp-letter-automation' ),
			'description'         => __( 'Automated letter campaigns', 'wp-letter-automation' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'author', 'custom-fields' ),
			'hierarchical'        => false,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => 'edit.php?post_type=letter',
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => false,
			'show_in_rest'        => true,
			'rest_base'           => 'letter-campaigns',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			'menu_position'       => null,
			'menu_icon'           => null,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'query_var'           => false,
			'rewrite'             => false,
			'capabilities'        => array(
				'read'              => 'read_letter_campaign',
				'edit_posts'        => 'edit_letter_campaigns',
				'edit_others_posts' => 'edit_others_letter_campaigns',
				'create_posts'      => 'create_letter_campaigns',
				'publish_posts'     => 'publish_letter_campaigns',
				'read_private_posts' => 'read_private_letter_campaigns',
				'delete_posts'      => 'delete_letter_campaigns',
			),
			'map_meta_cap'        => true,
		);

		register_post_type( 'letter_campaign', $args );
	}

	/**
	 * Register the Letter Log post type for tracking.
	 *
	 * @since 1.0.0
	 */
	private static function register_letter_log_post_type() {
		$labels = array(
			'name'                  => _x( 'Letter Logs', 'Post Type General Name', 'wp-letter-automation' ),
			'singular_name'         => _x( 'Letter Log', 'Post Type Singular Name', 'wp-letter-automation' ),
			'menu_name'             => __( 'Logs', 'wp-letter-automation' ),
			'name_admin_bar'        => __( 'Log', 'wp-letter-automation' ),
			'archives'              => __( 'Log Archives', 'wp-letter-automation' ),
			'attributes'            => __( 'Log Attributes', 'wp-letter-automation' ),
			'parent_item_colon'     => __( 'Parent Log:', 'wp-letter-automation' ),
			'all_items'             => __( 'All Logs', 'wp-letter-automation' ),
			'add_new_item'          => __( 'Add New Log', 'wp-letter-automation' ),
			'add_new'               => __( 'Add New', 'wp-letter-automation' ),
			'new_item'              => __( 'New Log', 'wp-letter-automation' ),
			'edit_item'             => __( 'Edit Log', 'wp-letter-automation' ),
			'update_item'           => __( 'Update Log', 'wp-letter-automation' ),
			'view_item'             => __( 'View Log', 'wp-letter-automation' ),
			'view_items'            => __( 'View Logs', 'wp-letter-automation' ),
			'search_items'          => __( 'Search Log', 'wp-letter-automation' ),
			'not_found'             => __( 'Not found', 'wp-letter-automation' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'wp-letter-automation' ),
			'featured_image'        => __( 'Featured Image', 'wp-letter-automation' ),
			'set_featured_image'    => __( 'Set featured image', 'wp-letter-automation' ),
			'remove_featured_image' => __( 'Remove featured image', 'wp-letter-automation' ),
			'use_featured_image'    => __( 'Use as featured image', 'wp-letter-automation' ),
			'insert_into_item'      => __( 'Insert into Log', 'wp-letter-automation' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Log', 'wp-letter-automation' ),
			'items_list'            => __( 'Logs list', 'wp-letter-automation' ),
			'items_list_navigation' => __( 'Logs list navigation', 'wp-letter-automation' ),
			'filter_items_list'     => __( 'Filter Logs list', 'wp-letter-automation' ),
		);

		$args = array(
			'label'               => __( 'Letter Log', 'wp-letter-automation' ),
			'description'         => __( 'Letter sending logs and history', 'wp-letter-automation' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'custom-fields' ),
			'hierarchical'        => false,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => 'edit.php?post_type=letter',
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => false,
			'show_in_rest'        => true,
			'rest_base'           => 'letter-logs',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			'menu_position'       => null,
			'menu_icon'           => null,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'query_var'           => false,
			'rewrite'             => false,
			'capabilities'        => array(
				'read'              => 'read_letter_log',
				'edit_posts'        => 'edit_letter_logs',
				'edit_others_posts' => 'edit_others_letter_logs',
				'create_posts'      => 'create_letter_logs',
				'publish_posts'     => 'publish_letter_logs',
				'read_private_posts' => 'read_private_letter_logs',
				'delete_posts'      => 'delete_letter_logs',
			),
			'map_meta_cap'        => true,
		);

		register_post_type( 'letter_log', $args );
	}

	/**
	 * Register custom post statuses.
	 *
	 * @since 1.0.0
	 */
	public static function register_post_statuses() {
		// Register 'draft' status
		self::register_draft_status();

		// Register 'scheduled' status
		self::register_scheduled_status();

		// Register 'sending' status
		self::register_sending_status();

		// Register 'sent' status
		self::register_sent_status();

		// Register 'failed' status
		self::register_failed_status();

		// Register 'bounced' status
		self::register_bounced_status();
	}

	/**
	 * Register 'draft' status for letters in progress.
	 *
	 * @since 1.0.0
	 */
	private static function register_draft_status() {
		register_post_status(
			'draft',
			array(
				'label'                     => _x( 'Draft', 'Post Status', 'wp-letter-automation' ),
				'public'                    => false,
				'exclude_from_search'       => true,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				/* translators: number of draft letters */
				'label_count'               => _n_noop( 'Draft <span class="count">(%s)</span>', 'Draft <span class="count">(%s)</span>', 'wp-letter-automation' ),
			)
		);
	}

	/**
	 * Register 'scheduled' status for letters scheduled to send.
	 *
	 * @since 1.0.0
	 */
	private static function register_scheduled_status() {
		register_post_status(
			'scheduled',
			array(
				'label'                     => _x( 'Scheduled', 'Post Status', 'wp-letter-automation' ),
				'public'                    => false,
				'exclude_from_search'       => true,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				/* translators: number of scheduled letters */
				'label_count'               => _n_noop( 'Scheduled <span class="count">(%s)</span>', 'Scheduled <span class="count">(%s)</span>', 'wp-letter-automation' ),
			)
		);
	}

	/**
	 * Register 'sending' status for letters currently being sent.
	 *
	 * @since 1.0.0
	 */
	private static function register_sending_status() {
		register_post_status(
			'sending',
			array(
				'label'                     => _x( 'Sending', 'Post Status', 'wp-letter-automation' ),
				'public'                    => false,
				'exclude_from_search'       => true,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				/* translators: number of sending letters */
				'label_count'               => _n_noop( 'Sending <span class="count">(%s)</span>', 'Sending <span class="count">(%s)</span>', 'wp-letter-automation' ),
			)
		);
	}

	/**
	 * Register 'sent' status for successfully sent letters.
	 *
	 * @since 1.0.0
	 */
	private static function register_sent_status() {
		register_post_status(
			'sent',
			array(
				'label'                     => _x( 'Sent', 'Post Status', 'wp-letter-automation' ),
				'public'                    => false,
				'exclude_from_search'       => true,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				/* translators: number of sent letters */
				'label_count'               => _n_noop( 'Sent <span class="count">(%s)</span>', 'Sent <span class="count">(%s)</span>', 'wp-letter-automation' ),
			)
		);
	}

	/**
	 * Register 'failed' status for letters that failed to send.
	 *
	 * @since 1.0.0
	 */
	private static function register_failed_status() {
		register_post_status(
			'failed',
			array(
				'label'                     => _x( 'Failed', 'Post Status', 'wp-letter-automation' ),
				'public'                    => false,
				'exclude_from_search'       => true,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				/* translators: number of failed letters */
				'label_count'               => _n_noop( 'Failed <span class="count">(%s)</span>', 'Failed <span class="count">(%s)</span>', 'wp-letter-automation' ),
			)
		);
	}

	/**
	 * Register 'bounced' status for letters that bounced.
	 *
	 * @since 1.0.0
	 */
	private static function register_bounced_status() {
		register_post_status(
			'bounced',
			array(
				'label'                     => _x( 'Bounced', 'Post Status', 'wp-letter-automation' ),
				'public'                    => false,
				'exclude_from_search'       => true,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				/* translators: number of bounced letters */
				'label_count'               => _n_noop( 'Bounced <span class="count">(%s)</span>', 'Bounced <span class="count">(%s)</span>', 'wp-letter-automation' ),
			)
		);
	}
}

// Initialize the class if not in CLI mode.
if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	WP_Letter_Automation_Post_Types::init();
}
