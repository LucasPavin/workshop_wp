<?php
/**
 * Created by Jerome GROSDENIER <jerome.grosdenier@gosselink.fr>
 * Date: 17/10/2018
 * Time: 09:36
 */

namespace Gosselink\Entity;

use Timber\Post;
use Timber\Timber;

class GKPageSection extends GKPage
{
	/**
	 * @var string $id
	 */
	public $id;

	/**
	 * @var string $class
	 */
	public $class;

	/**
	 * @var string $link
	 */
	public $link = "";

	/**
	 * @var string $nextLink
	 */
	public $nextLink = "";

	/**
	 * @var boolean $isPopup
	 */
	public $isPopup = false;

	/**
	 * GKPageSection constructor.
	 * @param \WP_Post $post
	 * @param string $id
	 * @param string $class
	 */
	public function __construct($post, $id, $class)
	{
		$template = get_page_template_slug($post);

		if ($template !== ''){
			$template = 'pages/' . str_replace('.php', '.twig', strtolower($template));
		}else if ($post->ID == get_option('page_for_posts')){
			$template = 'blog.twig';
		}else{
			$template = 'page.twig';
		}

		parent::__construct(array($template));

		$this->post = new Post($post);
		$this->id = $id;
		$this->class = $class;
		$this->link = home_url("/") . "#" . $this->id;

		$this->add_to_context( 'post', $this->post );
		$this->add_to_context( 'section' , $this );
		$this->add_to_context( 'data' , get_fields($this->post) );

		// Special case for blog page : we need to add the articles to the section context
		if ($this->post->ID == get_option( 'page_for_posts' )){
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => 3,
				'paged' => -1,
			);
			$this->add_to_context('posts', new \Timber\PostQuery($args));
		}
	}

	/**
	 * @return string
	 */
	public function get_link()
	{
		return $this->link;
	}

	/**
	 * @param string $link
	 */
	public function set_link($link)
	{
		$this->link = $link;
	}

	/**
	 * @return string
	 */
	public function get_id()
	{
		return $this->id;
	}

	/**
	 * @param string $id
	 */
	public function set_id($id)
	{
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	public function get_class()
	{
		return $this->class;
	}

	/**
	 * @param string $class
	 */
	public function set_class($class)
	{
		$this->class = $class;
	}

	/**
	 * @return string
	 */
	public function get_next_link()
	{
		return $this->nextLink;
	}

	/**
	 * @param string $nextLink
	 */
	public function set_next_link($nextLink)
	{
		$this->nextLink = $nextLink;
	}

	/**
	 * @return bool
	 */
	public function is_popup()
	{
		return $this->isPopup;
	}

	/**
	 * @param bool $isPopup
	 */
	public function set_is_popup($isPopup)
	{
		$this->isPopup = $isPopup;
	}

	/**
	 * @return bool
	 */
	public function get_is_popup()
	{
		return $this->isPopup;
	}

}