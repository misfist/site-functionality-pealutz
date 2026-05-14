<?php
/**
 * Modules
 *
 * @since   1.0.1
 * @package Site_Functionality
 */

namespace Site_Functionality\Modules;

use Site_Functionality\Common\Abstracts\Base;
use Site_Functionality\Modules\Remote_Media;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Loads all plugin modules.
 *
 * @since 1.0.1
 */
class Modules extends Base {

	/**
	 * Instantiate all modules.
	 *
	 * @since  1.0.1
	 * @return void
	 */
	public function init(): void {
		new Remote_Media();
	}

}
