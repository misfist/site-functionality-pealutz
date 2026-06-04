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
		'id'           => 'project',
		'slug'         => 'project',
		'menu'         => 'Projects',
		'title'        => 'Projects',
		'singular'     => 'Project',
		'icon'         => 'dashicons-book-alt',
		'taxonomies'   => array(
			'project_type',
		),
		'hierarchical' => true,
		'has_archive'  => false,
		'with_front'   => false,
		'rest_base'    => 'projects',
		'supports'     => array(
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

		self::$fields = array(
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
			),
		);

		error_log( print_r( function_exists( 'rwmb_meta' ), true ) );

		if ( is_plugin_active( 'meta-box-aio/meta-box-aio.php' ) || function_exists( '\rwmb_meta' ) ) {
			\add_filter( 'rwmb_meta_boxes', array( $this, 'register_fields_mb' ) );
		} else {
			\add_action( 'acf/include_fields', array( $this, 'register_fields' ) );
		}

		\add_action( 'init', array( $this, 'register_meta' ) );
		\add_action( 'init', array( $this, 'register_bindings' ) );
		\add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_editor_assets' ) );
	}

	/**
	 * Register Custom Fields
	 *
	 * @return void
	 */
	public function register_fields(): void {
		$args = array(
			'key'                   => 'group_project_details',
			'title'                 => __( 'Project Details', 'site-functionality' ),
			'fields'                => self::$fields,
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => self::$post_type['id'],
					),
				),
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'jetpack-portfolio',
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
	 * Register Fields
	 *
	 * @param array $meta_boxes
	 *
	 * @return array
	 */
	public function register_fields_mb( array $meta_boxes ): array {
		$meta_boxes[] = array(
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'show_in_rest'          => 1,
			'allow_ai_access'       => false,
			'post_types'            => array(
				self::$post_type['id'],
				'jetpack-portfolio',
			),
			'title'                 => __( 'Project Details', 'site-functionality' ),
			'id'                    => 'acf_group_project_details',
			''                      => array(
				'relation' => 'AND',
			),
			'fields'                => array(
				array(
					'type' => 'text',
					'name' => __( 'Company', 'site-functionality' ),
					'id'   => 'company',
				),
				array(
					'type' => 'url',
					'name' => __( 'URL', 'site-functionality' ),
					'id'   => 'url',
				),
				array(
					'type' => 'text',
					'name' => __( 'Location', 'site-functionality' ),
					'id'   => 'location',
				),
				array(
					'type'        => 'date',
					'name'        => __( 'Start Date', 'site-functionality' ),
					'id'          => 'start_date',
					'js_options'  => array(
						'dateFormat'      => 'mm/dd/yy',
						'changeYear'      => true,
						'yearRange'       => '-100:+100',
						'changeMonth'     => true,
						'showButtonPanel' => true,
						'firstDay'        => 1,
					),
					'save_format' => 'Ymd',
				),
				array(
					'type'        => 'date',
					'name'        => __( 'End Date', 'site-functionality' ),
					'id'          => 'end_date',
					'js_options'  => array(
						'dateFormat'      => 'mm/dd/yy',
						'changeYear'      => true,
						'yearRange'       => '-100:+100',
						'changeMonth'     => true,
						'showButtonPanel' => true,
						'firstDay'        => 1,
					),
					'save_format' => 'Ymd',
				),
				array(
					'type'       => 'group',
					'name'       => __( 'Clients', 'site-functionality' ),
					'id'         => 'clients',
					'clone'      => true,
					'sort_clone' => true,
					'fields'     => array(
						array(
							'type'              => 'text',
							'allow_in_bindings' => 1,
							'name'              => __( 'Name', 'site-functionality' ),
							'id'                => 'client_name',
						),
						array(
							'type'              => 'url',
							'allow_in_bindings' => 1,
							'name'              => __( 'URL', 'site-functionality' ),
							'id'                => 'client_url',
						),
					),
				),
			),
		);

		return $meta_boxes;
	}

	/**
	 * Register Meta
	 *
	 * @since 1.0.11
	 *
	 * @return void
	 */
	public function register_meta(): void {
		foreach ( self::$fields as $field ) {
			if ( 'repeater' === $field['type'] ) {
				continue;
			}

			\register_post_meta(
				self::$post_type['id'],
				$field['name'],
				array(
					'type'         => 'string',
					'single'       => true,
					'show_in_rest' => true,
				)
			);
		}
	}

	/**
	 * Register Block Bindings
	 *
	 * @since 1.0.11
	 *
	 * @return void
	 */
	public function register_bindings(): void {
		\register_block_bindings_source(
			'site-functionality/project-date',
			array(
				'label'              => __( 'Project Date', 'site-functionality' ),
				'get_value_callback' => array( $this, 'get_project_date_value' ),
				'uses_context'       => array( 'postId', 'postType' ),
			)
		);

		\register_block_bindings_source(
			'site-functionality/project-company',
			array(
				'label'              => __( 'Project Company', 'site-functionality' ),
				'get_value_callback' => array( $this, 'get_project_company_value' ),
				'uses_context'       => array( 'postId', 'postType' ),
			)
		);
	}

	/**
	 * Enqueue Editor Assets
	 *
	 * @since 1.0.12
	 *
	 * @return void
	 */
	public function enqueue_editor_assets(): void {
		$asset_path = \plugin_dir_path( __FILE__ ) . '../blocks/build/bindings.asset.php';

		if ( ! file_exists( $asset_path ) ) {
			return;
		}

		$asset_file = require $asset_path;

		\wp_enqueue_script(
			'site-functionality-bindings',
			\plugin_dir_url( __FILE__ ) . '../blocks/build/bindings.js',
			$asset_file['dependencies'],
			$asset_file['version'],
			true
		);
	}

	/**
	 * Get Project Date Binding Value
	 *
	 * @since 1.0.11
	 *
	 * @param array     $args   Binding args (e.g. [ 'key' => 'start_date' ]).
	 * @param \WP_Block $block  The block instance.
	 * @return string|null
	 */
	public function get_project_date_value( array $args, \WP_Block $block ): ?string {
		$post_id = $block->context['postId'] ?? \get_the_ID();
		$key     = $args['key'] ?? '';

		if ( empty( $key ) ) {
			return null;
		}

		$value = \get_post_meta( $post_id, $key, true );

		if ( empty( $value ) ) {
			return null;
		}

		$timestamp = \DateTime::createFromFormat( 'Ymd', $value );

		if ( false === $timestamp ) {
			return $value;
		}

		$format = \get_option( 'date_format', 'F Y' );

		return $timestamp->format( $format );
	}

	/**
	 * Get Project Company Binding Value
	 *
	 * Returns the company name linked to the project URL, or plain name if no URL is set.
	 *
	 * @since 1.0.11
	 *
	 * @param array     $args   Binding args.
	 * @param \WP_Block $block  The block instance.
	 * @return string|null
	 */
	public function get_project_company_value( array $args, \WP_Block $block ): ?string {
		$post_id = $block->context['postId'] ?? \get_the_ID();
		$company = \get_post_meta( $post_id, 'company', true );

		if ( empty( $company ) ) {
			return null;
		}

		$url = \get_post_meta( $post_id, 'url', true );

		if ( empty( $url ) ) {
			return \esc_html( $company );
		}

		return sprintf(
			'<a href="%s">%s</a>',
			\esc_url( $url ),
			\esc_html( $company )
		);
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
