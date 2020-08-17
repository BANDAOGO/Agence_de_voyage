<?php
/**
 * This is a file provides the section for the frontpage.
 *
 * For inner loops: @see ./itinerary-section-loops/banner-slider.php
 *
 * AKA Category Slider
 *
 * @package travelstore
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$panel_id       = 'travelstore_settings';
$section_id     = 'travelstore_customizer_settings_trips_by_category';
$enable_section = travelstore_get_theme_option( $panel_id, $section_id, 'enable_section' );

if ( ! $enable_section ) {
	return;
}

$section_title = travelstore_get_theme_option( $panel_id, $section_id, 'title' );
$taxonomy_name = travelstore_get_theme_option( $panel_id, $section_id, 'tax_dropdown' );
$number_items  = travelstore_get_theme_option( $panel_id, $section_id, 'number_items' );

$itinerary_terms = get_terms(
	array(
		'taxonomy'   => $taxonomy_name,
		'hide_empty' => true,
	)
);

if ( 'none' === $taxonomy_name ) {

	$itinerary_terms = array();

	$taxonomies = array(
		'category',
		'travel_locations',
		'itinerary_types',
		'activity',
	);

	if ( is_array( $taxonomies ) && count( $taxonomies ) > 0 ) {

		$index = 0;
		foreach ( $taxonomies as $taxonomy_name ) {
			$terms = get_terms(
				array(
					'taxonomy'   => $taxonomy_name,
					'hide_empty' => true,
				)
			);

			if ( is_array( $terms ) && count( $terms ) > 0 ) {
				foreach ( $terms as $itinerary_term ) {
					$term_id   = isset( $itinerary_term->term_id ) && ! empty( $itinerary_term->term_id ) ? $itinerary_term->term_id : '';
					$term_name = isset( $itinerary_term->name ) && ! empty( $itinerary_term->name ) ? $itinerary_term->name : '';
					$count     = isset( $itinerary_term->count ) && ! empty( $itinerary_term->count ) ? $itinerary_term->count : '';

					$itinerary_terms[ $index ] = (object) array(
						'term_id' => $term_id,
						'name'    => $term_name,
						'count'   => $count,
					);

					$index++;
				}
			}
		}
	}
}

?>
<section class="storefront-product-section storefront-product-categories" aria-label="<?php esc_attr_e( 'Product Categories', 'travelstore' ); ?>">

	<?php if ( ! empty( $section_title ) ) { ?>
		<h2 class="section-title"><?php echo esc_html( $section_title ); ?></h2>
	<?php } ?>
	<div class="wp-travel-childtheme-storefront category-slider">
		<div id="trip-slider" class="content-slider trip-slider categories owl-carousel owl-theme">

			<?php
			if ( is_array( $itinerary_terms ) && count( $itinerary_terms ) > 0 ) {
				foreach ( $itinerary_terms as $current_index_key => $itinerary_term ) {

					if ( $current_index_key >= $number_items ) {
						break;
					}

					$term_id   = isset( $itinerary_term->term_id ) && ! empty( $itinerary_term->term_id ) ? $itinerary_term->term_id : '';
					$term_name = isset( $itinerary_term->name ) && ! empty( $itinerary_term->name ) ? $itinerary_term->name : '';
					$count     = isset( $itinerary_term->count ) && ! empty( $itinerary_term->count ) ? $itinerary_term->count : '';
					$term_link = get_term_link( $term_id );

					// Attachments.
					$thumbnail_id  = get_term_meta( $term_id, 'wp_travel_trip_type_image_id', true );
					$thumbnail_url = wp_get_attachment_url( $thumbnail_id );
					$placeholder   = function_exists( 'wp_travel_get_post_placeholder_image_url' ) ? wp_travel_get_post_placeholder_image_url() : '';
					$thumbnail_url = ! empty( $thumbnail_url ) ? $thumbnail_url : $placeholder;
					?>
					<div class="item">
						<div class="category-item">
							<a href="<?php echo esc_url( $term_link ); ?>">
								<?php if ( $thumbnail_url ) { ?>
								<img src="<?php echo esc_url( $thumbnail_url ); ?>" alt="<?php echo esc_attr( $term_name ); ?>">
								<?php } ?>
								<?php echo sprintf( '<h2 class="woocommerce-loop-category__title">%s (%d)</h2>', esc_html( $term_name ), absint( $count ) ); ?>
							</a>
						</div>
					</div>
					<?php
				}
			}
			?>
		</div>
	</div>
</section>
