<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Theme Palace
 * @subpackage Travel Ultimate
 * @since Travel Ultimate 1.0.0
 */

/**
 * travel_ultimate_footer_primary_content hook
 *
 * @hooked travel_ultimate_add_contact_section -  10
 *
 */
do_action( 'travel_ultimate_footer_primary_content' );

/**
 * travel_ultimate_content_end_action hook
 *
 * @hooked travel_ultimate_content_end -  10
 *
 */
do_action( 'travel_ultimate_content_end_action' );

/**
 * travel_ultimate_content_end_action hook
 *
 * @hooked travel_ultimate_footer_start -  10
 * @hooked travel_ultimate_Footer_Widgets->add_footer_widgets -  20
 * @hooked travel_ultimate_footer_site_info -  40
 * @hooked travel_ultimate_footer_end -  100
 *
 */
do_action( 'travel_ultimate_footer' );

/**
 * travel_ultimate_page_end_action hook
 *
 * @hooked travel_ultimate_page_end -  10
 *
 */
do_action( 'travel_ultimate_page_end_action' ); 

?>

<?php wp_footer(); ?>

</body>
</html>
