<?php
/**
* This is the template that displays the front page.
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/#home-page-display
*
* @package srms
*/
?>

<?php get_header(); ?>
<?php $args = array(
    'post_type' => array('tile'),
    'posts_per_page' => '4',
    'meta_key' => 'order',
    'orderby' => 'meta_value_num',
    'order' => 'ASC',
    );
$query = new WP_Query($args); ?>

<div id="tiles">

<?php
    if ($query->have_posts()):
    $count = 0;
    while ($query->have_posts()): $query->the_post(); ?>
        <?php $count++; ?>
        <?php if ($count == 1) : ?>
            <div class="tile">
        <?php endif; ?>
    <a href="<?php echo get_page_link(get_post_meta(get_the_ID(), 'tilelink', true)); ?>"
       class="tile-link"></a><?php the_post_thumbnail('home-tile', ['loading' => 'lazy']); ?>
        <div class="tile-text"><h2><?php the_title(); ?></h2>
            <?php the_content(); ?>
	        <a href="#" class="button"><?php the_title(); ?></a>
        </div>
	    <?php edit_post_link( __( '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', 'srms' ), '<span class="edit-link" title="Edit this tile">', '</span>' ); ?>
        </div><?php if ($count !== 4) : ?><div class="tile">
        <?php endif; ?>
    <?php endwhile; ?>
    </div>
<?php else: ?>
    <article class="error">
        <h2>Sorry there was nothing on this page.</h2>
    </article>
<?php endif; ?>

<?php get_footer(); ?>
