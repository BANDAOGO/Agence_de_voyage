<?php
/**
 * pagination options
 *
 * @package Theme Palace
 * @subpackage Travel Ultimate
 * @since Travel Ultimate 1.0.0
 */

// Add sidebar section
$wp_customize->add_section( 'travel_ultimate_pagination', array(
	'title'               => esc_html__('Pagination','travel-ultimate'),
	'description'         => esc_html__( 'Pagination section options.', 'travel-ultimate' ),
	'panel'               => 'travel_ultimate_theme_options_panel',
) );

// Sidebar position setting and control.
$wp_customize->add_setting( 'travel_ultimate_theme_options[pagination_enable]', array(
	'sanitize_callback' => 'travel_ultimate_sanitize_switch_control',
	'default'             => $options['pagination_enable'],
) );

$wp_customize->add_control( new travel_ultimate_Switch_Control( $wp_customize, 'travel_ultimate_theme_options[pagination_enable]', array(
	'label'               => esc_html__( 'Pagination Enable', 'travel-ultimate' ),
	'section'             => 'travel_ultimate_pagination',
	'on_off_label' 		=> travel_ultimate_switch_options(),
) ) );

// Site layout setting and control.
$wp_customize->add_setting( 'travel_ultimate_theme_options[pagination_type]', array(
	'sanitize_callback'   => 'travel_ultimate_sanitize_select',
	'default'             => $options['pagination_type'],
) );

$wp_customize->add_control( 'travel_ultimate_theme_options[pagination_type]', array(
	'label'               => esc_html__( 'Pagination Type', 'travel-ultimate' ),
	'section'             => 'travel_ultimate_pagination',
	'type'                => 'select',
	'choices'			  => travel_ultimate_pagination_options(),
	'active_callback'	  => 'travel_ultimate_is_pagination_enable',
) );
