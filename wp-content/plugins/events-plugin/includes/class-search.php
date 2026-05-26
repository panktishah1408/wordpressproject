<?php
/**
 * Events search shortcode.
 *
 * @package EventsPlugin
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class EP_Search
 */
class EP_Search {

	const TAG = 'events_search';

	const PARAM_SEARCH   = 'ep_search';
	const PARAM_KEYWORD  = 'ep_q';
	const PARAM_LOCATION = 'ep_location';
	const PARAM_DATE     = 'ep_date';

	/**
	 * Register shortcode.
	 *
	 * @return void
	 */
	public function register() {
		add_shortcode( self::TAG, array( $this, 'render' ) );
	}

	/**
	 * Render [events_search].
	 *
	 * @return string
	 */
	public function render() {
		$keyword  = '';
		$location = '';
		$date     = '';

		if ( isset( $_GET[ self::PARAM_KEYWORD ] ) ) {
			$keyword = sanitize_text_field( wp_unslash( $_GET[ self::PARAM_KEYWORD ] ) );
		}

		if ( isset( $_GET[ self::PARAM_LOCATION ] ) ) {
			$location = sanitize_text_field( wp_unslash( $_GET[ self::PARAM_LOCATION ] ) );
		}

		if ( isset( $_GET[ self::PARAM_DATE ] ) ) {
			$date = sanitize_text_field( wp_unslash( $_GET[ self::PARAM_DATE ] ) );

			if ( '' !== $date && ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $date ) ) {
				$date = '';
			}
		}

		$is_search = isset( $_GET[ self::PARAM_SEARCH ] );

		ob_start();

		$this->render_form( $keyword, $location, $date );

		if ( $is_search ) {
			echo '<div class="ep-events-search-results">';
			echo $this->run_search( $keyword, $location, $date ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in EP_Event_List::render().
			echo '</div>';
		} else {
			echo '<p class="ep-events-search-hint">' . esc_html__( 'Use the form above to search events.', 'events-plugin' ) . '</p>';
		}

		return ob_get_clean();
	}

	/**
	 * Output search form.
	 *
	 * @param string $keyword  Current keyword.
	 * @param string $location Current location.
	 * @param string $date     Current date.
	 * @return void
	 */
	private function render_form( $keyword, $location, $date ) {
		?>
		<form method="get" class="ep-events-search-form" action="">
			<input type="hidden" name="<?php echo esc_attr( self::PARAM_SEARCH ); ?>" value="1" />

			<p class="ep-events-search-field">
				<label for="ep_q"><?php esc_html_e( 'Search', 'events-plugin' ); ?></label>
				<input
					type="search"
					id="ep_q"
					name="<?php echo esc_attr( self::PARAM_KEYWORD ); ?>"
					value="<?php echo esc_attr( $keyword ); ?>"
					placeholder="<?php esc_attr_e( 'Event name or description…', 'events-plugin' ); ?>"
					class="widefat"
				/>
			</p>

			<p class="ep-events-search-field">
				<label for="ep_location"><?php esc_html_e( 'Location', 'events-plugin' ); ?></label>
				<input
					type="text"
					id="ep_location"
					name="<?php echo esc_attr( self::PARAM_LOCATION ); ?>"
					value="<?php echo esc_attr( $location ); ?>"
					placeholder="<?php esc_attr_e( 'City or venue…', 'events-plugin' ); ?>"
					class="widefat"
				/>
			</p>

			<p class="ep-events-search-field">
				<label for="ep_date"><?php esc_html_e( 'On or after date', 'events-plugin' ); ?></label>
				<input
					type="date"
					id="ep_date"
					name="<?php echo esc_attr( self::PARAM_DATE ); ?>"
					value="<?php echo esc_attr( $date ); ?>"
					class="widefat"
				/>
			</p>

			<p class="ep-events-search-actions">
				<button type="submit" class="button"><?php esc_html_e( 'Search Events', 'events-plugin' ); ?></button>
				<?php if ( isset( $_GET[ self::PARAM_SEARCH ] ) ) : ?>
					<a class="ep-events-search-clear" href="<?php echo esc_url( get_permalink() ); ?>">
						<?php esc_html_e( 'Clear', 'events-plugin' ); ?>
					</a>
				<?php endif; ?>
			</p>
		</form>
		<?php
	}

	/**
	 * Run search query and return list HTML.
	 *
	 * @param string $keyword  Search keyword.
	 * @param string $location Location filter.
	 * @param string $date     Minimum date (Y-m-d).
	 * @return string
	 */
	private function run_search( $keyword, $location, $date ) {
		$args = array(
			'post_type'      => EP_Post_Type::POST_TYPE,
			'post_status'    => 'publish',
			'posts_per_page' => 20,
			'meta_key'       => EP_Meta_Box::META_DATE,
			'orderby'        => 'meta_value',
			'order'          => 'ASC',
		);

		if ( '' !== $keyword ) {
			$args['s'] = $keyword;
		}

		$meta_query = array();

		if ( '' !== $location ) {
			$meta_query[] = array(
				'key'     => EP_Meta_Box::META_LOCATION,
				'value'   => $location,
				'compare' => 'LIKE',
			);
		}

		if ( '' !== $date ) {
			$meta_query[] = array(
				'key'     => EP_Meta_Box::META_DATE,
				'value'   => $date,
				'compare' => '>=',
				'type'    => 'DATE',
			);
		}

		if ( ! empty( $meta_query ) ) {
			$args['meta_query'] = $meta_query;
		}

		$query = new WP_Query( $args );

		return EP_Event_List::render(
			$query,
			__( 'No events match your search.', 'events-plugin' )
		);
	}
}
