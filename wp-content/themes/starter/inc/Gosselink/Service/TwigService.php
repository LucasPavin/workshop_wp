<?php
namespace Gosselink\Service;

/**
 * Created by Jerome GROSDENIER <jerome.grosdenier@gosselink.fr>
 * User: studio21
 * Date: 19/04/2018
 * Time: 17:27
 */

use Gosselink\Entity\GKPage;
use Gosselink\GKSite;
use Timber\Menu;
use Timber\PostQuery;
use Timber\Image;
use Timber\ImageHelper;
use Timber\Timber;
use Twig\Environment;
use Twig\Extension\StringLoaderExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class TwigService {

	private $site;

	function __construct() {

		$service_manager = ServiceManager::get_instance();
		$this->site = $service_manager->get_site();

		add_filter('timber_context', array($this, 'add_to_context'));
		add_filter('get_twig', array($this, 'add_to_twig'));

		// Timber Images will be generated in a dedicated cache dir
		add_filter('timber/image/new_path', array($this, 'set_image_cache_path'));
		add_filter('timber/image/new_url', array($this, 'set_image_cache_url'));

		// Fix a Timber bug in URLHelper function
		add_filter('timber/URLHelper/url_to_file_system/path', function($path) {
			return strstr($path, '/wp-content');
		});
	}

	/**
	 * @param $context
	 * @return mixed
	 */
	function add_to_context($context) {
		/* this is where you can add your own variables to twig's global context */

		$context['assets'] = get_stylesheet_directory_uri() . '/static/';
		$context['parent']['assets'] = get_template_directory_uri() . '/static/';

		$context['menu'] = new Menu('main-menu');

		if (function_exists('get_field') && get_field('footer_menu_enabled', 'options')) {
			$context['footer_menu'] = new Menu('footer-menu');
            $context['footer_menu_2'] = new Menu('footer-menu-2');
            $context['footer_menu_3'] = new Menu('footer-menu-3');
            $context['footer_menu_4'] = new Menu('footer-menu-4');
		}

		if (function_exists('get_field') && get_field('sitemap_enabled', 'options')) {
			$context['sitemap_menu'] = new Menu('sitemap-menu');
		}

		$context['sidebar'] = Timber::get_widgets('sidebar');

		$context['site'] = $this->site;

		$security = array(
			'author_archive_enabled' => GKSite::AUTHOR_ARCHIVE_ENABLED,
		);
		$context['security'] = $security;

		$context['is_home'] = GKPage::is_homepage();

		$context['top_anchor'] = GKSite::TOP_ANCHOR;

		// ACF Options
		$context['options'] = array();
		if (function_exists('get_fields')) {
			$context['options'] = get_fields('option');
		}

		// WPML specific stuff
		if (shortcode_exists('wpml_language_switcher')) {

			// Add languages to the context
			$context['languages'] = apply_filters('wpml_active_languages', NULL, 'orderby=id&order=desc');

			// When WPML is enabled, TimberMenu doesn't always retrieve the right menu when using the menu slug.
			// => we need to use the id
			$menu_locations = get_nav_menu_locations();

			if (array_key_exists('main-menu', $menu_locations)) {
				$context['menu'] = new Menu($menu_locations['main-menu']);
			}

			if (function_exists('get_field') && array_key_exists('footer-menu', $menu_locations)) {
				$context['footer_menu'] = new Menu('footer-menu');
			}

			if (function_exists('get_field') && array_key_exists('sitemap-menu', $menu_locations)) {
				$context['sitemap_menu'] = new Menu('sitemap-menu');
			}

			// When site options don't have to be translated, we're getting them for the default language.
			if (!GKSite::TRANSLATE_OPTIONS){
				add_filter('acf/settings/current_language', '__return_false');
				$context['options'] = get_fields('option');
				remove_filter('acf/settings/current_language','__return_false');
			}else{
				$context['options'] = get_fields('option');
			}

		}

		// WPML : add language code to each page
		if (defined('ICL_LANGUAGE_CODE')){
			$context['language_code'] = ICL_LANGUAGE_CODE;
		}

		// Woocommerce stuff
		if (WooCommerceService::is_active()){
			$context['wc_placeholder_img'] = wc_placeholder_img_src( 'original');
		}

		// Languages if WPML is active
		$context['languages'] = apply_filters('wpml_active_languages', NULL, 'orderby=id&order=desc');

		return $context;
	}

	/**
	 * @param Environment $twig
	 * @return mixed
	 */
	function add_to_twig($twig) {

		/* this is where you can add your own functions to twig */
		$twig->addExtension(new StringLoaderExtension());

		/* Functions */
		$twig->addFunction(new TwigFunction('post_link', array($this, 'post_link')));
		$twig->addFunction(new TwigFunction('gk_image', array($this, 'gk_image')));

		/* Filters */
		$twig->addFilter(new TwigFilter('watermark',
			array('\Gosselink\Service\Helper\WatermarkTwigFilterHelper', 'watermark')
		));

		return $twig;
	}

	/**
	 * @param $path
	 * @return string
	 */
	function set_image_cache_path($path) {
		$filename = basename($path);

		return get_stylesheet_directory() . '/cache/' . $filename;
	}

	/**
	 * @param $url
	 * @return string
	 */
	function set_image_cache_url($url) {
		$filename = basename($url);

		return get_stylesheet_directory_uri() . '/cache/' . $filename;
	}

	/**
	 * Return the link for a post, using its slug
	 * @param string $slug Post slug. If it is a child, don't forget the parent slug too : like 'parent/child'
	 * @param string $type Post type
	 * @param string $lang_slug When using polylang, you can specify the lang you want the link for
	 * @return string Post link
	 */
	function post_link($slug, $type = 'page', $lang_slug = NULL)
	{
		$post = get_page_by_path($slug, OBJECT, $type);

		if ($post instanceof \WP_Post) {

			if ($lang_slug !== NULL){

				// When using Polylang
				if (function_exists('pll_get_post')){
					$id = $lang_slug ? pll_get_post($post->ID, $lang_slug) : $post->ID;
					return get_permalink($id);
				}

				// When using WPML
				if (function_exists('icl_object_id')){
					$url = get_the_permalink($post->ID);
					return apply_filters( 'wpml_permalink', $url , $lang_slug );
				}
			}

			return get_permalink($post->ID);
		}

		return $this->site->url . DIRECTORY_SEPARATOR . $slug . DIRECTORY_SEPARATOR;
	}

	/**
	 * Function to display images the right way (lazy loaded, retina-ready, ...)
	 * @param $path
	 * @param string $class
	 * @param string $alt
	 * @param bool $responsive
	 * @param bool $background
	 * @return string
	 */
	static function gk_image($path, $alt = "", $class = "", $responsive = true, $sizes = "100w", $background = false) {

		if (is_array($path) && array_key_exists('url', $path)){
			$path = $path['url'];
		}

		// Default image sizes. Can be overriden with a filter
		$responsive_sizes = apply_filters('gk_image_sizes', array(
			480,
			640,
			1024,
			1440,
		));

		// Just in case we pass an ACF image field instead of a path or url
		if (is_array($path) && array_key_exists('url', $path)){
			$path = $path['url'];
		}

		$src = $path;
		$data_src_set = '';

		if ($responsive) {
			try {
				$data_src_set_items = array();

				foreach ($responsive_sizes as $index => $size) {

					$source_image_size = @getimagesize($path);
					if ($source_image_size) {
						// Source image is bigger => we can resize
						if ($size < $source_image_size[0]) {

							$resized_path = ImageHelper::resize($path, $size);

							$src = $index == 0 ? $resized_path : $src;
							$data_src_set_items[] = $resized_path . ' ' . $size . 'w';
						} else {
							$data_src_set_items[] = $path . ' ' . $source_image_size[0] . 'w';
						}
					}
				}

				$data_src_set = implode(", ", $data_src_set_items );

			} catch (\Exception $e) {
				error_log("Cannot resize image : " . $path);
			}
		}

		if ($background) {

			$html = '<div class="lazy %1$s" style="background-image: url(%2$s);" data-srcset="%3$s" data-sizes="%4$s" alt="%5$s"></div>';
			return sprintf($html,
				htmlspecialchars($class),
				esc_url($src),
				esc_attr($data_src_set),
				esc_attr($sizes),
				htmlspecialchars($alt)
			);

		} else {

			$html = '<img class="lazy %1$s" loading="lazy" src="%2$s" loading="lazy" data-srcset="%3$s" data-sizes="%4$s" alt="%5$s"/>';
			return sprintf($html,
				htmlspecialchars($class),
				esc_url($src),
				esc_attr($data_src_set),
				esc_attr($sizes),
				htmlspecialchars($alt)
			);
		}
	}

}
