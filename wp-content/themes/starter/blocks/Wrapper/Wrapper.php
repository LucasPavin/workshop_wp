<?php

namespace Gosselink\Blocks\Wrapper;

use Gosselink\Entity\GKBlock;
use Gosselink\Settings\ACF\TechnicalOptions;

class Wrapper
{

	/** @var GKBlock */
	private $block;

	/**
	 * Download constructor.
	 */
	public function __construct($block)
	{
		$this->block = $block;

		$this->add_acf_fields();
	}

	/**
	 * Deal with ACF fields for this block
	 */
	function add_acf_fields()
	{
		acf_add_local_field_group(array(
			'key' => 'gk_flexi_wrapper',
			'name' => 'wrapper',
			'label' => __('Conteneur', 'gosselink'),
			'display' => 'block',
			'fields' => array(
				array(
					'key' => 'field_5f621ce1291b2',
					'label' => __('Activé', 'gosselink'),
					'name' => 'enabled',
					'type' => 'true_false',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'message' => '',
					'default_value' => 1,
					'ui' => 1,
					'ui_on_text' => __('Oui', 'gosselink'),
					'ui_off_text' => __('Non', 'gosselink'),
				),
				array(
					'key' => 'field_5f3cd00b16381',
					'label' => __('Largeur', 'gosselink'),
					'name' => 'width',
					'type' => 'select',
					'instructions' => '',
					'choices' => array(
						'' => __('Normale', 'gosselink'),
						'full' => __('Pleine largeur', 'gosselink'),
					),
					'default_value' => '',
				),
				array(
					'key' => 'field_5f3cd07016382',
					'label' => __('Type de fond', 'gosselink'),
					'name' => 'background',
					'type' => 'select',
					'instructions' => '',
					'choices' => array(
						'none' => __('Aucun', 'gosselink'),
						'color' => __('Couleur', 'gosselink'),
						'image' => __('Image', 'gosselink'),
					),
					'default_value' => 'none',
				),
				array(
					'key' => 'field_5f3cd3f616383',
					'label' => __('Image', 'gosselink'),
					'name' => 'image',
					'type' => 'image',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_5f3cd07016382',
								'operator' => '==',
								'value' => 'image',
							),
						),
					),
					'return_format' => 'array',
				),
				array(
					'key' => 'field_9cb5af8410bb7',
					'label' => __('Effet', 'gosselink'),
					'name' => 'effect',
					'type' => 'select',
					'instructions' => '',
					'choices' => array(
						'' => __('Aucun', 'gosselink'),
						//'parallax' => __('Parallaxe', 'gosselink'), // TODO : Parallax
						'fixed' => __('Image fixe', 'gosselink'),
					),
					'default_value' => '',
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_5f3cd07016382',
								'operator' => '==',
								'value' => 'image',
							),
						),
					),
				),
				array(
					'key' => 'field_5f3cd44716384',
					'label' => __('Couleur', 'gosselink'),
					'name' => 'color',
					'type' => 'select',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_5f3cd07016382',
								'operator' => '==',
								'value' => 'color',
							),
						),
					),
					'choices' => TechnicalOptions::get_theme_colors(),
				),
			),
			'location' => array(
				array(
					array(
						'param' => 'block',
						'operator' => '==',
						'value' => $this->block->acf_id,
					),
				),
			),
		));
	}
}
