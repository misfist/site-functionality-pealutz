<?php
/**
 * Taxonomy
 *
 * @since   1.0.0
 *
 * @package   Site_Functionality
 */
namespace Site_Functionality\App\Taxonomies;

use Site_Functionality\Common\Abstracts\Taxonomy;

/**
 * Class Taxonomies
 *
 * @package Site_Functionality\App\Taxonomies
 * @since 1.0.0
 */
class Project_Tag extends Taxonomy {

	/**
	 * Taxonomy data
	 */
	public static $taxonomy = array(
		'id'           => 'project_tag',
		'title'        => 'Project Tags',
		'singular'     => 'Project Tag',
		'menu'         => 'Tags',
		'post_types'   => array(
			'project',
			'page',
		),
		'hierarchical' => true,
		'has_archive'  => false,
		'archive'      => 'project-tag',
		'with_front'   => false,
		'rest'         => 'project-tags',
	);

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		parent::__construct();

		\add_action( 'init', array( $this, 'rewrite_rules' ), 10, 0 );
		\add_filter( 'rwmb_meta_boxes', array( $this, 'register_fields' ) );
	}

	/**
	 * Add rewrite rules
	 *
	 * @link https://developer.wordpress.org/reference/functions/add_rewrite_rule/
	 *
	 * @return void
	 */
	public function rewrite_rules(): void {}

	/**
	 * Register Fields
	 * 
	 * @since 1.0.14
	 *
	 * @param array $meta_boxes
	 * @return array
	 */
	public function register_fields( array $meta_boxes ): array {
		$meta_boxes[] = array(
			'taxonomies' => array( self::$taxonomy['id'] ),
			'title'      => __( '', 'site-functionality' ),
			'id'         => 'details',
			'fields'     => array(
				array(
					'type' => 'switch',
					'id'   => 'is_filter',
					'name' => __( 'Filter', 'site-functionality' ),
				),
			),
		);

		return $meta_boxes;
	}
}
