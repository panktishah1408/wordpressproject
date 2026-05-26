<?php
/**
 * Main plugin loader.
 *
 * @package EventsPlugin
 */

defined( 'ABSPATH' ) || exit;

require_once EP_PLUGIN_DIR . 'includes/class-post-type.php';
require_once EP_PLUGIN_DIR . 'includes/class-meta-box.php';
require_once EP_PLUGIN_DIR . 'includes/class-event-list.php';
require_once EP_PLUGIN_DIR . 'includes/class-shortcode.php';
require_once EP_PLUGIN_DIR . 'includes/class-search.php';

/**
 * Class EP_Plugin
 */
final class EP_Plugin {

	/**
	 * Singleton instance.
	 *
	 * @var EP_Plugin|null
	 */
	private static $instance = null;

	/**
	 * Post type handler.
	 *
	 * @var EP_Post_Type
	 */
	private $post_type;

	/**
	 * Meta box handler.
	 *
	 * @var EP_Meta_Box
	 */
	private $meta_box;

	/**
	 * Shortcode handler.
	 *
	 * @var EP_Shortcode
	 */
	private $shortcode;

	/**
	 * Search shortcode handler.
	 *
	 * @var EP_Search
	 */ƒ
	private $search;

	/**
	 * Get singleton instance.
	 *
	 * @return EP_Plugin
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	private function __construct() {
		$this->post_type = new EP_Post_Type();
		$this->meta_box  = new EP_Meta_Box();
		$this->shortcode = new EP_Shortcode();
		$this->search    = new EP_Search();

		add_action( 'init', array( $this->post_type, 'register' ) );
		add_action( 'add_meta_boxes', array( $this->meta_box, 'register' ) );
		add_action( 'save_post_' . EP_Post_Type::POST_TYPE, array( $this->meta_box, 'save' ), 10, 2 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_assets' ) );

		$this->shortcode->register();
		$this->search->register();
	}

	/**
	 * Register post type during activation (before init).
	 *
	 * @return void
	 */
	public function register_post_type_for_activation() {
		$this->post_type->register();
	}

	/**
	 * Enqueue frontend CSS on singular posts and pages.
	 *
	 * @return void
	 */
	public function enqueue_frontend_assets() {
		if ( ! is_singular() ) {
			return;
		}

		wp_enqueue_style(
			'ep-events',
			EP_PLUGIN_URL . 'assets/css/events.css',
			array(),
			EP_VERSION
		);
	}
}
