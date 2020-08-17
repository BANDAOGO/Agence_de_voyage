<?php
/**
 * This is a file provides the section for the frontpage.
 *
 * @package travelstore
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Bail early if WP Travel plugin is not activated or not exists.
 * Also here WP_Travel is a function name, not a class name.
 */
if ( ! function_exists( 'WP_Travel' ) ) {
	return;
}


$panel_id       = 'travelstore_settings';
$section_id     = 'travelstore_customizer_settings_trip_search';
$enable_section = travelstore_get_theme_option( $panel_id, $section_id, 'enable_section' );

if ( ! $enable_section ) {
	return;
}

?>

<section id="itinerary-trip-search-filter" class="storefront-product-section" aria-label="<?php esc_attr_e( 'Trip Search Form', 'travelstore' ); ?>">

	<div class="trip-search">
		<form class="form-wrapper" action="">
			<div class="item item-1">
				<i class="fas fa-map-marker-alt"></i>
				<?php
					$taxonomy_name = 'travel_locations';
					$args          = array(
						'show_option_all'   => __( 'All Location', 'travelstore' ),
						'show_option_none'  => __( 'All Location', 'travelstore' ),
						'option_none_value' => __( 'All Location', 'travelstore' ),
						'hide_empty'        => 0,
						'selected'          => 1,
						'hierarchical'      => 1,
						'name'              => $taxonomy_name,
						'class'             => 'wp-travel-taxonomy',
						'taxonomy'          => $taxonomy_name,
						'value_field'       => 'slug',
					);
					wp_dropdown_categories( $args, $taxonomy_name );
					?>
			</div>
			<div class="item item-2">
				<?php
					$taxonomy_name = 'itinerary_types';
					$args          = array(
						'show_option_all'   => __( 'Trip Types', 'travelstore' ),
						'show_option_none'  => __( 'Trip Types', 'travelstore' ),
						'option_none_value' => __( 'Trip Types', 'travelstore' ),
						'hide_empty'        => 1,
						'selected'          => 1,
						'hierarchical'      => 1,
						'name'              => $taxonomy_name,
						'class'             => 'wp-travel-taxonomy',
						'taxonomy'          => $taxonomy_name,
						'value_field'       => 'slug',
					);
					wp_dropdown_categories( $args, $taxonomy_name );
					?>
			</div>
			<div class="item item-3">
				<input type="text" name="s" placeholder="<?php esc_attr_e( 'Keyword', 'travelstore' ); ?>" id="search">
			</div>
			<div class="item item-4">
				<button type="submit" class="button product_type_simple"><?php esc_attr_e( 'Search', 'travelstore' ); ?></button>
			</div>
		</form>
	</div>
</section>
