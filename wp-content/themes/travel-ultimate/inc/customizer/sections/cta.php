<?php
/**
 * CTA Section options
 *
 * @package Theme Palace
 * @subpackage Travel Ultimate
 * @since Travel Ultimate 1.0.0
 */

// Add CTA section
$wp_customize->add_section( 'travel_ultimate_cta_section', array(
	'title'             => esc_html__( 'CTA','travel-ultimate' ),
	'description'       => esc_html__( 'CTA Section options.', 'travel-ultimate' ),
	'panel'             => 'travel_ultimate_front_page_panel',
) );

// CTA content enable control and setting
$wp_customize->add_setting( 'travel_ultimate_theme_options[cta_section_enable]', array(
	'default'			=> 	$options['cta_section_enable'],
	'sanitize_callback' => 'travel_ultimate_sanitize_switch_control',
) );

$wp_customize->add_control( new travel_ultimate_Switch_Control( $wp_customize, 'travel_ultimate_theme_options[cta_section_enable]', array(
	'label'             => esc_html__( 'CTA Section Enable', 'travel-ultimate' ),
	'section'           => 'travel_ultimate_cta_section',
	'on_off_label' 		=> travel_ultimate_switch_options(),
) ) );

// cta pages drop down chooser control and setting
$wp_customize->add_setting( 'travel_ultimate_theme_options[cta_content_page]', array(
	'sanitize_callback' => 'travel_ultimate_sanitize_page',
) );

$wp_customize->add_control( new travel_ultimate_Dropdown_Chooser( $wp_customize, 'travel_ultimate_theme_options[cta_content_page]', array(
	'label'             => esc_html__( 'Select Page', 'travel-ultimate' ),
	'section'           => 'travel_ultimate_cta_section',
	'choices'			=> travel_ultimate_page_choices(),
	'active_callback'	=> 'travel_ultimate_is_cta_section_enable',
) ) );

// CTA btn label setting and control
$wp_customize->add_setting( 'travel_ultimate_theme_options[cta_btn_label]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['cta_btn_label'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'travel_ultimate_theme_options[cta_btn_label]', array(
	'label'           	=> esc_html__( 'Button Label', 'travel-ultimate' ),
	'section'        	=> 'travel_ultimate_cta_section',
	'active_callback' 	=> 'travel_ultimate_is_cta_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'travel_ultimate_theme_options[cta_btn_label]', array(
		'selector'            => '#call-to-action .view-all .btn',
		'settings'            => 'travel_ultimate_theme_options[cta_btn_label]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'travel_ultimate_cta_btn_label_partial',
    ) );
}

