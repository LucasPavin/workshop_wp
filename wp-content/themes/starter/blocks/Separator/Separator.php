<?php

namespace Gosselink\Blocks\Separator;

use Gosselink\Entity\GKBlock;
use Gosselink\Settings\ACF\TechnicalOptions;

class Separator
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
            'key' => 'gk_flexi_separator',
            'title' => 'separator',
            'fields' => array(
                array(
                    'key' => 'field_610153b5f0643',
                    'label' => 'Separator',
                    'name' => 'separator',
                    'type' => 'range',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'min' => '',
                    'max' => 500,
                    'step' => '',
                    'prepend' => '',
                    'append' => 'px',
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
