<?php
/**
 * This files handles the hooks for the wp travel related sections
 * at frontpage or where necessary.
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

if ( ! function_exists( 'travelstore_load_itinerary_sections_fullwidth' ) ) {

	/**
	 * Loads the sections that needs be displayed as fullwidth in homepage.
	 *
	 * @see storefront > header.php
	 */
	function travelstore_load_itinerary_sections_fullwidth() {

		/**
		 * Bail if it is not homepage/frontpage template.
		 */
		if ( ! is_page_template( 'template-homepage.php' ) ) {
			return;
		}

		/**
		 * List your fullwidth section file names here.
		 */
		$sections = array(
			'banner-slider',
		);

		foreach ( $sections as $section ) {
			get_template_part( "sections/{$section}" );
		}

		/**
		 * Hide or display static content at frontpage.
		 */
		$enable_section = get_theme_mod( 'travelstore_display_static_content' );
		if ( ! $enable_section ) {
			remove_action( 'homepage', 'storefront_homepage_content' );
		}

	}
	add_action( 'storefront_before_content', 'travelstore_load_itinerary_sections_fullwidth' );
}

if ( ! function_exists( 'travelstore_load_itinerary_sections_content' ) ) {

	/**
	 * Hooks or loads the itinerary sections that needs be displayed as content in homepage.
	 *
	 * @see storefront > template-homepage.php
	 */
	function travelstore_load_itinerary_sections_content() {

		/**
		 * List your content section file names here.
		 */
		$sections = array(
			'trip-search',
			'trip-categories',
			'latest-trips',
			'featured-trips',
			'trip-offers',
			'customer-reviews',
		);

		foreach ( $sections as $section ) {
			get_template_part( "sections/{$section}" );
		}
	}
	add_action( 'homepage', 'travelstore_load_itinerary_sections_content', 10 );
}
