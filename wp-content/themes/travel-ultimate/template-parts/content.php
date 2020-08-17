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

$class = has_post_thumbnail() ? '' : 'no-post-thumbnail';
$options = travel_ultimate_get_theme_options();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>
    <div class="item-wrapper">
        <div class="featured-image" style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'post-thumbnail' ) ); ?>');">
            <div class="overlay"></div>
            <div class="read-more">
                <a href="<?php the_permalink(); ?>">
                    <?php echo travel_ultimate_get_svg( array( 'icon' => 'new-right' ) ); ?>
                    <span><?php echo esc_html( $options['excerpt_text'] ); ?></span>
                </a>
            </div><!-- .read-more -->
        </div><!-- .featured-image -->

        <div class="entry-container">
            <?php travel_ultimate_posted_on(); ?>
            <header class="entry-header">
                <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            </header>
        </div><!-- .entry-container -->
    </div>
</article><!-- #post-## -->
