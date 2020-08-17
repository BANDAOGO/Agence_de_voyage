<?php
	/**
	 * The header for our theme.
	 *
	 * This is the template that displays all of the <head> section and everything up until <div id="content">
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
	 *
	 * @package Theme Palace
	 * @subpackage Travel Ultimate
	 * @since Travel Ultimate 1.0.0
	 */

	/**
	 * travel_ultimate_doctype hook
	 *
	 * @hooked travel_ultimate_doctype -  10
	 *
	 */
	do_action( 'travel_ultimate_doctype' );

?>
<head>
<?php
	/**
	 * travel_ultimate_before_wp_head hook
	 *
	 * @hooked travel_ultimate_head -  10
	 *
	 */
	do_action( 'travel_ultimate_before_wp_head' );

	wp_head(); 
?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>

<?php
	/**
	 * travel_ultimate_page_start_action hook
	 *
	 * @hooked travel_ultimate_page_start -  10
	 *
	 */
	do_action( 'travel_ultimate_page_start_action' ); 

	/**
	 * travel_ultimate_loader_action hook
	 *
	 * @hooked travel_ultimate_loader -  10
	 *
	 */
	do_action( 'travel_ultimate_before_header' );

	/**
	 * travel_ultimate_header_action hook
	 *
	 * @hooked travel_ultimate_header_start -  10
	 * @hooked travel_ultimate_top_header -  20
	 * @hooked travel_ultimate_site_branding -  30
	 * @hooked travel_ultimate_site_navigation -  40
	 * @hooked travel_ultimate_header_end -  50
	 *
	 */
	do_action( 'travel_ultimate_header_action' );

	/**
	 * travel_ultimate_content_start_action hook
	 *
	 * @hooked travel_ultimate_content_start -  10
	 *
	 */
	do_action( 'travel_ultimate_content_start_action' );

	/**
	 * travel_ultimate_header_image_action hook
	 *
	 * @hooked travel_ultimate_header_image -  10
	 *
	 */
	do_action( 'travel_ultimate_header_image_action' );

    if ( travel_ultimate_is_frontpage() ) {
    	$i = 1;
    	$sections = travel_ultimate_sortable_sections();
		foreach ( $sections as $section => $value ) {
			add_action( 'travel_ultimate_primary_content', 'travel_ultimate_add_'. $section .'_section', $i . 0 );
		}
		do_action( 'travel_ultimate_primary_content' );
	} 