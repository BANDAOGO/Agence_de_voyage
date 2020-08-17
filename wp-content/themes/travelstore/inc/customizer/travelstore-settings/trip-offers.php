<?php
/**
 * This file has the settings for the featured trips options.
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


if ( ! function_exists( 'travelstore_customizer_settings_trip_offers' ) ) {

	/**
	 * Adds settings and options for the banner slider option.
	 *
	 * @param object $wp_customize WP customizer object.
	 */
	function travelstore_customizer_settings_trip_offers( $wp_customize ) {
		$panel_id   = 'travelstore_settings';
		$section_id = 'travelstore_customizer_settings_trip_offers';

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
				'type'              => 'heading',
				'custom_control'    => 'Travelstore_Customizer_Heading_Control',
				'name'              => travelstore_customizer_get_name( $panel_id, $section_id, 'separator_one' ),
				'sanitize_callback' => 'sanitize_text_field',
				'label'             => travelstore_get_customizer_defaults( $panel_id, $section_id, 'title' ),
				'section'           => $section_id,
				'active_callback'   => function() {
					$panel_id     = 'travelstore_settings';
					$section_id   = 'travelstore_customizer_settings_trip_offers';
					$options      = get_theme_mod( 'travelstore_theme_options' );
					$enable_section = ! empty( $options[ $panel_id ][ $section_id ]['enable_section'] ) ? $options[ $panel_id ][ $section_id ]['enable_section'] : false;
					return $enable_section;
				},
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
					$section_id   = 'travelstore_customizer_settings_trip_offers';
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
				'type'              => 'slim_select',
				'custom_control'    => 'Travelstore_Customizer_Slim_Select_Control',
				'name'              => travelstore_customizer_get_name( $panel_id, $section_id, 'tax_dropdown' ),
				'default'           => travelstore_get_customizer_defaults( $panel_id, $section_id, 'tax_dropdown' ),
				'description'       => esc_html__( 'If no taxonomy is selected, It will display the trip offers from all categories.', 'travelstore' ),
				'sanitize_callback' => 'travelstore_sanitize_select',
				'active_callback'   => function() {
					$panel_id     = 'travelstore_settings';
					$section_id   = 'travelstore_customizer_settings_trip_offers';
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
				'name'              => travelstore_customizer_get_name( $panel_id, $section_id, 'travel_locations_term' ),
				'default'           => travelstore_get_customizer_defaults( $panel_id, $section_id, 'travel_locations_term' ),
				'sanitize_callback' => 'travelstore_sanitize_select',
				'active_callback'   => function() {
					$panel_id     = 'travelstore_settings';
					$section_id   = 'travelstore_customizer_settings_trip_offers';
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
					$section_id   = 'travelstore_customizer_settings_trip_offers';
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
					$section_id   = 'travelstore_customizer_settings_trip_offers';
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

		travelstore_register_option(
			$wp_customize,
			array(
				'type'              => 'number',
				'name'              => travelstore_customizer_get_name( $panel_id, $section_id, 'numberposts' ),
				'default'           => travelstore_get_customizer_defaults( $panel_id, $section_id, 'numberposts' ),
				'description'       => esc_html__( 'Total number of sale enabled trips that you would like to display.', 'travelstore' ),
				'sanitize_callback' => 'sanitize_text_field',
				'active_callback'   => function() {
					$panel_id     = 'travelstore_settings';
					$section_id   = 'travelstore_customizer_settings_trip_offers';
					$options      = get_theme_mod( 'travelstore_theme_options' );
					$enable_section = ! empty( $options[ $panel_id ][ $section_id ]['enable_section'] ) ? $options[ $panel_id ][ $section_id ]['enable_section'] : false;
					return $enable_section;
				},
				'input_attrs'       => array(
					'min' => 0,
				),
				'label'             => esc_html__( 'Number of offer trips', 'travelstore' ),
				'section'           => $section_id,
			)
		);

		travelstore_register_option(
			$wp_customize,
			array(
				'type'              => 'heading',
				'custom_control'    => 'Travelstore_Customizer_Heading_Control',
				'name'              => travelstore_customizer_get_name( $panel_id, $section_id, 'separator_two' ),
				'sanitize_callback' => 'sanitize_text_field',
				'label'             => esc_html__( 'Call To Action', 'travelstore' ),
				'section'           => $section_id,
				'active_callback'   => function() {
					$panel_id     = 'travelstore_settings';
					$section_id   = 'travelstore_customizer_settings_trip_offers';
					$options      = get_theme_mod( 'travelstore_theme_options' );
					$enable_section = ! empty( $options[ $panel_id ][ $section_id ]['enable_section'] ) ? $options[ $panel_id ][ $section_id ]['enable_section'] : false;
					return $enable_section;
				},
			)
		);

		travelstore_register_option(
			$wp_customize,
			array(
				'type'              => 'slim_select',
				'custom_control'    => 'Travelstore_Customizer_Slim_Select_Control',
				'name'              => travelstore_customizer_get_name( $panel_id, $section_id, 'section_cta' ),
				'default'           => travelstore_get_customizer_defaults( $panel_id, $section_id, 'section_cta' ),
				'description'       => esc_html__( 'Search or select page or post for CTA', 'travelstore' ),
				'sanitize_callback' => 'travelstore_sanitize_select',
				'choices'           => travelstore_get_pages_and_posts(),
				'active_callback'   => function() {
					$panel_id     = 'travelstore_settings';
					$section_id   = 'travelstore_customizer_settings_trip_offers';
					$options      = get_theme_mod( 'travelstore_theme_options' );
					$enable_section = ! empty( $options[ $panel_id ][ $section_id ]['enable_section'] ) ? $options[ $panel_id ][ $section_id ]['enable_section'] : false;
					return $enable_section;
				},
				'label'             => esc_html__( 'Call To Action', 'travelstore' ),
				'section'           => $section_id,
			)
		);

		travelstore_register_option(
			$wp_customize,
			array(
				'type'              => 'slim_select',
				'custom_control'    => 'Travelstore_Customizer_Slim_Select_Control',
				'name'              => travelstore_customizer_get_name( $panel_id, $section_id, 'cta_link' ),
				'default'           => travelstore_get_customizer_defaults( $panel_id, $section_id, 'cta_link' ),
				'description'       => esc_html__( 'Select "Default" for selected page or post id link, "Trip Archives" for WP Travel archives link or "Custom Link" for CTA custom link.', 'travelstore' ),
				'sanitize_callback' => 'travelstore_sanitize_select',
				'active_callback'   => function() {
					$panel_id     = 'travelstore_settings';
					$section_id   = 'travelstore_customizer_settings_trip_offers';
					$options      = get_theme_mod( 'travelstore_theme_options' );
					$enable_section = ! empty( $options[ $panel_id ][ $section_id ]['enable_section'] ) ? $options[ $panel_id ][ $section_id ]['enable_section'] : false;
					$display        = ! empty( $options[ $panel_id ][ $section_id ]['section_cta'] ) && ( $options[ $panel_id ][ $section_id ]['section_cta'] > 0 );
					return $enable_section && $display;
				},
				'choices'           => array(
					'default'      => __( 'Default', 'travelstore' ),
					'trip_archive' => __( 'Trip Archives', 'travelstore' ),
					'custom'       => __( 'Custom Link', 'travelstore' ),
				),
				'label'             => esc_html__( 'CTA Button Link', 'travelstore' ),
				'section'           => $section_id,
			)
		);

		travelstore_register_option(
			$wp_customize,
			array(
				'type'              => 'url',
				'name'              => travelstore_customizer_get_name( $panel_id, $section_id, 'cta_custom_link' ),
				'default'           => travelstore_get_customizer_defaults( $panel_id, $section_id, 'cta_custom_link' ),
				'description'       => esc_html__( 'Enter a custom link for the call to action content.', 'travelstore' ),
				'sanitize_callback' => 'sanitize_text_field',
				'active_callback'   => function() {
					$panel_id     = 'travelstore_settings';
					$section_id   = 'travelstore_customizer_settings_trip_offers';
					$options      = get_theme_mod( 'travelstore_theme_options' );
					$enable_section = ! empty( $options[ $panel_id ][ $section_id ]['enable_section'] ) ? $options[ $panel_id ][ $section_id ]['enable_section'] : false;
					$display        = ! empty( $options[ $panel_id ][ $section_id ]['section_cta'] ) && ( $options[ $panel_id ][ $section_id ]['section_cta'] > 0 );
					$enable         = ! empty( $options[ $panel_id ][ $section_id ]['cta_link'] ) && ( 'custom' === $options[ $panel_id ][ $section_id ]['cta_link'] );
					return $enable_section && $display && $enable;
				},
				'label'             => esc_html__( 'Custom Link', 'travelstore' ),
				'section'           => $section_id,
			)
		);

	}
	add_action( 'customize_register', 'travelstore_customizer_settings_trip_offers' );
}
