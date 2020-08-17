<?php
/**
 * This files handles the enqueuing of the necessary styles and scripts.
 *
 * @package travelstore
 * @subpackage /inc
 */

use plainview\sdk_broadcast\form2\validation\error;

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'travelstore_enqueue_styles_and_scripts' ) ) {

	/**
	 * Enqueue the registered styles and scripts.
	 */
	function travelstore_enqueue_styles_and_scripts() {
		$parent_dir_uri  = TRAVELSTORE_PARENT_DIR_URI;
		$parent_version  = TRAVELSTORE_PARENT_VERSION;
		$child_version   = TRAVELSTORE_CHILD_VERSION;
		$child_theme_uri = TRAVELSTORE_CHILD_DIR_URI;
		$suffix          = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '.' : '.min.';

		$args = array(
			'parent_dir_uri'  => $parent_dir_uri,
			'parent_version'  => $parent_version,
			'child_version'   => $child_version,
			'child_theme_uri' => $child_theme_uri,
			'suffix'          => $suffix,
		);

		travelstore_enqueue_styles( $args );

		travelstore_enqueue_scripts( $args );

	}
	add_action( 'wp_enqueue_scripts', 'travelstore_enqueue_styles_and_scripts' );
}

if ( ! function_exists( 'travelstore_enqueue_styles' ) ) {

	/**
	 * Enqueue all stylesheets.
	 *
	 * @param array $args Required arguments for theme.
	 */
	function travelstore_enqueue_styles( $args ) {
		$suffix          = ! empty( $args['suffix'] ) ? $args['suffix'] : '.min.';
		$child_version   = ! empty( $args['child_version'] ) ? $args['child_version'] : '1.0.0';
		$child_theme_uri = ! empty( $args['child_theme_uri'] ) ? $args['child_theme_uri'] : '1.0.0';

		wp_enqueue_style( 'travelstore-playfair-font', 'https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap', array(), '1.0.0' );
		wp_enqueue_style( 'travelstore-owl-carousel', $child_theme_uri . "/assets/css/owl.carousel{$suffix}css", array(), '2.3.4' );
		wp_enqueue_style( 'travelstore-main-style', $child_theme_uri . "/assets/css/main{$suffix}css", array( 'travelstore-owl-carousel' ), $child_version );
	}
}


if ( ! function_exists( 'travelstore_enqueue_scripts' ) ) {

	/**
	 * Enqueue all scripts.
	 *
	 * @param array $args Required arguments for theme.
	 */
	function travelstore_enqueue_scripts( $args ) {
		$suffix          = ! empty( $args['suffix'] ) ? $args['suffix'] : '.min.';
		$child_version   = ! empty( $args['child_version'] ) ? $args['child_version'] : '1.0.0';
		$child_theme_uri = ! empty( $args['child_theme_uri'] ) ? $args['child_theme_uri'] : '1.0.0';

		wp_enqueue_script( 'travelstore-owl-carousel', $child_theme_uri . "/assets/js/owl.carousel{$suffix}js", array( 'jquery' ), '2.3.4', true );
		wp_enqueue_script( 'travelstore-script', $child_theme_uri . "/assets/js/custom{$suffix}js", array( 'jquery' ), $child_version, true );
	}
}

if ( ! function_exists( 'travelstore_override_parent_default_colors' ) ) {

	/**
	 * Overrides the default colors.
	 */
	function travelstore_override_parent_default_colors( $args ) {

		if ( ! $args ) {
			return $args;
		}

		$args['storefront_header_link_color']       = '#ffffff';
		$args['storefront_hero_text_color']         = '#ffffff';
		$args['storefront_header_background_color'] = '#000000';
		$args['storefront_header_text_color']       = '#ffffff';
		return $args;
	}
	add_filter( 'storefront_setting_default_values', 'travelstore_override_parent_default_colors' );
}

if ( ! function_exists( 'travelstore_dynamic_styles' ) ) {

	/**
	 * Add dynamic styles to wp_head.
	 * It will help to match the appearance of child theme elements to match with parents.
	 */
	function travelstore_dynamic_styles() {
		global $storefront;

		if ( ! is_object( $storefront ) ||
			! property_exists( $storefront, 'customizer' ) ||
			! is_a( $storefront->customizer, 'Storefront_Customizer' ) ||
			! method_exists( $storefront->customizer, 'get_storefront_theme_mods' ) ) {
			return;
		}

		$storefront_theme_mods   = $storefront->customizer->get_storefront_theme_mods();
		$button_background_color = ! empty( $storefront_theme_mods['button_background_color'] ) ? $storefront_theme_mods['button_background_color'] : '';
		$button_text_color       = ! empty( $storefront_theme_mods['button_text_color'] ) ? $storefront_theme_mods['button_text_color'] : '';
		?>
		<style id="travelstore-dynamic-styles">

			h1, h2, h3, h4, h5, h6 {
				font-family: 'Dancing Script', cursive;
			}
			a.btn, .hero-inner .hero-carousel .owl-nav [class*="owl-"] {
				color: <?php echo esc_attr( $button_text_color ); ?>;
				background-color: <?php echo esc_attr( $button_background_color ); ?>;
			}

			/* Need to override the default value using important */
			input.button.wp-travel-apply-coupon-btn, button.btn_full.wp-travel-update-cart-btn.update-cart {
				color: <?php echo esc_attr( $button_text_color ); ?> !important;
				background-color: <?php echo esc_attr( $button_background_color ); ?> !important;
			}
		</style>
		<?php
	}
	add_action( 'wp_head', 'travelstore_dynamic_styles' );
}
