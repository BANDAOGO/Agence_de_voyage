<?php
/**
 * Itinerary Single Contnet Template
 *
 * This template can be overridden by copying it to yourtheme/wp-travel/content-single-itineraries.php.
 *
 * HOWEVER, on occasion wp-travel will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.wensolutions.com/document/template-structure/
 * @author      WenSolutions
 * @package     wp-travel/Templates
 * @since       1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $wp_travel_itinerary;
?>

<div class="wp-travel-trip-meta-info">
  	<ul>
		<?php
		$post_id = get_the_ID();
		/**
		 * @since 1.0.4
		 */
		do_action( '	wp_travel_single_trip_meta_list', $post_id );
		?>
  	    <li>
  	 		<div class="travel-info">
				<strong class="title"><?php esc_html_e( 'Trip Type', 'travel-ultimate' ); ?></strong>
			</div>
			<div class="travel-info">
				<span class="value">

				<?php
				$trip_types_list = $wp_travel_itinerary->get_trip_types_list();
				if ( $trip_types_list ) {
					echo wp_kses( $trip_types_list, wp_travel_allowed_html( array( 'a' ) ) );
				} else {
					echo esc_html( apply_filters( 'wp_travel_default_no_trip_type_text', __( 'No trip type', 'travel-ultimate' ) ) );
				}
				?>
				</span>
			</div>
  	 	</li>
  	 	<li>
		    <div class="travel-info">
				<strong class="title"><?php esc_html_e( 'Activities', 'travel-ultimate' ); ?></strong>
			</div>
		   <div class="travel-info">
				<span class="value">

				<?php
				$activity_list = $wp_travel_itinerary->get_activities_list();
				if ( $activity_list ) {
					echo wp_kses( $activity_list, wp_travel_allowed_html( array( 'a' ) ) );
				} else {
					echo esc_html( apply_filters( 'wp_travel_default_no_activity_text', __( 'No Activities', 'travel-ultimate' ) ) );
				}
				?>
				</span>
			</div>
  	 	</li>
  	 	<li>
  	 		<div class="travel-info">
				<strong class="title"><?php esc_html_e( 'Group Size', 'travel-ultimate' ); ?></strong>
			</div>
			<div class="travel-info">
				<span class="value">
					<?php
					if ( $group_size = $wp_travel_itinerary->get_group_size() ) {
							printf( apply_filters( 'wp_travel_template_group_size_text' ,__( '%d pax', 'travel-ultimate' ) ), esc_html( $group_size ) );
					} else {
						echo esc_html( apply_filters( 'wp_travel_default_group_size_text', __( 'No Size Limit', 'travel-ultimate' ) ) );
					}
					?>
				</span>
			</div>
  	 	</li>
		<?php
		/**
		 * @since 1.0.4
		 */
		do_action( 'wp_travel_single_trip_meta_list', $post_id );
		?>
  	</ul>
</div>

<?php
do_action( 'wp_travel_before_single_itinerary', get_the_ID() );
if ( post_password_required() ) {
	echo get_the_password_form();
	return;
}

do_action( 'wp_travel_before_content_start');
?>




<div id="inner-content-wrapper" class="wrapper page-section">
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
			<div id="itinerary-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="content entry-content">
					<div class="wp-travel trip-headline-wrapper clearfix">
				        <div class="wp-travel-feature-slide-content featured-detail-section right-plot">
							<div class="right-plot-inner-wrap">

								<?php do_action( 'wp_travel_before_single_title', get_the_ID() ) ?>
											
								<?php do_action( 'wp_travel_single_trip_after_title', get_the_ID() ) ?>
								<div class="trip-short-desc">
									<?php the_excerpt(); ?>
								</div>
							  	<div class="booking-form">
									<div class="wp-travel-booking-wrapper">
										<?php
										//Get Settings
										$settings = wp_travel_get_settings();

										$enquery_global_setting = isset( $settings['enable_trip_enquiry_option'] ) ? $settings['enable_trip_enquiry_option'] : 'yes';

										$global_enquiry_option = get_post_meta( $post_id, 'wp_travel_use_global_trip_enquiry_option', true );

										if ( '' === $global_enquiry_option  ) {
											$global_enquiry_option = 'yes';
										}
										if( 'yes' == $global_enquiry_option ) {

											$enable_enquiry = $enquery_global_setting;

										}
										else {
											$enable_enquiry = get_post_meta( $post_id, 'wp_travel_enable_trip_enquiry_option', true );
										}
										$wp_travel_itinerary_tabs = wp_travel_get_frontend_tabs();
										$booking_tab = $wp_travel_itinerary_tabs['booking'];

										if ( isset( $booking_tab['show_in_menu'] ) && 'yes' === $booking_tab['show_in_menu'] ) :	?>
										<button class="wp-travel-booknow-btn"><?php echo esc_html( apply_filters( 'wp_travel_template_book_now_text', __( 'Book Now', 'travel-ultimate' ) ) ); ?></button>
										<?php endif; ?>
										<?php if ( 'yes' == $enable_enquiry ) : ?>

											<a id="wp-travel-send-enquiries" class="wp-travel-send-enquiries" data-effect="mfp-move-from-top" href="#wp-travel-enquiries">
												<span class="wp-travel-booking-enquiry">
													<span class="dashicons dashicons-editor-help"></span>
													<span>
														<?php esc_html_e( 'Trip Enquiry', 'travel-ultimate'); ?>
													</span>
												</span>
											</a>
										<?php endif; ?>

									</div>
								</div>
								<?php
									if ( 'yes' == $enable_enquiry ) :
										wp_travel_get_enquiries_form();
									endif;
								?>
								<?php
								global $wp_travel_itinerary;
								if ( is_singular( WP_TRAVEL_POST_TYPE ) ) : ?>
									<div class="wp-travel-trip-code"><span><?php esc_html_e( 'Trip Code', 'travel-ultimate' ) ?> :</span><code><?php echo esc_html( $wp_travel_itinerary->get_trip_code() ) ?></code></div>
								<?php endif; ?>

							</div>
				       
				        </div>
				    </div>
				    <?php 
				    wp_travel_frontend_trip_facts( $post_id );

				    wp_travel_trip_map( $post_id );

				    do_action( 'wp_travel_single_trip_after_header', get_the_ID() ); 

				    /* TODO: Add global Settings to show/hide related post. */

				    $settings = wp_travel_get_settings();
				    $hide_related_itinerary = ( isset( $settings['hide_related_itinerary'] ) && '' !== $settings['hide_related_itinerary'] ) ? $settings['hide_related_itinerary'] : 'no';

				    if ( 'yes' === $hide_related_itinerary ) {
				    	return;
				    }
				    $currency_code 	= ( isset( $settings['currency'] ) ) ? $settings['currency'] : '';
				    $currency_symbol = wp_travel_get_currency_symbol( $currency_code );

				    // For use in the loop, list 5 post titles related to first tag on current post.
				    $terms = wp_get_object_terms( $post_id, 'itinerary_types' );

				    $no_related_post_message = '<p class="wp-travel-no-detail-found-msg">' . esc_html__( 'Related trip not found.', 'travel-ultimate' ) . '</p>';
				    ?>
				     <div class="wp-travel-related-posts wp-travel-container-wrap">
				     	<div class="section-header">
				     	    <span class="section-subtitle"><?php echo esc_html__( 'Other Trips', 'travel-ultimate' ); ?></span>
				     	    <h2 class="section-title"><?php echo apply_filters( 'wp_travel_related_post_title', esc_html__( 'Related Trips', 'travel-ultimate' ) ); ?></h2>
				     	</div><!-- .section-header -->
				    	<div class="wp-travel-itinerary-items"> 
				    		 <?php
				    	 	if ( ! empty( $terms ) ) {
				    			$term_ids = wp_list_pluck( $terms, 'term_id' );
				    			$col_per_row = apply_filters( 'wp_travel_related_itineraries_col_per_row' , '3' );
				    			$args = array(
				    				'post_type' => WP_TRAVEL_POST_TYPE,
				    				'post__not_in' => array( $post_id ),
				    				'posts_per_page' => $col_per_row,
				    				'tax_query' => array(
				    					array(
				    						'taxonomy' => 'itinerary_types',
				    						'field' => 'id',
				    						'terms' => $term_ids,
				    					),
				    				),
				    			);
				    			$query = new WP_Query( $args );
				    		if ( $query->have_posts() ) { ?>
				    			
				    			<ul style="grid-template-columns:repeat(<?php esc_attr( $col_per_row ) ?>, 1fr)" class="wp-travel-itinerary-list">
				    				<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				    					<?php wp_travel_get_template_part( 'shortcode/itinerary', 'item' ); ?>
				    				<?php endwhile; ?>
				    			</ul>
				    		<?php
				    		} else {
				    			wp_travel_get_template_part( 'shortcode/itinerary', 'item-none' );
				    		}
				    		wp_reset_query();
				     } else {
				    	wp_travel_get_template_part( 'shortcode/itinerary', 'item-none' );
				     }
				     ?>
				     </div>
				     </div>

				</div><!-- .summary -->
			</div><!-- #itinerary-<?php the_ID(); ?> -->
        </main><!-- #main -->
    </div><!-- #primary -->
</div><!-- #inner-content-wrapper-->

<?php do_action( 'wp_travel_after_single_itinerary', get_the_ID() ); ?>
