<?php
/**
 * Created by Jerome GROSDENIER <jerome.grosdenier@gosselink.fr>
 * Date: 19/10/2018
 * Time: 17:09
 */

namespace Gosselink\Service;

/**
 * Class CommentsService
 * @package Gosselink\Service
 *
 * Disable comments
 */
class CommentsService
{
	function disable_comments() {

		add_action( 'admin_init', array($this, 'disable_comments_post_types_support') );

		add_filter( 'comments_open', array($this, 'disable_comments_status'), 20, 2 );
		add_filter( 'pings_open', array($this, 'disable_comments_status'), 20, 2 );

		add_filter( 'comments_array', array($this, 'disable_comments_hide_existing_comments'), 10, 2 );

		add_action( 'admin_menu', array($this, 'disable_comments_admin_menu') );

		add_action( 'admin_init', array($this, 'disable_comments_admin_menu_redirect') );

		add_action( 'admin_init', array($this, 'disable_comments_dashboard') );

		add_action( 'wp_before_admin_bar_render', array($this, 'disable_comments_admin_bar') );

		add_action( 'admin_print_styles-index.php', array( $this, 'admin_css' ) );
		add_action( 'admin_print_styles-profile.php', array( $this, 'admin_css' ) );

	}

	/** Disable comments */
	function disable_comments_post_types_support() {
		$post_types = get_post_types();
		foreach ( $post_types as $post_type ) {
			if ( post_type_supports( $post_type, 'comments' ) ) {
				remove_post_type_support( $post_type, 'comments' );
				remove_post_type_support( $post_type, 'trackbacks' );
			}
		}
	}

	/** Close comments on the front-end. */
	function disable_comments_status() {
		return false;
	}

	/** Hide existing comments.
	 *
	 * @since 2.0.0
	 *
	 * @param string $comments Being the comments.
	 *
	 * @return array
	 */
	function disable_comments_hide_existing_comments( $comments ) {
		$comments = array();
		return $comments;
	}

	/** Remove comments page in menu. */
	function disable_comments_admin_menu() {
		remove_menu_page( 'edit-comments.php' );
	}

	/** Redirect any user trying to access comments page. */
	function disable_comments_admin_menu_redirect() {
		global $pagenow;
		if ( 'edit-comments.php' === $pagenow ) {
			wp_redirect( admin_url() );
			exit;
		}
	}

	/** Remove comments metabox from dashboard. */
	function disable_comments_dashboard() {
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	}

	/** Remove comments links from admin bar. */
	function disable_comments_admin_bar() {
		if ( is_admin_bar_showing() ) {
			global $wp_admin_bar;
			$wp_admin_bar->remove_menu('comments');
		}
	}

	/** Remove comments from dashboard. */
	public function admin_css(){
		echo '<style>
			#dashboard_right_now .comment-count,
			#dashboard_right_now .comment-mod-count,
			#latest-comments,
			#welcome-panel .welcome-comments,
			.user-comment-shortcuts-wrap {
				display: none !important;
			}
		</style>';
	}

}