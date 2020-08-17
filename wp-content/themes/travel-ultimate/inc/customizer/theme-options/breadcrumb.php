<?php
/**
 * Breadcrumb options
 *
 * @package Theme Palace
 * @subpackage Travel Ultimate
 * @since Travel Ultimate 1.0.0
 */

$wp_customize->add_section( 'travel_ultimate_breadcrumb', array(
	'title'             => esc_html__( 'Breadcrumb','travel-ultimate' ),
	'description'       => esc_html__( 'Breadcrumb section options.', 'travel-ultimate' ),
	'panel'             => 'travel_ultimate_theme_options_panel',
) );

// Breadcrumb enable setting and control.
$wp_customize->add_setting( 'travel_ultimate_theme_options[breadcrumb_enable]', array(
	'sanitize_callback' => 'travel_ultimate_sanitize_switch_control',
	'default'          	=> $options['breadcrumb_enable'],
) );

$wp_customize->add_control( new travel_ultimate_Switch_Control( $wp_customize, 'travel_ultimate_theme_options[breadcrumb_enable]', array(
	'label'            	=> esc_html__( 'Enable Breadcrumb', 'travel-ultimate' ),
	'section'          	=> 'travel_ultimate_breadcrumb',
	'on_off_label' 		=> travel_ultimate_switch_options(),
) ) );

// Breadcrumb separator setting and control.
$wp_customize->add_setting( 'travel_ultimate_theme_options[breadcrumb_separator]', array(
	'sanitize_callback'	=> 'sanitize_text_field',
	'default'          	=> $options['breadcrumb_separator'],
) );

$wp_customize->add_control( 'travel_ultimate_theme_options[breadcrumb_separator]', array(
	'label'            	=> esc_html__( 'Separator', 'travel-ultimate' ),
	'active_callback' 	=> 'travel_ultimate_is_breadcrumb_enable',
	'section'          	=> 'travel_ultimate_breadcrumb',
) );
