<?php
/**
 * Theme Palace widgets inclusion
 *
 * This is the template that includes all custom widgets of Travel Ultimate
 *
 * @package Theme Palace
 * @subpackage Travel Ultimate
 * @since Travel Ultimate 1.0.0
 */

/*
 * Add social link widget
 */
require get_template_directory() . '/inc/widgets/social-link-widget.php';

/*
 * Add Latest Posts widget
 */
require get_template_directory() . '/inc/widgets/latest-posts-widget.php';


/**
 * Register widgets
 */
function travel_ultimate_register_widgets() {

	register_widget( 'travel_ultimate_Latest_Post' );

	register_widget( 'travel_ultimate_Social_Link' );

}
add_action( 'widgets_init', 'travel_ultimate_register_widgets' );