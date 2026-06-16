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

		if ( is_plugin_active( 'meta-box-aio/meta-box-aio.php' ) || function_exists( '\rwmb_meta' ) ) {
			\add_filter( 'rwmb_meta_boxes', array( $this, 'register_fields' ) );
		} else {
			\add_action( 'acf/include_fields', array( $this, 'register_fields_acf' ) );
		}

		\add_action( 'init', array( $this, 'fields_init' ) );
		\add_action( 'init', array( $this, 'register_meta' ) );
		\add_action( 'init', array( $this, 'register_bindings' ) );
		\add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_editor_assets' ) );
		\add_filter( 'render_block_core/list', array( $this, 'render_clients_list' ), 10, 2 );
	}

	/**
	 * Initialize field definitions.
	 *
	 * @since 1.0.12
	 *
	 * @return void
	 */
	public function fields_init(): void {
		self::$fields = array(
			array(
				'id'   => 'company',
				'name' => __( 'Company', 'site-functionality' ),
				'type' => 'text',
			),
			array(
				'id'   => 'url',
				'name' => __( 'URL', 'site-functionality' ),
				'type' => 'url',
			),
			array(
				'id'   => 'sector',
				'name' => __( 'Sector', 'site-functionality' ),
				'type' => 'text',
			),
			array(
				'id'   => 'location',
				'name' => __( 'Location', 'site-functionality' ),
				'type' => 'text',
			),
			array(
				'id'          => 'start_date',
				'name'        => __( 'Start Date', 'site-functionality' ),
				'type'        => 'date',
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
				'id'          => 'end_date',
				'name'        => __( 'End Date', 'site-functionality' ),
				'type'        => 'date',
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
				'id'                => 'clients',
				'name'              => __( 'Clients', 'site-functionality' ),
				'type'              => 'group',
				'clone'             => true,
				'sort_clone'        => true,
				'allow_in_bindings' => 1,
				'fields'            => array(
					array(
						'id'                => 'client_name',
						'name'              => __( 'Name', 'site-functionality' ),
						'type'              => 'text',
						'allow_in_bindings' => 1,
					),
					array(
						'id'                => 'client_url',
						'name'              => __( 'URL', 'site-functionality' ),
						'type'              => 'url',
						'allow_in_bindings' => 1,
					),
				),
			),
		);
	}

	/**
	 * Register Fields
	 *
	 * @param array $meta_boxes
	 *
	 * @return array
	 */
	public function register_fields( array $meta_boxes ): array {
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
			'fields'                => self::$fields,
		);

		return $meta_boxes;
	}

	/**
	 * Register Custom Fields
	 *
	 * @return void
	 */
	public function register_fields_acf(): void {
		$args = array(
			'key'                   => 'group_project_details',
			'title'                 => __( 'Project Details', 'site-functionality' ),
			'fields'                => self::mb_to_acf_fields( self::$fields ),
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
	 * Convert MB field definitions to ACF format.
	 *
	 * @param array $fields
	 * @return array
	 */
	protected static function mb_to_acf_fields( array $fields ): array {
		$mapped = array();

		foreach ( $fields as $field ) {
			$type = $field['type'];
			$acf  = array(
				'key'   => 'field_' . $field['id'],
				'label' => $field['name'],
				'name'  => $field['id'],
				'type'  => ( 'date' === $type ) ? 'date_picker' : ( ( 'group' === $type ) ? 'repeater' : $type ),
			);

			if ( 'date' === $type ) {
				$acf['display_format'] = 'm/d/Y';
				$acf['return_format']  = 'd/m/Y';
				$acf['first_day']      = 1;
			} elseif ( 'group' === $type ) {
				$acf['layout']     = 'table';
				$acf['sub_fields'] = self::mb_to_acf_fields( $field['fields'] ?? array() );
			}

			$mapped[] = $acf;
		}

		return $mapped;
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
			if ( 'group' === $field['type'] ) {
				$subfields = $field['fields'] ?? array();
				$properties = array();

				foreach ( $subfields as $subfield ) {
					$properties[ $subfield['id'] ] = array( 'type' => 'string' );
				}

				\register_post_meta(
					self::$post_type['id'],
					$field['id'],
					array(
						'type'         => 'array',
						'single'       => true,
						'show_in_rest' => array(
							'schema' => array(
								'type'  => 'array',
								'items' => array(
									'type'       => 'object',
									'properties' => $properties,
								),
							),
						),
					)
				);

				continue;
			}

			\register_post_meta(
				self::$post_type['id'],
				$field['id'],
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

		\register_block_bindings_source(
			'site-functionality/project-clients',
			array(
				'label'              => __( 'Clients', 'site-functionality' ),
				'get_value_callback' => array( $this, 'get_project_clients_value' ),
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
		$asset_path = SITE_FUNCTIONALITY_PATH . 'src/app/blocks/build/bindings.asset.php';

		if ( ! file_exists( $asset_path ) ) {
			error_log( __METHOD__ . sprintf( ': Asset file not found: %s', $asset_path ) );
			return;
		}

		$asset_file = include $asset_path;

		\wp_enqueue_script(
			'site-functionality-bindings',
			SITE_FUNCTIONALITY_URL . 'src/app/blocks/build/bindings.js',
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
	 * Get Project Clients Binding Value
	 *
	 * @since 1.0.12
	 *
	 * @param array     $args  Binding args.
	 * @param \WP_Block $block The block instance.
	 * @return string|null
	 */
	public function get_project_clients_value( array $args, \WP_Block $block ): ?string {
		$post_id = $block->context['postId'] ?? \get_the_ID();
		$clients = \get_post_meta( $post_id, 'clients', true );

		if ( empty( $clients ) || ! is_array( $clients ) ) {
			return null;
		}

		$items = array();

		foreach ( $clients as $client ) {
			$name = $client['client_name'] ?? '';
			$url  = $client['client_url'] ?? '';

			if ( empty( $name ) ) {
				continue;
			}

			$label   = \esc_html( $name );
			$content = $url ? sprintf( '<a href="%s">%s</a>', \esc_url( $url ), $label ) : $label;
			$items[] = '<li>' . $content . '</li>';
		}

		if ( empty( $items ) ) {
			return null;
		}

		return implode( '', $items );
	}

	/**
	 * Render clients list block with bound meta data.
	 *
	 * @since 1.0.12
	 *
	 * @param string   $block_content
	 * @param array    $block
	 * @return string
	 */
	public function render_clients_list( string $block_content, array $block ): string {
		$source = $block['attrs']['metadata']['bindings']['content']['source'] ?? '';

		if ( 'site-functionality/project-clients' !== $source ) {
			return $block_content;
		}

		$post_id = \get_the_ID();
		$clients = \get_post_meta( $post_id, 'clients', true );

		if ( empty( $clients ) || ! is_array( $clients ) ) {
			return $block_content;
		}

		$items = array();

		foreach ( $clients as $client ) {
			$name = $client['client_name'] ?? '';
			$url  = $client['client_url'] ?? '';

			if ( empty( $name ) ) {
				continue;
			}

			$label   = \esc_html( $name );
			$content = $url ? sprintf( '<a href="%s">%s</a>', \esc_url( $url ), $label ) : $label;
			$items[] = '<li class="wp-block-list-item">' . $content . '</li>';
		}

		if ( empty( $items ) ) {
			return $block_content;
		}

		$inner = implode( '', $items );

		return preg_replace( '#(<ul[^>]*>).*?(</ul>)#s', '$1' . $inner . '$2', $block_content );
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
