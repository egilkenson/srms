<?php
/**
 * This is the template that displays all of the <head> section, site header and main navigation up until <section id="main-content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package srms
 */
?>


<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width" />

    <script src="//use.typekit.net/vpc7tan.js"></script>
    <script>try{Typekit.load();}catch(e){}</script>

    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

    <?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

<div id="wrapper">
    <div id="image-header"

        <?php if (have_posts()): while (have_posts()): the_post();
        $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 1024,683 ), false, '' );
        ?>
         <?php if ( $src ) : ?>
         style="background: url(<?php echo $src[0]; ?> ) center !important; background-size: cover !important;"
        <?php endif ?>
        <?php
        endwhile;
        endif;
        rewind_posts();
        ?>
        >
        <header id="main-header">
            <a href="<?php echo site_url(); ?>"><h1><?php bloginfo('name'); ?></h1></a>
            <nav id="main-menu" role="navigation">
                <?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false )); ?>
            </nav>
        </header>
    </div>

    <section id="main-content">