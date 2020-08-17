<?php
/**
 * This is a file provides the section for the frontpage.
 *
 * For inner loops: @see ./itinerary-section-loops/featured-trips.php
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
$section_id     = 'travelstore_customizer_settings_featured_trips';
$enable_section = travelstore_get_theme_option( $panel_id, $section_id, 'enable_section' );

if ( ! $enable_section ) {
	return;
}

$section_title = travelstore_get_theme_option( $panel_id, $section_id, 'title' );

$args = array(
	'post_type'      => 'itineraries',
	'post_status'    => 'publish',
	'posts_per_page' => -1,
	'meta_query'     => array( // phpcs:ignore
		array(
			'key'     => 'wp_travel_featured',
			'value'   => 'yes',
			'compare' => '=',
		),
	),
);

$the_query = new WP_Query( $args );
?>
<script type='text/javascript'>
/* <![CDATA[ */

/**
 * We are localizing the WP Travel Total Featured Trip counts here so that
 * we don't have to query again.
 */
var wpTravelTotalFeaturedTrips = parseInt(<?php echo ! empty( $the_query->post_count ) ? (int) esc_html( $the_query->post_count ) : 0; ?>)
/* ]]> */
</script>
<section id="featured-trip" class="storefront-product-section storefront-product-categories" aria-label="<?php esc_attr_e( 'Product Categories', 'travelstore' ); ?>">
	<?php if ( ! empty( $section_title ) ) { ?>
		<h2 class="section-title"><?php echo esc_html( $section_title ); ?></h2>
	<?php } ?>
	<div class="wp-travel-childtheme-storefront category-slider">
		<ul id="featured-trip-slider" class="content-slider products owl-carousel owl-theme">
			<?php
			if ( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					get_template_part( 'sections/loops/featured-trips' );
				}
			}
			?>
		</ul>
	</div>
</section>
<?php
wp_reset_postdata();
