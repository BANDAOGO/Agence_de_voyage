<?php
/**
 * This file has the settings for the wp customizer core options.
 *
 * @package travelstore
 */

if ( ! function_exists( 'travelstore_create_other_core_options' ) ) {

	/**
	 * Adds other default or core options for the customizer and theme.
	 * for example: hide or display the frontpage static content
	 *
	 * @param object $wp_customize WordPress customizer objects.
	 */
	function travelstore_create_other_core_options( $wp_customize ) {

		travelstore_register_option(
			$wp_customize,
			array(
				'type'              => 'checkbox',
				'name'              => 'travelstore_display_static_content',
				'default'           => true,
				'sanitize_callback' => 'travelstore_sanitize_checkbox',
				'description'       => esc_html__( 'Check to enable or display the content on static front page. Note: To enable travelstore sections, select "Homepage" template for your static homepage.', 'travelstore' ),
				'label'             => esc_html__( 'Display static contents?', 'travelstore' ),
				'section'           => 'static_front_page',
			)
		);

	}
	add_action( 'customize_register', 'travelstore_create_other_core_options' );
}
