<?php
/**
 * This file has important functions to help the smooth work flow.
 *
 * @package travelstore
 * @subpackage /inc
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'travelstore_get_itinerary_meta' ) ) {

	/**
	 * Returns the array of wp travel trips meta informations.
	 *
	 * @param array $args Arguments for wp travel meta datas. It accepts the following values:
	 *                    * trip_id        => WP Travel Trip ID, default is get_the_ID().
	 *                    * min_price_sale => If set to 0, it will return sale price for any pricing option.
	 *                    * retrive        => Type of meta that you want to receive, default is all.
	 *                                        > **Other accepted values are:**
	 *                                         > * all ( default ),
	 *                                         > * general,
	 *                                         > * prices,
	 *                                         > * date_and_time,
	 *                                         > * trip_terms,
	 *                                         > * thumbnails,
	 *                    * featured_trips => If passed true, then function will returns
	 *                                        the meta info for featured trips only.
	 *                                        Default is false.
	 *
	 * @return array $wp_travel_meta Array of WP Travel meta data.
	 */
	function travelstore_get_itinerary_meta( $args = array() ) {

		$wp_travel_meta = array();

		/**
		 * Bail early if WP Travel plugin is not activated or not exists.
		 * Also here WP_Travel is a function name, not a class name.
		 */
		if ( ! function_exists( 'WP_Travel' ) ) {
			return $wp_travel_meta;
		}

		if ( ! class_exists( 'Travelstore_WP_Travel_Metas' ) ) {
			require_once TRAVELSTORE_CHILD_DIR . '/inc/classes/class-travelstore-wp-travel-metas.php';
		}

		$default = array(
			'trip_id'        => get_the_ID(),
			'min_price_sale' => 1,
			'retrive'        => 'all',
			'featured_trips' => false,
		);
		$args    = wp_parse_args( $args, $default );

		$trip_id        = ! empty( $args['trip_id'] ) ? $args['trip_id'] : false;
		$min_price_sale = $args['min_price_sale'];
		$retrive        = ! empty( $args['retrive'] ) ? $args['retrive'] : 'all';
		$featured_trips = ! empty( $args['featured_trips'] ) ? $args['featured_trips'] : false;

		// Bail early if trip id is empty.
		if ( empty( $trip_id ) ) {
			return $wp_travel_meta;
		}

		// Bail early if provided post id is not WP Travel Itinerary post.
		if ( 'itineraries' !== get_post_type( $trip_id ) ) {
			return $wp_travel_meta;
		}

		$meta_object   = new Travelstore_WP_Travel_Metas( $trip_id );
		$general       = $meta_object->general();
		$prices        = $meta_object->prices( $min_price_sale );
		$date_and_time = $meta_object->date_and_time();
		$trip_terms    = $meta_object->trip_terms();
		$thumbnails    = $meta_object->thumbnails();

		/**
		 * Create the meta array.
		 */
		$itinerary_meta = array(
			'general'       => $general,
			'prices'        => $prices,
			'date_and_time' => $date_and_time,
			'trip_terms'    => $trip_terms,
			'thumbnails'    => $thumbnails,
		);
		$wp_travel_meta = $itinerary_meta;

		/**
		 * If $args['featured_trips'] is passed true then
		 * reset the array and list only featured trips.
		 */
		if ( $featured_trips && 'yes' === $itinerary_meta['general']['is_featured'] ) {
			$wp_travel_meta = array();
			$wp_travel_meta = $itinerary_meta;
		}

		if ( 'all' === $retrive ) {
			return $wp_travel_meta;
		}

		return ! empty( $wp_travel_meta[ $retrive ] ) ? $wp_travel_meta[ $retrive ] : array();
	}
}


if ( ! function_exists( 'travelstore_get_itinerary_offer_trips' ) ) {

	/**
	 * Returns the array of sales enabled trips.
	 */
	function travelstore_get_itinerary_offer_trips( $section_id, $panel_id = 'travelstore_settings' ) {

		$trips       = array();
		$trip_offers = array();

		/**
		 * Bail early if WP Travel plugin is not activated or not exists.
		 * Also here WP_Travel is a function name, not a class name.
		 */
		if ( ! function_exists( 'WP_Travel' ) ) {
			return $trip_offers;
		}

		$numberposts   = travelstore_get_theme_option( $panel_id, $section_id, 'numberposts' );
		$taxonomy_name = travelstore_get_theme_option( $panel_id, $section_id, 'tax_dropdown' );

		$args = array(
			'post_type'      => 'itineraries',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
		);

		if ( 'none' !== $taxonomy_name ) {
			$itinerary_term[]  = travelstore_get_theme_option( $panel_id, $section_id, "{$taxonomy_name}_term" );
			$args['tax_query'] = array( // phpcs:ignore
				array(
					'taxonomy' => $taxonomy_name,
					'terms'    => $itinerary_term,
					'field'    => 'slug',
				),
			);
		}

		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$wp_travel_metas = travelstore_get_itinerary_meta( array( 'min_price_sale' => 0 ) );
				$enable_sale     = ! empty( $wp_travel_metas['prices']['enable_sale'] ) ? $wp_travel_metas['prices']['enable_sale'] : false;

				/**
				 * Filter the sale enabled trips.
				 */
				if ( $enable_sale ) {
					array_push( $trip_offers, get_the_ID() );
				}
			}
		}
		wp_reset_postdata();

		/**
		 * Re-create the array on the basis of number of posts set by user.
		 */
		if ( count( $trip_offers ) > 0 ) {

			/**
			 * If user tries to set $numberposts more than the available trips, reset it to $trip_offers
			 */
			if ( $numberposts > count( $trip_offers ) ) {
				$numberposts = count( $trip_offers );
			}
			for ( $index = 0; $index < $numberposts; $index++ ) {
				$trips[ $index ] = ! empty( $trip_offers[ $index ] ) ? $trip_offers[ $index ] : 0;
			}
		}

		return $trips;
	}
}
