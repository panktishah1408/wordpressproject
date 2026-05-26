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

		if ( ! $query->have_posts() ) {
			return '<p class="ep-events-empty">' . esc_html__( 'No upcoming events.', 'events-plugin' ) . '</p>';
		}

		ob_start();
		echo '<ul class="ep-events-list">';

		while ( $query->have_posts() ) {
			$query->the_post();

			$post_id  = get_the_ID();
			$date     = get_post_meta( $post_id, EP_Meta_Box::META_DATE, true );
			$location = get_post_meta( $post_id, EP_Meta_Box::META_LOCATION, true );
			?>
			<li class="ep-event-item">
				<h3 class="ep-event-title">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h3>
				<?php if ( $date ) : ?>
					<p class="ep-event-date">
						<strong><?php esc_html_e( 'Date:', 'events-plugin' ); ?></strong>
						<?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $date ) ) ); ?>
					</p>
				<?php endif; ?>
				<?php if ( $location ) : ?>
					<p class="ep-event-location">
						<strong><?php esc_html_e( 'Location:', 'events-plugin' ); ?></strong>
						<?php echo esc_html( $location ); ?>
					</p>
				<?php endif; ?>
				<div class="ep-event-excerpt"><?php the_excerpt(); ?></div>
			</li>
			<?php
		}

		echo '</ul>';
		wp_reset_postdata();

		return ob_get_clean();
	}
}
