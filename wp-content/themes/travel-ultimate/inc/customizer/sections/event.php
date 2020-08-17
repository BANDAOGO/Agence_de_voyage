<?php
/**
 * Event Section options
 *
 * @package Theme Palace
 * @subpackage Travel Ultimate
 * @since Travel Ultimate 1.0.0
 */

// Add Event section
$wp_customize->add_section( 'travel_ultimate_event_section', array(
	'title'             => esc_html__( 'Event','travel-ultimate' ),
	'description'       => esc_html__( 'Event Section options.', 'travel-ultimate' ),
	'panel'             => 'travel_ultimate_front_page_panel',
) );

// Event content enable control and setting
$wp_customize->add_setting( 'travel_ultimate_theme_options[event_section_enable]', array(
	'default'			=> 	$options['event_section_enable'],
	'sanitize_callback' => 'travel_ultimate_sanitize_switch_control',
) );

$wp_customize->add_control( new travel_ultimate_Switch_Control( $wp_customize, 'travel_ultimate_theme_options[event_section_enable]', array(
	'label'             => esc_html__( 'Event Section Enable', 'travel-ultimate' ),
	'section'           => 'travel_ultimate_event_section',
	'on_off_label' 		=> travel_ultimate_switch_options(),
) ) );

// event title setting and control
$wp_customize->add_setting( 'travel_ultimate_theme_options[event_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['event_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'travel_ultimate_theme_options[event_title]', array(
	'label'           	=> esc_html__( 'Title', 'travel-ultimate' ),
	'section'        	=> 'travel_ultimate_event_section',
	'active_callback' 	=> 'travel_ultimate_is_event_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'travel_ultimate_theme_options[event_title]', array(
		'selector'            => '#travel-events .section-header h2.section-title',
		'settings'            => 'travel_ultimate_theme_options[event_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'travel_ultimate_event_title_partial',
    ) );
}

for ( $i = 1; $i <= 3; $i++ ) :
	// event btn setting and control
	$wp_customize->add_setting( 'travel_ultimate_theme_options[event_read_more_' . $i . ']', array(
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'travel_ultimate_theme_options[event_read_more_' . $i . ']', array(
		'label'           	=> sprintf( esc_html__( 'Read more text %d', 'travel-ultimate' ), $i ),
		'section'        	=> 'travel_ultimate_event_section',
		'active_callback' 	=> 'travel_ultimate_is_event_section_enable',
	) );


	// event hr setting and control
	$wp_customize->add_setting( 'travel_ultimate_theme_options[event_hr_'. $i .']', array(
		'sanitize_callback' => 'sanitize_text_field'
	) );

	$wp_customize->add_control( new travel_ultimate_Customize_Horizontal_Line( $wp_customize, 'travel_ultimate_theme_options[event_hr_'. $i .']',
		array(
			'section'         => 'travel_ultimate_event_section',
			'active_callback' => 'travel_ultimate_is_event_section_enable',
			'type'			  => 'hr'
	) ) );
endfor;

// Add dropdown category setting and control.
$wp_customize->add_setting(  'travel_ultimate_theme_options[event_content_category]', array(
	'sanitize_callback' => 'travel_ultimate_sanitize_single_category',
) ) ;

$wp_customize->add_control( new travel_ultimate_Dropdown_Taxonomies_Control( $wp_customize,'travel_ultimate_theme_options[event_content_category]', array(
	'label'             => esc_html__( 'Select Category', 'travel-ultimate' ),
	'description'      	=> esc_html__( 'Note: Event selected no of posts will be shown from selected category', 'travel-ultimate' ),
	'section'           => 'travel_ultimate_event_section',
	'type'              => 'dropdown-taxonomies',
	'active_callback'	=> 'travel_ultimate_is_event_section_enable'
) ) );

