<?php
/**
 * Layout options
 *
 * @package Theme Palace
 * @subpackage Travel Ultimate
 * @since Travel Ultimate 1.0.0
 */

// Add sidebar section
$wp_customize->add_section( 'travel_ultimate_layout', array(
	'title'               => esc_html__('Layout','travel-ultimate'),
	'description'         => esc_html__( 'Layout section options.', 'travel-ultimate' ),
	'panel'               => 'travel_ultimate_theme_options_panel',
) );

// Site layout setting and control.
$wp_customize->add_setting( 'travel_ultimate_theme_options[site_layout]', array(
	'sanitize_callback'   => 'travel_ultimate_sanitize_select',
	'default'             => $options['site_layout'],
) );

$wp_customize->add_control(  new travel_ultimate_Custom_Radio_Image_Control ( $wp_customize, 'travel_ultimate_theme_options[site_layout]', array(
	'label'               => esc_html__( 'Site Layout', 'travel-ultimate' ),
	'section'             => 'travel_ultimate_layout',
	'choices'			  => travel_ultimate_site_layout(),
) ) );

// Sidebar position setting and control.
$wp_customize->add_setting( 'travel_ultimate_theme_options[sidebar_position]', array(
	'sanitize_callback'   => 'travel_ultimate_sanitize_select',
	'default'             => $options['sidebar_position'],
) );

$wp_customize->add_control(  new travel_ultimate_Custom_Radio_Image_Control ( $wp_customize, 'travel_ultimate_theme_options[sidebar_position]', array(
	'label'               => esc_html__( 'Global Sidebar Position', 'travel-ultimate' ),
	'section'             => 'travel_ultimate_layout',
	'choices'			  => travel_ultimate_global_sidebar_position(),
) ) );

// Post sidebar position setting and control.
$wp_customize->add_setting( 'travel_ultimate_theme_options[post_sidebar_position]', array(
	'sanitize_callback'   => 'travel_ultimate_sanitize_select',
	'default'             => $options['post_sidebar_position'],
) );

$wp_customize->add_control(  new travel_ultimate_Custom_Radio_Image_Control ( $wp_customize, 'travel_ultimate_theme_options[post_sidebar_position]', array(
	'label'               => esc_html__( 'Posts Sidebar Position', 'travel-ultimate' ),
	'section'             => 'travel_ultimate_layout',
	'choices'			  => travel_ultimate_sidebar_position(),
) ) );

// Post sidebar position setting and control.
$wp_customize->add_setting( 'travel_ultimate_theme_options[page_sidebar_position]', array(
	'sanitize_callback'   => 'travel_ultimate_sanitize_select',
	'default'             => $options['page_sidebar_position'],
) );

$wp_customize->add_control( new travel_ultimate_Custom_Radio_Image_Control( $wp_customize, 'travel_ultimate_theme_options[page_sidebar_position]', array(
	'label'               => esc_html__( 'Pages Sidebar Position', 'travel-ultimate' ),
	'section'             => 'travel_ultimate_layout',
	'choices'			  => travel_ultimate_sidebar_position(),
) ) );

if ( class_exists( 'WP_Travel' ) ) {
	// Post sidebar position setting and control.
	$wp_customize->add_setting( 'travel_ultimate_theme_options[wp_travel_sidebar_position]', array(
		'sanitize_callback'   => 'travel_ultimate_sanitize_select',
		'default'             => $options['wp_travel_sidebar_position'],
	) );

	$wp_customize->add_control( new travel_ultimate_Custom_Radio_Image_Control( $wp_customize, 'travel_ultimate_theme_options[wp_travel_sidebar_position]', array(
		'label'               => esc_html__( 'WP Travel Archive Sidebar Position', 'travel-ultimate' ),
		'section'             => 'travel_ultimate_layout',
		'choices'			  => travel_ultimate_sidebar_position(),
	) ) );
}