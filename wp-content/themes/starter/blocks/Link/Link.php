<?php

namespace Gosselink\Blocks\Link;

use Gosselink\Entity\GKBlock;
use Gosselink\Settings\ACF\TechnicalOptions;

class Link
{

	/** @var GKBlock */
	private $block;

	/**
	 * Link constructor.
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
			'key' => 'gk_flexi_link',
			'name' => 'link_block',
			'label' => __('Bloc lien', 'gosselink'),
			'display' => 'block',
			'fields' => array(
				array(
					'key' => 'field_5891b48c70da9',
					'label' => __('Insérer un lien dans votre page', 'gosselink'),
					'name' => 'link',
					'type' => 'repeater',
					'instructions' => __('Mettez à la disposition des internautes vos documents (format PDF) en les 
                    téléchargeant ci-dessus. Vous pouvez également insérer une brève description (facultatif).', 'gosselink'),
					'collapsed' => '',
					'min' => 1,
					'max' => '',
					'layout' => 'block',
					'button_label' => __('Ajouter un nouveau lien', 'gosselink'),
					'sub_fields' => array(

                        array(
                            'key' => 'image_show',
                            'label' => 'Afficher image',
                            'name' => 'show_image',
                            'type' => 'true_false',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'default_value' => 0,
                            'ui' => 1,
                        ),
                        array(
                            'key' => 'field_img_link',
                            'label' => 'Image',
                            'name' => 'img_link',
                            'type' => 'image',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field' => 'image_show',
                                        'operator' => '==',
                                        'value' => '1',
                                    ),
                                ),
                            ),
                        ),

						array(
							'key' => 'field_5891b547731ac',
							'label' => __('Intitulé du lien', 'gosselink'),
							'name' => '',
							'type' => 'tab',
							'instructions' => '',
						),
						array(
							'key' => 'field_5891b4af70daa',
							'label' => __('Intitulé du lien', 'gosselink'),
							'name' => 'link_title',
							'type' => 'text',
							'instructions' => '',
							'required' => 1,
							'default_value' => __('Voir le lien', 'gosselink'),
						),
						array(
							'key' => 'field_5891b57c731ae',
							'label' => __('Adresse', 'gosselink'),
							'name' => '',
							'type' => 'tab',
							'instructions' => '',
						),
						array(
							'key' => 'field_5891b50070dac',
							'label' => __('Adresse du lien', 'gosselink'),
							'name' => 'url_link',
							'type' => 'url',
							'instructions' => '',
							'required' => 1,
						),
						array(
							'key' => 'field_58a172f7a0771',
							'label' => __('Ouvrir le lien dans un nouvel onglet', 'gosselink'),
							'name' => 'target',
							'type' => 'true_false',
							'ui' => 1,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
					),
				),
			),
			'min' => '',
			'max' => '',
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
