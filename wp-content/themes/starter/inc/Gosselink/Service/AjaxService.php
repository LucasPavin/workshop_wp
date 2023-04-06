<?php
/**
 * Created by Jerome GROSDENIER <jerome.grosdenier@gosselink.fr>
 * Date: 03/09/2018
 * Time: 11:17
 */

namespace Gosselink\Service;

use Gosselink\Entity\GKPageSection;
use Gosselink\GKSite;
use Timber\Loader;
use Timber\Timber;

class AjaxService
{
	function __construct() {

		// Ajax to get a post content
		add_action( 'wp_ajax_post_content', array($this, 'get_post_content') );
		add_action( 'wp_ajax_nopriv_post_content', array($this, 'get_post_content') );


		// Delete Timber Cache
		add_action( 'wp_ajax_admin_delete_timber_cache', array($this, 'admin_delete_timber_cache') );
		add_action( 'wp_ajax_nopriv_admin_delete_timber_cache', array($this, 'admin_delete_timber_cache') );

	}

	/**
	 * Get post content to return as a response to an AJAX request
	 */
	function get_post_content(){

		$ID = $_POST['ID'];
		$nonce = $_POST['security'];

		if ($ID === null || !is_numeric($ID)){
			error_log("Ajax page load : ID is invalid");
			die( 'Wrong request' );
		}

		if ( ! wp_verify_nonce( $nonce, 'gk-nonce' ) ){
			error_log("Ajax page load : Nonce is invalid");
			die ( 'Busted!');
		}

		$page = new GKPageSection(get_post($ID), "", "");
		$page->set_is_popup(true);

		echo $page;

		die();
	}


	/**
	 * Admin Only : deletes timber image cache
	 */
	function admin_delete_timber_cache() {

		check_ajax_referer( GKSite::SECURITY_KEY, 'security' );

		$loader = new Loader();
		$loader->clear_cache_timber();
		$loader->clear_cache_twig();

		$files = glob(apply_filters('timber/image/new_path', '*'));
		foreach($files as $file){ // iterate files
			if(is_file($file)) {
				unlink($file); // delete file
			}
		}

		echo 'DONE';

		wp_die();
	}
}


