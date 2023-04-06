<?php

namespace Gosselink\Blocks\Download;

use Gosselink\Entity\GKBlock;
use Gosselink\Settings\ACF\TechnicalOptions;

class Download
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
			'key' => 'gk_flexi_download',
			'name' => 'download_block',
			'label' => __('Bloc de téléchargement', 'gosselink'),
			'display' => 'block',
			'fields' => array(
				array(
					'key' => 'field_5891b63b48682',
					'label' => __('Le document à télécharger', 'gosselink'),
					'name' => 'download',
					'type' => 'repeater',
					'instructions' => __('Mettez à la disposition des internautes vos documents (format PDF) en les 
                    téléchargeant ci-dessus. Vous pouvez également insérer une brève description (facultatif).', 'gosselink'),
					'collapsed' => '',
					'min' => 1,
					'max' => '',
					'layout' => 'block',
					'button_label' => __('Ajouter un téléchargement', 'gosselink'),
					'sub_fields' => array(
						array(
							'key' => 'field_5891b67348683',
							'label' => __('Le titre du document', 'gosselink'),
							'name' => '',
							'type' => 'tab',
							'instructions' => '',
						),
						array(
							'key' => 'field_5891b69448684',
							'label' => __('Titre du document à télécharger', 'gosselink'),
							'name' => 'doc_title',
							'type' => 'text',
							'instructions' => __('Indiquez le nom de votre document à télécharger.', 'gosselink'),
							'required' => 1,
							'default_value' => __('Télécharger le document', 'gosselink'),
						),

						array(
							'key' => 'field_5891b6d448687',
							'label' => __('Document à téléchargement', 'gosselink'),
							'name' => '',
							'type' => 'tab',
							'instructions' => '',
						),
						array(
							'key' => 'field_5891b6da48688',
							'label' => __('Document à télécharger', 'gosselink'),
							'name' => 'doc_link',
							'type' => 'file',
							'instructions' => __('Télécharger le document dans la bibliothèque de médias.', 'gosselink'),
							'required' => 1,
							'return_format' => 'url',
							'library' => 'all',
							'min_size' => '',
							'max_size' => 30,
							'mime_types' => '',
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
