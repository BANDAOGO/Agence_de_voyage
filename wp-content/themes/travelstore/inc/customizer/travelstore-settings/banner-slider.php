<?php
/**
 * This file has the settings for the banner section options.
 *
 * @package travelstore
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'travelstore_customizer_settings_banner_slider' ) ) {

	/**
	 * Adds settings and options for the banner slider option.
	 *
	 * @param object $wp_customize WP customizer object.
	 */
	function travelstore_customizer_settings_banner_slider( $wp_customize ) {
		$panel_id   = 'travelstore_settings';
		$section_id = 'travelstore_customizer_settings_banner_slider';

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
				'type'              => 'slim_select',
				'custom_control'    => 'Travelstore_Customizer_Slim_Select_Control',
				'name'              => travelstore_customizer_get_name( $panel_id, $section_id, 'tax_dropdown' ),
				'default'           => travelstore_get_customizer_defaults( $panel_id, $section_id, 'tax_dropdown' ),
				'sanitize_callback' => 'travelstore_sanitize_select',
				'description'       => esc_html__( 'If no taxonomy is selected, It will display the trips slides randomly.', 'travelstore' ),
				'active_callback'   => function() {
					$panel_id     = 'travelstore_settings';
					$section_id   = 'travelstore_customizer_settings_banner_slider';
					$options      = get_theme_mod( 'travelstore_theme_options' );
					$enable_section = ! empty( $options[ $panel_id ][ $section_id ]['enable_section'] ) ? $options[ $panel_id ][ $section_id ]['enable_section'] : false;
					return $enable_section;
				},
				'choices'           => travelstore_get_wp_travel_taxonomies(),
				'label'             => esc_html__( 'Taxonomy', 'travelstore' ),
				'section'           => $section_id,
			)
		);

		travelstore_register_option(
			$wp_customize,
			array(
				'type'              => 'slim_select',
				'custom_control'    => 'Travelstore_Customizer_Slim_Select_Control',
				'name'              => travelstore_customizer_get_name( $panel_id, $section_id, 'category_term' ),
				'default'           => travelstore_get_customizer_defaults( $panel_id, $section_id, 'category_term' ),
				'sanitize_callback' => 'travelstore_sanitize_select',
				'active_callback'   => function() {
					$panel_id     = 'travelstore_settings';
					$section_id   = 'travelstore_customizer_settings_banner_slider';
					$options      = get_theme_mod( 'travelstore_theme_options' );
					$enable_section = ! empty( $options[ $panel_id ][ $section_id ]['enable_section'] ) ? $options[ $panel_id ][ $section_id ]['enable_section'] : false;
					$selected_tax = ! empty( $options[ $panel_id ][ $section_id ]['tax_dropdown'] ) ? $options[ $panel_id ][ $section_id ]['tax_dropdown'] : false;
					return ( 'category' === $selected_tax ) && $enable_section;
				},
				'choices'           => travelstore_get_wp_travel_terms( 'category' ),
				'label'             => esc_html__( 'Select Destination', 'travelstore' ),
				'section'           => $section_id,
			)
		);

		travelstore_register_option(
			$wp_customize,
			array(
				'type'              => 'slim_select',
				'custom_control'    => 'Travelstore_Customizer_Slim_Select_Control',
				'name'              => travelstore_customizer_get_name( $panel_id, $section_id, 'travel_locations_term' ),
				'default'           => travelstore_get_customizer_defaults( $panel_id, $section_id, 'travel_locations_term' ),
				'sanitize_callback' => 'travelstore_sanitize_select',
				'active_callback'   => function() {
					$panel_id     = 'travelstore_settings';
					$section_id   = 'travelstore_customizer_settings_banner_slider';
					$options      = get_theme_mod( 'travelstore_theme_options' );
					$enable_section = ! empty( $options[ $panel_id ][ $section_id ]['enable_section'] ) ? $options[ $panel_id ][ $section_id ]['enable_section'] : false;
					$selected_tax = ! empty( $options[ $panel_id ][ $section_id ]['tax_dropdown'] ) ? $options[ $panel_id ][ $section_id ]['tax_dropdown'] : false;
					return ( 'travel_locations' === $selected_tax ) && $enable_section;
				},
				'choices'           => travelstore_get_wp_travel_terms( 'travel_locations' ),
				'label'             => esc_html__( 'Select Destination', 'travelstore' ),
				'section'           => $section_id,
			)
		);

		travelstore_register_option(
			$wp_customize,
			array(
				'type'              => 'slim_select',
				'custom_control'    => 'Travelstore_Customizer_Slim_Select_Control',
				'name'              => travelstore_customizer_get_name( $panel_id, $section_id, 'itinerary_types_term' ),
				'default'           => travelstore_get_customizer_defaults( $panel_id, $section_id, 'itinerary_types_term' ),
				'sanitize_callback' => 'travelstore_sanitize_select',
				'active_callback'   => function() {
					$panel_id     = 'travelstore_settings';
					$section_id   = 'travelstore_customizer_settings_banner_slider';
					$options      = get_theme_mod( 'travelstore_theme_options' );
					$enable_section = ! empty( $options[ $panel_id ][ $section_id ]['enable_section'] ) ? $options[ $panel_id ][ $section_id ]['enable_section'] : false;
					$selected_tax = ! empty( $options[ $panel_id ][ $section_id ]['tax_dropdown'] ) ? $options[ $panel_id ][ $section_id ]['tax_dropdown'] : false;
					return ( 'itinerary_types' === $selected_tax ) && $enable_section;
				},
				'choices'           => travelstore_get_wp_travel_terms( 'itinerary_types' ),
				'label'             => esc_html__( 'Select Trip Types', 'travelstore' ),
				'section'           => $section_id,
			)
		);

		travelstore_register_option(
			$wp_customize,
			array(
				'type'              => 'slim_select',
				'custom_control'    => 'Travelstore_Customizer_Slim_Select_Control',
				'name'              => travelstore_customizer_get_name( $panel_id, $section_id, 'activity_term' ),
				'default'           => travelstore_get_customizer_defaults( $panel_id, $section_id, 'activity_term' ),
				'sanitize_callback' => 'travelstore_sanitize_select',
				'active_callback'   => function() {
					$panel_id     = 'travelstore_settings';
					$section_id   = 'travelstore_customizer_settings_banner_slider';
					$options      = get_theme_mod( 'travelstore_theme_options' );
					$enable_section = ! empty( $options[ $panel_id ][ $section_id ]['enable_section'] ) ? $options[ $panel_id ][ $section_id ]['enable_section'] : false;
					$selected_tax = ! empty( $options[ $panel_id ][ $section_id ]['tax_dropdown'] ) ? $options[ $panel_id ][ $section_id ]['tax_dropdown'] : false;
					return ( 'activity' === $selected_tax ) && $enable_section;
				},
				'choices'           => travelstore_get_wp_travel_terms( 'activity' ),
				'label'             => esc_html__( 'Select Trip Activity', 'travelstore' ),
				'section'           => $section_id,
			)
		);

	}
	add_action( 'customize_register', 'travelstore_customizer_settings_banner_slider' );
}
