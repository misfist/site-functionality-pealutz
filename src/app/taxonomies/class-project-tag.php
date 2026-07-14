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
		'query_var'    => 'project-tag',
	);

	public static $archive_slug = 'portfolio';

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		parent::__construct();
		\add_filter( 'rwmb_meta_boxes', array( $this, 'register_fields' ) );
		\add_filter( 'query_vars', array( $this, 'register_query_vars' ) );
		\add_filter( 'term_link', array( $this, 'modify_term_link' ), 10, 3 );

		\add_action( 'init', array( $this, 'rewrite_rules' ), 10, 0 );
	}

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

	/**
	 * Register custom query vars
	 *
	 * @link https://developer.wordpress.org/reference/hooks/query_vars/
	 *
	 * @param array $vars The array of available query variables
	 * @return array $vars The array of available query variables
	 */
	public function register_query_vars( $vars ): array {
		$vars[] = 'project-tag';
		return $vars;
	}

	/**
	 * Modify term link
	 *
	 * @param string $termlink
	 * @param \WP_Term $term
	 * @param string $taxonomy
	 *
	 * @return string
	 */
	public function modify_term_link( string $termlink, \WP_Term $term, string $taxonomy ): string {
		if( is_admin() || self::$taxonomy['id'] !== $taxonomy ) {
			return $termlink;
		}

		return esc_url( add_query_arg( self::$taxonomy['query_var'], $term->slug, get_home_url( null, self::$archive_slug ) ) );

		return $termlink;
	}

	/**
	 * Add rewrite rules
	 *
	 * @link https://developer.wordpress.org/reference/functions/add_rewrite_rule/
	 *
	 * @return void
	 */
	public function rewrite_rules(): void {}
}
