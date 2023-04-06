<?php

namespace Gosselink\Blocks\SliderPage;

use Gosselink\Entity\GKBlock;

class SliderPage
{

	/** @var GKBlock */
	private $block;

	/**
	 * SliderPage constructor.
	 * @param $block
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
			'key' => 'group_gk_slider',
			'name' => 'slider_page',
			'label' => __('Slider', 'gosselink'),
			'show_in_graphql' => true,
				'graphql_field_name' => 'gkSlider',
			'fields' => array(
				array(
					'key' => 'field_gk_slides_to_show',
					'label' => 'Nombre d\'images à afficher simultanément',
					'name' => 'gk_slides_to_show',
					'type' => 'number',
					'instructions' => 'Doit être inférieur au nombre de slides',
					'required' => 0,
					'conditional_logic' => 0,
					'default_value' => '1',
					'min' => '1',
					'max' => '6'
				),
				array(
					'key' => 'field_gk_slider_slider',
					'label' => __('Slider', 'gosselink'),
					'name' => 'gk_slider',
					'type' => 'repeater',
					'instructions' => __('Insérez un diaporama.', 'gosselink'),
					'collapsed' => 'slider_image',
					'layout' => 'block',
					'min' => '1',
					'sub_fields' => array(
						array(
							'key' => 'field_slider_image',
							'label' => __('Image', 'gosselink'),
							'name' => 'image',
							'type' => 'image',
							'required' => 0,
							'instructions' => '',
						),
						array(
							'key' => 'slider_show_details',
							'label' => 'Afficher détails',
							'name' => 'show_details',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'default_value' => 0,
							'ui' => 1,
						),
						array(
							'key' => 'slider_title',
							'label' => 'Titre',
							'name' => 'title',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array(
								array(
									array(
										'field' => 'slider_show_details',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'tabs' => 'all',
							'toolbar' => 'basic',
							'media_upload' => 0,
							'delay' => 0,
						),
						array(
							'key' => 'slider_description',
							'label' => 'Description',
							'name' => 'description',
							'type' => 'wysiwyg',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array(
								array(
									array(
										'field' => 'slider_show_details',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'tabs' => 'all',
							'toolbar' => 'basic',
							'media_upload' => 0,
							'delay' => 0,
						),
						array(
							'key' => 'slider_link',
							'label' => 'Lien',
							'name' => 'link',
							'type' => 'link',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array(
								array(
									array(
										'field' => 'slider_show_details',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'return_format' => 'array',
						),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param' => 'block',
						'operator' => '==',
						'value' => 'acf/' . $this->block->slug,
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => true,
			'description' => '',
		));
	}
}

