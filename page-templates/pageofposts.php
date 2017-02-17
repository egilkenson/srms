<?php
/**
 * Template Name: Page of Posts
 * Description: Displays Page Contents, Followed By Posts Based On Custom 'category' Field
 *
 * @package srms
*/

get_header(); ?>


<div id="post-area">

    <?php if ( have_posts() ): ?>

        <?php while ( have_posts() ): the_post(); ?>
            <h2 class="category-head"><?php the_title(); ?></h2>
        <?php endwhile; ?>

        <?php
        if ( is_page() ) {
            $cat = get_post_meta( $posts[0]->ID, '_category', true );
        }
        if ( $cat ) :
            $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
            $post_per_page = -1; // -1 shows all posts
            $do_not_show_stickies = 1; // 0 to show stickies
            $args=array (
                'category__in' => array( $cat ),
                'meta_key' => 'order',
                'orderby' => 'meta_value_num',
                'order' => 'ASC',
                'paged' => $paged,
                'posts_per_page' => $post_per_page,
                'ignore_sticky_posts' => $do_not_show_stickies
            );
            $temp = $wp_query; // assign original query to temp variable for later use
            global $wp_query;
            $wp_query = null;
            $wp_query = new WP_Query( $args );

            if ( $wp_query->have_posts() ) : ?>
                <ul class="article-links">

                <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

                    <li><a href="#<?php srms_post_name(); ?>" class="article-link"><?php the_title(); ?></a></li>

                <?php endwhile; endif; ?>
            </ul>
            <?php rewind_posts(); ?>
            <?php $wp_query = $temp; //reset back to original query ?>

            <?php while ( have_posts() ): the_post(); ?>
            <?php if ( !empty($post->post_content) ): ?>
            <article id="<?php srms_post_name(); ?>">
                <?php the_content(); ?>
                <?php edit_post_link( __( 'Edit', 'srms' ), '<span class="edit-link">', '</span>' ); ?>
            </article>
            <?php endif; ?>
        <?php endwhile;

            global $wp_query;
            $wp_query = null;
            $wp_query = new WP_Query( $args );
            if ( $wp_query->have_posts() ) :
                while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
                    <article id="<?php srms_post_name(); ?>">
                        <h3 class="article-title"><?php the_title(); ?></h3>
                        <?php the_content(); ?>
                        <?php edit_post_link( __( 'Edit', 'srms' ), '<span class="edit-link">', '</span>' ); ?>
                        <a href="#" class="back-to-top">Back To Top <i class="fa fa-level-up"></i></a>
                    </article>
                <?php endwhile; ?>

            <?php endif; // if ( $wp_query->have_posts() ) ?>

        <?php endif; ?>

    <?php else: ?>
        <article class="error">
            <h2>Sorry there was nothing on this page.</h2>
        </article>

    <?php endif; ?>
</div>
</div>

<?php get_footer(); ?>