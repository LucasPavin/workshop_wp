<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

use Timber\Timber;
use Gosselink\Entity\GKPage;

$page = new GKPage(array(
	'404.twig'
));


$page->add_to_context('posts', new \Timber\PostQuery($args));

$page->render();
