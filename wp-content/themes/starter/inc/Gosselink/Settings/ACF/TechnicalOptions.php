<?php
/**
 * Created by Jerome GROSDENIER <jerome.grosdenier@gosselink.fr>
 * Date: 23/11/2018
 * Time: 17:31
 */

namespace Gosselink\Settings\ACF;

use Gosselink\GKSite;
use Timber\Timber;

class TechnicalOptions {
	function __construct() {
		add_action('acf/init', array($this, 'register_options'));

		add_action('acf/input/admin_head', array($this, 'timber_options_metabox'), 20);
	}

	function register_options() {

		if (function_exists('acf_add_local_field_group')):

			// Technical Options Page
			/////////////////////////////
			acf_add_local_field_group(array(
				'key' => 'gk_tech_options',
				'title' => __('Options techniques', 'gosselink'),
				'show_in_graphql' => true,
				'graphql_field_name' => 'gkTechOptions',
				'fields' => array(

					// Maps Options Panel
					////////////////////////
					array(
						'key' => 'gk_tech_options_maps_panel',
						'label' => __('Cartes', 'gosselink'),
						'name' => '',
						'type' => 'tab',
					),
					array(
						'key' => 'gk_tech_options_maps_key',
						'label' => __('Google API Key', 'gosselink'),
						'name' => 'maps_google_api_key',
						'type' => 'text',
						'required' => 0,
						'instructions' => __('Requis pour les champs Maps ACF', 'gosselink'),
					),
					array(
						'key' => 'gk_tech_options_maps_pin',
						'label' => __('Pin personnalisé', 'gosselink'),
						'name' => 'maps_pin',
						'type' => 'image',
						'instructions' => __('Fournir une image Retina. L\'ancre doit se situer en bas et au milieu de l\'image', 'gosselink'),
						'return_format' => 'array',
						'preview_size' => 'thumbnail',
						'library' => 'all',
						'mime_types' => 'png,jpg',
					),
					array(
						'key' => 'gk_tech_options_maps_snazzy',
						'label' => __('Code Snazzy Maps', 'gosselink'),
						'name' => 'maps_snazzy',
						'type' => 'textarea',
					),
					
					// Footer & Analytics Options Panel
					////////////////////////
					array(
						'key' => 'gk_tech_options_analytics_panel',
						'label' => __('Footer & Analytics', 'gosselink'),
						'name' => '',
						'type' => 'tab',
					),
					// Footer menu
					array(
						'key' => 'gk_tech_options_footer_menu_enabled',
						'label' => __('Footer menu', 'gosselink'),
						'name' => 'footer_menu_enabled',
						'type' => 'true_false',
						'default_value' => 0,
						'ui' => 1,
					),
					// Footer JS
					array(
						'key' => 'gk_tech_options_footer_js',
						'label' => __('Javascript du footer', 'gosselink'),
						'name' => 'footer_js',
						'type' => 'textarea',
						'required' => 0,
					),
					// Google Tag Manager
					array(
						'key' => 'gk_tech_options_gtm_enabled',
						'label' => __('Google Tag Manager', 'gosselink'),
						'name' => 'gtm_enabled',
						'type' => 'true_false',
						'default_value' => 0,
						'ui' => 1,
					),
					array(
						'key' => 'gk_tech_options_gtm_id',
						'label' => __('Code GTM', 'gosselink'),
						'name' => 'gtm_id',
						'type' => 'text',
						'required' => 0,
						'conditional_logic' => array(
							array(
								array(
									'field' => 'gk_tech_options_gtm_enabled',
									'operator' => '==',
									'value' => '1',
								),
							),
						),
					),

					// Various Options Panel
					////////////////////////
					array(
						'key' => 'gk_tech_options_various_panel',
						'label' => __('Options diverses', 'gosselink'),
						'name' => '',
						'type' => 'tab',
					),
					// Favicon
					array(
						'key' => 'gk_tech_options_favicon',
						'label' => __('Favicon', 'gosselink'),
						'name' => 'favicon',
						'type' => 'image',
						'instructions' => __('Format carré, 512x512px recommandé', 'gosselink'),
						'return_format' => 'array',
						'preview_size' => 'thumbnail',
						'library' => 'all',
						'mime_types' => 'png,jpg',
					),

					// Disable comments
					array(
						'key' => 'gk_tech_options_disable_comments',
						'label' => __('Commentaires désactivés', 'gosselink'),
						'name' => 'disable_comments',
						'type' => 'true_false',
						'default_value' => 0,
						'ui' => 1,
					),
					// Site Map
					array(
						'key' => 'gk_tech_options_sitemap_enabled',
						'label' => __('Plan du site', 'gosselink'),
						'instructions' => __('Ajoute un menu dédié au plan du site. La page associée reste à créer (un template dédié est disponible).', 'gosselink'),
						'name' => 'sitemap_enabled',
						'type' => 'true_false',
						'default_value' => 0,
						'ui' => 1,
					),					
					// Scroll Top
					array(
						'key' => 'gk_tech_options_scroll_top_enabled',
						'label' => __('Scroll top', 'gosselink'),
						'name' => 'scroll_top_enabled',
						'type' => 'true_false',
						'default_value' => 0,
						'ui' => 1,
					),
					// Blocks Gutenberg
					/////////////////
					array(
						'key' => 'gk_tech_options_blocks_panel',
						'label' => __('Blocs Gutenberg', 'gosselink'),
						'name' => '',
						'type' => 'tab',
						'parent' => 'gk_tech_options',
					),
					// Colors used in flexible content
					array(
						'key' => 'gk_tech_options_flexible_colors',
						'label' => __('Couleurs utilisés pour les blocs', 'gosselink'),
						'name' => 'flexible_colors',
						'type' => 'repeater',
						'default_value' => 1,
						'ui' => 1,
						'sub_fields' => array(
							array(
								'key' => 'gk_tech_options_flexible_colors_id',
								'label' => __('Classe', 'gosselink'),
								'name' => 'flexible_color_class',
								'type' => 'text',
								'instructions' => '',
								'required' => 1,
							),
							array(
								'key' => 'gk_tech_options_flexible_colors_name',
								'label' => __('Nom', 'gosselink'),
								'name' => 'flexible_color_name',
								'type' => 'text',
								'instructions' => '',
								'required' => 1,
							),
						),
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'options_page',
							'operator' => '==',
							'value' => 'gk-technical-options',
						),
					),
				),
			));

		endif;
	}

	/**
	 * Get colors from technical options
	 */
	public static function get_theme_colors($select = false) {

		$colors = array();

		if (function_exists('get_field')) {

			// Site options don't have to be translated, we're getting them for the default language.
			add_filter('acf/settings/current_language', '__return_false');

			$i = 0;
			while (get_field('flexible_colors_' . $i . '_flexible_color_class', 'options')) {
				if (!$select) {
					$colors[get_field('flexible_colors_' . $i . '_flexible_color_class', 'options')] = get_field('flexible_colors_' . $i . '_flexible_color_name', 'options');
				} else {
					$colors[$i]['label'] = get_field('flexible_colors_' . $i . '_flexible_color_name', 'options');
					$colors[$i]['value'] = get_field('flexible_colors_' . $i . '_flexible_color_class', 'options');
                }
				$i++;
			}

			remove_filter('acf/settings/current_language', '__return_false');
		}

		if (empty($colors)) {
			return false;
		}

		return $colors;
	}

	/**
	 * Display an extra meta box for special timber actions (like delete image cache, etc.)
	 */
	function timber_options_metabox() {

		$screen = get_current_screen();
		if ($screen->id !== 'options-du-site_page_gk-technical-options')
			return;

		add_meta_box(
			'custom-timber-actions-acf',
			__('Timber', 'gosselink'),
			array($this, 'timber_options_content'),
			'acf_options_page',
			'side',
			'high'
		);
	}

	/**
	 * Output the HTML for the call-to-action metabox.
	 */
	function timber_options_content() {
		?>
        <div id="timber-actions">
            <div class="acf-label">
                <label><?php _e('Effacer le cache', 'gosselink'); ?></label>
                <p class="description"><?php _e('Efface les images générées et le cache des templates', 'gosselink'); ?></p>
            </div>

            <div id="timber-action">
                <span class="spinner"></span>
                <input type="button" value="<?php _e('Effacer', 'gosselink'); ?>"
                       class="button button-primary button-large" id="timber_delete_cache" name="delete_cache">
            </div>

        </div>
		<?php
	}

}
