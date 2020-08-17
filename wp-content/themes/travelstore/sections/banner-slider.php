<?php
/**
 * This is a file provides the section for the frontpage.
 *
 * For inner loops: @see ./itinerary-section-loops/banner-slider.php
 *
 * @package travelstore
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$panel_id       = 'travelstore_settings';
$section_id     = 'travelstore_customizer_settings_banner_slider';
$enable_section = travelstore_get_theme_option( $panel_id, $section_id, 'enable_section' );

if ( ! $enable_section ) {
	return;
}

$section_title = travelstore_get_theme_option( $panel_id, $section_id, 'title' );
$taxonomy_name = travelstore_get_theme_option( $panel_id, $section_id, 'tax_dropdown' );

$posttype = 'category' === $taxonomy_name ? 'post' : 'itineraries';

if ( 'none' === $taxonomy_name ) {
	$posttype = array( 'post', 'itineraries' );
}

$args = array(
	'post_type'      => $posttype,
	'post_status'    => 'publish',
	'posts_per_page' => 5,
);

if ( 'none' !== $taxonomy_name ) {
	$terms = get_terms(
		array(
			'taxonomy'   => $taxonomy_name,
			'hide_empty' => false,
		)
	);

	$itinerary_term[] = travelstore_get_theme_option( $panel_id, $section_id, "{$taxonomy_name}_term" );

	$args['tax_query'] = array( // phpcs:ignore
		array(
			'taxonomy' => $taxonomy_name,
			'terms'    => $itinerary_term,
			'field'    => 'slug',
		),
	);
} else {
	$args['orderby'] = 'rand';
}

$the_query = new WP_Query( $args );
?>
<section class='storefront-hero-section'>
	<div class= 'hero-inner'>
		<div class='hero-carousel owl-carousel sr-carousel'>

		<?php
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				get_template_part( 'sections/loops/banner-slider' );
			}
		}
		?>
		</div>
	</div>
</section>
<?php
wp_reset_postdata();
