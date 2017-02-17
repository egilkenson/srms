<?php
/**
 * This is the default template for displaying page content
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#common-wordpress-template-files
 *
 * @package srms
 */
?>

<?php get_header(); ?>

<div id="post-area">
<?php if( have_posts() ): while( have_posts() ): the_post(); ?>
    <article id="#<?php srms_post_name(); ?>">
        <?php the_content(); ?>
        <?php edit_post_link( __( 'Edit', 'srms' ), '<span class="edit-link">', '</span>' ); ?>
        <a href="#" class="back-to-top">Back To Top <i class="fa fa-level-up"></i></a>

    </article>
<?php endwhile; ?>

    <?php else: ?>
    <article class="error">
        <h2>Sorry there was nothing on this page.</h2>
    </article>
<?php endif; ?>

    </div>
<?php get_footer(); ?>
