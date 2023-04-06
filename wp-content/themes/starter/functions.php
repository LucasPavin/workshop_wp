<?php
require_once get_template_directory() . '/vendor/autoload.php';

use Gosselink\GKSite;
use Timber\Timber;

new \Gosselink\Settings\Plugins();

$timber = new Timber();

if ( ! class_exists( 'Timber' ) ) {

	add_filter('template_include', function($template) {
		return get_stylesheet_directory() . '/static/no-timber.html';
	});
	

	return;
}

Timber::$dirname = array('templates');

$site = new GKSite();
