<?php
/**
 * Content CustomFields
 *
 * @since   1.0.0
 * @package SiteFunctionality
 */
namespace SiteFunctionality\CustomFields;

use SiteFunctionality\Abstracts\Base;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CustomFields extends Base {

	/**
	 * Custom fields
	 */
	public const FIELDS = array();

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $version, $plugin_name ) {
		parent::__construct( $version, $plugin_name );
		$this->init();
	}

	/**
	 * Init
	 *
	 * @return void
	 */
	public function init() {
		\add_action( 'acf/init', array( $this, 'acf_settings' ) );
		\add_action( 'acfe/init', array( $this, 'acfe_settings' ) );
		\add_action( 'acf/init', array( $this, 'register_fields' ) );
		if ( function_exists( '\acf_register_block_type' ) ) {
			\add_action( 'acf/init', array( $this, 'register_blocks' ) );
		}
		\add_action( 'acf/init', array( $this, 'register_block_fields' ) );
	}

	/**
	 * Modify ACF settings
	 *
	 * @link https://www.advancedcustomfields.com/resources/acf-settings/
	 *
	 * @return void
	 */
	public function acf_settings() {
		\acf_update_setting( 'l10n_textdomain', 'site-functionality' );

		\acf_update_setting( 'acfe/modules/taxonomies', false );
		\acf_update_setting( 'acfe/modules/forms', false );
		\acf_update_setting( 'acfe/modules/options_pages', false );
		\acf_update_setting( 'acfe/modules/post_types', false );
		\acf_update_setting( 'acfe/modules/ui', false );
	}

	/**
	 * Modify ACF settings
	 *
	 * @link https://www.acf-extended.com/features/modules/dynamic-options-pages
	 *
	 * @return void
	 */
	public function acfe_settings() {
		\acfe_update_setting( 'modules/taxonomies', false );
		\acfe_update_setting( 'modules/forms', false );
		\acfe_update_setting( 'modules/options_pages', false );
		\acfe_update_setting( 'modules/post_types', false );
		\acfe_update_setting( 'modules/ui', false );
	}

	/**
	 * Register Custom Fields
	 *
	 * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/#add-within-an-action
	 *
	 * @return void
	 */
	public function register_fields() {
		\acf_add_local_field_group(
			array(
				'key'                   => 'group_skills_group',
				'title'                 => __( 'Expertise', 'site-functionality' ),
				'fields'                => array(
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
								'button_label'      => __( 'Add Skill', 'site-functionality' ),
								'sub_fields'        => array(
									array(
										'key'           => 'field_skill',
										'label'         => __( 'Skill', 'site-functionality' ),
										'name'          => 'skill',
										'type'          => 'text',
										'instructions'  => '',
										'required'      => 0,
										'conditional_logic' => 0,
										'wrapper'       => array(
											'width' => '',
											'class' => '',
											'id'    => '',
										),
										'default_value' => '',
										'placeholder'   => '',
										'prepend'       => '',
										'append'        => '',
										'maxlength'     => '',
									),
									array(
										'key'           => 'field_rating',
										'label'         => __( 'Rating', 'site-functionality' ),
										'name'          => 'rating',
										'type'          => 'range',
										'instructions'  => '',
										'required'      => 0,
										'conditional_logic' => 0,
										'wrapper'       => array(
											'width' => '',
											'class' => '',
											'id'    => '',
										),
										'default_value' => '',
										'min'           => '',
										'max'           => 5,
										'step'          => '',
										'prepend'       => '',
										'append'        => '',
									),
								),
							),
						),
					),
				),
				'location'              => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'page',
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
			)
		);

		\acf_add_local_field_group(
			array(
				'key'                   => 'group_project_details',
				'title'                 => __( 'Project Details', 'site-functionality' ),
				'fields'                => array(
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
						'return_format'     => 'F Y',
						'first_day'         => 1,
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
						'return_format'     => 'F Y',
						'first_day'         => 1,
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
							),
						),
					),
				),
				'location'              => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'jetpack-portfolio',
						),
					),
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'project',
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
			)
		);
	}

	/**
	 * Register ACF Blocks
	 * 
	 * @link https://www.advancedcustomfields.com/resources/acf_register_block_type/
	 *
	 * @return void
	 */
	public function register_blocks() {
		\acf_register_block_type(
			array(
				'name'            => 'expertise',
				'title'           => __( 'Expertise', 'site-functionality' ),
				'active'          => true,
				'description'     => '',
				'category'        => 'common',
				'icon'            => 'list-view',
				'keywords'        => array(
					'skills',
					'list',
					'expertise',
				),
				'post_types'      => array(
					'page',
					'project',
				),
				'mode'            => 'preview',
				'align'           => '',
				'align_text'      => '',
				'align_content'   => 'top',
				'render_template' => 'inc/blocks/templates/expertise.php',
				'render_callback' => '',
				'enqueue_style'   => '',
				'enqueue_script'  => '',
				'enqueue_assets'  => '',
				'supports'        => array(
					'anchor'        => true,
					'align'         => true,
					'align_text'    => true,
					'align_content' => true,
					'full_height'   => false,
					'mode'          => true,
					'multiple'      => true,
					'example'       => array(),
					'jsx'           => true,
				),
			)
		);
	}

	/**
	 * Register Fields for ACF Block
	 * 
	 * @link @link https://www.advancedcustomfields.com/resources/register-fields-via-php/#add-within-an-action
	 *
	 * @return void
	 */
	public function register_block_fields() {
		acf_add_local_field_group(
			array(
				'key'                   => 'group_expertise_block_fields',
				'title'                 => __( 'Expertise', 'site-functionality' ),
				'fields'                => array(
					array(
						'key'                           => 'field_skills_group',
						'label'                         => __( 'Skills', 'site-functionality' ),
						'name'                          => 'skills_group',
						'aria-label'                    => '',
						'type'                          => 'repeater',
						'instructions'                  => '',
						'required'                      => 0,
						'conditional_logic'             => 0,
						'wrapper'                       => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'acfe_repeater_stylised_button' => 0,
						'layout'                        => 'row',
						'pagination'                    => 1,
						'rows_per_page'                 => 20,
						'min'                           => 0,
						'max'                           => 0,
						'collapsed'                     => 'field_section',
						'button_label'                  => __( 'Add Section', 'site-functionality' ),
						'sub_fields'                    => array(
							array(
								'key'               => 'field_section',
								'label'             => __( 'Section', 'site-functionality' ),
								'name'              => 'section',
								'aria-label'        => '',
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
								'parent_repeater'   => 'field_skills_group',
							),
							array(
								'key'               => 'field_skills',
								'label'             => __( 'Skills', 'site-functionality' ),
								'name'              => 'skills',
								'aria-label'        => '',
								'type'              => 'repeater',
								'instructions'      => '',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'acfe_repeater_stylised_button' => 1,
								'layout'            => 'table',
								'pagination'        => 0,
								'min'               => 0,
								'max'               => 0,
								'collapsed'         => '',
								'button_label'      => 'Add Row',
								'rows_per_page'     => 20,
								'sub_fields'        => array(
									array(
										'key'             => 'field_skill',
										'label'           => __( 'Skill', 'site-functionality' ),
										'name'            => 'skill',
										'aria-label'      => '',
										'type'            => 'text',
										'instructions'    => '',
										'required'        => 0,
										'conditional_logic' => 0,
										'wrapper'         => array(
											'width' => '',
											'class' => '',
											'id'    => '',
										),
										'default_value'   => '',
										'maxlength'       => '',
										'placeholder'     => '',
										'prepend'         => '',
										'append'          => '',
										'parent_repeater' => 'field_skills',
									),
									array(
										'key'             => 'field_rating',
										'label'           => __( 'Rating', 'site-functionality' ),
										'name'            => 'rating',
										'aria-label'      => '',
										'type'            => 'range',
										'instructions'    => '',
										'required'        => 0,
										'conditional_logic' => 0,
										'wrapper'         => array(
											'width' => '',
											'class' => '',
											'id'    => '',
										),
										'default_value'   => '',
										'min'             => 1,
										'max'             => 10,
										'step'            => '',
										'prepend'         => '',
										'append'          => '',
										'parent_repeater' => 'field_skills',
									),
								),
								'parent_repeater'   => 'field_skills_group',
							),
						),
					),
				),
				'location'              => array(
					array(
						array(
							'param'    => 'block',
							'operator' => '==',
							'value'    => 'acf/expertise',
						),
					),
				),
				'menu_order'            => 0,
				'position'              => 'acf_after_title',
				'style'                 => 'seamless',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen'        => '',
				'active'                => true,
				'description'           => '',
				'show_in_rest'          => 1,
				'acfe_display_title'    => '',
				'acfe_autosync'         => '',
				'acfe_form'             => 0,
				'acfe_meta'             => '',
				'acfe_note'             => '',
			)
		);
	}
}
