<?php
/**
 * This is the main file for the travelstore customizer.
 *
 * @package travelstore
 * @subpackage inc/customizer
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'travelstore_create_customizer_panel' ) ) {

	/**
	 * Creates the required panels in theme customizer options.
	 *
	 * @param object $wp_customize WordPress customizer objects.
	 */
	function travelstore_create_customizer_panel( $wp_customize ) {
		$wp_customize->add_panel(
			'travelstore_settings',
			array(
				'title'    => esc_html__( 'Travelstore Settings', 'travelstore' ),
				'priority' => 130,
			)
		);
	}
	add_action( 'customize_register', 'travelstore_create_customizer_panel' );
}


if ( ! function_exists( 'travelstore_customizer_includes' ) ) {

	/**
	 * It loads all the files related to customizer.
	 * Hooked in init to fix the custom taxonomy issues of wp travel.
	 */
	function travelstore_customizer_includes() {

		$child_theme_dir  = TRAVELSTORE_CHILD_DIR;
		$customizer_files = array(
			'custom-controls/misc/class-travelstore-customizer-heading-control',
			'custom-controls/slim-select/class-travelstore-customizer-slim-select-control',
			'helpers',
			'sanitization-functions',
			'core-options',
			'travelstore-settings/banner-slider',
			'travelstore-settings/trip-search',
			'travelstore-settings/trips-by-category',
			'travelstore-settings/latest-trips',
			'travelstore-settings/featured-trips',
			'travelstore-settings/trip-offers',
			'travelstore-settings/customer-reviews',
		);

		if ( count( $customizer_files ) > 0 ) {
			foreach ( $customizer_files as $customizer_file ) {
				require_once "{$child_theme_dir}/inc/customizer/{$customizer_file}.php";
			}
		}

	}
	add_action( 'init', 'travelstore_customizer_includes' );
}
