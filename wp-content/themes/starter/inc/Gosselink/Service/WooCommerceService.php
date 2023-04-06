<?php
/**
 * Created by Jerome GROSDENIER <jerome.grosdenier@gosselink.fr>
 * Date: 28/01/2020
 * Time: 17:28
 */

namespace Gosselink\Service;

use Gosselink\GKSite;
use Timber\Integrations\WooCommerce\WooCommerce;
use Twig\Environment;
use Twig\Extension\StringLoaderExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class WooCommerceService
{

	/**
	 * WooCommerceService constructor.
	 */
	public function __construct()
	{
		if (!self::is_active())
			return;

		// Init Timer Woocommerce integration
		WooCommerce::init();

		// Enable Woocommerce support & additionnal fonctionnalities
		add_action( 'after_setup_theme', array($this, 'add_woocommerce_support') );

		// Disable e-commerce functionnalities ?
		//$this->enable_catalog_mode();

		// Remove / move Woocommerce hooks
		add_Action ( 'after_setup_theme', array($this, 'manage_hooks'));

		// Twig functions dedicated to WooCommerce
		add_filter('get_twig', array($this, 'add_to_twig'));

		// Cart
		add_filter( 'woocommerce_add_to_cart_fragments', array($this, 'cart_fragments'), 10, 1 );
	}

	/**
	 * Tells if Woocommerce is active
	 * @return bool
	 */
	public static function is_active(){

		return function_exists('wc_get_product') && GKSite::WOOCOMMERCE_SUPPORT_ENABLED;
	}

	/**
	 * Simply add Woocommerce basic theme support
	 */
	function add_woocommerce_support() {
		add_theme_support( 'woocommerce' );

		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}

	/**
	 * Enable catalog mode
	 */
	function enable_catalog_mode(){

		// Products can't be purchased
		add_filter( 'woocommerce_is_purchasable', '__return_false');

		// Remove cart item
		add_filter( 'gosselink/woocommerce/display_cart', function (){ __return_empty_string(); }, 20, 2 );

		// Remove price
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

		// Deal with variations
		remove_action('woocommerce_single_variation', 'woocommerce_single_variation', 10);
		remove_action('woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20);
	}

	/**
	 * Manage Woocommerce Hooks
	 */
	function manage_hooks(){

		// Global
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

		// Archives

		// Product
	}

	/**
	 * @param Environment $twig
	 * @return mixed
	 */
	function add_to_twig($twig) {

		$twig->addFunction(new TwigFunction('timber_set_product', array($this, 'timber_set_product')));
		$twig->addFunction(new TwigFunction('display_cart', array($this, 'display_cart')));
		$twig->addFunction(new TwigFunction('display_account', array($this, 'display_account')));

		return $twig;
	}

	/**
	 * Fix WooCommerce issue with Timber
	 *
	 * @param $post
	 */
	function timber_set_product($post) {
		global $product;

		if (WooCommerceService::is_active() && is_woocommerce()) {
			$product = wc_get_product($post->ID);
		}
	}

	/**
	 * Add account to menu
	 * @return string
	 */
	public static function display_account(){
		$account_label = WC()->customer->get_display_name() !== '' ? WC()->customer->get_display_name() : __("Mon compte", "gosselink");

		$account_link =
			'<div class="header-cart">
				<a href="' . get_permalink( wc_get_page_id( 'myaccount' ) ) . '">
					'.$account_label.'
				</a>
			</div>';

		return $account_link;
	}

	/**
	 * Add cart to menu
	 * @return string
	 */
	public static function display_cart(){

		$cart_link =
			'<div class="header-cart">
				<a href="' . get_permalink( wc_get_page_id( 'cart' ) ) . '">
					<svg height="20" viewBox="0 -11 414.002 414" width="20" xmlns="http://www.w3.org/2000/svg" fill="#FFF"><path d="M202.48 352.133c0-21.801-17.671-39.473-39.468-39.473-21.801 0-39.473 17.672-39.473 39.469 0 21.8 17.672 39.473 39.473 39.473 21.785-.024 39.445-17.68 39.468-39.47zm-64.94 0c0-14.07 11.401-25.473 25.472-25.473 14.066 0 25.468 11.403 25.468 25.469 0 14.07-11.402 25.473-25.468 25.473-14.063-.016-25.457-11.41-25.473-25.47zm0 0M309.168 391.602c21.8.003 39.473-17.668 39.473-39.47.004-21.8-17.668-39.472-39.47-39.472S269.7 330.332 269.7 352.133c.028 21.785 17.68 39.441 39.469 39.469zm0-64.942c14.066 0 25.473 11.403 25.473 25.469.004 14.066-11.403 25.473-25.47 25.473s-25.472-11.403-25.472-25.47c.016-14.058 11.41-25.452 25.469-25.472zm0 0M7 14h42.7c14.05-.055 26.03 10.176 28.171 24.066l33.8 213.512c3.192 20.703 21.052 35.957 42 35.875h208.93a7.001 7.001 0 000-14h-208.93c-14.05.055-26.03-10.18-28.171-24.066l-5.746-36.301h213.98c18.118-.008 34.243-11.484 40.18-28.598l39.7-114.578A6.997 6.997 0 00407 60.613H95.613L91.7 35.875C88.508 15.172 70.65-.082 49.7 0H7a7.001 7.001 0 000 14zm390.164 60.617l-36.476 105.285a28.54 28.54 0 01-26.954 19.184H117.535L97.828 74.613zm0 0"/></svg>
					'.self::get_cart_count_fragment().'
				</a>
			</div>';

		return $cart_link;
	}

	/**
	 * Menu cart fragment content
	 * @return mixed
	 */
	private static function get_cart_count_fragment() {

		$cart_item_count = WC()->cart->get_cart_contents_count() > 0 ?:'';

		return '<span class="header-cart-count">'.$cart_item_count.'</span>';

	}

	/**
	 * Cart fragments for wherever it needs to be refreshed in ajax
	 * See https://iconicwp.com/blog/update-custom-cart-count-html-ajax-add-cart-woocommerce/
	 * @param $fragments
	 * @return mixed
	 */
	function cart_fragments($fragments ) {

		$fragments['span.header-cart-count'] = self::get_cart_count_fragment();

		return $fragments;

	}

}