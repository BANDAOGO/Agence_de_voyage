<?php
/**
 * Loop file for the itinerary-sections > latest-trips.php
 *
 * @package travelstore
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wp_travel_metas = travelstore_get_itinerary_meta();

// Prices and currency.
$currency_code = ! empty( $wp_travel_metas['prices']['currency_code'] ) ? $wp_travel_metas['prices']['currency_code'] : false;
$enable_sale   = ! empty( $wp_travel_metas['prices']['enable_sale'] ) ? $wp_travel_metas['prices']['enable_sale'] : false;
$regular_price = ! empty( $wp_travel_metas['prices']['regular_price'] ) ? $wp_travel_metas['prices']['regular_price'] : false;
$trip_price    = ! empty( $wp_travel_metas['prices']['trip_price'] ) ? $wp_travel_metas['prices']['trip_price'] : false; // This will give sales price if sale is enabled.

$pax          = ! empty( $wp_travel_metas['general']['pax'] ) ? $wp_travel_metas['general']['pax'] : '';
$ratings_html = ! empty( $wp_travel_metas['general']['ratings_html'] ) ? $wp_travel_metas['general']['ratings_html'] : '';
$placeholder  = ! empty( $wp_travel_metas['thumbnails']['placeholder_url'] ) ? $wp_travel_metas['thumbnails']['placeholder_url'] : '';
$thumbnail    = ! empty( $wp_travel_metas['thumbnails']['url'] ) ? $wp_travel_metas['thumbnails']['url'] : $placeholder;
$thumbnail    = $thumbnail ? $thumbnail : get_the_post_thumbnail_url();

$activities    = ! empty( $wp_travel_metas['trip_terms']['activity'] ) ? $wp_travel_metas['trip_terms']['activity'] : '';
$activity      = ! empty( $activities[0] ) ? $activities[0] : '';
$activity_id   = isset( $activity->term_id ) && ! empty( $activity->term_id ) ? $activity->term_id : '';
$activity_name = isset( $activity->name ) && ! empty( $activity->name ) ? $activity->name : '';
$activity_link = ! empty( $activity_id ) ? get_term_link( $activity_id ) : '';


/**
 * $current_trip_index & $total_trip_posts is set from loop using set_query_var function.
 */
$is_last = ( ( $current_trip_index + 1 ) === $total_trip_posts );

?>
<li id="latest-trip-<?php the_ID(); ?>" class="product <?php echo $is_last ? esc_attr( 'last' ) : ''; ?>">
	<a href="<?php the_permalink(); ?>"
		class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
		<?php if ( $thumbnail ) { ?>
			<img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php the_title(); ?>">
		<?php } ?>
		<?php
		the_title( '<h2 class="woocommerce-loop-product__title">', '</h2>' );

		echo wp_kses_post( $ratings_html );

		if ( 'itineraries' === get_post_type() ) {
			if ( ! empty( $trip_price ) && ! empty( $regular_price ) ) {
				?>
				<span class="price">
					<?php
					echo $enable_sale && $regular_price ? sprintf( '<del><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">%s</span>%s</span></del>', esc_html( $currency_code ), esc_html( $regular_price ) ) : '';
					echo $trip_price ? sprintf( '<span class="woocommerce-Price-amount amount amount-not-available"><span class="woocommerce-Price-currencySymbol">%s</span>%s</span>', esc_html( $currency_code ), esc_html( $trip_price ) ) : '';
					?>
				</span>
				<?php
			} else {
				echo sprintf( '<span class="price"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">%s</span>N/A</span></span>', esc_html( $currency_code ) );
			}
		}
		?>
	</a>
	<?php
	if ( 'itineraries' === get_post_type() ) {
		?>
			<a href="<?php the_permalink(); ?>#booking" class="button product_type_simple"><?php esc_html_e( 'Book Now', 'travelstore' ); ?></a>
		<?php
	} else {
		?>
			<a href="<?php the_permalink(); ?>" class="button product_type_simple"><?php esc_html_e( 'Read More', 'travelstore' ); ?></a>
		<?php
	}
	?>
</li>
<?php
