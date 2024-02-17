<?php
/**
 * This is the default template for displaying content
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#common-wordpress-template-files
 *
 * @package srms
 */
?>

<?php get_header(); ?>

    <div id="post-area">
        <ul class="article-links">
            <?php if (have_posts()): while (have_posts()): the_post(); ?>
                <li><a href="#<?php srms_post_name(); ?>" class="article-link"><?php the_title(); ?></a></li>
            <?php endwhile; endif; ?>
        </ul>

        <?php rewind_posts(); ?>

        <?php if (have_posts()): while (have_posts()): the_post(); ?>
            <article id="#<?php srms_post_name(); ?>">
                <h3><?php the_title(); ?></h3>
                <?php the_content(); ?>
	            <?php edit_post_link( __( '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', 'srms' ), '<span class="edit-link">', '</span>' ); ?>
                <a href="#" class="back-to-top">Back To Top <i class="fa fa-level-up"></i></a>
            </article>
        <?php endwhile; ?>
        <?php else: ?>
            <article class="error">
                <h2>Sorry there were no articles found</h2>
            </article>

        <?php endif; ?>

    </div>

<?php get_footer(); ?>