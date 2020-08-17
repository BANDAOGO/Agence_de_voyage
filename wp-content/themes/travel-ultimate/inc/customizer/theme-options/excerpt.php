<?php
/**
 * Excerpt options
 *
 * @package Theme Palace
 * @subpackage Travel Ultimate
 * @since Travel Ultimate 1.0.0
 */

// Add excerpt section
$wp_customize->add_section( 'travel_ultimate_excerpt_section', array(
	'title'             => esc_html__( 'Excerpt','travel-ultimate' ),
	'description'       => esc_html__( 'Excerpt section options.', 'travel-ultimate' ),
	'panel'             => 'travel_ultimate_theme_options_panel',
) );


// long Excerpt length setting and control.
$wp_customize->add_setting( 'travel_ultimate_theme_options[long_excerpt_length]', array(
	'sanitize_callback' => 'travel_ultimate_sanitize_number_range',
	'validate_callback' => 'travel_ultimate_validate_long_excerpt',
	'default'			=> $options['long_excerpt_length'],
) );

$wp_customize->add_control( 'travel_ultimate_theme_options[long_excerpt_length]', array(
	'label'       		=> esc_html__( 'Blog Page Excerpt Length', 'travel-ultimate' ),
	'description' 		=> esc_html__( 'Total words to be displayed in archive page/search page.', 'travel-ultimate' ),
	'section'     		=> 'travel_ultimate_excerpt_section',
	'type'        		=> 'number',
	'input_attrs' 		=> array(
		'style'       => 'width: 80px;',
		'max'         => 100,
		'min'         => 5,
	),
) );

// long Excerpt length setting and control.
$wp_customize->add_setting( 'travel_ultimate_theme_options[excerpt_text]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['excerpt_text'],
) );

$wp_customize->add_control( 'travel_ultimate_theme_options[excerpt_text]', array(
	'label'       		=> esc_html__( 'Blog Page Excerpt text', 'travel-ultimate' ),
	'section'     		=> 'travel_ultimate_excerpt_section',
) );
