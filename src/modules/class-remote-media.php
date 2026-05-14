<?php
/**
 * Remote Media
 *
 * Serves media uploads from a remote URL on local environments,
 * avoiding the need to sync the uploads directory.
 *
 * @since   1.0.1
 * @package Site_Functionality
 */

namespace Site_Functionality\Modules;

use Site_Functionality\Common\Abstracts\Base;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Serves media from a remote URL on local environments and provides
 * an admin settings page to configure the remote URL.
 *
 * @since 1.0.1
 */
class Remote_Media extends Base {

	/**
	 * Saved options.
	 *
	 * @since 1.0.1
	 * @var   array
	 */
	public array $options = array();

	/**
	 * Option group and option name.
	 *
	 * @since 1.0.1
	 * @var   string
	 */
	public const OPTION_NAME = 'site_settings';

	/**
	 * Admin menu slug.
	 *
	 * @since 1.0.1
	 * @var   string
	 */
	public const MENU_SLUG = 'site-settings';

	/**
	 * Option key for the remote media URL.
	 *
	 * @since 1.0.1
	 * @var   string
	 */
	protected string $remote_media_option = 'remote_media_url';

	/**
	 * Default remote media URL.
	 *
	 * @since 1.0.1
	 * @var   string
	 */
	protected string $remote_media_url = '';

	/**
	 * Required capability to manage settings.
	 *
	 * @since 1.0.1
	 * @var   string
	 */
	protected string $capabilities = 'manage_options';

	/**
	 * Register hooks and load saved options.
	 *
	 * @since  1.0.1
	 * @return void
	 */
	public function init(): void {
		$this->options = (array) get_option( self::OPTION_NAME, array() );

		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'init_settings' ) );

		if ( 'local' === wp_get_environment_type() ) {
			add_filter( 'upload_dir', array( $this, 'serve_remote_media' ) );
		}
	}

	/**
	 * Register the options page under Settings.
	 *
	 * @since  1.0.1
	 * @return void
	 */
	public function add_admin_menu(): void {
		add_options_page(
			esc_html__( 'Site Settings', 'site-functionality' ),
			esc_html__( 'Site Settings', 'site-functionality' ),
			$this->capabilities,
			self::MENU_SLUG,
			array( $this, 'render_page' ),
			1
		);
	}

	/**
	 * Register settings, section, and field.
	 *
	 * @since  1.0.1
	 * @return void
	 */
	public function init_settings(): void {
		register_setting( self::OPTION_NAME, self::OPTION_NAME );

		add_settings_section(
			self::OPTION_NAME . '_section',
			'',
			false,
			self::MENU_SLUG
		);

		add_settings_field(
			'remote_media_url',
			__( 'Serve Media from Remote URL', 'site-functionality' ),
			array( $this, 'render_remote_media_url' ),
			self::MENU_SLUG,
			self::OPTION_NAME . '_section'
		);
	}

	/**
	 * Render the settings page.
	 *
	 * @since  1.0.1
	 * @return void
	 */
	public function render_page(): void {
		if ( ! current_user_can( $this->capabilities ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'site-functionality' ) );
		}
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<form action="options.php" method="post">
				<?php
				settings_fields( self::OPTION_NAME );
				do_settings_sections( self::MENU_SLUG );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Render the remote media URL input field.
	 *
	 * @since  1.0.1
	 * @return void
	 */
	public function render_remote_media_url(): void {
		$value = $this->options[ $this->remote_media_option ] ?? $this->remote_media_url;
		?>
		<input
			type="text"
			id="<?php echo esc_attr( $this->remote_media_option ); ?>"
			name="<?php echo esc_attr( self::OPTION_NAME . '[' . $this->remote_media_option . ']' ); ?>"
			value="<?php echo esc_attr( $value ); ?>"
			class="regular-text"
		/>
		<?php
	}

	/**
	 * Rewrite upload URLs to point to the remote site on local environments.
	 *
	 * @since  1.0.1
	 * @param  array $dirs Upload directory data.
	 * @return array
	 */
	public function serve_remote_media( array $dirs ): array {
		$remote = $this->options[ $this->remote_media_option ] ?? '';

		if ( ! $remote ) {
			return $dirs;
		}

		$remote          = untrailingslashit( $remote );
		$local           = untrailingslashit( get_option( 'siteurl' ) );
		$dirs['baseurl'] = str_replace( $local, $remote, $dirs['baseurl'] );
		$dirs['url']     = str_replace( $local, $remote, $dirs['url'] );

		return $dirs;
	}

}
