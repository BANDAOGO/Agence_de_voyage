<?php
/**
 * Loop file for the itinerary-sections > banner-slider.php
 *
 * @package travelstore
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wp_travel_metas = travelstore_get_itinerary_meta();
$currency_code   = ! empty( $wp_travel_metas['prices']['currency_code'] ) ? $wp_travel_metas['prices']['currency_code'] : false;
$placeholder     = ! empty( $wp_travel_metas['thumbnails']['placeholder_url'] ) ? $wp_travel_metas['thumbnails']['placeholder_url'] : '';
$thumbnail       = ! empty( $wp_travel_metas['thumbnails']['url'] ) ? $wp_travel_metas['thumbnails']['url'] : $placeholder;

if ( 'post' === get_post_type() ) {
	$thumbnail = get_the_post_thumbnail_url();
}
?>
<div class="item">
	<img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php the_title(); ?>">
	<div class="carousel-caption text-center">
		<div class="container">
			<?php the_title( '<a href="' . esc_url( get_the_permalink() ) . '"><h2 class="slide-title">', '</h2></a>' ); ?>
			<?php the_excerpt(); ?>
			<?php
			if ( 'itineraries' === get_post_type() ) {
				?>
					<a href="<?php the_permalink(); ?>#booking" class="button product_type_simple"><?php esc_html_e( 'Book Now', 'travelstore' ); ?></a>
				<?php
			} else {
				?>
					<a href="<?php the_permalink(); ?>" class="button product_type_simple"><?php esc_html_e( 'Read More', 'travelstore' ); ?></a>
				<?php
			}
			?>
		</div>
	</div>
</div>
<?php
