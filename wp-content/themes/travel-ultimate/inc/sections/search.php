<?php
/**
 * Search section
 *
 * This is the template for the content of search section
 *
 * @package Theme Palace
 * @subpackage Travel Ultimate
 * @since Travel Ultimate 1.0.0
 */
if ( ! function_exists( 'travel_ultimate_add_search_section' ) ) :
    /**
    * Add search section
    *
    *@since Travel Ultimate 1.0.0
    */
    function travel_ultimate_add_search_section() {
    	$options = travel_ultimate_get_theme_options();
        // Check if search is enabled on frontpage
        $search_enable = apply_filters( 'travel_ultimate_section_status', true, 'search_section_enable' );

        if ( true !== $search_enable ) {
            return false;
        }

        // Render search section now.
        travel_ultimate_render_search_section();
    }
endif;

if ( ! function_exists( 'travel_ultimate_render_search_section' ) ) :
  /**
   * Start search section
   *
   * @return string search content
   * @since Travel Ultimate 1.0.0
   *
   */
   function travel_ultimate_render_search_section() {
        ?>
            <div id="travel-search-section">
                <div class="wrapper">
                    <div class="wp-travel-filter">
                        <?php 
                        if ( class_exists( 'WP_Travel' ) ) {
                            wp_travel_search_form(); 
                        } else {
                            echo get_search_form();
                        }
                        ?>
                    </div><!-- wp-travel-filter -->
                </div><!-- .wrapper -->      
            </div><!-- #travel-search-section -->

    <?php }
endif;