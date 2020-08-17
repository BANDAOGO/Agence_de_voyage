<?php
/**
 * Testimonial Section options
 *
 * @package Theme Palace
 * @subpackage Travel Ultimate
 * @since Travel Ultimate 1.0.0
 */

// Add Testimonial section
$wp_customize->add_section( 'travel_ultimate_testimonial_section', array(
	'title'             => esc_html__( 'Testimonial','travel-ultimate' ),
	'description'       => esc_html__( 'Testimonial Section options.', 'travel-ultimate' ),
	'panel'             => 'travel_ultimate_front_page_panel',
) );

// Testimonial content enable control and setting
$wp_customize->add_setting( 'travel_ultimate_theme_options[testimonial_section_enable]', array(
	'default'			=> 	$options['testimonial_section_enable'],
	'sanitize_callback' => 'travel_ultimate_sanitize_switch_control',
) );

$wp_customize->add_control( new travel_ultimate_Switch_Control( $wp_customize, 'travel_ultimate_theme_options[testimonial_section_enable]', array(
	'label'             => esc_html__( 'Testimonial Section Enable', 'travel-ultimate' ),
	'section'           => 'travel_ultimate_testimonial_section',
	'on_off_label' 		=> travel_ultimate_switch_options(),
) ) );

// testimonial title setting and control
$wp_customize->add_setting( 'travel_ultimate_theme_options[testimonial_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['testimonial_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'travel_ultimate_theme_options[testimonial_title]', array(
	'label'           	=> esc_html__( 'Title', 'travel-ultimate' ),
	'section'        	=> 'travel_ultimate_testimonial_section',
	'active_callback' 	=> 'travel_ultimate_is_testimonial_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'travel_ultimate_theme_options[testimonial_title]', array(
		'selector'            => '#client-testimonial .section-header h2.section-title',
		'settings'            => 'travel_ultimate_theme_options[testimonial_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'travel_ultimate_testimonial_title_partial',
    ) );
}

for ( $i = 1; $i <= 3; $i++ ) :
	// testimonial pages drop down chooser control and setting
	$wp_customize->add_setting( 'travel_ultimate_theme_options[testimonial_content_page_' . $i . ']', array(
		'sanitize_callback' => 'travel_ultimate_sanitize_page',
	) );

	$wp_customize->add_control( new travel_ultimate_Dropdown_Chooser( $wp_customize, 'travel_ultimate_theme_options[testimonial_content_page_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select Page %d', 'travel-ultimate' ), $i ),
		'section'           => 'travel_ultimate_testimonial_section',
		'choices'			=> travel_ultimate_page_choices(),
		'active_callback'	=> 'travel_ultimate_is_testimonial_section_enable',
	) ) );

endfor;

