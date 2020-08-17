<?php
/**
 * This file has the functions to help customizer work flow.
 *
 * @package travelstore
 * @subpackage inc/customizer
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Function to register control and setting.
 */
function travelstore_register_option( $wp_customize, $option ) {

	// Initialize Setting.
	$wp_customize->add_setting(
		$option['name'],
		array(
			'sanitize_callback' => $option['sanitize_callback'],
			'default'           => isset( $option['default'] ) ? $option['default'] : '',
			'transport'         => isset( $option['transport'] ) ? $option['transport'] : 'refresh',
			'theme_supports'    => isset( $option['theme_supports'] ) ? $option['theme_supports'] : '',
		)
	);

	$control = array(
		'label'    => $option['label'],
		'section'  => $option['section'],
		'settings' => $option['name'],
	);

	if ( isset( $option['active_callback'] ) ) {
		$control['active_callback'] = $option['active_callback'];
	}

	if ( isset( $option['priority'] ) ) {
		$control['priority'] = $option['priority'];
	}

	if ( isset( $option['choices'] ) ) {
		$control['choices'] = $option['choices'];
	}

	if ( isset( $option['type'] ) ) {
		$control['type'] = $option['type'];
	}

	if ( isset( $option['input_attrs'] ) ) {
		$control['input_attrs'] = $option['input_attrs'];
	}

	if ( isset( $option['description'] ) ) {
		$control['description'] = $option['description'];
	}

	if ( isset( $option['mime_type'] ) ) {
		$control['mime_type'] = $option['mime_type'];
	}

	if ( ! empty( $option['custom_control'] ) ) {
		$wp_customize->add_control( new $option['custom_control']( $wp_customize, $option['name'], $control ) );
	} else {
		$wp_customize->add_control( $option['name'], $control );
	}
}


if ( ! function_exists( 'travelstore_get_customizer_defaults' ) ) {

	/**
	 * Provides the customizer defaults.
	 *
	 * @param string $panel_id Customizer panel ID.
	 * @param string $section_id Customizer section ID.
	 * @param string $control Control key for the section ID..
	 */
	function travelstore_get_customizer_defaults( $panel_id, $section_id, $control ) {

		$defaults = array(
			'travelstore_settings' => array(
				'travelstore_customizer_settings_banner_slider' => array(
					'enable_section' => false,
					'title'          => esc_html__( 'Banner Slider', 'travelstore' ),
					'tax_dropdown'   => 'none',
				),
				'travelstore_customizer_settings_trip_search' => array(
					'enable_section' => false,
					'title'          => esc_html__( 'Trip Search', 'travelstore' ),
				),
				'travelstore_customizer_settings_trips_by_category' => array(
					'enable_section' => false,
					'title'          => esc_html__( 'Category Slider', 'travelstore' ),
					'number_items'   => 6,
					'tax_dropdown'   => 'none',
				),
				'travelstore_customizer_settings_latest_trips' => array(
					'enable_section' => false,
					'title'          => esc_html__( 'Latest Posts', 'travelstore' ),
					'section_cta'    => 'none',
					'cta_link'       => 'default',
					'tax_dropdown'   => 'none',
				),
				'travelstore_customizer_settings_featured_trips' => array(
					'enable_section' => false,
					'title'          => esc_html__( 'Featured Trips', 'travelstore' ),
				),
				'travelstore_customizer_settings_trip_offers' => array(
					'enable_section' => false,
					'title'          => esc_html__( 'Trip Offers', 'travelstore' ),
					'section_cta'    => 'none',
					'cta_link'       => 'default',
					'tax_dropdown'   => 'none',
					'numberposts'    => 3,
				),
				'travelstore_customizer_settings_customer_reviews' => array(
					'enable_section' => false,
					'title'          => esc_html__( 'Customer Reviews', 'travelstore' ),
					'review_type'    => '4_and_above',
				),
			),
		);

		return ! empty( $defaults[ $panel_id ][ $section_id ][ $control ] ) ? $defaults[ $panel_id ][ $section_id ][ $control ] : '';
	}
}


if ( ! function_exists( 'travelstore_customizer_get_name' ) ) {

	/**
	 * Generates the formated string for the control name attr.
	 */
	function travelstore_customizer_get_name( $panel, $section, $control ) {
		$mod_prefix = 'travelstore_theme_options';
		return "{$mod_prefix}[{$panel}][{$section}][{$control}]";
	}
}


if ( ! function_exists( 'travelstore_get_theme_option' ) ) {

	/**
	 * Provides the customizer theme options.
	 * Returns default options if nothing is set by the user.
	 *
	 * @param string $panel_id Customizer panel ID.
	 * @param string $section_id Customizer section ID.
	 * @param string $control Control key for the section ID..
	 */
	function travelstore_get_theme_option( $panel_id, $section_id, $control ) {
		if ( ! $panel_id || ! $section_id || ! $control ) {
			return;
		}

		$default = travelstore_get_customizer_defaults( $panel_id, $section_id, $control );
		$options = get_theme_mod( 'travelstore_theme_options' );
		return ! empty( $options[ $panel_id ][ $section_id ][ $control ] ) ? $options[ $panel_id ][ $section_id ][ $control ] : $default;
	}
}

if ( ! function_exists( 'travelstore_get_wp_travel_taxonomies' ) ) {

	/**
	 * Provides the formatted array for taxonomy listing.
	 */
	function travelstore_get_wp_travel_taxonomies() {

		$taxonomies = array(
			'none'     => esc_html__( 'Select Taxonomy', 'travelstore' ),
			'category' => esc_html__( 'Category', 'travelstore' ),
		);

		$wpt_tax = array(
			'travel_locations' => esc_html__( 'Trip Locations', 'travelstore' ),
			'itinerary_types'  => esc_html__( 'Trip Types', 'travelstore' ),
			'activity'         => esc_html__( 'Trip Activities', 'travelstore' ),
		);

		if ( function_exists( 'WP_Travel' ) ) {
			$taxonomies = array_merge( $taxonomies, $wpt_tax );
		}

		// Build the array.
		foreach ( $taxonomies as $tax_slug => $tax_label ) {
			$items[ $tax_slug ] = $tax_label;
		}

		return $items;
	}
}

if ( ! function_exists( 'travelstore_get_pages_and_posts' ) ) {

	/**
	 * Returns the formatted array of pages and posts for customizer option.
	 */
	function travelstore_get_pages_and_posts() {

		$items = array();

		$items['none'] = esc_html__( 'Select a post or page...', 'travelstore' );

		$the_query = new WP_Query(
			array(
				'post_type'      => 'post',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
			)
		);
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$items[ get_the_ID() ] = get_the_title();
			}
		}
		wp_reset_postdata();

		$the_query = new WP_Query(
			array(
				'post_type'      => 'page',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
			)
		);
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$items[ get_the_ID() ] = get_the_title();
			}
		}
		wp_reset_postdata();

		return $items;

	}
	travelstore_get_pages_and_posts();
}

if ( ! function_exists( 'travelstore_get_wp_travel_terms' ) ) {

	/**
	 * Provides the customizer formated terms.
	 */
	function travelstore_get_wp_travel_terms( $taxonomy ) {

		$term_array = array();
		$terms      = get_terms(
			array(
				'taxonomy'   => $taxonomy,
				'hide_empty' => true,
			)
		);

		if ( is_array( $terms ) && count( $terms ) > 0 ) {
			$term_array['none'] = esc_html__( 'Select a category...', 'travelstore' );
			foreach ( $terms as $itinerary_term ) {
				$slug  = ! empty( $itinerary_term->slug ) ? $itinerary_term->slug : '';
				$label = ! empty( $itinerary_term->name ) ? $itinerary_term->name : '';

				$term_array[ $slug ] = $label;
			}
		}

		return $term_array;
	}
}
