<?php

namespace Gosselink\Blocks\AccordionTabs;

use Gosselink\Entity\GKBlock;
use Gosselink\Settings\ACF\TechnicalOptions;

class AccordionTabs {

	/** @var GKBlock */
	private $block;

	/**
	 * AccordionTabs constructor.
	 */
	public function __construct($block) {
		$this->block = $block;

		$this->add_acf_fields();
	}

	/**
	 * Deal with ACF fields for this block
	 */
	function add_acf_fields() {

		acf_add_local_field_group(array(
			'key' => 'gk_flexi_accordion_tabs',
			'title' => 'Onglets',
			'fields' => array(
				array(
					'key' => 'field_accordion_or_tabs',
					'label' => __('Accordéon ou onglets','gosselink'),
					'name' => 'accordion_or_tabs',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'choices' => array(
						'accordion' => 'Accordéon',
						'tabs' => 'Onglets',
					),
					'default_value' => array(
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 1,
					'ajax' => 0,
					'return_format' => 'value',
					'placeholder' => '',
				),
				array(
					'key' => 'field_position',
					'label' => __('Position de la navigation','gosselink'),
					'name' => 'position',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_accordion_or_tabs',
								'operator' => '==',
								'value' => 'tabs',
							),
						),
					),
					'choices' => array(
						'horizontal' => 'Haut',
						'vertical' => 'Gauche',
					),
					'default_value' => array(
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 1,
					'ajax' => 0,
					'return_format' => 'value',
					'placeholder' => '',
				),
				array(
					'key' => 'field_accordion_tabs_block',
					'label' => __('Bloc','gosselink'),
					'name' => 'accordion_tabs_block',
					'type' => 'repeater',
					'instructions' => '',
					'required' => 1,
					'collapsed' => 'field_title',
					'min' => 1,
					'max' => 0,
					'layout' => 'row',
					'button_label' => '',
					'sub_fields' => array(
						array(
							'key' => 'field_title',
							'label' => __('Titre','gosselink'),
							'name' => 'title',
							'type' => 'text',
							'required' => 1,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '25',
							),
						),
						array(
							'key' => 'field_content',
							'label' => __('Contenu','gosselink'),
							'name' => 'content',
							'type' => 'wysiwyg',
							'required' => 1,
							'conditional_logic' => 0,
							'tabs' => 'all',
							'toolbar' => 'basic',
							'media_upload' => 1,
							'delay' => 0,
							'wrapper' => array(
								'width' => '75',
							),
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
