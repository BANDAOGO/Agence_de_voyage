<?php
/**
 * Travelstore main functions and definitions.
 *
 * @link https://codex.wordpress.org/Child_Themes
 * @package travelstore
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$parent_dir_uri      = get_template_directory_uri();
$parent_version      = wp_get_theme( 'storefront' )->get( 'Version' );
$child_theme_dir     = get_stylesheet_directory();
$child_theme_version = wp_get_theme()->get( 'Version' );
$child_theme_dir_uri = get_stylesheet_directory_uri();

/**
 * Define constants.
 */
! defined( 'TRAVELSTORE_PARENT_VERSION' ) ? define( 'TRAVELSTORE_PARENT_VERSION', $parent_version ) : false;
! defined( 'TRAVELSTORE_PARENT_DIR_URI' ) ? define( 'TRAVELSTORE_PARENT_DIR_URI', $parent_dir_uri ) : false;
! defined( 'TRAVELSTORE_CHILD_DIR' ) ? define( 'TRAVELSTORE_CHILD_DIR', $child_theme_dir ) : false;
! defined( 'TRAVELSTORE_CHILD_VERSION' ) ? define( 'TRAVELSTORE_CHILD_VERSION', $child_theme_version ) : false;
! defined( 'TRAVELSTORE_CHILD_DIR_URI' ) ? define( 'TRAVELSTORE_CHILD_DIR_URI', $child_theme_dir_uri ) : false;

if ( ! function_exists( 'travelstore_after_setup_theme' ) ) {

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function travelstore_after_setup_theme() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 */
		load_theme_textdomain( 'travelstore', TRAVELSTORE_CHILD_DIR . '/languages' );
	}
	add_action( 'after_setup_theme', 'travelstore_after_setup_theme' );

}

if ( ! function_exists( 'travelstore_get_breadcrumb' ) ) {

	/**
	 * Returns the html for breadcrumbs.
	 */
	function travelstore_get_breadcrumb() {

		if ( class_exists( 'WooCommerce' ) ) {
			return;
		}

		if ( function_exists( 'yoast_breadcrumb' ) ) {
			return;
		}

		if ( ! function_exists( 'travelstore_breadcrumb_trail' ) || ! class_exists( 'Travelstore_Breadcrumb_Trail' ) ) {
			require_once get_stylesheet_directory() . '/inc/classes/travelstore-breadcrumb-class.php';
		}

		$breadcrumb = '';

		$args = array(
			'container'     => 'div',
			'show_on_front' => false,
			'show_browse'   => false,
			'echo'          => false,
		);

		$is_showable = travelstore_breadcrumb_trail( $args );

		$breadcrumb .= '<!-- Breadcrumb Starts -->';

		if ( $is_showable ) {
			$breadcrumb .= '<nav id="travelstore-breadcrumb">';
			$breadcrumb .= '<div class="container">';
			$breadcrumb .= travelstore_breadcrumb_trail( $args );
			$breadcrumb .= '</div>';
			$breadcrumb .= '</nav>';
		}

		$breadcrumb .= '<!-- Breadcrumb Ends -->';
		echo wp_kses_post( $breadcrumb );
	}
	add_action( 'storefront_before_content', 'travelstore_get_breadcrumb', 10 );
}


/**
 * Include files.
 */
function travelstore_include_files() {

	$file_paths = array(
		'inc/assets',
		'inc/helpers',
		'inc/customizer/customizer',
		'inc/itinerary-sections',
		'inc/tgm-plugin/tgmpa-hook',
	);

	$child_theme_dir = TRAVELSTORE_CHILD_DIR;

	foreach ( $file_paths as $file_path ) {

		/**
		 * If wp_normalize_path function exists then use it to normalize
		 * the filesystem path according to the operating systems
		 * else use as it is.
		 */
		if ( function_exists( 'wp_normalize_path' ) ) {
			require_once wp_normalize_path( "{$child_theme_dir}/{$file_path}.php" );
		} else {
			require_once "{$child_theme_dir}/{$file_path}.php";
		}
	}
}
travelstore_include_files();
