<?php
/**
 * The template for displaying Author Archive pages
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

use Gosselink\Entity\GKArchive;
use Timber\Post;
use Timber\User;

global $wp_query;

$page = new GKArchive(array(
	'author.twig',
	'archive.twig'
));

if ( isset( $wp_query->query_vars['author'] ) ) {
	// Overriding page title
	$author = new User( $wp_query->query_vars['author'] );
	$page->add_to_context('title', sprintf( esc_html__('Auteur : "%s"' , 'gosselink'), $author->name() ));
}

$page->render();
