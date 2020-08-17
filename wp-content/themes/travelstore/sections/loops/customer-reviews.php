<?php
/**
 * This is a section file for the Customer Reviews section loop file.
 *
 * @package travelstore
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$panel_id   = 'travelstore_settings';
$section_id = 'travelstore_customizer_settings_customer_reviews';

$args = array(
	'post_type'   => 'itineraries',
	'post_status' => 'publish',
	'status'      => 'approve', // Only display the approved comments.
);

$reviews = get_comments( $args );

$review_type = travelstore_get_theme_option( $panel_id, $section_id, 'review_type' );

switch ( $review_type ) {
	case '3_and_above':
		$filter = 3;
		break;
	case '4_and_above':
		$filter = 4;
		break;
	case '5_stars_only':
		$filter = 5;
		break;
	default:
		$filter = false;
		break;
}

if ( is_array( $reviews ) && count( $reviews ) > 0 ) {
	foreach ( $reviews as $index => $review ) {
		$review_id      = ! empty( $review->comment_ID ) ? $review->comment_ID : '';
		$review_trip_id = ! empty( $review->comment_post_ID ) ? $review->comment_post_ID : '';
		$review_content = ! empty( $review->comment_content ) ? $review->comment_content : '';
		$review_by      = ! empty( $review->comment_author ) ? $review->comment_author : '';
		$reviewer_email = ! empty( $review->comment_author_email ) ? $review->comment_author_email : '';
		$review_date    = ! empty( $review->comment_date_gmt ) ? $review->comment_date_gmt : '';

		$wp_travel_metas = travelstore_get_itinerary_meta( array( 'trip_id' => $review_trip_id ) );
		$ratings         = ! empty( $wp_travel_metas['general']['ratings'] ) ? $wp_travel_metas['general']['ratings'] : '';
		$ratings_html    = ! empty( $wp_travel_metas['general']['ratings_html'] ) ? $wp_travel_metas['general']['ratings_html'] : '';
		$placeholder     = ! empty( $wp_travel_metas['thumbnails']['placeholder_url'] ) ? $wp_travel_metas['thumbnails']['placeholder_url'] : '';
		$thumbnail       = ! empty( $wp_travel_metas['thumbnails']['url'] ) ? $wp_travel_metas['thumbnails']['url'] : $placeholder;

		if ( $filter && ! ( $ratings >= $filter ) ) {
			continue;
		}
		?>
		<li class="product-review first style-2">
			<div class="sr-review-content">
				<div class="review-container">
					<div>
						<div class="star-rating">
							<?php echo wp_kses_post( $ratings_html ); ?>
						</div>
						<h4 class="trip-title"><?php echo esc_html( get_the_title( $review_trip_id ) ); ?></h4>
						<p><?php echo esc_html( $review_content ); ?></p>
						<a href="<?php echo esc_url( get_the_permalink( $review_trip_id ) ); ?>" class="sr-view-product"><?php echo esc_html__( 'View this trip', 'travelstore' ); ?> → </a>
					</div>
					<div>
						<img width="200" height="200" src="<?php echo esc_url( $thumbnail ); ?>" class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image" alt="<?php echo esc_attr( get_the_title( $review_trip_id ) ); ?>">
					</div>
				</div>
			</div>
			<div class="sr-review-meta">
				<div>
					<?php echo wp_kses_post( get_avatar( $reviewer_email ) ); ?>
				</div>
				<div class="meta-content">
					<strong><?php echo esc_html( $review_by ); ?></strong><br>
					<date><?php echo esc_html( $review_date ); ?></date>
				</div>
			</div>
		</li>

		<?php
	}
}
?>
