<?php
/**
 * Package Section options
 *
 * @package Theme Palace
 * @subpackage Travel Ultimate
 * @since Travel Ultimate 1.0.0
 */

// Add Package section
$wp_customize->add_section( 'travel_ultimate_package_section', array(
	'title'             => esc_html__( 'Packages','travel-ultimate' ),
	'description'       => esc_html__( 'Packages Section options.', 'travel-ultimate' ),
	'panel'             => 'travel_ultimate_front_page_panel',
) );

// Package content enable control and setting
$wp_customize->add_setting( 'travel_ultimate_theme_options[package_section_enable]', array(
	'default'			=> 	$options['package_section_enable'],
	'sanitize_callback' => 'travel_ultimate_sanitize_switch_control',
) );

$wp_customize->add_control( new travel_ultimate_Switch_Control( $wp_customize, 'travel_ultimate_theme_options[package_section_enable]', array(
	'label'             => esc_html__( 'Package Section Enable', 'travel-ultimate' ),
	'section'           => 'travel_ultimate_package_section',
	'on_off_label' 		=> travel_ultimate_switch_options(),
) ) );

// package title setting and control
$wp_customize->add_setting( 'travel_ultimate_theme_options[package_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['package_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'travel_ultimate_theme_options[package_title]', array(
	'label'           	=> esc_html__( 'Title', 'travel-ultimate' ),
	'section'        	=> 'travel_ultimate_package_section',
	'active_callback' 	=> 'travel_ultimate_is_package_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'travel_ultimate_theme_options[package_title]', array(
		'selector'            => '#recommended-packages .section-header h2.section-title',
		'settings'            => 'travel_ultimate_theme_options[package_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'travel_ultimate_package_title_partial',
    ) );
}

// Package content type control and setting
$wp_customize->add_setting( 'travel_ultimate_theme_options[package_content_type]', array(
	'default'          	=> $options['package_content_type'],
	'sanitize_callback' => 'travel_ultimate_sanitize_select',
) );

$choices = array( 
		'page' 		=> esc_html__( 'Page', 'travel-ultimate' ),
	);
if ( class_exists( 'WP_Travel' ) ) {
	$choices['trip'] = esc_html__( 'Trip', 'travel-ultimate' );
}
$wp_customize->add_control( 'travel_ultimate_theme_options[package_content_type]', array(
	'label'             => esc_html__( 'Content Type', 'travel-ultimate' ),
	'section'           => 'travel_ultimate_package_section',
	'type'				=> 'select',
	'active_callback' 	=> 'travel_ultimate_is_package_section_enable',
	'choices'			=> $choices,
) );


for ( $i = 1; $i <= 3; $i++ ) :

	// package pages drop down chooser control and setting
	$wp_customize->add_setting( 'travel_ultimate_theme_options[package_content_page_' . $i . ']', array(
		'sanitize_callback' => 'travel_ultimate_sanitize_page',
	) );

	$wp_customize->add_control( new travel_ultimate_Dropdown_Chooser( $wp_customize, 'travel_ultimate_theme_options[package_content_page_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select Page %d', 'travel-ultimate' ), $i ),
		'section'           => 'travel_ultimate_package_section',
		'choices'			=> travel_ultimate_page_choices(),
		'active_callback'	=> 'travel_ultimate_is_package_section_content_page_enable',
	) ) );

	if ( class_exists( 'WP_Travel' ) ) {
		// slider trip drop down chooser control and setting
		$wp_customize->add_setting( 'travel_ultimate_theme_options[package_content_trip_' . $i . ']', array(
			'sanitize_callback' => 'travel_ultimate_sanitize_page',
		) );

		$wp_customize->add_control( new travel_ultimate_Dropdown_Chooser( $wp_customize, 'travel_ultimate_theme_options[package_content_trip_' . $i . ']', array(
			'label'             => sprintf( esc_html__( 'Select Trip %d', 'travel-ultimate' ), $i ),
			'section'           => 'travel_ultimate_package_section',
			'choices'			=> travel_ultimate_trip_choices(),
			'active_callback'	=> 'travel_ultimate_is_package_section_content_trip_enable',
		) ) );
	}

endfor;
