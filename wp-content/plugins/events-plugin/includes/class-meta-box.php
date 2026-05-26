<?php
/**
 * Event meta box (date, location).
 *
 * @package EventsPlugin
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class EP_Meta_Box
 */
class EP_Meta_Box {

	const META_DATE     = '_ep_event_date';
	const META_LOCATION = '_ep_event_location';
	const NONCE_ACTION  = 'ep_save_event_meta';
	const NONCE_NAME    = 'ep_event_meta_nonce';

	/**
	 * Register meta box for Events.
	 *
	 * @return void
	 */
	public function register() {
		add_meta_box(
			'ep_event_details',
			__( 'Event Details', 'events-plugin' ),
			array( $this, 'render' ),
			EP_Post_Type::POST_TYPE,
			'normal',
			'high'
		);
	}

	/**
	 * Render meta box fields.
	 *
	 * @param WP_Post $post Current post.
	 * @return void
	 */
	public function render( $post ) {
		wp_nonce_field( self::NONCE_ACTION, self::NONCE_NAME );

		$date     = get_post_meta( $post->ID, self::META_DATE, true );
		$location = get_post_meta( $post->ID, self::META_LOCATION, true );
		?>
		<p>
			<label for="ep_event_date"><strong><?php esc_html_e( 'Event Date', 'events-plugin' ); ?></strong></label><br />
			<input
				type="date"
				id="ep_event_date"
				name="ep_event_date"
				value="<?php echo esc_attr( $date ); ?>"
				class="widefat"
			/>
		</p>
		<p>
			<label for="ep_event_location"><strong><?php esc_html_e( 'Location', 'events-plugin' ); ?></strong></label><br />
			<input
				type="text"
				id="ep_event_location"
				name="ep_event_location"
				value="<?php echo esc_attr( $location ); ?>"
				class="widefat"
				placeholder="<?php esc_attr_e( 'e.g. Community Hall, Austin TX', 'events-plugin' ); ?>"
			/>
		</p>
		<?php
	}

	/**
	 * Save meta on post save.
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post    Post object.
	 * @return void
	 */
	public function save( $post_id, $post ) {
		unset( $post );

		if ( ! isset( $_POST[ self::NONCE_NAME ] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ self::NONCE_NAME ] ) ), self::NONCE_ACTION ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( isset( $_POST['ep_event_date'] ) ) {
			$date = sanitize_text_field( wp_unslash( $_POST['ep_event_date'] ) );

			if ( '' !== $date && ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $date ) ) {
				$date = '';
			}

			update_post_meta( $post_id, self::META_DATE, $date );
		}

		if ( isset( $_POST['ep_event_location'] ) ) {
			$location = sanitize_text_field( wp_unslash( $_POST['ep_event_location'] ) );
			update_post_meta( $post_id, self::META_LOCATION, $location );
		}
	}
}
