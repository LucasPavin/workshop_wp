<?php

namespace Gosselink\Settings\ACF;

class HomepageFields
{
    function __construct()
    {
        add_action('acf/init', array($this, 'register_options'));
    }

    function register_options()
    {
        if (function_exists('acf_add_local_field_group')):
            acf_add_local_field_group(array(
                'key' => 'group_602a9a2160dc1',
                'title' => 'Homepage',
                'show_in_graphql' => true,
                'graphql_field_name' => 'homePageFields',
                'fields' => array(
                    array(
                        'key' => 'field_6099476a62f714',
                        'label' => 'Slider',
                        'name' => '',
                        'type' => 'tab',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'placement' => 'top',
                        'endpoint' => 0,
                    ),
                    array(
                        'key' => 'field_5ed0dbd7a0ca0',
                        'label' => __('Que souhaitez-vous faire ?', 'gosselink'),
                        'name' => 'choice',
                        'type' => 'radio',
                        'instructions' => '',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'choices' => array(
                            'home_slider' => __('Ajouter une image', 'gosselink'),
                            'vimeo' => __('Ajouter une vidéo (Viméo)', 'gosselink'),
                            'youtube' => __('Ajouter une vidéo (Youtube)', 'gosselink'),
                        ),
                    ),
                    array(
                        'key' => 'field_5ed0dbf7a0ca1',
                        'label' => 'ID de la vidéo Viméo',
                        'name' => 'vimeo',
                        'type' => 'text',
                        'instructions' => 'exemple: 381133920. Votre vidéo doit être silencieuse. Votre vidéo doit être paramétrée de façon à boucler (Interaction Tools > End screen > Loop)',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_5ed0dbd7a0ca0',
                                    'operator' => '==',
                                    'value' => 'vimeo',
                                ),
                            ),
                        ),
                        'default_value' => '381133920',
                        'placeholder' => '381133920',
                    ),
                    array(
                        'key' => 'field_5ed0dbf7a0c99',
                        'label' => 'ID de la vidéo Youtube',
                        'name' => 'youtube',
                        'type' => 'text',
                        'instructions' => 'exemple: 7-OQEZ1nHbU. La vidéo sera jouée sans le son et en boucle automatiquement.',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_5ed0dbd7a0ca0',
                                    'operator' => '==',
                                    'value' => 'youtube',
                                ),
                            ),
                        ),
                        'default_value' => '7-OQEZ1nHbU',
                        'placeholder' => '7-OQEZ1nHbU',
                    ),
                    array(
                        'key' => 'field_602a9c857f65b',
                        'label' => 'Slider',
                        'name' => 'home_slider',
                        'type' => 'repeater',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_5ed0dbd7a0ca0',
                                    'operator' => '==',
                                    'value' => 'home_slider',
                                ),
                            ),
                        ),
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'collapsed' => '',
                        'min' => 0,
                        'max' => 0,
                        'layout' => 'block',
                        'button_label' => '',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_602a9c857f65c',
                                'label' => 'Image',
                                'name' => 'image',
                                'type' => 'image',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
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
                            array(
                                'key' => 'field_606c125e9c8f2',
                                'label' => 'Format de l\'image',
                                'name' => 'img_style',
                                'type' => 'select',
                                'instructions' => 'Comment souhaitez-vous voir apparaître l\'image ?',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '33.333',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'choices' => array(
                                    'cover' => '100% de large',
                                    'contain' => 'contenue dans le bloc',
                                ),
                                'default_value' => 'contenue',
                                'allow_null' => 0,
                                'multiple' => 0,
                                'ui' => 0,
                                'return_format' => 'value',
                                'ajax' => 0,
                                'placeholder' => '',
                            ),
                            array(
                                'key' => 'field_606c5e1e393aa',
                                'label' => 'Position',
                                'name' => 'position',
                                'type' => 'select',
                                'instructions' => 'Positionnez votre image.',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '33.333',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'choices' => array(
                                    'top' => 'En haut',
                                    'bottom' => 'En bas',
                                ),
                                'default_value' => false,
                                'allow_null' => 0,
                                'multiple' => 0,
                                'ui' => 0,
                                'return_format' => 'value',
                                'ajax' => 0,
                                'placeholder' => '',
                            ),
                            array(
                                'key' => 'field_606c024daa84a',
                                'label' => 'Couleur',
                                'name' => 'color',
                                'type' => 'color_picker',
                                'instructions' => 'Choisissez le fond de votre slider.',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '33.333',
                                    'class' => '',
                                    'id' => '',
                                ),
                            ),
                            array(
                                'key' => 'field_602a9c857f65d',
                                'label' => 'Titre',
                                'name' => 'title',
                                'type' => 'text',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
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
                                'key' => 'field_606c024daa99d',
                                'label' => 'Couleur',
                                'name' => 'title_color',
                                'type' => 'color_picker',
                                'instructions' => 'Choisissez la couleur du titre de votre slider.',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '33.333',
                                    'class' => '',
                                    'id' => '',
                                ),
                            ),
                            array(
                                'key' => 'field_602a9c857f65e',
                                'label' => 'Détails',
                                'name' => 'description',
                                'type' => 'textarea',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'default_value' => '',
                                'placeholder' => '',
                                'maxlength' => '',
                                'rows' => '',
                                'new_lines' => '',
                            ),
                            array(
                                'key' => 'field_606c024daz26p',
                                'label' => 'Couleur',
                                'name' => 'text_color',
                                'type' => 'color_picker',
                                'instructions' => 'Choisissez la couleur du texte de votre slider.',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '33.333',
                                    'class' => '',
                                    'id' => '',
                                ),
                            ),
                            array(
                                'key' => 'field_602a9c857f65f',
                                'label' => 'lien',
                                'name' => 'link',
                                'type' => 'link',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'return_format' => 'array',
                            ),
                            array(
                                'key' => 'field_606c024daq77d',
                                'label' => 'Couleur',
                                'name' => 'button_color',
                                'type' => 'color_picker',
                                'instructions' => 'Choisissez la couleur du bouton de votre slider.',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '50',
                                    'class' => '',
                                    'id' => '',
                                ),
                            ),
                            array(
                                'key' => 'field_606c024day15a',
                                'label' => 'Couleur',
                                'name' => 'text_button_color',
                                'type' => 'color_picker',
                                'instructions' => 'Choisissez la couleur du texte du bouton de votre slider.',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '50',
                                    'class' => '',
                                    'id' => '',
                                ),
                            ),
                        ),
                    ),
                ),


                'location' => array(
                    array(
                        array(
                            'param' => 'page_type',
                            'operator' => '==',
                            'value' => 'front_page',
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
        endif;
    }
}