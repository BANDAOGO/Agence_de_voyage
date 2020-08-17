<?php
/**
 * This is a file provides the section for the frontpage.
 *
 * For inner loops: @see ./itinerary-section-loops/trip-offers.php
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
$section_id     = 'travelstore_customizer_settings_trip_offers';
$enable_section = travelstore_get_theme_option( $panel_id, $section_id, 'enable_section' );

if ( ! $enable_section ) {
	return;
}

$section_title = travelstore_get_theme_option( $panel_id, $section_id, 'title' );

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

?>
<section class="storefront-product-section storefront-recent-products" aria-label="<?php esc_attr_e( 'Recent Products', 'travelstore' ); ?>">
	<?php if ( ! empty( $section_title ) ) { ?>
		<h2 class="section-title"><?php echo esc_html( $section_title ); ?></h2>
	<?php } ?>
	<div class="woocommerce columns-4 ">
		<ul class="products columns-4">

			<?php if ( 'none' !== $cta_id ) { ?>
			<li class="product product-pro-banner" style="background-image: url(<?php echo esc_url( $cta_thumbnail ); ?>);">
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
				<?php
			}
			get_template_part( 'sections/loops/trip-offers' );
			?>

		</ul>
	</div>
</section>
<?php
