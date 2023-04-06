<?php

namespace Gosselink\Blocks\Timeline;

use Gosselink\Entity\GKBlock;

class Timeline
{

    /** @var GKBlock */
    private $block;

    /**
     * Timeline constructor.
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
            'key' => 'gk_flexi_timeline',
            'name' => 'timeline',
            'label' => __('Frise historique', 'gosselink'),
            'display' => 'row',
            'fields' => array(
                array(
                    'key' => 'field_57179f475c6d4',
                    'label' => __('Frise historique', 'gosselink'),
                    'name' => 'timeline_block',
                    'type' => 'repeater',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'collapsed' => 'field_57179f595c6d5',
                    'min' => 0,
                    'max' => 0,
                    'layout' => 'block',
                    'button_label' => 'Ajouter un élément',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_6026a559099cb',
                            'label' => __('Couleur', 'gosselink'),
                            'name' => 'color',
                            'type' => 'color_picker',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                        ),


                        array(
                            'key' => 'field_602a2e408f12c',
                            'label' => 'Ajouter un bloc titre/sous-titre ?',
                            'name' => 'add_block',
                            'type' => 'true_false',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'message' => '',
                            'default_value' => 0,
                            'ui' => 1,
                            'ui_on_text' => '',
                            'ui_off_text' => '',
                        ),
                        array(
                            'key' => 'field_602a2d04cdd39',
                            'label' => 'Titre principal',
                            'name' => 'big_title',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field' => 'field_602a2e408f12c',
                                        'operator' => '==',
                                        'value' => '1',
                                    ),
                                ),
                            ),
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'field_602a2d17cdd3a',
                            'label' => 'Sous-titre principal',
                            'name' => 'big_subtitle',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field' => 'field_602a2e408f12c',
                                        'operator' => '==',
                                        'value' => '1',
                                    ),
                                ),
                            ),
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),

                        array(
                            'key' => 'field_57179f595c6d5',
                            'label' => __('Date', 'gosselink'),
                            'name' => 'dated',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '100',
                                'class' => '',
                                'id' => '',
                            ),
                        ),

                        array(
                            'key' => 'field_57179f645c6d6',
                            'label' => __('Evénement', 'gosselink'),
                            'name' => 'event',
                            'type' => 'wysiwyg',
                            'instructions' => '',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'new_lines' => 'br',
                        ),
                        array(
                            'key' => 'field_571a23b812ca6',
                            'label' => __('Image', 'gosselink'),
                            'name' => 'event_image',
                            'type' => 'image',
                            'instructions' => '',
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
