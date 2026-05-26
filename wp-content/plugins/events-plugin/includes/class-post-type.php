<?php
/**
 * Events custom post type.
 *
 * @package EventsPlugin
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class EP_Post_Type
 */
class EP_Post_Type {

	const POST_TYPE = 'ep_event';

	/**
	 * Register CPT on init.
	 *
	 * @return void
	 */
	public function register() {
		$labels = array(
			'name'               => _x( 'Events', 'post type general name', 'events-plugin' ),
			'singular_name'      => _x( 'Event', 'post type singular name', 'events-plugin' ),
			'menu_name'          => _x( 'Events', 'admin menu', 'events-plugin' ),
			'add_new'            => _x( 'Add New', 'event', 'events-plugin' ),
			'add_new_item'       => __( 'Add New Event', 'events-plugin' ),
			'edit_item'          => __( 'Edit Event', 'events-plugin' ),
			'new_item'           => __( 'New Event', 'events-plugin' ),
			'view_item'          => __( 'View Event', 'events-plugin' ),
			'search_items'       => __( 'Search Events', 'events-plugin' ),
			'not_found'          => __( 'No events found.', 'events-plugin' ),
			'not_found_in_trash' => __( 'No events found in Trash.', 'events-plugin' ),
		);

		$args = array(
			'labels'          => $labels,
			'public'          => true,
			'show_ui'         => true,
			'show_in_menu'    => true,
			'menu_icon'       => 'dashicons-calendar-alt',
			'supports'        => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'has_archive'     => true,
			'rewrite'         => array( 'slug' => 'events' ),
			'show_in_rest'    => true,
			'capability_type' => 'post',
			'map_meta_cap'    => true,
		);

		register_post_type( self::POST_TYPE, $args );
	}
}
