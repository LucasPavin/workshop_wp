<?php

namespace Gosselink\Settings\ACF;
use Gosselink\GKSite;

/**
 * Created by Jerome GROSDENIER <jerome.grosdenier@gosselink.fr>
 * User: studio21
 * Date: 19/04/2018
 * Time: 17:27
 */

class OptionsPages
{
	function __construct()
	{
		add_action('acf/init', array($this, 'register_options'));
		add_action('acf/init', array($this, 'acf_init'));

		// WPML : on n'affiche les options que pour la langue courante (dans le cas où il ne faut pas les traduire).
		$show_options = true;
		if ( !GKSite::TRANSLATE_OPTIONS && defined('ICL_LANGUAGE_CODE')){
			$default_lang = apply_filters( 'wpml_default_language', NULL );
			$current_lang = apply_filters( 'wpml_current_language', NULL );

			if ($current_lang !== $default_lang){
				add_action('acf/input/admin_head', array($this, 'add_metaboxes'), 20);
				$show_options = false;
			}
		}

		if ($show_options){
			new SiteOptions();
			new TechnicalOptions();
		}
	}

	function register_options()
	{

		if( function_exists('acf_add_options_page') ) {

			// Main Options Page
			$site_options_page = acf_add_options_page(array(
				'page_title' => __('Options du site', 'gosselink'),
				'menu_title' => __('Options du site', 'gosselink'),
				'menu_slug' => 'gk-options-site',
				'capability' => 'edit_pages',
				'icon_url' => 'dashicons-admin-generic',
				'position' => 2,
				'redirect' => false,
				'show_in_graphql' => true
			));

			acf_add_options_sub_page(array(
				'page_title' 	=> __('Options techniques', 'gosselink'),
				'menu_title' 	=> __('Options techniques', 'gosselink'),
				'parent_slug' 	=> $site_options_page['menu_slug'],
				'menu_slug'     => 'gk-technical-options',
				'capability' => 'manage_options',
			));
		}
	}

	function acf_init()
	{
		acf_update_setting('google_api_key', get_field('maps_google_api_key', 'options'));
	}

	/**
	 * Display an extra meta box for special timber actions (like delete image cache, etc.)
	 */
	function add_metaboxes() {

		$screen = get_current_screen();
		if ($screen->id !== 'options-du-site_page_gk-technical-options' && $screen->id !== 'toplevel_page_gk-options-site')
			return;

		// Warning about WPML trying to translate options
		if (shortcode_exists('wpml_language_switcher')){
			add_meta_box(
				'custom-wpml-box-acf',
				__('Traduction des options', 'gosselink'),
				array($this, 'wpml_warning'),
				'acf_options_page',
				'normal',
				'high'
			);
		}
	}

	/**
	 * Output the HTML for the WPML Warning.
	 */
	function wpml_warning() {
		?>
		<div id="wpml-warning">
			<div class="acf-label">
				<label style="color:red;"><strong><?php _e('Attention', 'gosselink'); ?></strong></label>
				<p class="description"><?php _e('La gestion des options n\'est disponible que dans la langue par défaut du site.', 'gosselink'); ?></p>
			</div>
		</div>
		<?php
	}
}
