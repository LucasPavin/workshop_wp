<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.2
 */

use Gosselink\Entity\GKArchive;
use Timber\Post;

$templates = array( 'archive.twig', 'index.twig' );
$title = __('Archive', 'gosselink');
if ( is_day() ) {
	$title = sprintf( esc_html__('Archive : "%s"' , 'gosselink'), get_the_date( 'D M Y' ) );
} else if ( is_month() ) {
	$title = sprintf( esc_html__('Archive : "%s"' , 'gosselink'), get_the_date( 'M Y' ) );
} else if ( is_year() ) {
	$title = sprintf( esc_html__('Archive : "%s"' , 'gosselink'), get_the_date( 'Y' ) );
} else if ( is_tag() ) {
	$title = single_tag_title( '', false );
} else if ( is_category() ) {
	$title = single_cat_title( '', false );
	array_unshift( $templates, 'archive-' . get_query_var( 'cat' ) . '.twig' );
} else if ( is_post_type_archive() ) {
	$title = post_type_archive_title( '', false );
	array_unshift( $templates, 'archive-' . get_post_type() . '.twig' );
}

$page = new GKArchive( $templates );

$page->add_to_context('title', $title);

$page->render();
