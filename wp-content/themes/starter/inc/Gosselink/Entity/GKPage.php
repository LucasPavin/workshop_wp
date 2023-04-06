<?php
/**
 * Created by Jerome GROSDENIER <jerome.grosdenier@gosselink.fr>
 * Date: 17/10/2018
 * Time: 09:36
 */

namespace Gosselink\Entity;

class GKPage extends GKPost
{
	/**
	 * @param array $templates
	 */
	public function __construct($templates)
	{
		parent::__construct();

		$this->templates = $templates;
	}

	/**
	 * Tell if the current page is the actual homepage
	 * @return bool
	 */
	public static function is_homepage(){
		return is_front_page() && !is_home();
	}

}