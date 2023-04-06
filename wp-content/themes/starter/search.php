<?php
/**
 * Search results page
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

use Gosselink\Entity\GKArchive;
use Timber\Post;

$page = new GKArchive( array(
	'search.twig',
	'archive.twig',
	'index.twig'
));

// Page title
$page->add_to_context('title', sprintf( esc_html__('Résultats de recherche pour  "%s"' , 'gosselink'), get_search_query() ));

$page->render();