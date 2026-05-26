<?php
/**
 * Renders event query results as HTML list.
 *
 * @package EventsPlugin
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class EP_Event_List
 */
class EP_Event_List {

	/**
	 * Render events from a WP_Query.
	 *
	 * @param WP_Query $query         Query with posts.
	 * @param string   $empty_message Message when no posts found.
	 * @return string
	 */
	public static function render( $query, $empty_message = '' ) {
		if ( ! $query->have_posts() ) {
			if ( '' === $empty_message ) {
				$empty_message = __( 'No events found.', 'events-plugin' );
			}

			return '<p class="ep-events-empty">' . esc_html( $empty_message ) . '</p>';
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
