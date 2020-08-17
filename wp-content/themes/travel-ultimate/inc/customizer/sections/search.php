<?php
/**
 * Search Section options
 *
 * @package Theme Palace
 * @subpackage Travel Ultimate
 * @since Travel Ultimate 1.0.0
 */

// Add Search section
$wp_customize->add_section( 'travel_ultimate_search_section', array(
	'title'             => esc_html__( 'Search','travel-ultimate' ),
	'description'       => esc_html__( 'Search Section options.', 'travel-ultimate' ),
	'panel'             => 'travel_ultimate_front_page_panel',
) );

// Search content enable control and setting
$wp_customize->add_setting( 'travel_ultimate_theme_options[search_section_enable]', array(
	'default'			=> 	$options['search_section_enable'],
	'sanitize_callback' => 'travel_ultimate_sanitize_switch_control',
) );

$wp_customize->add_control( new travel_ultimate_Switch_Control( $wp_customize, 'travel_ultimate_theme_options[search_section_enable]', array(
	'label'             => esc_html__( 'Search Section Enable', 'travel-ultimate' ),
	'section'           => 'travel_ultimate_search_section',
	'on_off_label' 		=> travel_ultimate_switch_options(),
) ) );