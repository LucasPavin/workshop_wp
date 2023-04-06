<?php

namespace Gosselink\Blocks\Highlights;

use Gosselink\Entity\GKBlock;
use Gosselink\Settings\ACF\TechnicalOptions;

class Highlights
{

	/** @var GKBlock */
	private $block;

	/**
	 * Highlights constructor.
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
			'key' => 'gk_flexi_highlights',
			'name' => 'number_block',
			'label' => __('Chiffres clés ou valeurs', 'gosselink'),
			'display' => 'block',
			'fields' => array(
				array(
					'key' => 'field_58b69d76cdac3',
					'label' => __('Chiffres clés', 'gosselink'),
					'name' => 'key_number',
					'type' => 'repeater',
					'instructions' => __('Détaillez ici les chiffres clés ou encore les valeurs de votre entreprise pour un affichage plus pertinent de ces données côté client. Mise en exergue dans un bloc de couleur en accord avec votre charte graphique.', 'gosselink'),
					'collapsed' => '',
					'min' => 1,
					'max' => '',
					'layout' => 'block',
					'button_label' => __('Ajouter un chiffre clé ou une valeur', 'gosselink'),
					'sub_fields' => array(
						array(
							'key' => 'field_58b69f0dcdac9',
							'label' => __('Je souhaite insérer une icône plutôt qu\'un chiffre', 'gosselink'),
							'name' => 'choice',
							'type' => 'true_false',
							'instructions' => '',
							'ui' => 1,
						),
						array(
							'key' => 'field_58b69d76cdac7',
							'label' => __('L\'icône', 'gosselink'),
							'name' => 'icon',
							'type' => 'image',
							'instructions' => 'Insérez l\'icône que vous souhaitez mettre en avant.',
							'required' => 0,
							'conditional_logic' => array(
								array(
									array(
										'field' => 'field_58b69f0dcdac9',
										'operator' => '==',
										'value' => 1,
									),
								),
							),
							'return_format' => 'url',
							'preview_size' => 'thumbnail',
							'library' => 'all',
						),
						array(
							'key' => 'field_58b69d76cdac4',
							'label' => __('Le chiffre clé', 'gosselink'),
							'name' => 'number',
							'type' => 'number',
							'instructions' => __('Renseignez le chiffre clé (uniquement le chiffre) que vous souhaitez mettre en avant.', 'gosselink'),
							'required' => 0,
							'conditional_logic' => array(
								array(
									array(
										'field' => 'field_58b69f0dcdac9',
										'operator' => '!=',
										'value' => 1,
									),
								),
							),
							'wrapper' => array(
								'width' => '50',
								'class' => '',
								'id' => '',
							),
						),
						array(
							'key' => 'field_59e8560ef7bb4',
							'label' => __('Extension', 'gosselink'),
							'name' => 'extension',
							'type' => 'text',
							'instructions' => __('Texte à apposer au chiffre (unité de mesure, ...)', 'gosselink'),
							'required' => 0,
							'conditional_logic' => array(
								array(
									array(
										'field' => 'field_58b69f0dcdac9',
										'operator' => '!=',
										'value' => 1,
									),
								),
							),
							'wrapper' => array(
								'width' => '50',
								'class' => '',
								'id' => '',
							),
						),
						array(
							'key' => 'field_58b69d76cdac5',
							'label' => __('Le détail', 'gosselink'),
							'name' => 'detail',
							'type' => 'textarea',
							'instructions' => __('Détaillez le chiffre clé ou la valeur souhaitée.', 'gosselink'),
                            'maxlength' => 60,
						),
					),
				),
			),
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
