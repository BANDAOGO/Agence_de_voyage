<?php
/**
 * Customizer active callbacks
 *
 * @package Theme Palace
 * @subpackage Travel Ultimate
 * @since Travel Ultimate 1.0.0
 */

if ( ! function_exists( 'travel_ultimate_is_breadcrumb_enable' ) ) :
	/**
	 * Check if breadcrumb is enabled.
	 *
	 * @since Travel Ultimate 1.0.0
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function travel_ultimate_is_breadcrumb_enable( $control ) {
		return $control->manager->get_setting( 'travel_ultimate_theme_options[breadcrumb_enable]' )->value();
	}
endif;

if ( ! function_exists( 'travel_ultimate_is_pagination_enable' ) ) :
	/**
	 * Check if pagination is enabled.
	 *
	 * @since Travel Ultimate 1.0.0
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function travel_ultimate_is_pagination_enable( $control ) {
		return $control->manager->get_setting( 'travel_ultimate_theme_options[pagination_enable]' )->value();
	}
endif;

/**
 * Front Page Active Callbacks
 */

/**
 * Check if cta section is enabled.
 *
 * @since Travel Ultimate 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function travel_ultimate_is_cta_section_enable( $control ) {
	return ( $control->manager->get_setting( 'travel_ultimate_theme_options[cta_section_enable]' )->value() );
}

/**
 * Check if package section is enabled.
 *
 * @since Travel Ultimate 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function travel_ultimate_is_package_section_enable( $control ) {
	return ( $control->manager->get_setting( 'travel_ultimate_theme_options[package_section_enable]' )->value() );
}

/**
 * Check if package section content type is trip.
 *
 * @since Travel Ultimate 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function travel_ultimate_is_package_section_content_trip_enable( $control ) {
	$content_type = $control->manager->get_setting( 'travel_ultimate_theme_options[package_content_type]' )->value();
	return travel_ultimate_is_package_section_enable( $control ) && ( 'trip' == $content_type );
}

/**
 * Check if package section seperator.
 *
 * @since Travel Ultimate 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function travel_ultimate_is_package_section_content_seperator_enable( $control ) {
	$content_type = $control->manager->get_setting( 'travel_ultimate_theme_options[package_content_type]' )->value();
	return travel_ultimate_is_package_section_enable( $control ) && ( in_array( $content_type, array( 'page', 'post' ) ) );
}

/**
 * Check if package section content type is page.
 *
 * @since Travel Ultimate 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function travel_ultimate_is_package_section_content_page_enable( $control ) {
	$content_type = $control->manager->get_setting( 'travel_ultimate_theme_options[package_content_type]' )->value();
	return travel_ultimate_is_package_section_enable( $control ) && ( 'page' == $content_type );
}


/**
 * Check if about section is enabled.
 *
 * @since Travel Ultimate 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function travel_ultimate_is_about_section_enable( $control ) {
	return ( $control->manager->get_setting( 'travel_ultimate_theme_options[about_section_enable]' )->value() );
}

/**
 * Check if tour cat is enabled.
 *
 * @since Travel Ultimate 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function travel_ultimate_is_tour_cat_enable( $control ) {
	$content_type = $control->manager->get_setting( 'travel_ultimate_theme_options[tour_content_type]' )->value();
	return travel_ultimate_is_about_section_enable( $control ) && ( 'cat' == $content_type );
}

/**
 * Check if tour trip is enabled.
 *
 * @since Travel Ultimate 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function travel_ultimate_is_tour_trip_enable( $control ) {
	$content_type = $control->manager->get_setting( 'travel_ultimate_theme_options[tour_content_type]' )->value();
	return travel_ultimate_is_about_section_enable( $control ) && ( 'trip-types' == $content_type );
}


/**
 * Check if slider section is enabled.
 *
 * @since Travel Ultimate 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function travel_ultimate_is_slider_section_enable( $control ) {
	return ( $control->manager->get_setting( 'travel_ultimate_theme_options[slider_section_enable]' )->value() );
}

/**
 * Check if slider section content type is trip.
 *
 * @since Travel Ultimate 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function travel_ultimate_is_slider_section_content_trip_enable( $control ) {
	$content_type = $control->manager->get_setting( 'travel_ultimate_theme_options[slider_content_type]' )->value();
	return travel_ultimate_is_slider_section_enable( $control ) && ( 'trip' == $content_type );
}

/**
 * Check if slider section content type is page.
 *
 * @since Travel Ultimate 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function travel_ultimate_is_slider_section_content_page_enable( $control ) {
	$content_type = $control->manager->get_setting( 'travel_ultimate_theme_options[slider_content_type]' )->value();
	return travel_ultimate_is_slider_section_enable( $control ) && ( 'page' == $content_type );
}

/**
 * Check if destination section is enabled.
 *
 * @since Travel Ultimate 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function travel_ultimate_is_destination_section_enable( $control ) {
	return ( $control->manager->get_setting( 'travel_ultimate_theme_options[destination_section_enable]' )->value() );
}

/**
 * Check if destination section content type is trip.
 *
 * @since Travel Ultimate 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function travel_ultimate_is_dest_destinations_enable( $control ) {
	$content_type = $control->manager->get_setting( 'travel_ultimate_theme_options[destination_content_type]' )->value();
	return travel_ultimate_is_destination_section_enable( $control ) && ( 'destination' == $content_type );
}

/**
 * Check if destination section content type is page.
 *
 * @since Travel Ultimate 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function travel_ultimate_is_destination_section_content_page_enable( $control ) {
	$content_type = $control->manager->get_setting( 'travel_ultimate_theme_options[destination_content_type]' )->value();
	return travel_ultimate_is_destination_section_enable( $control ) && ( 'page' == $content_type );
}

/**
 * Check if destination section seperator.
 *
 * @since Travel Ultimate 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function travel_ultimate_is_destination_section_content_seperator_enable( $control ) {
	$content_type = $control->manager->get_setting( 'travel_ultimate_theme_options[destination_content_type]' )->value();
	return travel_ultimate_is_destination_section_enable( $control ) && ( in_array( $content_type, array( 'page', 'post' ) ) );
}

/**
 * Check if event section is enabled.
 *
 * @since Travel Ultimate 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function travel_ultimate_is_event_section_enable( $control ) {
	return ( $control->manager->get_setting( 'travel_ultimate_theme_options[event_section_enable]' )->value() );
}

/**
 * Check if testimonial section is enabled.
 *
 * @since Travel Ultimate 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function travel_ultimate_is_testimonial_section_enable( $control ) {
	return ( $control->manager->get_setting( 'travel_ultimate_theme_options[testimonial_section_enable]' )->value() );
}
