<?php
/**
 * Testimonial section
 *
 * This is the template for the content of testimonial section
 *
 * @package Theme Palace
 * @subpackage Travel Ultimate
 * @since Travel Ultimate 1.0.0
 */
if ( ! function_exists( 'travel_ultimate_add_testimonial_section' ) ) :
    /**
    * Add testimonial section
    *
    *@since Travel Ultimate 1.0.0
    */
    function travel_ultimate_add_testimonial_section() {
    	$options = travel_ultimate_get_theme_options();
        // Check if testimonial is enabled on frontpage
        $testimonial_enable = apply_filters( 'travel_ultimate_section_status', true, 'testimonial_section_enable' );

        if ( true !== $testimonial_enable ) {
            return false;
        }
        // Get testimonial section details
        $section_details = array();
        $section_details = apply_filters( 'travel_ultimate_filter_testimonial_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render testimonial section now.
        travel_ultimate_render_testimonial_section( $section_details );
    }
endif;

if ( ! function_exists( 'travel_ultimate_get_testimonial_section_details' ) ) :
    /**
    * testimonial section details.
    *
    * @since Travel Ultimate 1.0.0
    * @param array $input testimonial section details.
    */
    function travel_ultimate_get_testimonial_section_details( $input ) {
        $options = travel_ultimate_get_theme_options();
        
        $content = array();
        $page_ids = array();


        for ( $i = 1; $i <= 3; $i++ ) {
            if ( ! empty( $options['testimonial_content_page_' . $i] ) ) :
                $page_ids[] = $options['testimonial_content_page_' . $i];

            endif;
        }
        
        $args = array(
            'post_type'         => 'page',
            'post__in'          => ( array ) $page_ids,
            'posts_per_page'    => 3,
            'orderby'           => 'post__in',
            );                    
        

            // Run The Loop.
            $query = new WP_Query( $args );
            $i = 0;
            if ( $query->have_posts() ) : 
                while ( $query->have_posts() ) : $query->the_post();
                    $page_post['title']     = get_the_title();
                    $page_post['url']       = get_the_permalink();
                    $page_post['excerpt']   = travel_ultimate_trim_content( 20 );
                    $page_post['image']  	= has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'thumbnail' ) : '';

                    // Push to the main array.
                    array_push( $content, $page_post );
                    $i++;
                endwhile;
            endif;
            wp_reset_postdata();
            
        if ( ! empty( $content ) ) {
            $input = $content;
        }
        return $input;
    }
endif;
// testimonial section content details.
add_filter( 'travel_ultimate_filter_testimonial_section_details', 'travel_ultimate_get_testimonial_section_details' );


if ( ! function_exists( 'travel_ultimate_render_testimonial_section' ) ) :
  /**
   * Start testimonial section
   *
   * @return string testimonial content
   * @since Travel Ultimate 1.0.0
   *
   */
   function travel_ultimate_render_testimonial_section( $content_details = array() ) {
        $options = travel_ultimate_get_theme_options();
        if ( empty( $content_details ) ) {
            return;
        } ?>

        <div id="client-testimonial" class="relative page-section" style="background-image: url(<?php echo esc_url(get_template_directory_uri() . '/assets/uploads/gray-pattern.png'); ?> );">
                <div class="wrapper">
                    <div class="section-header">
                        <?php if ( ! empty( $options['testimonial_title'] ) ) : ?>
                            <h2 class="section-title"><?php echo esc_html( $options['testimonial_title'] ); ?></h2>
                        <?php endif; ?>
                    </div><!-- .section-header -->

                    <!-- supports col-1, col-2, col-3 -->
                    <div class="section-content clear col-3">
                        <?php foreach ( $content_details as $content ) : ?>
                            <article>
                                <div class="image-title-wrapper clear">
                                    <?php if ( ! empty( $content['image'] ) ) : ?>
                                        <img src="<?php echo esc_url( $content['image'] ); ?>">
                                    <?php endif; ?>

                                    <header class="entry-header">
                                        <?php if ( ! empty( $content['title'] ) ) : ?>
                                            <h2 class="entry-title"><a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></h2>
                                        <?php endif; ?>
                                    </header>
                                </div><!-- .image-title-wrapper -->
                                

                                <?php if ( ! empty( $content['excerpt'] ) ) : ?>
                                    <div class="entry-content">
                                        <p><?php echo wp_kses_post( $content['excerpt'] ); ?></p>
                                    </div><!-- .entry-content -->
                                <?php endif; ?>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div><!-- .wrapper -->
            </div><!-- #clients-section -->

    <?php }
endif;