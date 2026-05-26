<?php
/**
 * Events list shortcode.
 *
 * @package EventsPlugin
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class EP_Shortcode
 */
class EP_Shortcode {

	const TAG = 'events_list';

	/**
	 * Register shortcode.
	 *
	 * @return void
	 */
	public function register() {
		add_shortcode( self::TAG, array( $this, 'render' ) );
	}

	/**
	 * Render [events_list limit="10" order="ASC"].
	 *
	 * @param array|string $atts Shortcode attributes.
	 * @return string
	 */
	public function render( $atts ) {
		$atts = shortcode_atts(
			array(
				'limit' => 10,
				'order' => 'ASC',
			),
			$atts,
			self::TAG
		);

		$limit = absint( $atts['limit'] );
		$order = ( 'DESC' === strtoupper( $atts['order'] ) ) ? 'DESC' : 'ASC';

		$query = new WP_Query(
			array(
				'post_type'      => EP_Post_Type::POST_TYPE,
				'posts_per_page' => $limit > 0 ? $limit : 10,
				'post_status'    => 'publish',
				'meta_key'       => EP_Meta_Box::META_DATE,
				'orderby'        => 'meta_value',
				'order'          => $order,
			)
		);

		return EP_Event_List::render(
			$query,
			__( 'No upcoming events.', 'events-plugin' )
		);
	}
}
