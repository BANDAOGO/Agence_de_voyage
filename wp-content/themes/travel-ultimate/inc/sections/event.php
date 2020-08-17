<?php
/**
 * Event section
 *
 * This is the template for the content of event section
 *
 * @package Theme Palace
 * @subpackage Travel Ultimate
 * @since Travel Ultimate 1.0.0
 */
if ( ! function_exists( 'travel_ultimate_add_event_section' ) ) :
    /**
    * Add event section
    *
    *@since Travel Ultimate 1.0.0
    */
    function travel_ultimate_add_event_section() {
    	$options = travel_ultimate_get_theme_options();
        // Check if event is enabled on frontpage
        $event_enable = apply_filters( 'travel_ultimate_section_status', true, 'event_section_enable' );

        if ( true !== $event_enable ) {
            return false;
        }
        // Get event section details
        $section_details = array();
        $section_details = apply_filters( 'travel_ultimate_filter_event_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render event section now.
        travel_ultimate_render_event_section( $section_details );
    }
endif;

if ( ! function_exists( 'travel_ultimate_get_event_section_details' ) ) :
    /**
    * event section details.
    *
    * @since Travel Ultimate 1.0.0
    * @param array $input event section details.
    */
    function travel_ultimate_get_event_section_details( $input ) {
        $options = travel_ultimate_get_theme_options();        
        $content = array();
        
        $cat_id = ! empty( $options['event_content_category'] ) ? $options['event_content_category'] : '';
        $args = array(
            'post_type'         => 'post',
            'posts_per_page'    =>  3,
            'cat'               => absint( $cat_id ),
            'ignore_sticky_posts'   => true,
            );                    


        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['id']        = get_the_ID();
                $page_post['title']     = get_the_title();
                $page_post['url']       = get_the_permalink();
                $page_post['img']       = get_the_post_thumbnail_url( get_the_ID(), 'large' );
                $page_post['excerpt']   = travel_ultimate_trim_content( 15 );

                if ( ! empty( $page_post ) ) {
                    array_push( $content, $page_post );
                }
                // Push to the main array.
            endwhile;
        endif;
        wp_reset_postdata();

            
        if ( ! empty( $content ) ) {
            $input = $content;
        }
        return $input;
    }
endif;
// event section content details.
add_filter( 'travel_ultimate_filter_event_section_details', 'travel_ultimate_get_event_section_details' );


if ( ! function_exists( 'travel_ultimate_render_event_section' ) ) :
  /**
   * Start event section
   *
   * @return string event content
   * @since Travel Ultimate 1.0.0
   *
   */
   function travel_ultimate_render_event_section( $content_details = array() ) {
        $options = travel_ultimate_get_theme_options();
        $i=1;
        if ( empty( $content_details ) ) {
            return;
        } ?>

        <div id="latest-posts" class="relative page-section">
            <div class="wrapper">
                <div class="section-header">
                    <?php if ( ! empty( $options['event_title'] ) ) : ?>
                        <h2 class="section-title"><?php echo esc_html( $options['event_title'] ); ?></h2>
                    <?php endif; ?>
                </div><!-- .section-header -->

                 <div class="posts-slider classic-slider" data-slick='{"slidesToShow": 3, "slidesToScroll": 1, "infinite": true, "speed": 800, "dots": false, "arrows":true, "autoplay": true, "draggable": true, "fade": false }'>
                    <?php foreach ( $content_details as $content ) : ?>
                        <article>
                            <div class="post-item-wrapper">
                                <div class="featured-image" style="background-image: url('<?php echo esc_url( $content['img'] ); ?>');">
                                    <div class="overlay"></div>
                                    <?php if ( ! empty( $options['event_read_more_' . $i ] ) ) { ?>
                                        <div class="read-more">
                                            <a href="<?php echo esc_url( $content['url'] ); ?>" tabindex="-1">
                                                <?php echo travel_ultimate_get_svg( array( 'icon' => 'new-right' ) ); ?>
                                                <span><?php echo esc_html( $options['event_read_more_' . $i ] ); ?></span>
                                            </a>
                                        </div><!-- .read-more -->
                                    <?php } ?>

                                    <ul class="post-categories">
                                        <?php 
                                            $cats = get_the_category( $content['id'] );
                                            // foreach ( $cats as $cat ) { 
                                                ?>
                                                <li><a href="<?php echo esc_url( get_category_link( $cats[0]->term_id ) ); ?>"><?php echo esc_html( get_cat_name( $cats[0]->term_id ) ); ?></a></li>
                                        
                                    </ul><!-- .post-categories -->
                                </div>

                                <div class="entry-container">
                                    <div class="entry-meta before-title">
                                        <?php travel_ultimate_posted_on( $content['id'] ); ?>
                                    </div><!-- .entry-meta -->

                                    <header class="entry-header">
                                        <h2 class="entry-title"><a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></h2>
                                    </header>

                                    <div class="entry-content">
                                        <p><?php echo esc_html( $content['excerpt'] ); ?></p>
                                    </div><!-- .entry-content -->

                                    <div class="entry-meta after-title">
                                        <?php travel_ultimate_posted_on( $content['id'] ); ?>
                                    </div><!-- .entry-meta -->

                                    <?php if ( ! empty( $options['event_read_more_' . $i ] ) ) { ?>
                                        <div class="read-more">
                                            <a href="<?php echo esc_url( $content['url'] ); ?>" tabindex="-1">
                                                <?php echo travel_ultimate_get_svg( array( 'icon' => 'new-right' ) ); ?>
                                                <span><?php echo esc_html( $options['event_read_more_' . $i ] ); ?></span>
                                            </a>
                                        </div><!-- .read-more -->
                                    <?php } ?>
                                </div><!-- .entry-container -->
                            </div><!-- .post-item-wrapper -->
                        </article>
                    <?php $i++; endforeach; ?>
                </div><!-- .section-content -->
            </div><!-- .wrapper -->
        </div><!-- #travel-preparation -->
        
    <?php }
endif;