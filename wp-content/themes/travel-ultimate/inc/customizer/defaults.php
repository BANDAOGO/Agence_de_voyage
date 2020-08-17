<?php
/**
 * Customizer default options
 *
 * @package Theme Palace
 * @subpackage Travel Ultimate
 * @since Travel Ultimate 1.0.0
 * @return array An array of default values
 */

function travel_ultimate_get_default_theme_options() {
	$theme_data = wp_get_theme();
	$travel_ultimate_default_options = array(
		// Color Options
		'header_title_color'			=> '#fff',
		'header_tagline_color'			=> '#fff',
		'header_txt_logo_extra'			=> 'show-all',

		// breadcrumb
		'breadcrumb_enable'				=> true,
		'breadcrumb_separator'			=> '/',
		
		// layout 
		'site_layout'         			=> 'wide',
		'sidebar_position'         		=> 'right-sidebar',
		'wp_travel_sidebar_position'    => 'right-sidebar',
		'post_sidebar_position' 		=> 'right-sidebar',
		'page_sidebar_position' 		=> 'right-sidebar',

		// excerpt options
		'long_excerpt_length'           => 25,
		'excerpt_text'           => esc_html__( 'Tour Details', 'travel-ultimate' ),
		
		// pagination options
		'pagination_enable'         	=> true,
		'pagination_type'         		=> 'default',

		// footer options
		'scroll_top_visible'        	=> true,

		// reset options
		'reset_options'      			=> false,
		
		// homepage options
		'enable_frontpage_content' 		=> false,

		// blog/archive options
		'your_latest_posts_title' 		=> esc_html__( 'Blogs', 'travel-ultimate' ),
		'hide_date' 					=> false,


		// single post theme options
		'single_post_hide_date' 		=> false,
		'single_post_hide_author'		=> false,
		'single_post_hide_category'		=> false,
		'single_post_hide_tags'			=> false,

		/* Front Page */
		'search_section_enable'			=> false,

		// Banner
		'cta_section_enable'			=> false,
		'cta_btn_label'					=> esc_html__( 'View All Details', 'travel-ultimate' ),

		// package
		'package_section_enable'		=> false,
		'package_content_type'			=> 'page',
		'package_title'					=> esc_html__( 'We are all here at your services for everything.', 'travel-ultimate' ),

		// About
		'about_section_enable'			=> false,
		'about_title'					=> esc_html__( 'About Us', 'travel-ultimate' ),
		'tour_content_type'		=> 'cat',

		// Slider
		'slider_section_enable'			=> false,
		'slider_content_type'			=> 'page',

		// destination
		'destination_section_enable'	=> false,
		'destination_content_type'		=> 'page',
		'destination_title'				=> esc_html__( 'Great Tour Around World', 'travel-ultimate' ),

		// destination
		'event_section_enable'			=> false,
		'event_title'					=> esc_html__( 'Event Calendar', 'travel-ultimate' ),

		// testimonial
		'testimonial_section_enable'	=> false,
		'testimonial_title'				=> esc_html__( 'Elite Travellers say', 'travel-ultimate' ),
		
	);

	$output = apply_filters( 'travel_ultimate_default_theme_options', $travel_ultimate_default_options );

	// Sort array in ascending order, according to the key:
	if ( ! empty( $output ) ) {
		ksort( $output );
	}

	return $output;
}