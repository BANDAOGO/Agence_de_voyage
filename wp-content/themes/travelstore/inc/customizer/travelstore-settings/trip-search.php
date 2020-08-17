<?php
/**
 * This file has the settings for the trip search section options.
 *
 * @package travelstore
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'WP_Travel' ) ) {
	return;
}

if ( ! function_exists( 'travelstore_customizer_settings_trip_search' ) ) {

	/**
	 * Adds settings and options for the trip search option.
	 *
	 * @param object $wp_customize WP customizer object.
	 */
	function travelstore_customizer_settings_trip_search( $wp_customize ) {
		$panel_id   = 'travelstore_settings';
		$section_id = 'travelstore_customizer_settings_trip_search';

		// Add section.
		$wp_customize->add_section(
			$section_id,
			array(
				'title' => travelstore_get_customizer_defaults( $panel_id, $section_id, 'title' ),
				'panel' => $panel_id,
			)
		);

		travelstore_register_option(
			$wp_customize,
			array(
				'type'              => 'checkbox',
				'name'              => travelstore_customizer_get_name( $panel_id, $section_id, 'enable_section' ),
				'default'           => travelstore_get_customizer_defaults( $panel_id, $section_id, 'enable_section' ),
				'sanitize_callback' => 'travelstore_sanitize_checkbox',
				'label'             => esc_html__( 'Enable Section?', 'travelstore' ),
				'section'           => $section_id,
			)
		);

	}
	add_action( 'customize_register', 'travelstore_customizer_settings_trip_search' );
}
