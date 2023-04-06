<?php

namespace Gosselink\Settings;
/**
 * Created by Jerome GROSDENIER <jerome.grosdenier@gosselink.fr>
 * User: studio21
 * Date: 03/04/2018
 * Time: 17:27
 */

class Plugins
{

	function __construct() {
		add_action( 'tgmpa_register', array($this, 'register_required_plugins') );
		add_filter( 'wpseo_metabox_prio', array($this, 'move_yoast_below_acf'));
	}

	function register_required_plugins() {
		$plugins = array(

			array(
				'name'               => 'Advanced Custom Fields PRO',
				'slug'               => 'advanced-custom-fields-pro',
				'required'           => true,
				'source'             => get_stylesheet_directory() . '/inc/plugins/advanced-custom-fields-pro.zip',
			),
			array(
				'name'              => 'Yoast SEO',
				'slug'              => 'wordpress-seo',
				'required'           => false,
			),
			array(
				'name'              => 'ACF Content Analysis for Yoast SEO',
				'slug'              => 'acf-content-analysis-for-yoast-seo',
				'required'           => false,
			),


		);

		$config = array(
			'id'           => 'gosselink',
			'capability'   => 'manage_options',
			'has_notices'  => true,
			'dismissable'  => false,
			'is_automatic' => true,
		);

		tgmpa( $plugins, $config );
	}

	function move_yoast_below_acf() {
		return 'low';
	}

}
