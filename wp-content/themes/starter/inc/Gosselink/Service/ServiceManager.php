<?php
/**
 * Created by Jerome GROSDENIER <jerome.grosdenier@gosselink.fr>
 * Date: 29/01/2020
 * Time: 09:54
 */

namespace Gosselink\Service;


class ServiceManager
{
	private static $_instance = null;

	private $_site;

	/**
	 * ServiceManager constructor.
	 * @param $site
	 */
	public function __construct($site)
	{
		$this->_site = $site;
	}


	/**
	 * @param null $site
	 * @return ServiceManager|null
	 */
	public static function get_instance($site = Null) {

		if(is_null(self::$_instance)) {
			self::$_instance = new ServiceManager($site);
		}

		return self::$_instance;
	}

	/**
	 * @return mixed
	 */
	public function get_site()
	{
		return $this->_site;
	}
}