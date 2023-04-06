<?php
/**
 * Template Name: Page Contact
 * Description: Page Contact
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
	'pages/template-page-contact.twig'
));


$args = array(
    'post_type' => 'gksl_poi',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'DESC',
    'tax_query' => array(
        array (
            'taxonomy' => 'gksl_poi_type',
            'field' => 'slug',
            'terms' => 'filiales',
        )
    ),
);

$locations_filiales = new Timber\PostQuery($args);
$page->add_to_context('locations_filiales', $locations_filiales->get_posts());

$args = array(
    'post_type' => 'gksl_poi',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'DESC',
    'tax_query' => array(
        array (
            'taxonomy' => 'gksl_poi_type',
            'field' => 'slug',
            'terms' => 'sites',
        )
    ),
);

$locations_sites = new Timber\PostQuery($args);
$page->add_to_context('locations_sites', $locations_sites->get_posts());

$page->render();