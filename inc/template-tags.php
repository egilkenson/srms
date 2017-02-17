<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package srms
 */

// Clean Post Title

function srms_post_name() {
    global $post;
    $title = sanitize_title($post->post_title);
    echo $title;
}