<?php

namespace Gosselink\Settings\ACF;

class ActusFields {
	function __construct() {
		add_action('acf/init', array($this, 'register_options'));
	}

	function register_options() {
		if (function_exists('acf_add_local_field_group')):

			acf_add_local_field_group(array(
				'key' => 'group_actus',
				'title' => 'Actualites',
				'show_in_graphql' => true,
				'graphql_field_name' => 'group_actus',
				'fields' => array(
					array(
						'key' => 'field_target',
						'label' => 'Action du "Lire la suite"',
						'name' => 'internal',
						'type' => 'true_false',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'message' => '',
						'default_value' => 1,
						'ui' => 1,
						'ui_on_text' => 'Interne',
						'ui_off_text' => 'Externe',
					),
					array(
						'key' => 'field_external_link',
						'label' => 'Lien',
						'name' => 'external_link',
						'type' => 'link',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => array(
							array(
								array(
									'field' => 'field_target',
									'operator' => '!=',
									'value' => '1',
								),
							),
						),
						'return_format' => 'array',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'post',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'acf_after_title',
				'style' => 'seamless',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true,
				'description' => '',
			));

		endif;
	}
}
