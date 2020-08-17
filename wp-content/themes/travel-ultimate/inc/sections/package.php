<?php
/**
 * Package section
 *
 * This is the template for the content of package section
 *
 * @package Theme Palace
 * @subpackage Travel Ultimate
 * @since Travel Ultimate 1.0.0
 */
if ( ! function_exists( 'travel_ultimate_add_package_section' ) ) :
    /**
    * Add package section
    *
    *@since Travel Ultimate 1.0.0
    */
    function travel_ultimate_add_package_section() {
    	$options = travel_ultimate_get_theme_options();
        // Check if package is enabled on frontpage
        $package_enable = apply_filters( 'travel_ultimate_section_status', true, 'package_section_enable' );

        if ( true !== $package_enable ) {
            return false;
        }
        // Get package section details
        $section_details = array();
        $section_details = apply_filters( 'travel_ultimate_filter_package_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render package section now.
        travel_ultimate_render_package_section( $section_details );
    }
endif;

if ( ! function_exists( 'travel_ultimate_get_package_section_details' ) ) :
    /**
    * package section details.
    *
    * @since Travel Ultimate 1.0.0
    * @param array $input package section details.
    */
    function travel_ultimate_get_package_section_details( $input ) {
        $options = travel_ultimate_get_theme_options();

        // Content type.
        $package_content_type  = $options['package_content_type'];
        
        $content = array();
        switch ( $package_content_type ) {
        	
            case 'page':
                $page_ids = array();

                for ( $i = 1; $i <= 3; $i++ ) {
                    if ( ! empty( $options['package_content_page_' . $i] ) )
                        $page_ids[] = $options['package_content_page_' . $i];
                }
                
                $args = array(
                    'post_type'         => 'page',
                    'post__in'          => ( array ) $page_ids,
                    'posts_per_page'    => 3,
                    'orderby'           => 'post__in',
                    );                    
            break;

            case 'trip':

                if ( ! class_exists( 'WP_Travel' ) )
                    return;
                
                $trip_ids = array();

                for ( $i = 1; $i <= 3; $i++ ) {
                    if ( ! empty( $options['package_content_trip_' . $i] ) )
                        $trip_ids[] = $options['package_content_trip_' . $i];
                }
                
                $args = array(
                    'post_type'         => 'itineraries',
                    'post__in'          => ( array ) $trip_ids,
                    'posts_per_page'    => 3,
                    'orderby'           => 'post__in',
                    'ignore_sticky_posts'   => true,
                    );                    
            break;

            default:
            break;
        }


            // Run The Loop.
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) : 
                while ( $query->have_posts() ) : $query->the_post();
                    $page_post['id']     = get_the_ID();
                    $page_post['title']     = get_the_title();
                    $page_post['url']       = get_the_permalink();
                    $page_post['img']       = get_the_post_thumbnail_url( get_the_ID(),  'large' );
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
// package section content details.
add_filter( 'travel_ultimate_filter_package_section_details', 'travel_ultimate_get_package_section_details' );


if ( ! function_exists( 'travel_ultimate_render_package_section' ) ) :
  /**
   * Start package section
   *
   * @return string package content
   * @since Travel Ultimate 1.0.0
   *
   */
   function travel_ultimate_render_package_section( $content_details = array() ) {
        $options = travel_ultimate_get_theme_options();
        $content_type = $options['package_content_type'];
        $i = 1;        

        if ( empty( $content_details ) ) {
            return;
        } ?>

        <div id="recommended-packages" class="relative page-section">
            <div class="wrapper">
                <div class="section-header align-center">
                    <?php if ( ! empty( $options['package_sub_title'] ) ) : ?>
                        <span class="section-subtitle"><?php echo esc_html( $options['package_sub_title'] ); ?></span>
                    <?php endif; ?>

                    <?php if ( ! empty( $options['package_title'] ) ) : ?>
                        <h2 class="section-title"><?php echo esc_html( $options['package_title'] ); ?></h2>
                    <?php endif; ?>
                </div><!-- .section-header -->

                <div class="section-content clear col-3">
                    <?php 
                    $i = 1;
                    foreach ( $content_details as $content ) : ?>
                        <article class="has-post-thumbnail">
                            <div class="package-wrapper">
                                <div class="featured-image" style="background-image: url('<?php echo esc_url( $content['img'] ); ?>');">
                                    <?php if ( 'trip' === $content_type && class_exists( 'WP_Travel' ) ) { ?>
                                        <div class="clearfix">
                                            <?php wp_travel_single_trip_rating( $content['id'] );  ?>
                                        </div><!-- .clearfix -->
                                    <?php } ?>
                                </div><!-- .featured-image -->

                                <div class="entry-container">
                                    <span class="location">
                                        <?php 
                                        if ( 'trip' === $content_type ) { 
                                            $terms = get_the_terms( $content['id'], 'travel_locations' );
                                            if ( is_array( $terms ) && count( $terms ) > 0 ) {
                                                foreach ( $terms as $term ) {
                                                ?>
                                                <a href="<?php echo esc_url( get_term_link( $term->term_id ) ) ?>"><?php echo esc_html( $term->name ); ?></a>
                                                <?php 
                                                }
                                            } 
                                        } elseif ( 'page' != $content_type ) {
                                            $cats = get_the_category( $content['id'] );
                                            foreach ( $cats as $cat ) { 
                                                ?>
                                                <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>"><?php echo esc_html( get_cat_name( $cat->term_id ) ); ?></a>
                                        <?php 
                                            } 
                                        }
                                        ?>
                                    </span>

                                    <h4 class="post-title"><a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></h4>

                                    <div class="trip-metas clear">
                                        <div class="wp-travel-trip-time trip-fixed-departure">
                                            <?php if ( 'trip' === $content_type && class_exists( 'WP_Travel' ) ) {
                                                wp_travel_get_trip_duration( $content['id'] );
                                            } else {
                                                echo '<i class="fa fa-calendar"></i>';
                                                echo esc_html( get_the_date( get_option( 'date_format' ), $content['id'] ) );
                                            }
                                            ?>
                                        </div>

                                        <?php if ( 'trip' === $content_type && class_exists( 'WP_Travel' ) ) { 
                                            $trip_price = wp_travel_get_price( $content['id'] );
                                            $settings        = wp_travel_get_settings();
                                            $currency_code   = ( isset( $settings['currency'] ) ) ? $settings['currency'] : '';
                                            $currency_symbol = wp_travel_get_currency_symbol( $currency_code );
                                            
                                            ?>
                                            <div class="price-meta">
                                                <span><span class="trip-price"><?php echo esc_html( $currency_symbol ) . esc_html( $trip_price ); ?></span></span><!-- .trip-price -->
                                            </div><!-- .price-meta -->
                                        <?php } ?>
                                    </div><!-- .trip-metas -->
                                </div><!-- .entry-container -->
                            </div><!-- .package-wrapper -->
                        </article>
                    <?php $i++; 
                    endforeach; ?>
                </div><!-- .packages-content -->   
            </div><!-- wrapper -->
        </div><!-- packages -->
        
    <?php }
endif;