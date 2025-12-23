<?php
/**
 * ACFFields Class
 *
 * Registers and manages all ACF field groups for the wp-letter-automation plugin.
 *
 * @package wp-letter-automation
 * @subpackage Includes
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ACFFields Class
 *
 * Handles registration and management of all Advanced Custom Fields (ACF)
 * field groups used throughout the wp-letter-automation plugin.
 *
 * @since 1.0.0
 */
class ACFFields {

	/**
	 * Constructor
	 *
	 * Initializes ACF fields registration hooks.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'acf/init', array( $this, 'register_field_groups' ) );
	}

	/**
	 * Register all ACF field groups
	 *
	 * Registers all field groups used by the wp-letter-automation plugin.
	 * This method is hooked to the 'acf/init' action.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_field_groups() {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		$this->register_letter_settings_group();
		$this->register_letter_content_group();
		$this->register_letter_recipients_group();
	}

	/**
	 * Register Letter Settings Field Group
	 *
	 * Registers the field group for letter settings and configuration.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function register_letter_settings_group() {
		acf_add_local_field_group( array(
			'key'      => 'group_letter_settings',
			'title'    => __( 'Letter Settings', 'wp-letter-automation' ),
			'fields'   => array(
				array(
					'key'          => 'field_letter_template',
					'name'         => 'template',
					'label'        => __( 'Letter Template', 'wp-letter-automation' ),
					'type'         => 'select',
					'instructions' => __( 'Choose a template for this letter', 'wp-letter-automation' ),
					'required'     => 1,
					'choices'      => $this->get_available_templates(),
				),
				array(
					'key'          => 'field_letter_date_format',
					'name'         => 'date_format',
					'label'        => __( 'Date Format', 'wp-letter-automation' ),
					'type'         => 'select',
					'instructions' => __( 'Select the date format for this letter', 'wp-letter-automation' ),
					'choices'      => array(
						'F j, Y'     => date( 'F j, Y' ),
						'd/m/Y'      => date( 'd/m/Y' ),
						'Y-m-d'      => date( 'Y-m-d' ),
						'm/d/Y'      => date( 'm/d/Y' ),
					),
				),
				array(
					'key'      => 'field_letter_status',
					'name'     => 'status',
					'label'    => __( 'Status', 'wp-letter-automation' ),
					'type'     => 'select',
					'choices'  => array(
						'draft'      => __( 'Draft', 'wp-letter-automation' ),
						'scheduled'  => __( 'Scheduled', 'wp-letter-automation' ),
						'sent'       => __( 'Sent', 'wp-letter-automation' ),
					),
					'default'  => 'draft',
				),
				array(
					'key'          => 'field_letter_scheduled_date',
					'name'         => 'scheduled_date',
					'label'        => __( 'Scheduled Date', 'wp-letter-automation' ),
					'type'         => 'date_time_picker',
					'instructions' => __( 'Set when this letter should be sent', 'wp-letter-automation' ),
					'conditional_logic' => array(
						array(
							array(
								'field'    => 'field_letter_status',
								'operator' => '==',
								'value'    => 'scheduled',
							),
						),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'letter',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => array(),
			'active'                => true,
			'description'           => __( 'Configure settings and metadata for automated letters', 'wp-letter-automation' ),
		) );
	}

	/**
	 * Register Letter Content Field Group
	 *
	 * Registers the field group for letter content and body.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function register_letter_content_group() {
		acf_add_local_field_group( array(
			'key'      => 'group_letter_content',
			'title'    => __( 'Letter Content', 'wp-letter-automation' ),
			'fields'   => array(
				array(
					'key'          => 'field_letter_subject',
					'name'         => 'subject',
					'label'        => __( 'Subject Line', 'wp-letter-automation' ),
					'type'         => 'text',
					'instructions' => __( 'Enter the subject line for the letter', 'wp-letter-automation' ),
					'required'     => 1,
					'placeholder'  => __( 'e.g., Important Update Regarding Your Account', 'wp-letter-automation' ),
				),
				array(
					'key'          => 'field_letter_greeting',
					'name'         => 'greeting',
					'label'        => __( 'Greeting', 'wp-letter-automation' ),
					'type'         => 'text',
					'instructions' => __( 'Enter the greeting (e.g., Dear [recipient_name])', 'wp-letter-automation' ),
					'placeholder'  => __( 'e.g., Dear [recipient_name]', 'wp-letter-automation' ),
				),
				array(
					'key'          => 'field_letter_body',
					'name'         => 'body',
					'label'        => __( 'Letter Body', 'wp-letter-automation' ),
					'type'         => 'wysiwyg',
					'instructions' => __( 'Enter the main content of the letter. Use [tags] for dynamic placeholders.', 'wp-letter-automation' ),
					'required'     => 1,
					'toolbar'      => 'full',
					'media_upload' => 1,
				),
				array(
					'key'          => 'field_letter_closing',
					'name'         => 'closing',
					'label'        => __( 'Letter Closing', 'wp-letter-automation' ),
					'type'         => 'text',
					'instructions' => __( 'Enter the closing salutation', 'wp-letter-automation' ),
					'placeholder'  => __( 'e.g., Sincerely', 'wp-letter-automation' ),
				),
				array(
					'key'          => 'field_letter_signature',
					'name'         => 'signature',
					'label'        => __( 'Signature/Footer', 'wp-letter-automation' ),
					'type'         => 'textarea',
					'instructions' => __( 'Enter signature or footer information', 'wp-letter-automation' ),
					'rows'         => 4,
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'letter',
					),
				),
			),
			'menu_order'            => 1,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => array(),
			'active'                => true,
			'description'           => __( 'Manage the content of automated letters', 'wp-letter-automation' ),
		) );
	}

	/**
	 * Register Letter Recipients Field Group
	 *
	 * Registers the field group for managing letter recipients.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function register_letter_recipients_group() {
		acf_add_local_field_group( array(
			'key'      => 'group_letter_recipients',
			'title'    => __( 'Letter Recipients', 'wp-letter-automation' ),
			'fields'   => array(
				array(
					'key'          => 'field_letter_recipient_type',
					'name'         => 'recipient_type',
					'label'        => __( 'Recipient Type', 'wp-letter-automation' ),
					'type'         => 'select',
					'instructions' => __( 'Choose how recipients will be selected', 'wp-letter-automation' ),
					'required'     => 1,
					'choices'      => array(
						'all_users'     => __( 'All Users', 'wp-letter-automation' ),
						'user_role'     => __( 'By User Role', 'wp-letter-automation' ),
						'custom_list'   => __( 'Custom User List', 'wp-letter-automation' ),
						'user_meta'     => __( 'By User Meta', 'wp-letter-automation' ),
					),
					'default'      => 'all_users',
				),
				array(
					'key'          => 'field_letter_user_roles',
					'name'         => 'user_roles',
					'label'        => __( 'User Roles', 'wp-letter-automation' ),
					'type'         => 'select',
					'instructions' => __( 'Select one or more user roles', 'wp-letter-automation' ),
					'multiple'     => 1,
					'choices'      => $this->get_user_roles(),
					'conditional_logic' => array(
						array(
							array(
								'field'    => 'field_letter_recipient_type',
								'operator' => '==',
								'value'    => 'user_role',
							),
						),
					),
				),
				array(
					'key'          => 'field_letter_custom_recipients',
					'name'         => 'custom_recipients',
					'label'        => __( 'Custom Recipients', 'wp-letter-automation' ),
					'type'         => 'user',
					'instructions' => __( 'Select specific users to receive this letter', 'wp-letter-automation' ),
					'multiple'     => 1,
					'conditional_logic' => array(
						array(
							array(
								'field'    => 'field_letter_recipient_type',
								'operator' => '==',
								'value'    => 'custom_list',
							),
						),
					),
				),
				array(
					'key'          => 'field_letter_exclude_users',
					'name'         => 'exclude_users',
					'label'        => __( 'Exclude Users', 'wp-letter-automation' ),
					'type'         => 'user',
					'instructions' => __( 'Select users to exclude from this letter', 'wp-letter-automation' ),
					'multiple'     => 1,
				),
				array(
					'key'          => 'field_letter_sent_count',
					'name'         => 'sent_count',
					'label'        => __( 'Sent Count', 'wp-letter-automation' ),
					'type'         => 'number',
					'instructions' => __( 'Number of recipients this letter has been sent to', 'wp-letter-automation' ),
					'readonly'     => 1,
					'default'      => 0,
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'letter',
					),
				),
			),
			'menu_order'            => 2,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => array(),
			'active'                => true,
			'description'           => __( 'Configure recipients for automated letters', 'wp-letter-automation' ),
		) );
	}

	/**
	 * Get Available Templates
	 *
	 * Returns available letter templates.
	 * Can be extended to load from a configuration file or database.
	 *
	 * @since 1.0.0
	 *
	 * @return array Array of template choices
	 */
	private function get_available_templates() {
		/**
		 * Filter available letter templates
		 *
		 * @since 1.0.0
		 *
		 * @param array $templates Default templates
		 */
		return apply_filters( 'wp_letter_automation_templates', array(
			'standard'  => __( 'Standard', 'wp-letter-automation' ),
			'formal'    => __( 'Formal', 'wp-letter-automation' ),
			'friendly'  => __( 'Friendly', 'wp-letter-automation' ),
			'marketing' => __( 'Marketing', 'wp-letter-automation' ),
		) );
	}

	/**
	 * Get User Roles
	 *
	 * Returns an array of available user roles.
	 *
	 * @since 1.0.0
	 *
	 * @return array Array of user roles
	 */
	private function get_user_roles() {
		global $wp_roles;

		if ( ! isset( $wp_roles ) ) {
			$wp_roles = new WP_Roles();
		}

		$choices = array();

		foreach ( $wp_roles->roles as $role_key => $role_data ) {
			$choices[ $role_key ] = $role_data['name'];
		}

		return $choices;
	}

	/**
	 * Get Field Value
	 *
	 * Helper method to retrieve a field value from a post.
	 *
	 * @since 1.0.0
	 *
	 * @param int    $post_id The post ID
	 * @param string $field_name The field name
	 * @param mixed  $default Default value if field is not found
	 *
	 * @return mixed The field value
	 */
	public static function get_field( $post_id, $field_name, $default = null ) {
		if ( function_exists( 'get_field' ) ) {
			$value = get_field( $field_name, $post_id );
			return false !== $value ? $value : $default;
		}

		return $default;
	}

	/**
	 * Update Field Value
	 *
	 * Helper method to update a field value for a post.
	 *
	 * @since 1.0.0
	 *
	 * @param int    $post_id The post ID
	 * @param string $field_name The field name
	 * @param mixed  $value The value to set
	 *
	 * @return bool True on success, false on failure
	 */
	public static function update_field( $post_id, $field_name, $value ) {
		if ( function_exists( 'update_field' ) ) {
			return update_field( $field_name, $value, $post_id );
		}

		return false;
	}
}
