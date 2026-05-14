<?php
/**
 * The file that defines the core plugin class
 *
 * @link       https://github.com/misfist/site-functionality
 * @since      1.0.0
 * @package    site-functionality
 */

namespace Site_Functionality;

use Site_Functionality\App\Post_Types\Post_Types;
use Site_Functionality\App\Taxonomies\Taxonomies;
use Site_Functionality\App\Blocks\Blocks;
use Site_Functionality\Modules\Modules;

/**
 * Hooks the plugin's classes to WordPress's actions and filters.
 */
class Site_Functionality {

	/**
	 * Define the core functionality of the plugin.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->load_dependencies();
	}

	/**
	 * Load dependent classes.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	protected function load_dependencies(): void {
		new Post_Types();
		new Taxonomies();
		new Blocks();
		new Modules();
	}

}
