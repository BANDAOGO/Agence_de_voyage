<?php
/**
 * Destination Section options
 *
 * @package Theme Palace
 * @subpackage Travel Ultimate
 * @since Travel Ultimate 1.0.0
 */

// Add Destination section
$wp_customize->add_section( 'travel_ultimate_destination_section', array(
	'title'             => esc_html__( 'Destination','travel-ultimate' ),
	'description'       => esc_html__( 'Destination Section options.', 'travel-ultimate' ),
	'panel'             => 'travel_ultimate_front_page_panel',
) );

// Destination content enable control and setting
$wp_customize->add_setting( 'travel_ultimate_theme_options[destination_section_enable]', array(
	'default'			=> 	$options['destination_section_enable'],
	'sanitize_callback' => 'travel_ultimate_sanitize_switch_control',
) );

$wp_customize->add_control( new travel_ultimate_Switch_Control( $wp_customize, 'travel_ultimate_theme_options[destination_section_enable]', array(
	'label'             => esc_html__( 'Destination Section Enable', 'travel-ultimate' ),
	'section'           => 'travel_ultimate_destination_section',
	'on_off_label' 		=> travel_ultimate_switch_options(),
) ) );

// destination title setting and control
$wp_customize->add_setting( 'travel_ultimate_theme_options[destination_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['destination_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'travel_ultimate_theme_options[destination_title]', array(
	'label'           	=> esc_html__( 'Title', 'travel-ultimate' ),
	'section'        	=> 'travel_ultimate_destination_section',
	'active_callback' 	=> 'travel_ultimate_is_destination_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'travel_ultimate_theme_options[destination_title]', array(
		'selector'            => '#travel-destinations .section-header h2.section-title',
		'settings'            => 'travel_ultimate_theme_options[destination_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'travel_ultimate_destination_title_partial',
    ) );
}


// Destination content type control and setting
$wp_customize->add_setting( 'travel_ultimate_theme_options[destination_content_type]', array(
	'default'          	=> $options['destination_content_type'],
	'sanitize_callback' => 'travel_ultimate_sanitize_select',
) );

$choices = array( 
		'page' 		=> esc_html__( 'Page', 'travel-ultimate' ),
	);
if ( class_exists( 'WP_Travel' ) ) {
	$choices['destination'] = esc_html__( 'Destination', 'travel-ultimate' );
}

$wp_customize->add_control( 'travel_ultimate_theme_options[destination_content_type]', array(
	'label'             => esc_html__( 'Content Type', 'travel-ultimate' ),
	'section'           => 'travel_ultimate_destination_section',
	'type'				=> 'select',
	'active_callback' 	=> 'travel_ultimate_is_destination_section_enable',
	'choices'			=> $choices,
) );

for ( $i = 1; $i <= 2; $i++ ) :
	// destination pages drop down chooser control and setting
	$wp_customize->add_setting( 'travel_ultimate_theme_options[destination_content_page_' . $i . ']', array(
		'sanitize_callback' => 'travel_ultimate_sanitize_page',
	) );

	$wp_customize->add_control( new travel_ultimate_Dropdown_Chooser( $wp_customize, 'travel_ultimate_theme_options[destination_content_page_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select Page %d', 'travel-ultimate' ), $i ),
		'section'           => 'travel_ultimate_destination_section',
		'choices'			=> travel_ultimate_page_choices(),
		'active_callback'	=> 'travel_ultimate_is_destination_section_content_page_enable',
	) ) );

	// destination hr setting and control
	$wp_customize->add_setting( 'travel_ultimate_theme_options[destination_hr_'. $i .']', array(
		'sanitize_callback' => 'sanitize_text_field'
	) );

	$wp_customize->add_control( new travel_ultimate_Customize_Horizontal_Line( $wp_customize, 'travel_ultimate_theme_options[destination_hr_'. $i .']',
		array(
			'section'         => 'travel_ultimate_destination_section',
			'active_callback' => 'travel_ultimate_is_destination_section_content_seperator_enable',
			'type'			  => 'hr'
	) ) );
endfor;

if ( class_exists( 'WP_Travel' ) ) {
	// Add dropdown destinations setting and control.
	$wp_customize->add_setting(  'travel_ultimate_theme_options[dest_destinations]', array(
		'sanitize_callback' => 'absint',
	) ) ;

	$wp_customize->add_control( new travel_ultimate_Dropdown_Taxonomies_Control( $wp_customize,'travel_ultimate_theme_options[dest_destinations]', array(
		'label'             => esc_html__( 'Select destinations', 'travel-ultimate' ),
		'description'      	=> esc_html__( 'Note: Selected destination\'s no of posts will be shown from selected category', 'travel-ultimate' ),
		'section'           => 'travel_ultimate_destination_section',
		'type'              => 'dropdown-taxonomies',
		'taxonomy'			=> 'travel_locations',
		'active_callback'	=> 'travel_ultimate_is_dest_destinations_enable'
	) ) );
}