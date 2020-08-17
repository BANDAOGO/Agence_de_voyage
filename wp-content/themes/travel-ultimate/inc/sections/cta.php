<?php
/**
 * CTA section
 *
 * This is the template for the content of cta section
 *
 * @package Theme Palace
 * @subpackage Travel Ultimate
 * @since Travel Ultimate 1.0.0
 */
if ( ! function_exists( 'travel_ultimate_add_cta_section' ) ) :
    /**
    * Add cta section
    *
    *@since Travel Ultimate 1.0.0
    */
    function travel_ultimate_add_cta_section() {
    	$options = travel_ultimate_get_theme_options();
        // Check if cta is enabled on frontpage
        $cta_enable = apply_filters( 'travel_ultimate_section_status', true, 'cta_section_enable' );

        if ( true !== $cta_enable ) {
            return false;
        }
        // Get cta section details
        $section_details = array();
        $section_details = apply_filters( 'travel_ultimate_filter_cta_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render cta section now.
        travel_ultimate_render_cta_section( $section_details );
    }
endif;

if ( ! function_exists( 'travel_ultimate_get_cta_section_details' ) ) :
    /**
    * cta section details.
    *
    * @since Travel Ultimate 1.0.0
    * @param array $input cta section details.
    */
    function travel_ultimate_get_cta_section_details( $input ) {
        $options = travel_ultimate_get_theme_options();
        $content = array();
        $page_id = ! empty( $options['cta_content_page'] ) ? $options['cta_content_page'] : '';
        $args = array(
            'post_type'         => 'page',
            'page_id'           => $page_id,
            'posts_per_page'    => 1,
        );
            
        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['id']        = get_the_id();
                $page_post['title']     = get_the_title();
                $page_post['url']       = get_the_permalink();
                $page_post['excerpt']   = travel_ultimate_trim_content( 25 );
                $page_post['image']  	= has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'large' ) : '';

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
// cta section content details.
add_filter( 'travel_ultimate_filter_cta_section_details', 'travel_ultimate_get_cta_section_details' );


if ( ! function_exists( 'travel_ultimate_render_cta_section' ) ) :
  /**
   * Start cta section
   *
   * @return string cta content
   * @since Travel Ultimate 1.0.0
   *
   */
   function travel_ultimate_render_cta_section( $content_details = array() ) {
        $options = travel_ultimate_get_theme_options();
        $btn_label = ! empty( $options['cta_btn_label'] ) ? $options['cta_btn_label'] : esc_html__( 'Learn More', 'travel-ultimate' );

        if ( empty( $content_details ) ) {
            return;
        } ?>

        <div id="call-to-action" class="relative page-section">
                <div class="wrapper">
                    <?php foreach ( $content_details as $content ) : ?>
                        <article class="<?php echo ! empty( $content['image'] ) ? 'has' : 'no'; ?>-post-thumbnail">
                            <div class="featured-image" style="background-image: url('<?php echo esc_url( $content['image'] ); ?>');">
                            </div>

                            <div class="entry-container">

                                <header class="entry-header">
                                    <h2 class="entry-title"><?php echo esc_html( $content['title'] ); ?></h2>
                                </header>

                                <div class="entry-content">
                                    <p><?php echo wp_kses_post( $content['excerpt'] ); ?></p>
                                </div><!-- .entry-content -->                                

                                <?php if ( ! empty( $options['cta_btn_label'] ) ) : ?>
                                    <div class="view-all">
                                        <a href="<?php echo esc_url( $content['url'] ); ?>" class="btn"><?php echo esc_html( $options['cta_btn_label'] ); ?></a>
                                    </div><!-- .view-all -->
                                <?php endif; ?>
                            </div><!-- .entry-container -->
                        </article>
                        
                    <?php endforeach; ?>
            </div><!-- .wrapper -->
        </div><!-- .hero-cta-wrapper -->
    <?php }
endif;