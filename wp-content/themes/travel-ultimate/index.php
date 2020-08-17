<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Theme Palace
 * @subpackage Travel Ultimate
 * @since Travel Ultimate 1.0.0
 */

get_header(); 
$options = travel_ultimate_get_theme_options();
$sticky_posts = get_option( 'sticky_posts' );
$sticky_args = array( 
	'post_type'	=> 'post',
	'post__in' => ( array ) $sticky_posts,
);
?>

<div id="inner-content-wrapper" class="wrapper page-section">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php 
			if ( ! empty( $sticky_posts ) ) :
				$sticky_query = new WP_Query( $sticky_args );
				if ( $sticky_query -> have_posts() && get_query_var( 'paged' ) === 0 ) : ?>
					<div class="sticky-post-wrapper clear">
						<?php while ( $sticky_query -> have_posts() ) : $sticky_query -> the_post(); ?>
		                <article class="sticky <?php echo has_post_thumbnail() ? 'has' : 'no'; ?>-post-thumbnail">
							<div class="item-wrapper">
			                	<?php if ( has_post_thumbnail() ) : ?>
				                    <div class="featured-image">
				                        <div class="featured-image" style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'large' ) ); ?>');">
				                    	</div><!-- .featured-image -->
				                    </div><!-- .featured-image -->
				                <?php endif; ?>

			                    <div class="entry-container">
		                            <?php travel_ultimate_posted_on(); ?>

			                        <header class="entry-header">
			                            <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			                        </header>

			                        <div class="entry-content">
			                            <?php the_excerpt(); ?>
			                        </div><!-- .entry-content -->
			                        <div class="read-more">
			                            <a href="<?php the_permalink(); ?>">
			                                <?php echo travel_ultimate_get_svg( array( 'icon' => 'new-right' ) ); ?>
			                                <span><?php echo esc_html( $options['excerpt_text'] ); ?></span>
			                            </a>
			                        </div><!-- .read-more -->
			                    </div><!-- .entry-container -->
	            			</div>
		                </article>
		            	<?php endwhile; ?>
	            	</div>
		        <?php endif; 
		        wp_reset_postdata();
	        endif;
	        ?>

	        <div class="archive-blog-wrapper posts-wrapper clear col-2">
				<?php
				if ( have_posts() ) : ?>

					<?php
					/* Start the Loop */
					while ( have_posts() ) : the_post();

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', get_post_format() );

					endwhile;

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif; ?>
			</div>
			<?php  
			/**
			* Hook - travel_ultimate_action_pagination.
			*
			* @hooked travel_ultimate_pagination 
			*/
			do_action( 'travel_ultimate_action_pagination' ); 

			?>
		</main><!-- #main -->
	</div><!-- #primary -->

	<?php  
	if ( travel_ultimate_is_sidebar_enable() ) {
		get_sidebar();
	}
	?>
</div><!-- .wrapper -->

<?php
get_footer();
