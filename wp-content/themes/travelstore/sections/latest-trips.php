<?php
/**
 * This is a file provides the section for the frontpage.
 *
 * For inner loops: @see ./itinerary-section-loops/latest-trips.php
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
$section_id     = 'travelstore_customizer_settings_latest_trips';
$enable_section = travelstore_get_theme_option( $panel_id, $section_id, 'enable_section' );

if ( ! $enable_section ) {
	return;
}

$section_title = travelstore_get_theme_option( $panel_id, $section_id, 'title' );
$taxonomy_name = travelstore_get_theme_option( $panel_id, $section_id, 'tax_dropdown' );


/**
 * CTA.
 */
$cta_id        = travelstore_get_theme_option( $panel_id, $section_id, 'section_cta' );
$cta_link      = travelstore_get_theme_option( $panel_id, $section_id, 'cta_link' );
$cta_title     = get_the_title( $cta_id );
$cta_excerpt   = get_the_excerpt( $cta_id );
$cta_thumbnail = get_the_post_thumbnail_url( $cta_id, 'large' );
$cta_btn_label = __( 'Read More', 'travelstore' );
$cta_btn_link  = get_the_permalink( $cta_id );

if ( 'trip_archive' === $cta_link ) {
	$cta_btn_label = __( 'Book More', 'travelstore' );
	$cta_btn_link  = get_site_url( '', '/itinerary' );
}

if ( 'custom' === $cta_link ) {
	$cta_btn_link = travelstore_get_theme_option( $panel_id, $section_id, 'cta_custom_link' );
}

$posttype = 'category' === $taxonomy_name ? 'post' : 'itineraries';

if ( 'none' === $taxonomy_name ) {
	$posttype = array( 'post', 'itineraries' );
}

$args = array(
	'post_type'      => $posttype,
	'post_status'    => 'publish',
	'posts_per_page' => 'none' !== $cta_id ? 3 : 4,
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
}

$the_query = new WP_Query( $args );

?>
<section class="storefront-product-section storefront-recent-products" aria-label="<?php esc_attr_e( 'Recent Products', 'travelstore' ); ?>">
	<?php if ( ! empty( $section_title ) ) { ?>
		<h2 class="section-title"><?php echo esc_html( $section_title ); ?></h2>
	<?php } ?>
	<div class="woocommerce columns-4 ">
		<ul class="products columns-4">

			<?php if ( 'none' !== $cta_id ) { ?>
			<li class="product product-pro-banner" style="background-image: url(<?php echo wp_kses_post( $cta_thumbnail ); ?>);">
				<div class="banner-caption">
					<a href="<?php echo esc_url( $cta_btn_link ); ?>">
						<?php if ( ! empty( $cta_title ) ) { ?>
							<h2 class="woocommerce-loop-product__title"><?php echo esc_html( $cta_title ); ?></h2>
						<?php } ?>
						<p><?php echo wp_kses_post( $cta_excerpt ); ?></p>
					</a>
					<a href="<?php echo esc_url( $cta_btn_link ); ?>" class="btn"><?php echo esc_html( $cta_btn_label ); ?></a>
				</div>
			</li>
			<?php } ?>

			<?php
			if ( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					set_query_var( 'total_trip_posts', $the_query->post_count );
					set_query_var( 'current_trip_index', $the_query->current_post );
					get_template_part( 'sections/loops/latest-trips' );
				}
			}
			?>

		</ul>
	</div>
</section>
<?php
wp_reset_postdata();
