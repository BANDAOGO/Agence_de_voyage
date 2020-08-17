<?php
/**
 * This file has the settings for the trips by category options.
 *
 * @package travelstore
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'travelstore_customizer_settings_trips_by_category' ) ) {

	/**
	 * Adds settings and options for the banner slider option.
	 *
	 * @param object $wp_customize WP customizer object.
	 */
	function travelstore_customizer_settings_trips_by_category( $wp_customize ) {
		$panel_id   = 'travelstore_settings';
		$section_id = 'travelstore_customizer_settings_trips_by_category';

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

		travelstore_register_option(
			$wp_customize,
			array(
				'type'              => 'text',
				'name'              => travelstore_customizer_get_name( $panel_id, $section_id, 'title' ),
				'default'           => travelstore_get_customizer_defaults( $panel_id, $section_id, 'title' ),
				'sanitize_callback' => 'sanitize_text_field',
				'active_callback'   => function() {
					$panel_id     = 'travelstore_settings';
					$section_id   = 'travelstore_customizer_settings_trips_by_category';
					$options      = get_theme_mod( 'travelstore_theme_options' );
					$enable_section = ! empty( $options[ $panel_id ][ $section_id ]['enable_section'] ) ? $options[ $panel_id ][ $section_id ]['enable_section'] : false;
					return $enable_section;
				},
				'label'             => esc_html__( 'Title', 'travelstore' ),
				'section'           => $section_id,
			)
		);

		travelstore_register_option(
			$wp_customize,
			array(
				'type'              => 'number',
				'name'              => travelstore_customizer_get_name( $panel_id, $section_id, 'number_items' ),
				'default'           => travelstore_get_customizer_defaults( $panel_id, $section_id, 'number_items' ),
				'sanitize_callback' => 'sanitize_text_field',
				'input_attrs'       => array(
					'min' => 1,
				),
				'description'       => esc_html__( 'Mention the number of items to display.', 'travelstore' ),
				'active_callback'   => function() {
					$panel_id     = 'travelstore_settings';
					$section_id   = 'travelstore_customizer_settings_trips_by_category';
					$options      = get_theme_mod( 'travelstore_theme_options' );
					$enable_section = ! empty( $options[ $panel_id ][ $section_id ]['enable_section'] ) ? $options[ $panel_id ][ $section_id ]['enable_section'] : false;
					return $enable_section;
				},
				'label'             => esc_html__( 'Number Of Items', 'travelstore' ),
				'section'           => $section_id,
			)
		);

		travelstore_register_option(
			$wp_customize,
			array(
				'type'              => 'slim_select',
				'custom_control'    => 'Travelstore_Customizer_Slim_Select_Control',
				'name'              => travelstore_customizer_get_name( $panel_id, $section_id, 'tax_dropdown' ),
				'default'           => travelstore_get_customizer_defaults( $panel_id, $section_id, 'tax_dropdown' ),
				'sanitize_callback' => 'travelstore_sanitize_select',
				'active_callback'   => function() {
					$panel_id     = 'travelstore_settings';
					$section_id   = 'travelstore_customizer_settings_trips_by_category';
					$options      = get_theme_mod( 'travelstore_theme_options' );
					$enable_section = ! empty( $options[ $panel_id ][ $section_id ]['enable_section'] ) ? $options[ $panel_id ][ $section_id ]['enable_section'] : false;
					return $enable_section;
				},
				'choices'           => travelstore_get_wp_travel_taxonomies(),
				'label'             => esc_html__( 'Taxonomy', 'travelstore' ),
				'section'           => $section_id,
			)
		);

	}
	add_action( 'customize_register', 'travelstore_customizer_settings_trips_by_category' );
}
