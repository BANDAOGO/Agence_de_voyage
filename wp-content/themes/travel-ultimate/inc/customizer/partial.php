<?php
/**
* Partial functions
*
* @package Theme Palace
* @subpackage Travel Ultimate
* @since Travel Ultimate 1.0.0
*/

if ( ! function_exists( 'travel_ultimate_package_title_partial' ) ) :
    // package title
    function travel_ultimate_package_title_partial() {
        $options = travel_ultimate_get_theme_options();
        return esc_html( $options['package_title'] );
    }
endif;

if ( ! function_exists( 'travel_ultimate_about_title_partial' ) ) :
    // about title
    function travel_ultimate_about_title_partial() {
        $options = travel_ultimate_get_theme_options();
        return esc_html( $options['about_title'] );
    }
endif;

if ( ! function_exists( 'travel_ultimate_destination_title_partial' ) ) :
    // destination title
    function travel_ultimate_destination_title_partial() {
        $options = travel_ultimate_get_theme_options();
        return esc_html( $options['destination_title'] );
    }
endif;

if ( ! function_exists( 'travel_ultimate_testimonial_title_partial' ) ) :
    // testimonial title
    function travel_ultimate_testimonial_title_partial() {
        $options = travel_ultimate_get_theme_options();
        return esc_html( $options['testimonial_title'] );
    }
endif;


if ( ! function_exists( 'travel_ultimate_event_title_partial' ) ) :
    // event title
    function travel_ultimate_event_title_partial() {
        $options = travel_ultimate_get_theme_options();
        return esc_html( $options['event_title'] );
    }
endif;
