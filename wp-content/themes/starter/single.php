<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

use Gosselink\Entity\GKPost;

$args = array(
    'post_type' => 'post',
    'posts_per_page' => 3,
    'paged' => -1,
);

$page = new GKPost();

$page->add_to_context('posts', new \Timber\PostQuery($args));

$page->render();
