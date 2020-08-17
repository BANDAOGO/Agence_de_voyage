<?php
/**
 * About Section options
 *
 * @package Theme Palace
 * @subpackage Travel Ultimate
 * @since Travel Ultimate 1.0.0
 */

// Add About section
$wp_customize->add_section( 'travel_ultimate_about_section', array(
	'title'             => esc_html__( 'About Us','travel-ultimate' ),
	'description'       => esc_html__( 'About Section options.', 'travel-ultimate' ),
	'panel'             => 'travel_ultimate_front_page_panel',
) );

// About content enable control and setting
$wp_customize->add_setting( 'travel_ultimate_theme_options[about_section_enable]', array(
	'default'			=> 	$options['about_section_enable'],
	'sanitize_callback' => 'travel_ultimate_sanitize_switch_control',
) );

$wp_customize->add_control( new travel_ultimate_Switch_Control( $wp_customize, 'travel_ultimate_theme_options[about_section_enable]', array(
	'label'             => esc_html__( 'About Section Enable', 'travel-ultimate' ),
	'section'           => 'travel_ultimate_about_section',
	'on_off_label' 		=> travel_ultimate_switch_options(),
) ) );

// about pages drop down chooser control and setting
$wp_customize->add_setting( 'travel_ultimate_theme_options[about_content_page]', array(
	'sanitize_callback' => 'travel_ultimate_sanitize_page',
) );

$wp_customize->add_control( new travel_ultimate_Dropdown_Chooser( $wp_customize, 'travel_ultimate_theme_options[about_content_page]', array(
	'label'             => esc_html__( 'Select Page', 'travel-ultimate' ),
	'section'           => 'travel_ultimate_about_section',
	'choices'			=> travel_ultimate_page_choices(),
	'active_callback'	=> 'travel_ultimate_is_about_section_enable',
) ) );



// about hr setting and control
$wp_customize->add_setting( 'travel_ultimate_theme_options[about_hr]', array(
	'sanitize_callback' => 'sanitize_text_field'
) );

$wp_customize->add_control( new travel_ultimate_Customize_Horizontal_Line( $wp_customize, 'travel_ultimate_theme_options[about_hr]',
	array(
		'section'         => 'travel_ultimate_about_section',
		'active_callback' => 'travel_ultimate_is_about_section_enable',
		'type'			  => 'hr' 
) ) );

// About content type control and setting
$wp_customize->add_setting( 'travel_ultimate_theme_options[tour_content_type]', array(
	'sanitize_callback' => 'travel_ultimate_sanitize_select',
) );

$wp_customize->add_control( 'travel_ultimate_theme_options[tour_content_type]', array(
	'label'             => esc_html__( 'Tour Content Type', 'travel-ultimate' ),
	'section'           => 'travel_ultimate_about_section',
	'type'				=> 'select',
	'active_callback' 	=> 'travel_ultimate_is_about_section_enable',
	'choices'			=> array( 
		'cat' 		=> esc_html__( 'Category', 'travel-ultimate' ),
		'trip-types' 		=> esc_html__( 'Trip Type', 'travel-ultimate' ),
	),
) );

for ( $i = 1; $i <= 4; $i++ ) { 
	// Add dropdown category setting and control.
	$wp_customize->add_setting(  'travel_ultimate_theme_options[tour_cat_' . $i . ']', array(
		'sanitize_callback' => 'absint',
	) ) ;

	$wp_customize->add_control( new travel_ultimate_Dropdown_Taxonomies_Control( $wp_customize,'travel_ultimate_theme_options[tour_cat_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select category %d', 'travel-ultimate' ), $i ),
		'description'      	=> esc_html__( 'Note: Selected category\'s no of posts will be shown from selected category', 'travel-ultimate' ),
		'section'           => 'travel_ultimate_about_section',
		'type'              => 'dropdown-categories',
		'active_callback'	=> 'travel_ultimate_is_tour_cat_enable'
	) ) );
	// Add dropdown destinations setting and control.
	$wp_customize->add_setting(  'travel_ultimate_theme_options[tour_trip_' . $i . ']', array(
		'sanitize_callback' => 'absint',
	) ) ;

	$wp_customize->add_control( new travel_ultimate_Dropdown_Taxonomies_Control( $wp_customize,'travel_ultimate_theme_options[tour_trip_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select trip type %d', 'travel-ultimate' ), $i ),
		'description'      	=> esc_html__( 'Note: Selected trip type\'s no of posts will be shown from selected category', 'travel-ultimate' ),
		'section'           => 'travel_ultimate_about_section',
		'type'              => 'dropdown-taxonomies',
		'taxonomy'			=> 'itinerary_types',
		'active_callback'	=> 'travel_ultimate_is_tour_trip_enable'
	) ) );

	// tour image setting and control.
	$wp_customize->add_setting( 'travel_ultimate_theme_options[tour_image_' . $i . ']', array(
		'sanitize_callback' => 'travel_ultimate_sanitize_image'
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'travel_ultimate_theme_options[tour_image_' . $i . ']',
			array(
			'label'       		=> sprintf( esc_html__( 'Image %d', 'travel-ultimate' ), $i ),
			'section'     		=> 'travel_ultimate_about_section',
			'active_callback'	=> 'travel_ultimate_is_about_section_enable',
	) ) );

	// about hr setting and control
	$wp_customize->add_setting( 'travel_ultimate_theme_options[tour_type_' . $i . ']', array(
		'sanitize_callback' => 'sanitize_text_field'
	) );

	$wp_customize->add_control( new travel_ultimate_Customize_Horizontal_Line( $wp_customize, 'travel_ultimate_theme_options[tour_type_' . $i . ']',
		array(
			'section'         => 'travel_ultimate_about_section',
			'active_callback' => 'travel_ultimate_is_about_section_enable',
			'type'			  => 'hr'
	) ) );
}