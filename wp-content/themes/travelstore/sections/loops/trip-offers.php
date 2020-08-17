<?php
/**
 * Loop file for the itinerary-sections > trip-offers.php
 *
 * @package travelstore
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section_id  = 'travelstore_customizer_settings_trip_offers';
$offer_trips = travelstore_get_itinerary_offer_trips( $section_id );
$trip_count  = is_array( $offer_trips ) ? count( $offer_trips ) : 0;

if ( $trip_count > 0 ) {
	foreach ( $offer_trips as $index => $offer_trip_id ) {

		$meta_args = array(
			'trip_id' => $offer_trip_id,
		);

		$wp_travel_metas = travelstore_get_itinerary_meta( $meta_args );

		$trip_title = ! empty( $wp_travel_metas['general']['title'] ) ? $wp_travel_metas['general']['title'] : false;

		// Prices and currency.
		$currency_code = ! empty( $wp_travel_metas['prices']['currency_code'] ) ? $wp_travel_metas['prices']['currency_code'] : false;
		$enable_sale   = ! empty( $wp_travel_metas['prices']['enable_sale'] ) ? $wp_travel_metas['prices']['enable_sale'] : false;
		$regular_price = ! empty( $wp_travel_metas['prices']['regular_price'] ) ? $wp_travel_metas['prices']['regular_price'] : false;
		$trip_price    = ! empty( $wp_travel_metas['prices']['trip_price'] ) ? $wp_travel_metas['prices']['trip_price'] : false; // This will give sales price if sale is enabled.

		$pax          = ! empty( $wp_travel_metas['general']['pax'] ) ? $wp_travel_metas['general']['pax'] : '';
		$ratings_html = ! empty( $wp_travel_metas['general']['ratings_html'] ) ? $wp_travel_metas['general']['ratings_html'] : '';
		$placeholder  = ! empty( $wp_travel_metas['thumbnails']['placeholder_url'] ) ? $wp_travel_metas['thumbnails']['placeholder_url'] : '';
		$thumbnail    = ! empty( $wp_travel_metas['thumbnails']['url'] ) ? $wp_travel_metas['thumbnails']['url'] : $placeholder;

		$activities    = ! empty( $wp_travel_metas['trip_terms']['activity'] ) ? $wp_travel_metas['trip_terms']['activity'] : '';
		$activity      = ! empty( $activities[0] ) ? $activities[0] : '';
		$activity_id   = isset( $activity->term_id ) && ! empty( $activity->term_id ) ? $activity->term_id : '';
		$activity_name = isset( $activity->name ) && ! empty( $activity->name ) ? $activity->name : '';
		$activity_link = ! empty( $activity_id ) ? get_term_link( $activity_id ) : '';

		$is_last = ( ( $index + 1 ) === $trip_count );

		?>
		<li id="latest-trip-<?php echo esc_attr( $offer_trip_id ); ?>" class="product <?php echo $is_last ? esc_attr( 'last' ) : ''; ?>">
			<a href="<?php the_permalink( $offer_trip_id ); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
				<img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php echo esc_attr( $trip_title ); ?>">
				<?php
				if ( $trip_title ) {
					?>
					<h2 class="woocommerce-loop-product__title"><?php echo esc_html( $trip_title ); ?></h2>
					<?php
				}
				echo '<span class="onsale">' . esc_html__( 'Sale!', 'travelstore' ) . '</span>';
				echo wp_kses_post( $ratings_html );

				if ( ! empty( $trip_price ) && ! empty( $regular_price ) ) {
					?>
					<span class="price">
						<?php
						echo $enable_sale && $regular_price ? sprintf( '<del><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">%s</span>%s</span></del>', esc_html( $currency_code ), esc_html( $regular_price ) ) : '';
						echo $trip_price ? sprintf( '<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">%s</span>%s</span>', esc_html( $currency_code ), esc_html( $trip_price ) ) : '';
						?>
					</span>
					<?php
				}
				?>
			</a>
			<a href="<?php echo esc_url( get_the_permalink( $offer_trip_id ) ); ?>#booking" class="button product_type_simple"><?php esc_html_e( 'Book Now', 'travelstore' ); ?></a>
		</li>
		<?php

	}
}
