<?php


namespace Gosselink\Blocks\EcoVideo;

use Gosselink\Entity\GKBlock;
use Gosselink\Settings\ACF\TechnicalOptions;

class EcoVideo
{
    /** @var GKBlock */
    private $block;

    /**
     * EcoVideo constructor.
     */
    public function __construct($block)
    {
        $this->block = $block;
        $this->add_acf_fields();
    }

    function add_acf_fields()
    {
        acf_add_local_field_group(array(
            'key' => 'gk_flexi_eco_video',
            'title' => "Éco vidéo",
            'fields' => array(
                array(
                    'key' => 'gk_flexi_eco_video_link',
                    'label' => 'Vidéo',
                    'name' => 'eco_video',
                    'type' => 'text',
                    'instructions' => 'Entrez le code de la vidéo YouTube qui vous souhaitez intégrer. Exemple pour l\'url : https://www.youtube.com/watch?v=LXb3EKWsInQ entrez : LXb3EKWsInQ',
                    'required' => 0,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_6304e43441fb2',
                                'operator' => '==',
                                'value' => '1',
                            ),
                        ),
                    ),
                    'wrapper' => array(
                        'width' => '50',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => 'LXb3EKWsInQ',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'gk_flexi_eco_video_minia',
                    'label' => 'Miniature de la vidéo',
                    'name' => 'eco_miniature',
                    'type' => 'image',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_6304e43441fb2',
                                'operator' => '==',
                                'value' => '1',
                            ),
                        ),
                    ),
                    'wrapper' => array(
                        'width' => '50',
                        'class' => '',
                        'id' => '',
                    ),
                    'return_format' => 'array',
                    'preview_size' => 'medium',
                    'library' => 'all',
                    'min_width' => '',
                    'min_height' => '',
                    'min_size' => '',
                    'max_width' => '',
                    'max_height' => '',
                    'max_size' => '',
                    'mime_types' => '',
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
