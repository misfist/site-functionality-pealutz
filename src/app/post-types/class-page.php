<?php
/**
 * Content Post_Types
 *
 * @since   1.0.0
 * @package Site_Functionality
 */
namespace Site_Functionality\App\Post_Types;

use Site_Functionality\Common\Abstracts\Base;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Page extends Base {

	/**
	 * Post_Type data
	 */
	public static $post_type = array(
		'id' => 'page',
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

		if ( is_plugin_active( 'meta-box-aio/meta-box-aio.php' )  || function_exists( '\rwmb_meta' ) ) {
			\add_filter( 'rwmb_meta_boxes', array( $this, 'register_fields_mb' ) );
		} else {
			\add_action( 'acf/include_fields', array( $this, 'register_fields' ) );
		}
	}

	/**
	 * Register Custom Fields
	 *
	 * @return void
	 */
	public function register_fields(): void {
		$fields = array(
			array(
				'key'               => 'field_skills_group',
				'label'             => __( 'Skills', 'site-functionality' ),
				'name'              => 'skills_group',
				'type'              => 'repeater',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'collapsed'         => 'field_section',
				'min'               => 0,
				'max'               => 0,
				'layout'            => 'row',
				'button_label'      => __( 'Add Section', 'site-functionality' ),
				'sub_fields'        => array(
					array(
						'key'               => 'field_section',
						'label'             => __( 'Section', 'site-functionality' ),
						'name'              => 'section',
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
						'key'               => 'field_skills',
						'label'             => __( 'Skills', 'site-functionality' ),
						'name'              => 'skills',
						'type'              => 'repeater',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'collapsed'         => 'field_skill',
						'min'               => 0,
						'max'               => 0,
						'layout'            => 'table',
						'button_label'      => __( 'Add Skill' ),
						'sub_fields'        => array(
							array(
								'key'               => 'field_skill',
								'label'             => __( 'Skill', 'site-functionality' ),
								'name'              => 'skill',
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
								'key'               => 'field_rating',
								'label'             => __( 'Rating', 'site-functionality' ),
								'name'              => 'rating',
								'type'              => 'range',
								'instructions'      => '',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'default_value'     => '',
								'min'               => '',
								'max'               => 5,
								'step'              => '',
								'prepend'           => '',
								'append'            => '',
								'ui'                => 1,
							),
						),
					),
				),
			),
		);

		$args = array(
			'key'                   => 'group_skills_group',
			'title'                 => __( 'Expertise', 'site-functionality' ),
			'fields'                => $fields,
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => self::$post_type['id'],
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
			'show_in_rest'          => 1,
		);

		acf_add_local_field_group( $args );
	}

	/**
	 * Register Custom Fields
	 *
	 * @param array $meta_boxes
	 *
	 * @return array
	 */
	function register_fields_mb( array $meta_boxes ): array {
		$meta_boxes[] = array(
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'post_types'            => array( self::$post_type['id'] ),
			'title'                 => __( 'Expertise', 'site-functionality' ),
			'id'                    => 'acf_group_skills_group',
			''                      => array(
				'relation' => 'AND',
			),
			'fields'                => array(
				array(
					'type'       => 'group',
					'name'       => __( 'Skills', 'site-functionality' ),
					'id'         => 'skills_group',
					'clone'      => true,
					'sort_clone' => true,
					'add_button' => __( 'Add Section', 'site-functionality' ),
					'fields'     => array(
						array(
							'type' => 'text',
							'name' => __( 'Section', 'site-functionality' ),
							'id'   => 'section',
						),
						array(
							'type' => 'text',
							'name' => __( 'Skill', 'site-functionality' ),
							'id'   => 'skill',
						),
						array(
							'type' => 'range',
							'max'  => 5,
							'name' => __( 'Rating', 'site-functionality' ),
							'id'   => 'ratting',
						),
					),
				),
			),
		);

		return $meta_boxes;
	}
}
