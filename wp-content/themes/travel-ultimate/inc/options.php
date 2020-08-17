<?php
/**
 * Theme Palace options
 *
 * @package Theme Palace
 * @subpackage Travel Ultimate
 * @since Travel Ultimate 1.0.0
 */

/**
 * List of pages for page choices.
 * @return Array Array of page ids and name.
 */
function travel_ultimate_page_choices() {
    $pages = get_pages();
    $choices = array();
    $choices[0] = esc_html__( '--Select--', 'travel-ultimate' );
    foreach ( $pages as $page ) {
        $choices[ $page->ID ] = $page->post_title;
    }
    return  $choices;
}


/**
 * List of iteneries for post choices.
 * @return Array Array of post ids and name.
 */
function travel_ultimate_trip_choices() {
    if ( ! class_exists( 'WP_Travel' ) ) {
        return;
    }
    $posts = get_posts( array( 'post_type' => 'itineraries', 'numberposts' => -1 ) );
    $choices = array();
    $choices[0] = esc_html__( '--Select--', 'travel-ultimate' );
    foreach ( $posts as $post ) {
        $choices[ $post->ID ] = $post->post_title;
    }
    return  $choices;
}

if ( ! function_exists( 'travel_ultimate_typography_options' ) ) :
    /**
     * Returns list of typography
     * @return array font styles
     */
    function travel_ultimate_typography_options(){
        $choices = array(
            'default'         => esc_html__( 'Default', 'travel-ultimate' ),
            'header-font-1'   => esc_html__( 'Rajdhani', 'travel-ultimate' ),
            'header-font-2'   => esc_html__( 'Cherry Swash', 'travel-ultimate' ),
            'header-font-3'   => esc_html__( 'Philosopher', 'travel-ultimate' ),
            'header-font-4'   => esc_html__( 'Slabo 27px', 'travel-ultimate' ),
            'header-font-5'   => esc_html__( 'Dosis', 'travel-ultimate' ),
        );

        $output = apply_filters( 'travel_ultimate_typography_options', $choices );
        if ( ! empty( $output ) ) {
            ksort( $output );
        }

        return $output;
    }
endif;


if ( ! function_exists( 'travel_ultimate_site_layout' ) ) :
    /**
     * Site Layout
     * @return array site layout options
     */
    function travel_ultimate_site_layout() {
        $travel_ultimate_site_layout = array(
            'wide-layout'  => get_template_directory_uri() . '/assets/images/full.png',
            'boxed-layout' => get_template_directory_uri() . '/assets/images/boxed.png',
        );

        $output = apply_filters( 'travel_ultimate_site_layout', $travel_ultimate_site_layout );
        return $output;
    }
endif;

if ( ! function_exists( 'travel_ultimate_selected_sidebar' ) ) :
    /**
     * Sidebars options
     * @return array Sidbar positions
     */
    function travel_ultimate_selected_sidebar() {
        $travel_ultimate_selected_sidebar = array(
            'sidebar-1'             => esc_html__( 'Default Sidebar', 'travel-ultimate' ),
            'optional-sidebar'      => esc_html__( 'Optional Sidebar', 'travel-ultimate' ),

        );

        $output = apply_filters( 'travel_ultimate_selected_sidebar', $travel_ultimate_selected_sidebar );

        return $output;
    }
endif;


if ( ! function_exists( 'travel_ultimate_global_sidebar_position' ) ) :
    /**
     * Global Sidebar position
     * @return array Global Sidebar positions
     */
    function travel_ultimate_global_sidebar_position() {
        $travel_ultimate_global_sidebar_position = array(
            'right-sidebar' => get_template_directory_uri() . '/assets/images/right.png',
            'no-sidebar'    => get_template_directory_uri() . '/assets/images/full.png',
        );

        $output = apply_filters( 'travel_ultimate_global_sidebar_position', $travel_ultimate_global_sidebar_position );

        return $output;
    }
endif;


if ( ! function_exists( 'travel_ultimate_sidebar_position' ) ) :
    /**
     * Sidebar position
     * @return array Sidbar positions
     */
    function travel_ultimate_sidebar_position() {
        $travel_ultimate_sidebar_position = array(
            'right-sidebar' => get_template_directory_uri() . '/assets/images/right.png',
            'no-sidebar'    => get_template_directory_uri() . '/assets/images/full.png',

        );

        $output = apply_filters( 'travel_ultimate_sidebar_position', $travel_ultimate_sidebar_position );

        return $output;
    }
endif;


if ( ! function_exists( 'travel_ultimate_pagination_options' ) ) :
    /**
     * Pagination
     * @return array site pagination options
     */
    function travel_ultimate_pagination_options() {
        $travel_ultimate_pagination_options = array(
            'numeric'   => esc_html__( 'Numeric', 'travel-ultimate' ),
            'default'   => esc_html__( 'Default(Older/Newer)', 'travel-ultimate' ),
        );

        $output = apply_filters( 'travel_ultimate_pagination_options', $travel_ultimate_pagination_options );

        return $output;
    }
endif;


if ( ! function_exists( 'travel_ultimate_switch_options' ) ) :
    /**
     * List of custom Switch Control options
     * @return array List of switch control options.
     */
    function travel_ultimate_switch_options() {
        $arr = array(
            'on'        => esc_html__( 'Enable', 'travel-ultimate' ),
            'off'       => esc_html__( 'Disable', 'travel-ultimate' )
        );
        return apply_filters( 'travel_ultimate_switch_options', $arr );
    }
endif;

if ( ! function_exists( 'travel_ultimate_hide_options' ) ) :
    /**
     * List of custom Switch Control options
     * @return array List of switch control options.
     */
    function travel_ultimate_hide_options() {
        $arr = array(
            'on'        => esc_html__( 'Yes', 'travel-ultimate' ),
            'off'       => esc_html__( 'No', 'travel-ultimate' )
        );
        return apply_filters( 'travel_ultimate_hide_options', $arr );
    }
endif;

if ( ! function_exists( 'travel_ultimate_sortable_sections' ) ) :
    /**
     * List of sections Control options
     * @return array List of Sections control options.
     */
    function travel_ultimate_sortable_sections() {
        $sections = array(
            'slider'    => esc_html__( 'Slider', 'travel-ultimate' ),
            'search'    => esc_html__( 'Search', 'travel-ultimate' ),
            'package'   => esc_html__( 'Package', 'travel-ultimate' ),
            'about'     => esc_html__( 'About Us', 'travel-ultimate' ),
            'cta'    => esc_html__( 'CTA', 'travel-ultimate' ),
            'destination'     => esc_html__( 'Destination', 'travel-ultimate' ),
            'testimonial' => esc_html__( 'Testimonial', 'travel-ultimate' ),
            'event' => esc_html__( 'Event', 'travel-ultimate' ),
        );
        return apply_filters( 'travel_ultimate_sortable_sections', $sections );
    }
endif;