<?php
/**
 * Taxonomy
 *
 * @package   SiteFunctionality
 */
namespace SiteFunctionality\Taxonomies;

use SiteFunctionality\Abstracts\Taxonomy;
use SiteFunctionality\PostTags\Project;

/**
 * Class Taxonomies
 *
 * @package SiteFunctionality\Taxonomies
 * @since 1.0.0
 */
class ProjectTag extends Taxonomy {

	/**
	 * Taxonomy data
	 */
	public const TAXONOMY = array(
		'id'          => 'project_tag',
		'title'       => 'Project Tags',
		'singular'    => 'Project Tag',
		'menu'        => 'Tags',
		'post_types'  => array( 'project' ),
		'has_archive' => 'projects/tag',
		'archive'     => 'projects/tag',
		'with_front'  => false,
		'rest'        => 'project-tags',
	);

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $version, $plugin_name ) {
		parent::__construct( $version, $plugin_name );

		\add_action( 'init', array( $this, 'rewrite_rules' ), 10, 0 );
	}

	/**
	 * Add rewrite rules
	 *
	 * @link https://developer.wordpress.org/reference/functions/add_rewrite_rule/
	 *
	 * @return void
	 */
	public function rewrite_rules() {}

}
