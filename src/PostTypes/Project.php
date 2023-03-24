<?php
/**
 * Content PostTypes
 *
 * @since   1.0.0
 * @package SiteFunctionality
 */
namespace SiteFunctionality\PostTypes;

use SiteFunctionality\Abstracts\PostType;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Project extends PostType {

	/**
	 * PostType data
	 */
	public const POST_TYPE = array(
		'id'          => 'project',
		'slug'        => 'project',
		'menu'        => 'Projects',
		'title'       => 'Projects',
		'singular'    => 'Project',
		'icon'        => 'dashicons-analytics',
		'taxonomies'  => array(),
		'has_archive' => false,
		'with_front'  => false,
		'rest_base'   => 'project',
		'supports'    => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'external-links' ),
	);

	/**
	 * Post Type fields
	 */
	public const FIELDS = array(
		'_links_to',
		'_links_to_target',
	);

	/**
	 * Init
	 *
	 * @return void
	 */
	public function init() {
		parent::init();
		// \add_action( 'init', array( $this, 'register_meta' ) );
		\add_action( 'acf/init', array( $this, 'register_fields' ) );
	}

	/**
	 * Register Custom Fields
	 *
	 * @return void
	 */
	public function register_fields() {
		\acf_add_local_field_group(
			array(
				'key'                   => 'group_source_info_' .  self::POST_TYPE['id'],
				'title'                 => __( 'Source Information', 'site-functionality' ),
				'fields'                => array(
					array(
						'key'               => 'field_source',
						'label'             => __( 'Source', 'site-functionality' ),
						'name'              => 'source',
						'type'              => 'link',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'return_format'     => 'array',
					),
				),
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
				'position'              => 'side',
				'style'                 => 'seamless',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen'        => '',
				'active'                => true,
				'description'           => '',
				'show_in_rest'          => 1,
			)
		);

	}

	/**
	 * Register custom query vars
	 *
	 * @link https://developer.wordpress.org/reference/hooks/query_vars/
	 *
	 * @param array $vars The array of available query variables
	 */
	public function registerQueryVars( $vars ) : array {
		return $vars;
	}

}
