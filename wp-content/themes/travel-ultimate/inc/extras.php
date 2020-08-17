<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Theme Palace
 * @subpackage Travel Ultimate
 * @since Travel Ultimate 1.0.0
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function travel_ultimate_body_classes( $classes ) {
	$options = travel_ultimate_get_theme_options();

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	
	// Check if slider is enabled on frontpage
	$slider_enable = apply_filters( 'travel_ultimate_section_status', true, 'slider_section_enable' );

	if ( ! $slider_enable ) {
	    $classes[] = 'featured-slider-disabled';
	}

	// Menu
	$classes[] = 'classic-menu';


	// Add a class for layout
	$classes[] = esc_attr( $options['site_layout'] );

	if ( is_post_type_archive( 'itineraries' ) || is_tax( 'itinerary_types' ) || is_tax( 'travel_locations' ) || is_tax( 'travel_keywords' ) || is_tax( 'travel_keywords' ) ) {
		if ( is_active_sidebar( 'wp-travel-archive-sidebar' ) ) {
			$classes[] = $options['wp_travel_sidebar_position'];
		} else {
			$classes[] = 'no-sidebar';
		}
	} else {
		// Add a class for sidebar
		$sidebar_position = travel_ultimate_layout();
		$sidebar = 'sidebar-1';
		if ( is_singular() || is_home() ) {
			$id = ( is_home() && ! is_front_page() ) ? get_option( 'page_for_posts' ) : get_the_id();
		  	$sidebar = get_post_meta( $id, 'travel-ultimate-selected-sidebar', true );
		  	$sidebar = ! empty( $sidebar ) ? $sidebar : 'sidebar-1';
		}
		
		if ( is_active_sidebar( $sidebar ) ) {
			$classes[] = esc_attr( $sidebar_position );
		} else {
			$classes[] = 'no-sidebar';
		}
	}

	if ( is_singular( 'itineraries' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'travel_ultimate_body_classes' );