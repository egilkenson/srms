<?php get_header(); ?>

    <div id="post-area">
       <?php if (have_posts()): while (have_posts()): the_post(); ?>
            <article id="#<?php srms_post_name(); ?>">
                <h3><?php the_title(); ?></h3>
                <?php the_content(); ?>
	            <?php edit_post_link( __( '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', 'srms' ), '<span class="edit-link">', '</span>' ); ?>
                    <?php $category = get_the_category(); ?>
                    <?php if ($category[0]->cat_name == "School"): ?>
                        <a href="/our-school/" class="back-to-top">
                            <i class="fa fa-arrow-left"></i> More in Our School</a>
                    <?php else: ?>
                    <a href="/<?php echo strtolower ($category[0]->cat_name); ?>/" class="back-to-top">
                        <i class="fa fa-arrow-left"></i> More in <?php echo $category[0]->cat_name; ?></a>

                    <?php endif ?>

            </article>
        <?php endwhile; ?>
        <?php else: ?>
            <article class="error">
                <h2>Sorry there were no articles found</h2>
            </article>

        <?php endif; ?>

    </div>

<?php get_footer(); ?>