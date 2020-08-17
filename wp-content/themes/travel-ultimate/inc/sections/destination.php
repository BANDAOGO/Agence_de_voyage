<?php
/**
 * Destination section
 *
 * This is the template for the content of destination section
 *
 * @package Theme Palace
 * @subpackage Travel Ultimate
 * @since Travel Ultimate 1.0.0
 */
if ( ! function_exists( 'travel_ultimate_add_destination_section' ) ) :
    /**
    * Add destination section
    *
    *@since Travel Ultimate 1.0.0
    */
    function travel_ultimate_add_destination_section() {
    	$options = travel_ultimate_get_theme_options();
        // Check if destination is enabled on frontpage
        $destination_enable = apply_filters( 'travel_ultimate_section_status', true, 'destination_section_enable' );

        if ( true !== $destination_enable ) {
            return false;
        }
        // Get destination section details
        $section_details = array();
        $section_details = apply_filters( 'travel_ultimate_filter_destination_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render destination section now.
        travel_ultimate_render_destination_section( $section_details );
    }
endif;

if ( ! function_exists( 'travel_ultimate_get_destination_section_details' ) ) :
    /**
    * destination section details.
    *
    * @since Travel Ultimate 1.0.0
    * @param array $input destination section details.
    */
    function travel_ultimate_get_destination_section_details( $input ) {
        $options = travel_ultimate_get_theme_options();

        // Content type.
        $destination_content_type  = $options['destination_content_type'];
        $destination_count = ! empty( $options['destination_count'] ) ? $options['destination_count'] : 2;
        
        $content = array();
        switch ( $destination_content_type ) {
        	
            case 'page':
                $page_ids = array();

                for ( $i = 1; $i <= 2; $i++ ) {
                    if ( ! empty( $options['destination_content_page_' . $i] ) )
                        $page_ids[] = $options['destination_content_page_' . $i];
                }
                
                $args = array(
                    'post_type'         => 'page',
                    'post__in'          => ( array ) $page_ids,
                    'posts_per_page'    => 2,
                    'orderby'           => 'post__in',
                    );                    
            break;

            case 'destination':

                if ( ! class_exists( 'WP_Travel' ) )
                    return;
                
                $dest_id = ! empty( $options['dest_destinations'] ) ? $options['dest_destinations'] : '';
                $args = array(
                    'post_type'         => 'itineraries',
                    'posts_per_page'    => 2,
                    'ignore_sticky_posts'   => true,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'travel_locations',
                            'field' => 'term_id',
                            'terms'  => $dest_id,
                        )
                    ),
                );                    
            break;

            default:
            break;
        }


        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['id']        = get_the_ID();
                $page_post['title']     = get_the_title();
                $page_post['url']       = get_the_permalink();
                $page_post['img']       = get_the_post_thumbnail_url( get_the_ID(), 'large' );
                $page_post['excerpt']   = travel_ultimate_trim_content( 15 );

                // Push to the main array.
                array_push( $content, $page_post );
            endwhile;
        endif;
        wp_reset_postdata();

            
        if ( ! empty( $content ) ) {
            $input = $content;
        }
        return $input;
    }
endif;
// destination section content details.
add_filter( 'travel_ultimate_filter_destination_section_details', 'travel_ultimate_get_destination_section_details' );


if ( ! function_exists( 'travel_ultimate_render_destination_section' ) ) :
  /**
   * Start destination section
   *
   * @return string destination content
   * @since Travel Ultimate 1.0.0
   *
   */
   function travel_ultimate_render_destination_section( $content_details = array() ) {
        $options = travel_ultimate_get_theme_options();
        $content_type = $options['destination_content_type'];
        $i = 1;        

        if ( empty( $content_details ) ) {
            return;
        } ?>

        <div id="travel-destinations" class="relative page-section">
            <div class="wrapper">
                <div class="section-header">
                    <?php if ( ! empty( $options['destination_title'] ) ) : ?>
                        <h2 class="section-title"><?php echo esc_html( $options['destination_title'] ); ?></h2>
                    <?php endif; ?>
                </div><!-- .section-header -->

                <div class="section-content clear col-2">
                    <?php foreach ( $content_details as $content ) : ?>
                        <article>
                            <div class="destination-item-wrapper">
                                <div class="featured-image" style="background-image: url('<?php echo esc_url( $content['img'] ); ?>');">
                                    <?php if ( ( 'trip' == $content_type || 'destination' == $content_type ) && class_exists( 'WP_Travel' ) ) { 
                                        $trip_price = wp_travel_get_price( $content['id'] );
                                        $settings        = wp_travel_get_settings();
                                        $currency_code   = ( isset( $settings['currency'] ) ) ? $settings['currency'] : '';
                                        $currency_symbol = wp_travel_get_currency_symbol( $currency_code );
                                        ?>
                                        <div class="entry-meta">
                                            <span class="trip-price">                       
                                                <span class="current-price"><?php echo esc_html( $currency_symbol ) . esc_html( $trip_price ); ?></span>
                                            </span><!-- .trip-price -->
                                        </div><!-- .entry-meta -->
                                    <?php } ?>
                                </div><!-- .featured-image -->

                                <div class="entry-container">
                                    <header class="entry-header">
                                        <h2 class="entry-title"><a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></h2>
                                    </header>

                                    <div class="entry-content">
                                        <p><?php echo esc_html( $content['excerpt'] ); ?></p>
                                    </div><!-- .entry-content -->
                                </div><!-- .entry-container -->
                            </div><!-- .destination-item-wrapper -->
                        </article>
                    <?php $i++; endforeach; ?>
                </div><!-- .section-content -->
            </div><!-- .wrapper -->
        </div><!-- #travel-preparation -->
        
    <?php }
endif;