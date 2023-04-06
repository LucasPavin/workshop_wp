<?php

namespace Gosselink\Settings;
/**
 * Created by Jerome GROSDENIER <jerome.grosdenier@gosselink.fr>
 * User: studio21
 * Date: 19/04/2018
 * Time: 17:27
 */

class CustomPostTypes
{

	function __construct() {
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
	}

	function register_post_types() {
		//this is where you can register custom post types		
	}

	function register_taxonomies() {
		//this is where you can register custom taxonomies
	}

}