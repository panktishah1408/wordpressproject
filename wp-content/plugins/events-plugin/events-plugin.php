<?php
/**
 * Plugin Name:       Events Plugin
 * Description:       Manage events with date and location; display via shortcode.
 * Version:           1.0.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            Your Name
 * License:           GPL-2.0-or-later
 * Text Domain:       events-plugin
 *
 * @package EventsPlugin
 */

defined( 'ABSPATH' ) || exit;

define( 'EP_VERSION', '1.0.0' );
define( 'EP_PLUGIN_FILE', __FILE__ );
define( 'EP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'EP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once EP_PLUGIN_DIR . 'includes/class-plugin.php';

/**
 * Returns the main plugin instance.
 *
 * @return EP_Plugin
 */
function ep_plugin() {
	return EP_Plugin::instance();
}

register_activation_hook( __FILE__, 'ep_activate_plugin' );

/**
 * Flush rewrite rules on activation.
 *
 * @return void
 */
function ep_activate_plugin() {
	ep_plugin()->register_post_type_for_activation();
	flush_rewrite_rules();
}

register_deactivation_hook( __FILE__, 'ep_deactivate_plugin' );

/**
 * Flush rewrite rules on deactivation.
 *
 * @return void
 */
function ep_deactivate_plugin() {
	flush_rewrite_rules();
}

ep_plugin();
