<?php
/**
 * Content Taxonomies
 *
 * @since   1.0.0
 * @package Site_Functionality
 */
namespace Site_Functionality\App\Taxonomies;

use Site_Functionality\Common\Abstracts\Base;
use Site_Functionality\App\Taxonomies\Project_Type;
use Site_Functionality\App\Taxonomies\Project_Tag;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Taxonomies extends Base {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Init
	 *
	 * @return void
	 */
	public function init(): void {
		new Project_Type();
		new Project_Tag();
	}

}
