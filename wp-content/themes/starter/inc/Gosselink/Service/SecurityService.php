<?php
/**
 * Created by Jerome GROSDENIER <jerome.grosdenier@gosselink.fr>
 * Date: 09/08/2018
 * Time: 16:12
 */

namespace Gosselink\Service;

use Gosselink\GKSite;


/**
 * Class SecurityService
 * Resposible for all the security related stuff (obviously)
 * @package Gosselink\Service
 */
class SecurityService
{
	function __construct() {

		if (!GKSite::AUTHOR_ARCHIVE_ENABLED){
			add_action('template_redirect', array($this, 'disable_author_archives'));
		}

		// Allow security updates even when the project is versionned with git/svn.
		add_filter( 'automatic_updates_is_vcs_checkout', function( $checkout, $context ) {return false;}, 10, 2 );

	}


	/**
	 * Disable Author Archive (don't display usernames publicly)
	 */
	function disable_author_archives() {

		if (is_author()) {

			global $wp_query;
			$wp_query->set_404();
			status_header(404);

		} else {

			redirect_canonical();

		}

	}



}