<?php

namespace Gosselink\Entity;

use Timber\Term;

class GKTaxonomy extends GKPost
{

	/**
	 * @param array $templates
	 */
	public function __construct($templates)
	{
		parent::__construct();

		$this->templates = $templates;

		$this->add_to_context('term', new Term());
	}

}