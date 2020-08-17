<?php
/**
 * Archive options
 *
 * @package Theme Palace
 * @subpackage Travel Ultimate
 * @since Travel Ultimate 1.0.0
 */

// Add archive section
$wp_customize->add_section( 'travel_ultimate_archive_section', array(
	'title'             => esc_html__( 'Blog/Archive','travel-ultimate' ),
	'description'       => esc_html__( 'Archive section options.', 'travel-ultimate' ),
	'panel'             => 'travel_ultimate_theme_options_panel',
) );

// Your latest posts title setting and control.
$wp_customize->add_setting( 'travel_ultimate_theme_options[your_latest_posts_title]', array(
	'default'           => $options['your_latest_posts_title'],
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'travel_ultimate_theme_options[your_latest_posts_title]', array(
	'label'             => esc_html__( 'Your Latest Posts Title', 'travel-ultimate' ),
	'description'       => esc_html__( 'This option only works if Static Front Page is set to "Your latest posts."', 'travel-ultimate' ),
	'section'           => 'travel_ultimate_archive_section',
	'type'				=> 'text',
	'active_callback'   => 'travel_ultimate_is_latest_posts'
) );

// Archive date meta setting and control.
$wp_customize->add_setting( 'travel_ultimate_theme_options[hide_date]', array(
	'default'           => $options['hide_date'],
	'sanitize_callback' => 'travel_ultimate_sanitize_switch_control',
) );

$wp_customize->add_control( new travel_ultimate_Switch_Control( $wp_customize, 'travel_ultimate_theme_options[hide_date]', array(
	'label'             => esc_html__( 'Hide Date', 'travel-ultimate' ),
	'section'           => 'travel_ultimate_archive_section',
	'on_off_label' 		=> travel_ultimate_hide_options(),
) ) );
