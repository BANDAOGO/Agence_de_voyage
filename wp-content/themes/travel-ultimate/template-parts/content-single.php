<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Theme Palace
 * @subpackage Travel Ultimate
 * @since Travel Ultimate 1.0.0
 */
$options = travel_ultimate_get_theme_options();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-meta">
        <?php 
        if ( ! $options['single_post_hide_author'] ) :
        	echo travel_ultimate_author();
        endif;

        if ( ! $options['single_post_hide_date'] ) :
        	travel_ultimate_posted_on();
        endif;
        ?>
    </div><!-- .entry-meta -->

	<div class="entry-container">
		<div class="entry-content">
			<?php
				the_content( sprintf(
					/* translators: %s: Name of current post. */
					wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'travel-ultimate' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'travel-ultimate' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->

		<div class="entry-meta">
			<?php 
        	travel_ultimate_single_categories(); 
			
			travel_ultimate_entry_footer(); ?>
		</div>
	</div><!-- .entry-container -->
</article><!-- #post-## -->
