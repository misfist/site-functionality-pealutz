<?php
/**
 * Content Post_Types
 *
 * @since   1.0.0
 * @package Site_Functionality
 */
namespace Site_Functionality\App\Post_Types;

use Site_Functionality\Common\Abstracts\Post_Type;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Project extends Post_Type {

	/**
	 * Post_Type data
	 */
	public static $post_type = array(
		'id'          => 'project',
		'slug'        => 'project',
		'menu'        => 'Project',
		'title'       => 'Projects',
		'singular'    => 'Project',
		'icon'        => 'dashicons-book-alt',
		'taxonomies'  => array(
			'project_type',
		),
		'has_archive' => false,
		'with_front'  => false,
		'rest_base'   => 'projects',
		'supports'    => array(
			'title',
			'editor',
			'author',
			'thumbnail',
			'custom-fields',
			'external-links',
		),
	);

	/**
	 * Post Type fields
	 */
	public static $field = array(
		'_links_to',
		'_links_to_target',
	);

	/**
	 * Init
	 *
	 * @return void
	 */
	public function init(): void {
		parent::init();
		// \add_action( 'init', array( $this, 'register_meta' ) );
		\add_action( 'acf/init', array( $this, 'register_fields' ) );
	}

	/**
	 * Register Custom Fields
	 *
	 * @return void
	 */
	public function register_fields(): void {
		$fields = array(
			array(
				'key'               => 'field_company',
				'label'             => __( 'Company', 'site-functionality' ),
				'name'              => 'company',
				'type'              => 'text',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'default_value'     => '',
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
				'maxlength'         => '',
				'ui'                => 1,
			),
			array(
				'key'               => 'field_url',
				'label'             => __( 'URL', 'site-functionality' ),
				'name'              => 'url',
				'type'              => 'url',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'default_value'     => '',
				'placeholder'       => '',
				'ui'                => 1,
			),
			array(
				'key'               => 'field_location',
				'label'             => __( 'Location', 'site-functionality' ),
				'name'              => 'location',
				'type'              => 'text',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'default_value'     => '',
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
				'maxlength'         => '',
				'ui'                => 1,
			),
			array(
				'key'               => 'field_start_date',
				'label'             => __( 'Start Date', 'site-functionality' ),
				'name'              => 'start_date',
				'type'              => 'date_picker',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'display_format'    => 'm/d/Y',
				'return_format'     => 'd/m/Y',
				'first_day'         => 1,
				'ui'                => 1,
			),
			array(
				'key'               => 'field_end_date',
				'label'             => __( 'End Date', 'site-functionality' ),
				'name'              => 'end_date',
				'type'              => 'date_picker',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'display_format'    => 'm/d/Y',
				'return_format'     => 'd/m/Y',
				'first_day'         => 1,
				'ui'                => 1,
			),
			array(
				'key'               => 'field_clients',
				'label'             => __( 'Clients', 'site-functionality' ),
				'name'              => 'clients',
				'type'              => 'repeater',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'collapsed'         => 'field_client_name',
				'min'               => 0,
				'max'               => 0,
				'layout'            => 'table',
				'button_label'      => '',
				'sub_fields'        => array(
					array(
						'key'               => 'field_client_name',
						'label'             => __( 'Name', 'site-functionality' ),
						'name'              => 'client_name',
						'type'              => 'text',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => '',
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
						'maxlength'         => '',
						'ui'                => 1,
					),
					array(
						'key'               => 'field_client_url',
						'label'             => __( 'URL', 'site-functionality' ),
						'name'              => 'client_url',
						'type'              => 'url',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => '',
						'placeholder'       => '',
						'ui'                => 1,
					),
				),
				∂,
			),
		);

		$args = array(
			'key'                   => 'group_project_details',
			'title'                 => __( 'Project Details', 'site-functionality' ),
			'fields'                => $fields,
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => self::POST_TYPE['id'],
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'active'                => 1,
			'description'           => '',
		);

		acf_add_local_field_group( $args );
	}

	/**
	 * Register Meta
	 *
	 * @return void
	 */
	public function register_meta(): void {}

	/**
	 * Modify Post Content
	 *
	 * @link https://developer.wordproject.org/reference/hooks/the_content/
	 *
	 * @param string $content
	 * @return string $content
	 */
	public function modify_post_content( $content ): string {
		return $content;
	}

	/**
	 * Modify Post Title
	 *
	 * @link https://developer.wordproject.org/reference/hooks/the_title/
	 *
	 * @param string $content
	 * @return string $content
	 */
	public function modify_post_title( $title ): string {
		return $title;
	}

	/**
	 * Register custom query vars
	 *
	 * @link https://developer.wordproject.org/reference/hooks/query_vars/
	 *
	 * @param array $vars The array of available query variables
	 */
	public function register_query_vars( $vars ): array {
		return $vars;
	}
}
