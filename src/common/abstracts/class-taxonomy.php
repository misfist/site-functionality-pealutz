<?php
/**
 * Taxonomy
 *
 * @package   Site_Functionality
 */
namespace Site_Functionality\Common\Abstracts;

use Site_Functionality\Common\Abstracts\Base;

/**
 * Class Taxonomies
 *
 * @package Site_Functionality\Common\Abstracts
 * @since 1.0.0
 */
abstract class Taxonomy extends Base {

	/**
	 * Taxonomy data
	 */
	public static $taxonomy;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 */
	public function init(): void {
		/**
		 * This general class is always being instantiated as requested in the Bootstrap class
		 *
		 * @see Bootstrap::__construct
		 */

		add_action( 'init', array( $this, 'register' ) );
	}

	/**
	 * Register taxonomy
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register() : void {

		$labels = array(
			'name'                       => _x( $this::$taxonomy['title'] ?? $this::$taxonomy['id'], 'Taxonomy General Name', 'site-functionality' ),
			'singular_name'              => _x( $this::$taxonomy['singular'] ?? $this::$taxonomy['title'] ?? $this::$taxonomy['id'], 'Taxonomy Singular Name', 'site-functionality' ),
			'menu_name'                  => __( $this::$taxonomy['menu'] ?? $this::$taxonomy['title'] ?? $this::$taxonomy['id'], 'site-functionality' ),
			'all_items'                  => $this::$taxonomy['all_items'] ?? sprintf( /* translators: %s: post type title */ __( 'All %s', 'site-functionality' ), $this::$taxonomy['title'] ?? $this::$taxonomy['id'] ),
			'parent_item'                => $this::$taxonomy['parent_item'] ?? sprintf( /* translators: %s: post type title */ __( 'Parent %s', 'site-functionality' ), $this::$taxonomy['singular'] ?? $this::$taxonomy['title'] ?? $this::$taxonomy['id'] ),
			'parent_item_colon'          => $this::$taxonomy['parent_item_colon'] ?? sprintf( /* translators: %s: post type title */ __( 'Parent %s:', 'site-functionality' ), $this::$taxonomy['singular'] ?? $this::$taxonomy['title'] ?? $this::$taxonomy['id'] ),
			'new_item_name'              => $this::$taxonomy['new_item_name'] ?? sprintf( /* translators: %s: post type singular title */ __( 'New %s Name', 'site-functionality' ), $this::$taxonomy['singular'] ?? $this::$taxonomy['title'] ?? $this::$taxonomy['id'] ),
			'add_new_item'               => $this::$taxonomy['add_new_item'] ?? sprintf( /* translators: %s: post type singular title */ __( 'Add New %s', 'site-functionality' ), $this::$taxonomy['singular'] ?? $this::$taxonomy['title'] ?? $this::$taxonomy['id'] ),
			'edit_item'                  => $this::$taxonomy['edit_item'] ?? sprintf( /* translators: %s: post type singular title */ __( 'Edit %s', 'site-functionality' ), $this::$taxonomy['singular'] ?? $this::$taxonomy['title'] ?? $this::$taxonomy['id'] ),
			'update_item'                => $this::$taxonomy['update_item'] ?? sprintf( /* translators: %s: post type title */ __( 'Update %s', 'site-functionality' ), $this::$taxonomy['singular'] ?? $this::$taxonomy['title'] ?? $this::$taxonomy['id'] ),
			'view_item'                  => $this::$taxonomy['view_item'] ?? sprintf( /* translators: %s: post type singular title */ __( 'View %s', 'site-functionality' ), $this::$taxonomy['singular'] ?? $this::$taxonomy['title'] ?? $this::$taxonomy['id'] ),
			'search_items'               => $this::$taxonomy['search_items'] ?? sprintf( /* translators: %s: post type title */ __( 'Search %s', 'site-functionality' ), $this::$taxonomy['title'] ?? $this::$taxonomy['id'] ),
			'separate_items_with_commas' => $this::$taxonomy['separate_items_with_commas'] ?? sprintf( /* translators: %s: post type title */ __( 'Separate %s with commas', 'site-functionality' ), strtolower( $this::$taxonomy['title'] ?? $this::$taxonomy['id'] ) ),
			'add_or_remove_items'        => $this::$taxonomy['add_or_remove_items'] ?? sprintf( /* translators: %s: post type title */ __( 'Add or remove %s', 'site-functionality' ), strtolower( $this::$taxonomy['title'] ?? $this::$taxonomy['id'] ) ),
			'popular_items'              => $this::$taxonomy['popular_items'] ?? sprintf( /* translators: %s: post type title */ __( 'Popular %s', 'site-functionality' ), $this::$taxonomy['title'] ?? $this::$taxonomy['id'] ),
			'no_terms'                   => $this::$taxonomy['no_terms'] ?? sprintf( /* translators: %s: post type title */ __( 'No %s', 'site-functionality' ), strtolower( $this::$taxonomy['title'] ?? $this::$taxonomy['id'] ) ),
			'items_list'                 => $this::$taxonomy['items_list'] ?? sprintf( /* translators: %s: post type title */ __( '%s list', 'site-functionality' ), $this::$taxonomy['title'] ?? $this::$taxonomy['id'] ),
			'items_list_navigation'      => $this::$taxonomy['items_list_navigation'] ?? sprintf( /* translators: %s: post type title */ __( '%s list navigation', 'site-functionality' ), $this::$taxonomy['title'] ?? $this::$taxonomy['id'] ),
		);

		$rewrite = array(
			'slug'       => $this::$taxonomy['archive'] ?? $this::$taxonomy['id'],
			'with_front' => $this::$taxonomy['with_front'] ?? true,
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => $this::$taxonomy['hierarchical'] ?? false,
			'public'            => $this::$taxonomy['public'] ?? true,
			'show_ui'           => $this::$taxonomy['show_ui'] ?? true,
			'show_admin_column' => $this::$taxonomy['show_admin_column'] ?? true,
			'show_in_nav_menus' => $this::$taxonomy['show_in_nav_menus'] ?? true,
			'show_tagcloud'     => $this::$taxonomy['show_tagcloud'] ?? true,
			'rewrite'           => $rewrite,
			'show_in_rest'      => $this::$taxonomy['show_in_rest'] ?? true,
			'rest_base'         => $this::$taxonomy['rest'] ?? $this::$taxonomy['id'],
		);
		\register_taxonomy(
			$this::$taxonomy['id'],
			$this::$taxonomy['post_types'],
			\apply_filters( \get_class( $this ) . '\Args', $args )
		);
	}
}
