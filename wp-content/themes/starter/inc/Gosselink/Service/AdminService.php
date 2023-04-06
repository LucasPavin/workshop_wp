<?php
/**
 * Created by Jerome GROSDENIER <jerome.grosdenier@gosselink.fr>
 * Date: 09/08/2018
 * Time: 16:12
 */

namespace Gosselink\Service;

use Gosselink\GKSite;

class AdminService
{
	function __construct() {

        add_action( 'login_enqueue_scripts', array( $this, 'load_login_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_scripts' ) );
		add_action( 'admin_init', array( $this, 'load_admin_theme' ) );
		add_filter( 'get_user_option_admin_color', array( $this, 'set_default_admin_theme') );
		remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
		add_filter( 'login_headerurl', array($this, 'change_login_url') );
		add_filter('upload_mimes', array($this, 'manage_mime_types') );
		add_action( 'admin_init', array($this, 'manage_capabilities'));
		add_action('admin_menu', array($this,'hide_admin_menus'), 999);
		add_action('admin_bar_menu', array($this,'hide_admin_bar_menus'), 999);
        add_action('map_meta_cap', array($this,'allow_access_to_data_privacy'), 1, 4);

	}

	/**
	 * Change capabilities here if needed
	 */
	function manage_capabilities() {

		// Allow editor to edit Menus (= view Apparence menu, but hide some of its items)
		$role_object = get_role( 'editor' );
		$role_object->add_cap( 'edit_theme_options' );

		// Editor can also manage woocommerce stuff
		if (WooCommerceService::is_active()){
			$role_object->add_cap( 'manage_woocommerce' );
			$role_object->add_cap( 'view_woocommerce_reports' );
		}
	}

    /**
     * Allow editors and other administrators to edit Data Privacy page
     */
    function allow_access_to_data_privacy($caps, $cap, $user_id, $args)
    {
        if (!is_user_logged_in()) return $caps;

        $user_meta = get_userdata($user_id);
        if (array_intersect(['editor', 'administrator'], $user_meta->roles)) {
            if ('manage_privacy_options' === $cap) {
                $manage_name = is_multisite() ? 'manage_network' : 'manage_options';
                $caps = array_diff($caps, [ $manage_name ]);
            }
        }
        return $caps;
    }



    /**
	 * Admin login scripts and stylesheets
	 */
	function load_login_scripts() {
		$theme = wp_get_theme();
		wp_enqueue_style('admin-styles', get_template_directory_uri() . '/dist/admin.min.css', array(), $theme->Version, 'all');
	}

	/**
	 * Admin scripts and stylesheets
	 */
	function load_admin_scripts() {
        $theme = wp_get_theme();
        wp_register_script( 'admin-scripts', get_template_directory_uri() . '/dist/admin.min.js', array( 'jquery', 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ), $theme->Version, true );

	    $data_array = array(
		    'security' => wp_create_nonce(GKSite::SECURITY_KEY),
	    );
        wp_localize_script( 'admin-scripts', 'admin_data', $data_array );
        wp_enqueue_script( 'admin-scripts' );
    }

	/**
	 * Admin theme declaration
	 */
	function load_admin_theme() {
		wp_admin_css_color(
			'gosselink',
			'Gosselink',
			get_template_directory_uri() . '/dist/admin.min.css',
			array('#222', '#333', '#01a29a', '#38c1ba'),
			array()
		);
	}

	/**
	 * Setting admin theme
	 */
	function set_default_admin_theme() {
		return 'gosselink';
	}

	/**
	 * Login URL
	 */
	function change_login_url() {
		return 'https://www.gosselink.fr';
	}


	/**
	 * Allow SVG and other mime types
	 * @param $mimes
	 * @return mixed
	 */
	function manage_mime_types($mimes) {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}


	/**
	 * Hide Menus for editor
	 */
	function hide_admin_menus() {

		$file_to_hide = 'themes.php';

		if (!current_user_can('administrator')) {
			remove_menu_page('edit.php'); // Remove Posts
			remove_menu_page('tools.php'); // Remove Tools
			remove_menu_page('options-general.php'); // Remove Settings

			remove_submenu_page( $file_to_hide, $file_to_hide ); // hide the theme selection submenu
			remove_submenu_page( $file_to_hide, 'widgets.php' ); // hide the widgets submenu

			// hide the customizer submenu
			global $submenu;
			if ( isset( $submenu[ $file_to_hide ] ) ) {
				foreach ( $submenu[ $file_to_hide ] as $index => $menu_item ) {
					foreach ($menu_item as $value) {
						if (strpos($value,'customize') !== false) {
							unset( $submenu[ $file_to_hide ][ $index ] );
						}
					}
				}
			}
		}

	}

	/**
	 * Hide Menus in admin bar for editor
	 */
	function hide_admin_bar_menus($wp_admin_bar) {
		if (current_user_can('editor')) {
			$wp_admin_bar->remove_node('customize');
		}
	}
}
