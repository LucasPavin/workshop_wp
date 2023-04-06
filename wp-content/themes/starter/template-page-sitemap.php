<?php
/**
 * Template Name: Page Plan du site
 * Description: Page Plan du site
 */

use Gosselink\Entity\GKPage;

/**
 * Page template example.
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$page = new GKPage(array(
	'pages/template-page-sitemap.twig'
));

$page->render();