<?php
/**
 * This is a section file for the Customer Reviews section.
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
$section_id     = 'travelstore_customizer_settings_customer_reviews';
$enable_section = travelstore_get_theme_option( $panel_id, $section_id, 'enable_section' );

if ( ! $enable_section ) {
	return;
}

$section_title = travelstore_get_theme_option( $panel_id, $section_id, 'title' );
?>

<div class="storefront-product-section storefront-reviews">
	<div class="woocommerce columns-2">
		<?php if ( ! empty( $section_title ) ) { ?>
			<h2 class="section-title">
				<span><?php echo esc_html( $section_title ); ?></span>
			</h2>
		<?php } ?>
		<ul id="review-slider" class="content-slider review product-reviews owl-carousel">
			<?php
				get_template_part( 'sections/loops/customer-reviews' );
			?>
		</ul>
	</div>
</div>
