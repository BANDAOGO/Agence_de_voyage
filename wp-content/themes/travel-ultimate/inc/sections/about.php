<?php
/**
 * About section
 *
 * This is the template for the content of about section
 *
 * @package Theme Palace
 * @subpackage Travel Ultimate
 * @since Travel Ultimate 1.0.0
 */
if ( ! function_exists( 'travel_ultimate_add_about_section' ) ) :
    /**
    * Add about section
    *
    *@since Travel Ultimate 1.0.0
    */
    function travel_ultimate_add_about_section() {
    	$options = travel_ultimate_get_theme_options();
        // Check if about is enabled on frontpage
        $about_enable = apply_filters( 'travel_ultimate_section_status', true, 'about_section_enable' );

        if ( true !== $about_enable ) {
            return false;
        }
        // Get about section details
        $section_details = array();
        $section_details = apply_filters( 'travel_ultimate_filter_about_section_details', $section_details );

        $tour_details = array();
        $tour_details = apply_filters( 'travel_ultimate_filter_tour_section_details', $tour_details );

        if ( empty( $section_details ) && empty( $tour_details ) ) {
            return;
        }

        // Render about section now.
        travel_ultimate_render_about_section( $section_details, $tour_details );
    }
endif;

if ( ! function_exists( 'travel_ultimate_get_about_section_details' ) ) :
    /**
    * about section details.
    *
    * @since Travel Ultimate 1.0.0
    * @param array $input about section details.
    */
    function travel_ultimate_get_about_section_details( $input ) {
        $options = travel_ultimate_get_theme_options();

        $content = array();
        $page_id = ! empty( $options['about_content_page'] ) ? $options['about_content_page'] : '';
        $args = array(
            'post_type'         => 'page',
            'page_id'           => $page_id,
            'posts_per_page'    => 1,
            );                    

            // Run The Loop.
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) : 
                while ( $query->have_posts() ) : $query->the_post();
                    $page_post['title']     = get_the_title();
                    $page_post['excerpt']   = travel_ultimate_trim_content( 50 );

                    if ( ! empty( $page_post ) ) {
                        // Push to the main array.
                        array_push( $content, $page_post );
                    }
                endwhile;
            endif;
            wp_reset_postdata();
            
        if ( ! empty( $content ) ) {
            $input = $content;
        }
        return $input;
    }
endif;
// about section content details.
add_filter( 'travel_ultimate_filter_about_section_details', 'travel_ultimate_get_about_section_details' );

if ( ! function_exists( 'travel_ultimate_get_tour_section_details' ) ) :
    /**
    * about section details.
    *
    * @since Travel Ultimate 1.0.0
    * @param array $input about section details.
    */
        function travel_ultimate_get_tour_section_details( $input ) {
        $options = travel_ultimate_get_theme_options();
        // Content type.
        $tour_content_type  = $options['tour_content_type'];
        
        $content = array();
        switch ( $tour_content_type ) {
            
            case 'cat':
                $cat = array();
                for ( $i = 1; $i <= 4; $i++ ) {
                    if ( ! empty( $options['tour_cat_' . $i] ) ){
                        $cat_id = $options['tour_cat_' . $i];
                        $term = get_term( $cat_id, 'category' );
                        $cat['count'] = $term->count;
                        $cat['name'] = $term->name;
                        $cat['url'] = get_term_link( $cat_id, 'category' );
                    }
                    if ( ! empty( $cat ) ) {
                        // Push to the main array.
                        array_push( $content, $cat );
                    }
                }
            break;

            case 'trip-types':
                $trip_type = array();
                for ( $i = 1; $i <= 4; $i++ ) {
                    if ( ! empty( $options['tour_trip_' . $i] ) ){
                        $trip_id = $options['tour_trip_' . $i];
                        $term = get_term( $trip_id, 'itinerary_types' );
                        $trip_type['count'] = $term->count;
                        $trip_type['name'] = $term->name;
                        $trip_type['url'] = get_term_link( $trip_id, 'itinerary_types' );
                        
                        if ( ! empty( $trip_type ) ) {
                            array_push( $content, $trip_type );
                        }
                    }
                }  
            break;

            default:
            break;
        }

        if ( ! empty( $content ) ) {
            $input = $content;
        }
        return $input;
    }
endif;
// about section content details.
add_filter( 'travel_ultimate_filter_tour_section_details', 'travel_ultimate_get_tour_section_details' );


if ( ! function_exists( 'travel_ultimate_render_about_section' ) ) :
  /**
   * Start about section
   *
   * @return string about content
   * @since Travel Ultimate 1.0.0
   *
   */
   function travel_ultimate_render_about_section( $content_details = array(), $tour_details = array() ) {
        $options = travel_ultimate_get_theme_options();

        if ( empty( $content_details ) && empty( $tour_details ) ) {
            return;
        } 
        ?>
        
       <div id="about-us" class="relative page-section" style="background-image: url(<?php echo esc_url(get_template_directory_uri() . '/assets/uploads/gray-pattern.png'); ?>);">

            <?php if ( ! empty( $content_details ) ) { ?>
                <div class="wrapper">
                    <?php foreach ( $content_details as $content ) : ?>
                        <div class="header-content-wrapper clear">
                            <div class="section-header">
                                <?php if ( ! empty( $content['title'] ) ) : ?>
                                    <h2 class="section-title"><?php echo esc_html( $content['title'] ); ?></h2>
                                <?php endif; ?>
                            </div><!-- .section-header -->

                            <?php if ( ! empty( $content['excerpt'] ) ) : ?>
                                <div class="section-content">
                                    <p><?php echo wp_kses_post( $content['excerpt'] ); ?></p>
                                </div><!-- .section-content -->
                            <?php endif; ?>
                        </div><!-- .header-content-wrapper -->
                    <?php endforeach; ?>
                </div><!-- .wrapper -->
            <?php }; ?>

            <?php if ( ! empty( $tour_details ) ) { ?>
                <!-- use classes "classic-slider and modern-slider" -->
                <div class="tours-slider classic-slider" data-slick='{"slidesToShow": 4, "slidesToScroll": 1, "infinite": true, "speed": 1000, "dots": false, "arrows":true, "autoplay": false, "draggable": true, "fade": false }'>
                    <?php 
                    $i = 1;
                    foreach ( $tour_details as $tour ) : 
                        $img = ( ! empty( $options['tour_image_' . $i ] ) ) ? $options['tour_image_' . $i ] : '';
                        ?>
                        <article>
                            <div class="tour-item-wrapper" style="background-image: url('<?php echo esc_url( $img ); ?>');">
                                <header class="entry-header">
                                    <h2 class="entry-title">
                                        <?php if ( ! empty( $tour['name'] ) ) { ?>
                                            <a href="<?php echo esc_url( $tour['url'] ); ?>">
                                                <?php echo esc_html( $tour['name'] ); ?>
                                            </a>
                                        <?php } ?>
                                    </h2>
                                    <?php if ( ! empty( $tour['count'] ) ) { ?>
                                        <span><?php echo absint( $tour['count'] ) . esc_html__( ' Trips', 'travel-ultimate' ); ?></span>
                                    <?php } ?>
                                </header>
                            </div><!-- .tour-item-wrapper -->
                        </article>
                    <?php 
                    $i++;
                    endforeach; ?>
                </div><!-- .tours-slider -->
            <?php } ?>
        </div><!-- #skills -->

    <?php
    }
endif;