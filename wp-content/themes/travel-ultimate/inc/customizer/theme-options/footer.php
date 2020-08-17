<?php
/**
 * Footer options
 *
 * @package Theme Palace
 * @subpackage Travel Ultimate
 * @since Travel Ultimate 1.0.0
 */

// Footer Section
$wp_customize->add_section( 'travel_ultimate_section_footer',
	array(
		'title'      			=> esc_html__( 'Footer Options', 'travel-ultimate' ),
		'priority'   			=> 900,
		'panel'      			=> 'travel_ultimate_theme_options_panel',
	)
);


// scroll top visible
$wp_customize->add_setting( 'travel_ultimate_theme_options[scroll_top_visible]',
	array(
		'default'       		=> $options['scroll_top_visible'],
		'sanitize_callback' => 'travel_ultimate_sanitize_switch_control',
	)
);
$wp_customize->add_control( new travel_ultimate_Switch_Control( $wp_customize, 'travel_ultimate_theme_options[scroll_top_visible]',
    array(
		'label'      			=> esc_html__( 'Display Scroll Top Button', 'travel-ultimate' ),
		'section'    			=> 'travel_ultimate_section_footer',
		'on_off_label' 		=> travel_ultimate_switch_options(),
    )
) );