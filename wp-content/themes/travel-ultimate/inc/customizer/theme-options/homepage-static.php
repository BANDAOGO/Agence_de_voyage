<?php
/**
* Homepage (Static ) options
*
* @package Theme Palace
* @subpackage Travel Ultimate
* @since Travel Ultimate 1.0.0
*/

// Homepage (Static ) setting and control.
$wp_customize->add_setting( 'travel_ultimate_theme_options[enable_frontpage_content]', array(
	'sanitize_callback'   => 'travel_ultimate_sanitize_checkbox',
	'default'             => $options['enable_frontpage_content'],
) );

$wp_customize->add_control( 'travel_ultimate_theme_options[enable_frontpage_content]', array(
	'label'       	=> esc_html__( 'Enable Content', 'travel-ultimate' ),
	'description' 	=> esc_html__( 'Check to enable content on static front page only.', 'travel-ultimate' ),
	'section'     	=> 'static_front_page',
	'type'        	=> 'checkbox',
) );