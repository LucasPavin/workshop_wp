<?php
/**
 * Created by Jerome GROSDENIER <jerome.grosdenier@gosselink.fr>
 * Date: 23/11/2018
 * Time: 16:00
 */

namespace Gosselink\Settings\ACF;

class BlogOptions
{
	function __construct()
	{
		add_action('acf/init', array($this, 'register_options'));
	}

	function register_options()
	{

		if( function_exists('acf_add_local_field_group') ):

			// AUDIO POSTS
			////////////////////
			acf_add_local_field_group(array(

				'key' => 'blog_audio_posts',
				'title' => __('Audio', 'gosselink'),
				'show_in_graphql' => true,
				'graphql_field_name' => 'blogOptions',
				'fields' => array(
					array(
						'key' => 'blog_sound_file',
						'label' => __('Fichier son', 'gosselink'),
						'name' => 'sound_file',
						'type' => 'file',
						'return_format' => 'url',
						'library' => 'all',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_format',
							'operator' => '==',
							'value' => 'audio',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => array(
					0 => 'permalink',
					1 => 'excerpt',
					2 => 'discussion',
					3 => 'comments',
					4 => 'revisions',
					5 => 'author',
					6 => 'tags',
					7 => 'send-trackbacks',
				),
			));

			// GALLERY POSTS
			////////////////////
			acf_add_local_field_group(array(
				'key' => 'gallery_posts',
				'title' => __('Galerie Photos', 'gosselink'),
				'show_in_graphql' => true,
				'fields' => array(
					array(
						'key' => 'blog_gallery_posts',
						'label' => __('Images', 'gosselink'),
						'name' => 'gallery_posts',
						'type' => 'repeater',
						'min' => 0,
						'max' => 0,
						'layout' => 'table',
						'sub_fields' => array(
							array(
								'key' => 'gallery_post_image',
								'label' => __('Image', 'gosselink'),
								'name' => 'image',
								'type' => 'image',
								'return_format' => 'array',
								'preview_size' => 'thumbnail',
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
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_format',
							'operator' => '==',
							'value' => 'gallery',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'show_in_graphql' => true,
			));

			// VIDEO POSTS
			////////////////////
			acf_add_local_field_group(array(
				'key' => 'blog_video_posts',
				'title' => __('Video', 'gosselink'),
				'show_in_graphql' => true,
				'fields' => array(
					array(
						'key' => 'blog_video_post',
						'label' => __('Adresse de votre vidéo', 'gosselink'),
						'name' => 'video',
						'type' => 'oembed',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'width' => '',
						'height' => '',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_format',
							'operator' => '==',
							'value' => 'video',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'acf_after_title',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => array(
					0 => 'the_content',
					1 => 'excerpt',
					2 => 'discussion',
					3 => 'comments',
					4 => 'revisions',
					5 => 'author',
					6 => 'categories',
					7 => 'tags',
					8 => 'send-trackbacks',
				)
			));

		endif;
	}
}
