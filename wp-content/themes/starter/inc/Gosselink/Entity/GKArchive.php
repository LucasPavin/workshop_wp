<?php
/**
 * Created by Jerome GROSDENIER <jerome.grosdenier@gosselink.fr>
 * Date: 17/10/2018
 * Time: 09:36
 */

namespace Gosselink\Entity;

use Timber\PostQuery;

class GKArchive extends GKPost
{

	/**
	 * @param array $templates
	 */
	public function __construct($templates)
	{
		parent::__construct();

		$this->templates = $templates;

		$this->add_to_context('posts', new PostQuery());
	}

}