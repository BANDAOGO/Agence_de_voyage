<?php
/**
 * This file has the settings for the customer reviews options.
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


if ( ! function_exists( 'travelstore_customizer_settings_customer_reviews' ) ) {

	/**
	 * Adds settings and options for the banner slider option.
	 *
	 * @param object $wp_customize WP customizer object.
	 */
	function travelstore_customizer_settings_customer_reviews( $wp_customize ) {
		$panel_id   = 'travelstore_settings';
		$section_id = 'travelstore_customizer_settings_customer_reviews';

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
					$section_id   = 'travelstore_customizer_settings_customer_reviews';
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
				'name'              => travelstore_customizer_get_name( $panel_id, $section_id, 'review_type' ),
				'default'           => travelstore_get_customizer_defaults( $panel_id, $section_id, 'review_type' ),
				'sanitize_callback' => 'travelstore_sanitize_select',
				'description'       => esc_html__( 'Filter the reviews according to the trip average ratings.', 'travelstore' ),
				'active_callback'   => function() {
					$panel_id     = 'travelstore_settings';
					$section_id   = 'travelstore_customizer_settings_customer_reviews';
					$options      = get_theme_mod( 'travelstore_theme_options' );
					$enable_section = ! empty( $options[ $panel_id ][ $section_id ]['enable_section'] ) ? $options[ $panel_id ][ $section_id ]['enable_section'] : false;
					return $enable_section;
				},
				'choices'           => array(
					'display_all'  => esc_html__( 'Display all reviews', 'travelstore' ),
					'3_and_above'  => esc_html__( 'From 3 stars and above', 'travelstore' ),
					'4_and_above'  => esc_html__( 'From 4 stars and above', 'travelstore' ),
					'5_stars_only' => esc_html__( '5 stars only', 'travelstore' ),
				),
				'label'             => esc_html__( 'Filter reviews', 'travelstore' ),
				'section'           => $section_id,
			)
		);
	}
	add_action( 'customize_register', 'travelstore_customizer_settings_customer_reviews' );
}
